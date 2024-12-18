<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderReceipt;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderReceiptRequest;
use App\Http\Requests\UpdateOrderReceiptRequest;

class OrderReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
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
            // $request->receipt_image->move('images/orders/', $receipt,'public');
            $request->receipt_image->move('storage/receipts/', $receipt);
            // $request->receipt_image->move('images/orders/', $receipt,'publics');
        }
        // Create a new receipt entry
        OrderReceipt::create([
            'order_id' => $request->order_id,
            'payment_date' => $payment_date,
            'amount' => $request->amount,
            'receipt_image' => $receipt,
            'status' => 'Pending', // Default status
        ]);

        return redirect()->back()->with('success', 'Payment receipt has been uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderReceipt $orderReceipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderReceipt $orderReceipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderReceiptRequest $request, OrderReceipt $orderReceipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderReceipt $orderReceipt)
    {
        //
    }
}
