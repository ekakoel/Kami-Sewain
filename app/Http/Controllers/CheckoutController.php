<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Checkout;
use App\Models\Promotion;
use App\Models\Shippings;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCheckoutRequest;
use App\Http\Requests\UpdateCheckoutRequest;

class CheckoutController extends Controller
{
    public function index()
    {
        $business = BusinessProfile::where('id',1)->first();
        $cart = session()->get('cart', []);
        $banks = BankAccount::all();
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }
        $promos = Promotion::where('status','Active')->get();
        // Proceed to checkout
        return view('checkout.index', compact('cart','business','banks','promos'));
    }
    public function process(Request $request)
    {
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
        $now = Carbon::now();
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(fn($details) => $details['quantity'] * $details['price'], $cart));
        $rentalStartDate = Carbon::parse($validated['rental_start_date']);
        $rentalEndDate = Carbon::parse($validated['rental_end_date']);
        $rentalDuration = $rentalStartDate->diffInDays($rentalEndDate);
        $user_id = Auth::user()->id;
        $productId = $request->product_id;
        $productPrice = $request->product_price;
        $date = date('Ymd',strtotime($now));
        $orders = Orders::where('user_id',$user_id)->where('created_at',$now)->get();
        if ($orders) {
            $corders = count($orders);
        }else{
            $corders = 1;
        }
        $orderno = $date."-".$user_id."-".$corders;
        $order_status = "Payment";
        $shipping_status = "Prepared";
        $recipient = $request->recipient;
        $order = new Orders([
            'order_no' => $orderno,
            'user_id' => $user_id,
            'bank_id' => $request->bank_id,
            'product_id' => $productId,
            'product_price' => $productPrice,
            'rental_start_date' => $validated['rental_start_date'],
            'rental_end_date' => $validated['rental_end_date'],
            'rental_duration' => $rentalDuration,
            'total' => $total,
            'status' => $order_status,
        ]);
        $order->save();
        $shipping = new Shippings([
            'order_id' => $order->id,
            'recipient' => $recipient,
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
        session()->forget('cart');

        return redirect()->route('products.index')->with('success', 'Order placed successfully!');
    }

}
