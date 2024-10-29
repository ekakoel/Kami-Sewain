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
            <div class="admin-navigation-title">Orders</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active"><a href="/admin/orders">Orders</a></div>
            </div>
        </div>
        {{-- PAID ORDERS --}}
        @if (count($paid_orders)>0)
            <div class="card-box mb-30">
                <div class="card-box-header">
                    <div class="card-box-title">Paid Orders</div>
                </div>
                <div class="pb-20">
                    <table id="productTable" class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order No</th>
                                <th>Rental Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paid_orders as $no=>$order)
                                <tr>
                                    <td class="table-plus">{{ ++$no }}</td>
                                    <td>{{ $order->order_no }}</td>
                                    <td>{{ date('d M Y', strtotime($order->rental_start_date)) }} - {{ date('d M Y', strtotime($order->rental_start_date)) }}</td>
                                    <td>Rp {{ number_format($order->total_price, 0, ",", ".") }} </td>
                                    <td>{{ $order->status }} </td>
                                    <td>
                                        <a class="btn-icon" href="{{ route('admin.order.detail',$order->id) }}" type="button"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        @endif
        {{-- ON PAYMENT ORDERS --}}
        @if (count($payment_orders)>0)
            <div class="card-box mb-30">
                <div class="card-box-header">
                    <div class="card-box-title">Orders on Payment</div>
                </div>
                <div class="pb-20">
                    <table id="productTable" class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order No</th>
                                <th>Rental Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment_orders as $pno=>$p_order)
                                @php
                                    $duedate = date('Ymd',strtotime('-7 days',strtotime($p_order->rental_start_date)));
                                    $today = date('Ymd',strtotime($now));
                                @endphp
                                <tr>
                                    <td class="table-plus {{ $duedate < $today?"danger-text":"" }}">{{ ++$pno }}</td>
                                    <td class="{{ $duedate < $today?"danger-text":"" }}" >{{ $p_order->order_no }}</td>
                                    <td class="{{ $duedate < $today?"danger-text":"" }}">{{ date('d M Y', strtotime($p_order->rental_start_date)) }} - {{ date('d M Y', strtotime($p_order->rental_start_date)) }}</td>
                                    <td class="{{ $duedate < $today?"danger-text":"" }}">Rp {{ number_format($p_order->total_price, 0, ",", ".") }} </td>
                                    <td class="{{ $duedate < $today?"danger-text":"" }}">{{ $p_order->status }} </td>
                                    <td class="{{ $duedate < $today?"danger-text":"" }}">
                                        <a class="btn-icon" href="{{ route('admin.order.detail',$p_order->id) }}" type="button"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        @endif
        {{-- ORDER HISTORY --}}
        @if (count($order_history)>0)
            <div class="card-box mb-30">
                <div class="card-box-header">
                    <div class="card-box-title">Order History</div>
                </div>
                <div class="pb-20">
                    <table id="productTable" class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order No</th>
                                <th>Rental Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="datatable-nosort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order_history as $oh=>$h_order)
                                <tr>
                                    <td class="table-plus">{{ ++$oh }}</td>
                                    <td>{{ $h_order->order_no }}</td>
                                    <td>{{ date('d M Y', strtotime($h_order->rental_start_date)) }} - {{ date('d M Y', strtotime($h_order->rental_start_date)) }}</td>
                                    <td>Rp {{ number_format($h_order->total_price, 0, ",", ".") }} </td>
                                    <td>{{ $h_order->status == "Payment"?"Canceled":$h_order->status; }}</td>
                                    <td>
                                        <a class="dropdown-item" href="{{ route('admin.order.detail',$h_order->id) }}" type="button"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        @endif
        
    </div>
</main>
    
@endsection