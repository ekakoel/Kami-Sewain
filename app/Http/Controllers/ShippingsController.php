<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Shippings;
use Illuminate\Http\Request;
use App\Models\ShippingTransport;
use App\Http\Requests\StoreShippingsRequest;
use App\Http\Requests\UpdateShippingsRequest;

class ShippingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Orders::with('products')->get();
        $now = Carbon::now();
        $shippingPres = Shippings::where('delivery_date','>=',$now)->where('status','Prepared')->get();
        $shippingIns = Shippings::where('delivery_date','>=',$now)->where('status','Ready')->get();
        $shippingStandBy = Shippings::where('delivery_date','>=',$now)->where('status','Send')->get();
        $shippingInUses = Shippings::where('delivery_date','<=',$now)->where('return_date','>=',$now)->where('status','Send')->get();
        $shippingOuts = Shippings::where('return_date','<',$now)->where('status','Send')->get();
        $transports = ShippingTransport::where('status','available')->get();
        return view('admin.shippings.index',compact(
            'shippingPres',
            'shippingIns',
            'shippingStandBy',
            'shippingInUses',
            'shippingOuts',
            'transports',
            'now',
            'orders',
        ));
    }

    public function update_shipping_product(Request $request, $id)
    {
        $shipping = Shippings::findOrFail($id);
        $messages = 'Product has been ready to send';
        $shipping->update([
            'status' => $request->status,
        ]);
        return redirect()->route('admin.shippings')->with('success', $messages);
    }

    public function send_product(Request $request, $id)
    {
        $shipping = Shippings::findOrFail($id);
        $courier = $request->courier;
        $courier_phone = $request->courier_telephone;
        $note = $request->note;
        $shippingTransportId = $request->transport_id;
        if ($shipping->product_location == 'Warehouse') {
            $shipping->update([
                'courier_send' => $courier,
                'courier_send_phone' => $courier_phone,
                'product_location' => 'Rental Place',
                'note_send' => $note,
                'status' => 'Send',
            ]);
            $messages = 'Product has been sent';
        }else{
            $shipping->update([
                'courier_take' => $courier,
                'courier_take_phone' => $courier_phone,
                'product_location' => 'Warehouse',
                'note_take' => $note,
                'status' => 'Taken',
            ]);
            $messages = 'Product has been taken';
        }
        $shipping->shippingTransports()->attach($shippingTransportId);
        return redirect()->route('admin.shippings')->with('success', $messages);
    }

    public function take_shipping_product(Request $request, $id)
    {
        $shipping = Shippings::findOrFail($id);
        $courier = $request->courier;
        $courier_phone = $request->courier_telephone;
        $note = $request->note;
        $shippingTransportId = $request->transport_id;
        $shipping->update([
            'courier_take' => $courier,
            'courier_take_phone' => $courier_phone,
            'product_location' => 'Warehouse',
            'note_take' => $note,
            'status' => 'Taken',
        ]);
        $messages = 'Product has been taken';
        $shipping->shippingTransports()->attach($shippingTransportId);
        return redirect()->route('admin.shippings')->with('success', $messages);
    }
    
}
