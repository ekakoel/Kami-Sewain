<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ShippingTransport;
use App\Http\Requests\StoreShippingTransportRequest;
use App\Http\Requests\UpdateShippingTransportRequest;

class ShippingTransportController extends Controller
{

    public function index()
    {
        $now = Carbon::now();
        $transports = ShippingTransport::all();
        
        return view('admin.transports.index', compact('transports','now'));
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
    public function store(StoreShippingTransportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingTransport $shippingTransport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingTransport $shippingTransport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShippingTransportRequest $request, ShippingTransport $shippingTransport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingTransport $shippingTransport)
    {
        //
    }
}
