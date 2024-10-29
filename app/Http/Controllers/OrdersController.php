<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Checkout;
use App\Models\Promotion;
use App\Models\Shippings;
use App\Models\PageProperty;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrdersRequest;
use App\Http\Requests\UpdateOrdersRequest;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = 'orders';
        $page_properties = PageProperty::where('page', $page)->first();
        $business = BusinessProfile::where('id',1)->first();
        $now = Carbon::now();
        $user_id = Auth::user()->id;
        $orders = Orders::with('products')->where('user_id',$user_id)->where('status','!=','archived')->where('rental_end_date','>=',$now)->get();
        $order_history = Orders::with('products')->where('user_id',$user_id)->where('rental_end_date','<',$now)->get();
        return view('orders.index', compact(
            'orders',
            'business',
            'page_properties',
            'order_history',
        ));
    }
    public function detail_orders($orderno)
    {
        $now = Carbon::now();
        $user_id = Auth::user()->id;
        $order = Orders::with('products')->where('order_no',$orderno)->where('user_id',$user_id)->first();
        if ($order) {
            $page = 'orders';
            $page_properties = PageProperty::where('page', $page)->first();
            $business = BusinessProfile::where('id',1)->first();
            $now = Carbon::now();
            $user_id = Auth::user()->id;
            $orders = Orders::with('products')->where('user_id',$user_id)->where('status','!=','archived')->where('rental_end_date','>=',$now)->get();
            $receipt_paids = $order->receipts->where('status','Paid');
            return view('orders.detail', compact(
                'now',
                'order',
                'orders',
                'business',
                'page_properties',
                'receipt_paids',
            ));
        }else{
            return redirect()->route('orders.index')->with('success', 'Order not found!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create_order(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('orders.index');
        }
        // Validasi data dari request
        $validated = $request->validate([
            'recipient' => 'required|string|max:255',
            'telephone' => 'required',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'rental_start_date' => 'required|date',
            'rental_end_date' => 'required|date|after_or_equal:rental_start_date',
        ]);
        // Buat order baru
        $now = Carbon::now();
        $date = date('Ymd',strtotime($now));
        $user = Auth::user();
        $user_id = Auth::user()->id;
        $orders = Orders::all();
        if (count($orders)>0) {
            $cord = count($orders);
        }else{
            $cord = 0;
        }
        $promo = session()->get('promotion', null);
        if ($promo) {
            $promotion = Promotion::where('id',$promo['id'])->first();
            if ($promotion) {
                $discount_percent = $promotion->discount_percent;
                $discount_amount = $promotion->discount_amount;
                $user->promotions()->updateExistingPivot($promotion->id, ['status' => 'Used']);
            }else{
                $discount_percent = NULL;
                $discount_amount = NULL;
            }
        }else{
            $discount_percent = NULL;
            $discount_amount = NULL;
        }
        $corders = $cord + 1;
        $orderno = "ORD-".$date."-".$user_id."-".$corders;
        $rentalStartDate = Carbon::parse($validated['rental_start_date']);
        $rentalEndDate = Carbon::parse($validated['rental_end_date']);
        $rentalDuration = $rentalStartDate->diffInDays($rentalEndDate);
        $order_status = "Payment";
        $shipping_status = "Prepared";
        $total = array_sum(array_map(fn($details) => $details['quantity'] * $details['price'], $cart));
        $total_price = $total * $rentalDuration;
        $balance = $total_price;
        $payment_duedate = $rentalStartDate->subDays(7);
        $payment_method = "Bank Transfer";
        if ($discount_percent > 0 ) {
            $discount = ($discount_percent / 100) * $total_price;
            $balance -= $discount;
            
        }elseif($discount_amount>0){
            $balance = $total_price - $discount_amount;
        }
        $payment_status = "Unpaid";
        $order = Orders::create([
            'order_no' => $orderno,
            'user_id' => $user_id,
            'bank_id' => $request->bank_id,
            'rental_start_date' => $rentalStartDate,
            'rental_end_date' => $rentalEndDate,
            'rental_duration' => $rentalDuration,
            'total' => $total,
            'total_price' => $total_price,
            'discount_percent' => $discount_percent,
            'discount_amount' => $discount_amount,
            'balance' => $balance,
            'payment_duedate' => $payment_duedate,
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
            'status' => $order_status,
        ]);

        foreach ($cart as $item) {
            $cart_total_price = $item['quantity']*$item['price'];
            $order->products()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total_price' => $cart_total_price,
            ]);
        }
        $shipping = new Shippings([
            'order_id' => $order->id,
            'recipient' => $request->recipient,
            'telephone' => $validated['telephone'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'postcode' => $validated['postcode'],
            'country' => $validated['country'],
            'delivery_date' => $validated['rental_start_date'],
            'return_date' => $validated['rental_end_date'],
            'status' => $shipping_status,
        ]);
        $shipping->save();
        // Hapus cart dari session setelah order tersimpan
        session()->forget('cart');
        session()->forget('promotion');
        return redirect()->route('orders.detail',$order->order_no)->with('success', 'Order placed successfully!');
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return number_format($total, 2);
    }

    /**
     * Display the specified resource.
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrdersRequest $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_orders($code)
    {
        $order = Orders::where('order_no',$code);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }
}
