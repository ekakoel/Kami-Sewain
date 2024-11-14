<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Checkout;
use App\Models\Shippings;
use App\Models\OrderReceipt;
use App\Models\PageProperty;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOrdersRequest;
use App\Http\Requests\UpdateOrdersRequest;

class OrderAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = 'admin-orders';
        $page_properties = PageProperty::where('page', $page)->first();
        $business = BusinessProfile::where('id',1)->first();
        $now = Carbon::now();
        $paid_orders = Orders::with('products')->where('status','Paid')->where('rental_start_date','>=',$now)->get();
        $payment_orders = Orders::with('products')->where('status','Payment')->where('rental_start_date','>=',$now)->get();
        $order_history = Orders::with('products')->where('rental_start_date','<',$now)->get();
        return view('admin.orders.index', compact(
            'now',
            'paid_orders',
            'payment_orders',
            'order_history',
            'business',
            'page_properties',
        ));
    }
    public function detail_order($id)
    {
        $now = Carbon::now();
        $order = Orders::with('products')->where('id',$id)->first();
        if ($order) {
            $page = 'orders';
            $page_properties = PageProperty::where('page', $page)->first();
            $business = BusinessProfile::where('id',1)->first();
            $now = Carbon::now();
            
            $receipt_paids = $order->receipts->where('status','Valid');
            return view('admin.orders.detail', compact(
                'now',
                'order',
                'business',
                'page_properties',
                'receipt_paids',
            ));
        }else{
            return redirect()->route('products.index')->with('success', 'Order not found!');
        }
    }

    public function store_receipt(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id', // Ensure the order exists
            'payment_date' => 'required',
            'amount' => 'required|numeric',
            'receipt_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);
        $order = Orders::where('id',$request->order_id)->first();
        // Handle image upload
        $imagePath = $request->file('receipt_image')->store('receipts', 'public');
        $payment_date = date('Y-m-d',strtotime($request->payment_date));
        if ($request->hasFile('receipt_image')) {
            $receipt = time() . '_receipt_'.$order->order_no.".". $request->receipt_image->getClientOriginalExtension();
            $request->receipt_image->storeAs('images/receipts/', $receipt);
        }
        // Create a new receipt entry
        OrderReceipt::create([
            'order_id' => $request->order_id,
            'payment_date' => $payment_date,
            'amount' => $request->amount,
            'note' => $request->note,
            'receipt_image' => $receipt,
            'status' => 'Pending', // Default status
        ]);

        return redirect()->back()->with('success', 'Payment receipt has been uploaded successfully.');
    }

    public function destroy_receipt($id)
    {
        $receipt = OrderReceipt::find($id);
        $order_id = $receipt->order_id;
        if (!$receipt) {
            return response()->json(['error' => 'Receipt not found'], 404);
        }
        if ($receipt->receipt_image && file_exists('storage/receipts/' . $receipt->receipt_image)) {
            unlink('storage/receipts/' . $receipt->receipt_image);
        }
        $receipt->delete();
        return redirect()->route('admin.order.detail',$order_id)->with('success', 'Receipt deleted successfully');
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
        $user_id = Auth::admin()->id;
        $orders = Orders::all();
        if (count($orders)>0) {
            $cord = count($orders);
        }else{
            $cord = 0;
        }
        $corders = $cord + 1;
        $orderno = "ORD-".$date."-".$user_id."-".$corders;
        $rentalStartDate = Carbon::parse($validated['rental_start_date']);
        $rentalEndDate = Carbon::parse($validated['rental_end_date']);
        $rentalDuration = $rentalStartDate->diffInDays($rentalEndDate);
        $order_status = "Payment";
        $shipping_status = "Payment";
        $total = array_sum(array_map(fn($details) => $details['quantity'] * $details['price'], $cart));
        $total_price = $total * $rentalDuration;
        $payment_duedate = $rentalStartDate->subDays(7);
        $payment_method = "Bank Transfer";
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
            'payment_duedate' => $payment_duedate,
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
            'balance' => $total_price,
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
        return redirect()->route('orders.detail',$order->order_no)->with('success', 'Order placed successfully!');
    }

    public function set_order_to_paid(Request $request, $id)
    {
        $order = Orders::findOrFail($id);
        $status = 'Paid';
        $order->update([
            'status' => $status,
        ]);
        return redirect()->route('admin.order.detail',$id)->with('success', 'Product updated successfully');
    }

    public function set_order_to_reject(Request $request, $id)
    {
        $order = Orders::findOrFail($id);
        $status = 'Rejected';
        $order->update([
            'status' => $status,
        ]);
        return redirect()->route('admin.order.detail',$id)->with('success', 'Product updated successfully');
    }
    public function set_order_to_payment(Request $request, $id)
    {
        $order = Orders::findOrFail($id);
        $status = 'Payment';
        $order->update([
            'status' => $status,
        ]);
        return redirect()->route('admin.order.detail',$id)->with('success', 'Product updated successfully');
    }
    public function validate_receipt(Request $request, $id)
    {
        $receipt = OrderReceipt::findOrFail($id);
        $status = $request->status;
        $order_id = $receipt->order_id;
        $order = Orders::where('id',$order_id)->first();
        if ($status == "Valid") {
            $balance = $order->balance - $receipt->amount;
            if ($balance > 0) {
                $order_status = 'Payment';
                $payment_status = 'Payment';
            }else{
                $order_status = 'Paid';
                $payment_status = 'Paid';
            }
        }else{
            $balance = $order->balance;
            $order_status = 'Payment';
            $payment_status = 'Payment';
        }
        $order->update([
            'balance' => $balance,
            'status' => $order_status,
            'payment_status' => $payment_status,
        ]);
        $receipt->update([
            'status' => $status,
            'note' => $request->note,
        ]);
        if ($order->balance <= 0) {
            $shipping = $order->shipping;
            $order->shipping->update([
                'status' => 'Prepared',
            ]);
        }
        return redirect()->route('admin.order.detail',$order_id)->with('success', 'Receipt updated successfully');
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return number_format($total, 2);
    }

    
}
