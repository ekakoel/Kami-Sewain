@extends('admin.layouts.master')

@section('title', 'Product Order')

@section('main')
<main>
    <div class="container-fluid px-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="admin-navigation">
            <div class="admin-navigation-title">Shippings</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active"><a href="/admin/shippings">Shippings</a></div>
            </div>
        </div>
        {{-- SHIPPINGS PREPARED--}}
        @if (count($shippingPres)>0)
            <div class="card-box mb-30">
                <div class="card-box-header">
                    <div class="card-box-title">Prepared (Warehouse)</div>
                </div>
                <div class="pb-20">
                    <table id="productTable" class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Rental Date</th>
                                <th>Order No</th>
                                <th>Product</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shippingPres as $no=>$shipping_pre)
                                <tr class="{{ date('dmY',strtotime($shipping_pre->delivery_date.'-2 days')) <= date('dmY',strtotime($now))?"bg-red":"" }}">
                                    <td>{{ date('d M Y', strtotime($shipping_pre->delivery_date)) }} - {{ date('d M Y', strtotime($shipping_pre->return_date)) }} ({{  $shipping_pre->order->rental_duration }}{{ $shipping_pre->order->rental_duration > 1?" Days":" Day" }})</td>
                                    <td>{{ $shipping_pre->order->order_no }}</td>
                                    <td>
                                        @foreach ($shipping_pre->order->products as $product)
                                            {{ "- ". $product->name." (".$product->pivot->quantity." pcs)" }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $shipping_pre->product_location }}</td>
                                    {{-- <td>Rp {{ number_format($shipping_pre->total_price, 0, ",", ".") }} </td> --}}
                                    <td>
                                        @if ($shipping_pre->order->status == "Paid")
                                            {{ $shipping_pre->status }}
                                        @else
                                            Unpaid
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                @if ($shipping_pre->order->status == "Paid")
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#updateProduct{{ $shipping_pre->id }}" type="button"><i class="fa-solid fa-pencil"></i> Update</a>
                                                @endif
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#detailProduct{{ $shipping_pre->id }}" type="button"><i class="fa-solid fa-eye"></i> Detail</a>
                                            </div>
                                        </div>
                                        
                                        {{-- <a class="btn-icon" href="{{ route('admin.shipping.detail',$shipping_pre->id) }}" type="button"><i class="fa-solid fa-eye"></i></a> --}}
                                    </td>
                                </tr>
                                {{-- MODAL DETAIL PRODUCT --}}
                                <div class="modal fade" id="detailProduct{{ $shipping_pre->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h4 class="modal-title m-0">{{ $shipping_pre->product_location == 'Warehouse'?"Delivery Product":"Product Intake" }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="m-0"><strong>Status</strong></p>
                                                <p class="color-secondary">
                                                    @if ($shipping_pre->order->status == "Paid")
                                                        {{ $shipping_pre->status }}
                                                    @else
                                                        Unpaid
                                                    @endif
                                                </p>
                                                <p class="m-0"><strong>Product</strong></p>
                                                <p>
                                                    @foreach ($shipping_pre->order->products as $delivery_product)
                                                        {{ "- ". $delivery_product->name." (".$delivery_product->pivot->quantity." pcs)" }}<br>
                                                    @endforeach
                                                </p>
                                                
                                                <p class="m-0"><strong>{{ $shipping_pre->product_location == 'Warehouse'?"Recipient":"Responsible" }}</strong></p>
                                                <p>
                                                    {{ $shipping_pre->recipient }} ({{ $shipping_pre->telephone }})
                                                </p>
                                                <p class="m-0"><strong>{{ $shipping_pre->product_location == 'Warehouse'?"Shipping Address":"Product Location" }}</strong></p>
                                                <p>
                                                    {{ $shipping_pre->address.", ".$shipping_pre->city.', '.$shipping_pre->country.' ('.$shipping_pre->postcode.')' }}
                                                </p>
                                                <p class="m-0"><strong>Rental Date</strong></p>
                                                <p>
                                                    {{ date('d M Y',strtotime($shipping_pre->delivery_date)).' - '.date('d M Y',strtotime($shipping_pre->return_date)) }}
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- MODAL UPDATE PRODUCT --}}
                                @if ($shipping_pre->order->status == "Paid")
                                    <div class="modal fade" id="updateProduct{{ $shipping_pre->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">

                                                    <h4 class="modal-title m-0" id="myLargeModalLabel">{{ $shipping_pre->product_location == 'Warehouse'?"Delivery Product":"Product Intake" }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.shipping.update',$shipping_pre->id) }}" method="POST" id="updateShippingProduct{{ $shipping_pre->id }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <p class="m-0"><strong>Product</strong></p>
                                                        <p>
                                                            @foreach ($shipping_pre->order->products as $delivery_product)
                                                                {{ "- ". $delivery_product->name." (".$delivery_product->pivot->quantity." pcs)" }}<br>
                                                            @endforeach
                                                        </p>
                                                        
                                                        <p class="m-0"><strong>{{ $shipping_pre->product_location == 'Warehouse'?"Recipient":"Responsible" }}</strong></p>
                                                        <p>
                                                            {{ $shipping_pre->recipient }} ({{ $shipping_pre->telephone }})
                                                        </p>
                                                        <p class="m-0"><strong>{{ $shipping_pre->product_location == 'Warehouse'?"Shipping Address":"Product Location" }}</strong></p>
                                                        <p>
                                                            {{ $shipping_pre->address.", ".$shipping_pre->city.', '.$shipping_pre->country.' ('.$shipping_pre->postcode.')' }}
                                                        </p>
                                                        <p class="m-0"><strong>Rental Date</strong></p>
                                                        <p>
                                                            {{ date('d M Y',strtotime($shipping_pre->delivery_date)).' - '.date('d M Y',strtotime($shipping_pre->return_date)) }}
                                                        </p>
                                                        <hr class="hr-light">
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <select name="status" id="status_product" class="form-control" required>
                                                                <option selected value="Prepared">Prepared</option>
                                                                <option value="Ready">Ready</option>
                                                                <option value="Cancel">Cancel</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                                    <button type="submit" form="updateShippingProduct{{ $shipping_pre->id }}" class="btn button-secondary" id="sendProductToCustomer"><i class="fa-solid fa-check"></i> Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        @endif

        {{-- SHIPPINGS READY TO SEND--}}
        @if (count($shippingIns)>0)
            <div class="card-box mb-30">
                <div class="card-box-header">
                    <div class="card-box-title">Ready for delivery (Warehouse)</div>
                </div>
                <div class="pb-20">
                    <table id="productTable" class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order No</th>
                                <th>Rental Date</th>
                                <th>Product</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shippingIns as $no=>$shipping_in)
                                <tr class="{{ date('dmY',strtotime($shipping_in->delivery_date.'-2 days')) <= date('dmY',strtotime($now))?"bg-red":"" }}">
                                    <td class="table-plus">{{ ++$no }}</td>
                                    <td>{{ $shipping_in->order->order_no }}</td>
                                    <td>{{ date('d M Y', strtotime($shipping_in->delivery_date)) }} - {{ date('d M Y', strtotime($shipping_in->return_date)) }} ({{  $shipping_in->order->rental_duration }}{{ $shipping_in->order->rental_duration > 1?" Days":" Day" }})</td>
                                    <td>
                                        @foreach ($shipping_in->order->products as $product)
                                            {{ "- ". $product->name." (".$product->pivot->quantity." pcs)" }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $shipping_in->product_location }}</td>
                                    {{-- <td>Rp {{ number_format($shipping_in->total_price, 0, ",", ".") }} </td> --}}
                                    <td>{{ $shipping_in->status }} </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                @if ($shipping_in->product_location == 'Warehouse')
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sendProduct{{ $shipping_in->id }}" type="button"><i class="fa-solid fa-truck"></i> Send</a>
                                                @else
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sendProduct{{ $shipping_in->id }}" type="button"><i class="fa-solid fa-truck"></i> Take</a>
                                                @endif
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#detailProduct{{ $shipping_in->id }}" type="button"><i class="fa-solid fa-eye"></i> Detail</a>
                                            </div>
                                        </div>
                                        
                                        {{-- <a class="btn-icon" href="{{ route('admin.shipping.detail',$shipping_in->id) }}" type="button"><i class="fa-solid fa-eye"></i></a> --}}
                                    </td>
                                </tr>
                                {{-- MODAL DETAIL PRODUCT --}}
                                <div class="modal fade" id="detailProduct{{ $shipping_in->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h4 class="modal-title m-0">{{ $shipping_in->product_location == 'Warehouse'?"Delivery Product":"Product Intake" }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="m-0"><strong>Status</strong></p>
                                                <p class="color-secondary">
                                                    {{ $shipping_in->status }}
                                                </p>
                                                <p class="m-0"><strong>Product</strong></p>
                                                <p>
                                                    @foreach ($shipping_in->order->products as $delivery_product)
                                                        {{ "- ". $delivery_product->name." (".$delivery_product->pivot->quantity." pcs)" }}<br>
                                                    @endforeach
                                                </p>
                                                
                                                <p class="m-0"><strong>{{ $shipping_in->product_location == 'Warehouse'?"Recipient":"Responsible" }}</strong></p>
                                                <p>
                                                    {{ $shipping_in->recipient }} ({{ $shipping_in->telephone }})
                                                </p>
                                                <p class="m-0"><strong>{{ $shipping_in->product_location == 'Warehouse'?"Shipping Address":"Product Location" }}</strong></p>
                                                <p>
                                                    {{ $shipping_in->address.", ".$shipping_in->city.', '.$shipping_in->country.' ('.$shipping_in->postcode.')' }}
                                                </p>
                                                <p class="m-0"><strong>Rental Date</strong></p>
                                                <p>
                                                    {{ date('d M Y',strtotime($shipping_in->delivery_date)).' - '.date('d M Y',strtotime($shipping_in->return_date)) }}
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- MODAL SEND PRODUCT --}}
                                <div class="modal fade" id="sendProduct{{ $shipping_in->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h4 class="modal-title m-0" id="myLargeModalLabel">{{ $shipping_in->product_location == 'Warehouse'?"Delivery Product":"Product Intake" }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.shipping.send',$shipping_in->id) }}" method="POST" id="sendShippingProduct{{ $shipping_in->id }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <p class="m-0"><strong>Product</strong></p>
                                                    <p>
                                                        @foreach ($shipping_in->order->products as $delivery_product)
                                                            {{ "- ". $delivery_product->name." (".$delivery_product->pivot->quantity." pcs)" }}<br>
                                                        @endforeach
                                                    </p>
                                                    
                                                    <p class="m-0"><strong>{{ $shipping_in->product_location == 'Warehouse'?"Recipient":"Responsible" }}</strong></p>
                                                    <p>
                                                        {{ $shipping_in->recipient }} ({{ $shipping_in->telephone }})
                                                    </p>
                                                    <p class="m-0"><strong>{{ $shipping_in->product_location == 'Warehouse'?"Shipping Address":"Product Location" }}</strong></p>
                                                    <p>
                                                        {{ $shipping_in->address.", ".$shipping_in->city.', '.$shipping_in->country.' ('.$shipping_in->postcode.')' }}
                                                    </p>
                                                    <p class="m-0"><strong>SRC - DST</strong></p>
                                                    <p>
                                                        @if ($shipping_in->product_location == 'Warehouse')
                                                            Warehouse -> {{ $shipping_in->address.", ".$shipping_in->city.', '.$shipping_in->country.' ('.$shipping_in->postcode.')' }}
                                                        @else
                                                            {{ $shipping_in->address.", ".$shipping_in->city.', '.$shipping_in->country.' ('.$shipping_in->postcode.')' }} -> Warehouse
                                                        @endif
                                                    </p>
                                                    <hr class="hr-light">
                                                    <div class="form-group">
                                                        <label for="transport_id">Transport</label>
                                                        <select name="transport_id" id="transport_id" class="form-control" required>
                                                            <option selected value="">Select Transport</option>
                                                            @foreach ($transports as $transport)
                                                                <option value="{{ $transport->id }}">{{ $transport->name }} ({{ $transport->type.' - '.$transport->brand }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="courier">Courier Name <span>*</span></label>
                                                        <input type="text" class="form-control" id="courier" name="courier" value="{{ old('courier') }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="courier_telephone">Courier Telephone <span>*</span></label>
                                                        <input type="number" class="form-control" id="courier_telephone" name="courier_telephone" value="{{ old('courier_telephone') }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="note">Note</label>
                                                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                                <button type="submit" form="sendShippingProduct{{ $shipping_in->id }}" class="btn button-secondary" id="sendProductToCustomer"><i class="fa-solid fa-truck"></i> Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        @endif
        {{-- SHIPPINGS STANDBY --}}
        @if (count($shippingStandBy)>0)
            <div class="card-box mb-30">
                <div class="card-box-header">
                    <div class="card-box-title">Stand by (Rental Location)</div>
                </div>
                <div class="pb-20">
                    <table id="productTable" class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order No</th>
                                <th>Rental Date</th>
                                <th>Product</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shippingStandBy as $use=>$shipping_standby)
                                <tr>
                                    <td class="table-plus">{{ ++$use }}</td>
                                    <td>{{ $shipping_standby->order->order_no }}</td>
                                    <td>{{ date('d M Y', strtotime($shipping_standby->delivery_date)) }} - {{ date('d M Y', strtotime($shipping_standby->return_date)) }} ({{  $shipping_standby->order->rental_duration }}{{ $shipping_standby->order->rental_duration > 1?" Days":" Day" }})</td>
                                    <td>
                                        @foreach ($shipping_standby->order->products as $product)
                                            {{ "- ". $product->name." (".$product->pivot->quantity." pcs)" }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $shipping_standby->product_location }}</td>
                                    {{-- <td>Rp {{ number_format($shipping_standby->total_price, 0, ",", ".") }} </td> --}}
                                    <td>Stand by</td>
                                    <td>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#detailProduct{{ $shipping_standby->id }}" type="button"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="detailProduct{{ $shipping_standby->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h4 class="modal-title m-0">{{ $shipping_standby->product_location == 'Warehouse'?"Delivery Product":"Product Intake" }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="m-0"><strong>Product</strong></p>
                                                <p>
                                                    @foreach ($shipping_standby->order->products as $delivery_product)
                                                        {{ "- ". $delivery_product->name." (".$delivery_product->pivot->quantity." pcs)" }}<br>
                                                    @endforeach
                                                </p>
                                                
                                                <p class="m-0"><strong>{{ $shipping_standby->product_location == 'Warehouse'?"Recipient":"Responsible" }}</strong></p>
                                                <p>
                                                    {{ $shipping_standby->recipient }} ({{ $shipping_standby->telephone }})
                                                </p>
                                                <p class="m-0"><strong>{{ $shipping_standby->product_location == 'Warehouse'?"Shipping Address":"Product Location" }}</strong></p>
                                                <p>
                                                    {{ $shipping_standby->address.", ".$shipping_standby->city.', '.$shipping_standby->country.' ('.$shipping_standby->postcode.')' }}
                                                </p>
                                                <p class="m-0"><strong>Rental Date</strong></p>
                                                <p>
                                                    {{ date('d M Y',strtotime($shipping_standby->delivery_date)).' - '.date('d M Y',strtotime($shipping_standby->return_date)) }}
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        @endif
        {{-- SHIPPINGS IN USE--}}
        @if (count($shippingInUses)>0)
            <div class="card-box mb-30">
                <div class="card-box-header">
                    <div class="card-box-title">Used (Rental Location)</div>
                </div>
                <div class="pb-20">
                    <table id="productTable" class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Rental Date</th>
                                <th>Order No</th>
                                <th>Product</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shippingInUses as $use=>$shipping_use)
                                <tr class="{{ date('ymd',strtotime($shipping_use->order->rental_start_date)) == date('ymd',strtotime($now))?"bg-green":""; }}">
                                    <td>{{ date('d M Y', strtotime($shipping_use->delivery_date)) }} - {{ date('d M Y', strtotime($shipping_use->return_date)) }} ({{  $shipping_use->order->rental_duration }}{{ $shipping_use->order->rental_duration > 1?" Days":" Day" }})</td>
                                    <td>{{ $shipping_use->order->order_no }}</td>
                                    <td>
                                        @foreach ($shipping_use->order->products as $product)
                                            {{ "- ". $product->name." (".$product->pivot->quantity." pcs)" }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $shipping_use->product_location }}</td>
                                    {{-- <td>Rp {{ number_format($shipping_use->total_price, 0, ",", ".") }} </td> --}}
                                    <td>Used</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#detailProduct{{ $shipping_use->id }}"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="detailProduct{{ $shipping_use->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h4 class="modal-title m-0">{{ $shipping_use->product_location == 'Warehouse'?"Delivery Product":"Product Intake" }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="m-0"><strong>Product</strong></p>
                                                <p>
                                                    @foreach ($shipping_use->order->products as $delivery_product)
                                                        {{ "- ". $delivery_product->name." (".$delivery_product->pivot->quantity." pcs)" }}<br>
                                                    @endforeach
                                                </p>
                                                
                                                <p class="m-0"><strong>{{ $shipping_use->product_location == 'Warehouse'?"Recipient":"Responsible" }}</strong></p>
                                                <p>
                                                    {{ $shipping_use->recipient }} ({{ $shipping_use->telephone }})
                                                </p>
                                                <p class="m-0"><strong>{{ $shipping_use->product_location == 'Warehouse'?"Shipping Address":"Product Location" }}</strong></p>
                                                <p>
                                                    {{ $shipping_use->address.", ".$shipping_use->city.', '.$shipping_use->country.' ('.$shipping_use->postcode.')' }}
                                                </p>
                                                <p class="m-0"><strong>Rental Date</strong></p>
                                                <p>
                                                    {{ date('d M Y',strtotime($shipping_use->delivery_date)).' - '.date('d M Y',strtotime($shipping_use->return_date)) }}
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        @endif
        
        {{-- SHIPPINGS OUT--}}
        @if (count($shippingOuts)>0)
            <div class="card-box mb-30">
                <div class="card-box-header">
                    <div class="card-box-title">Done (waiting for pickup)</div>
                </div>
                <div class="pb-20">
                    <table id="productTable" class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Rental Date</th>
                                <th>Order No</th>
                                <th>Product</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shippingOuts as $no=>$shipping_out)
                                <tr>
                                    <td>{{ date('d M Y', strtotime($shipping_out->delivery_date)) }} - {{ date('d M Y', strtotime($shipping_out->return_date)) }} ({{  $shipping_out->order->rental_duration }}{{ $shipping_out->order->rental_duration > 1?" Days":" Day" }})</td>
                                    <td>{{ $shipping_out->order->order_no }}</td>
                                    <td>
                                        @foreach ($shipping_out->order->products as $product)
                                            {{ "- ". $product->name." (".$product->pivot->quantity." pcs)" }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $shipping_out->product_location }}</td>
                                    {{-- <td>Rp {{ number_format($shipping_out->total_price, 0, ",", ".") }} </td> --}}
                                    <td>Return</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                <i class="dw dw-more"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                @if ($shipping_out->product_location == 'Warehouse')
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#takeProduct{{ $shipping_out->id }}" type="button"><i class="fa-solid fa-truck"></i> Send</a>
                                                @else
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#takeProduct{{ $shipping_out->id }}" type="button"><i class="fa-solid fa-truck"></i> Take</a>
                                                @endif
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#detailProduct{{ $shipping_out->id }}" type="button"><i class="fa-solid fa-eye"></i> Detail</a>
                                                
                                            </div>
                                        </div>
                                        
                                        {{-- <a class="btn-icon" href="{{ route('admin.shipping.detail',$shipping_out->id) }}" type="button"><i class="fa-solid fa-eye"></i></a> --}}
                                    </td>
                                </tr>
                                <div class="modal fade" id="detailProduct{{ $shipping_out->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h4 class="modal-title m-0">{{ $shipping_out->product_location == 'Warehouse'?"Delivery Product":"Product Intake" }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="m-0"><strong>Product</strong></p>
                                                <p>
                                                    @foreach ($shipping_out->order->products as $delivery_product)
                                                        {{ "- ". $delivery_product->name." (".$delivery_product->pivot->quantity." pcs)" }}<br>
                                                    @endforeach
                                                </p>
                                                
                                                <p class="m-0"><strong>{{ $shipping_out->product_location == 'Warehouse'?"Recipient":"Responsible" }}</strong></p>
                                                <p>
                                                    {{ $shipping_out->recipient }} ({{ $shipping_out->telephone }})
                                                </p>
                                                <p class="m-0"><strong>{{ $shipping_out->product_location == 'Warehouse'?"Shipping Address":"Product Location" }}</strong></p>
                                                <p>
                                                    {{ $shipping_out->address.", ".$shipping_out->city.', '.$shipping_out->country.' ('.$shipping_out->postcode.')' }}
                                                </p>
                                                <p class="m-0"><strong>Rental Date</strong></p>
                                                <p>
                                                    {{ date('d M Y',strtotime($shipping_out->delivery_date)).' - '.date('d M Y',strtotime($shipping_out->return_date)) }}
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="takeProduct{{ $shipping_out->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h4 class="modal-title m-0">{{ $shipping_out->product_location == 'Warehouse'?"Delivery Product":"Product Intake" }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.shipping.take',$shipping_out->id) }}" method="POST" id="takeShippingProduct{{ $shipping_out->id }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <p class="m-0"><strong>Product</strong></p>
                                                    <p>
                                                        @foreach ($shipping_out->order->products as $delivery_product)
                                                            {{ "- ". $delivery_product->name." (".$delivery_product->pivot->quantity." pcs)" }}<br>
                                                        @endforeach
                                                    </p>
                                                    
                                                    <p class="m-0"><strong>{{ $shipping_out->product_location == 'Warehouse'?"Recipient":"Responsible" }}</strong></p>
                                                    <p>
                                                        {{ $shipping_out->recipient }} ({{ $shipping_out->telephone }})
                                                    </p>
                                                    <p class="m-0"><strong>{{ $shipping_out->product_location == 'Warehouse'?"Shipping Address":"Product Location" }}</strong></p>
                                                    <p>
                                                        {{ $shipping_out->address.", ".$shipping_out->city.', '.$shipping_out->country.' ('.$shipping_out->postcode.')' }}
                                                    </p>
                                                    <p class="m-0"><strong>SRC - DST</strong></p>
                                                    <p>
                                                        @if ($shipping_out->product_location == 'Warehouse')
                                                            Warehouse -> {{ $shipping_out->address.", ".$shipping_out->city.', '.$shipping_out->country.' ('.$shipping_out->postcode.')' }}
                                                        @else
                                                            {{ $shipping_out->address.", ".$shipping_out->city.', '.$shipping_out->country.' ('.$shipping_out->postcode.')' }} -> Warehouse
                                                        @endif
                                                    </p>
                                                    <hr class="hr-light">
                                                    <div class="form-group">
                                                        <label for="transport_id">Transport</label>
                                                        <select name="transport_id" id="transport_id" class="form-control" required>
                                                            <option selected value="">Select Transport</option>
                                                            @foreach ($transports as $transport)
                                                                <option value="{{ $transport->id }}">{{ $transport->name }} ({{ $transport->type.' - '.$transport->brand }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="courier">Courier Name <span>*</span></label>
                                                        <input type="text" class="form-control" id="courier" name="courier" value="{{ old('courier') }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="courier_telephone">Courier Telephone <span>*</span></label>
                                                        <input type="number" class="form-control" id="courier_telephone" name="courier_telephone" value="{{ old('courier_telephone') }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="note">Note</label>
                                                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                                <button type="submit" form="takeShippingProduct{{ $shipping_out->id }}" class="btn button-secondary" id="takeProductToCustomer"><i class="fa-solid fa-truck"></i> Pickup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        @endif
        
        
        
    </div>
</main>
    
@endsection