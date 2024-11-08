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
                                    if ($p_order->discount_amount) {
                                        $p_grand_total = $p_order->total_price - $p_order->discount_amount;
                                    }else {
                                        $p_grand_total = $p_order->total_price;
                                    }
                                    if ($p_order->discount_percent) {
                                        $p_grand_total = $p_order->total_price - ($p_order->total_price * ($p_order->discount_percent / 100));
                                    }else {
                                        $p_grand_total = $p_order->total_price;
                                    }
                                @endphp
                                <tr>
                                    <td class="table-plus {{ $duedate < $today?"danger-text":"" }}">{{ ++$pno }}</td>
                                    <td class="{{ $duedate < $today?"danger-text":"" }}" >{{ $p_order->order_no }}</td>
                                    <td class="{{ $duedate < $today?"danger-text":"" }}">{{ date('d M Y', strtotime($p_order->rental_start_date)) }} - {{ date('d M Y', strtotime($p_order->rental_end_date)) }}</td>
                                    <td class="{{ $duedate < $today?"danger-text":"" }}">
                                        @if ($p_order->discount_amount or $p_order->discount_percent)
                                            <span class="span-disc">Disc</span>
                                        @endif
                                        Rp {{ number_format($p_grand_total, 0, ",", ".") }} 
                                    </td>
                                    <td class="{{ $duedate < $today?"danger-text":"" }}">
                                        {{ $p_order->status }}
                                        @foreach ($p_order->receipts as $p_receipt)
                                            <a href="#" data-toggle="modal" data-target="#receiptDetail{{ $p_receipt->id }}" type="button"> <i class="fa-solid fa-file-image {{ $p_receipt->status == "Invalid"?'color-danger':"" }}" data-toggle="tooltip" data-placement="top" title="Receipt {{ date('d M Y',strtotime($p_receipt->payment_date)) }}"></i></a>
                                            <div class="modal fade" id="receiptDetail{{ $p_receipt->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="modal-title" id="myLargeModalLabel">Payment Receipt</div>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img class="receipt-img" src="{{ asset('storage/receipts/'.$p_receipt->receipt_image) }}" alt="Order Receipt">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
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
                                @php
                                    if ($order->discount_amount) {
                                        $grand_total = $order->total_price - $order->discount_amount;
                                    }else {
                                        $grand_total = $order->total_price;
                                    }
                                    if ($order->discount_percent) {
                                        $grand_total = $order->total_price - ($order->total_price * ($order->discount_percent / 100));
                                    }else {
                                        $grand_total = $order->total_price;
                                    }
                                @endphp
                                <tr>
                                    <td class="table-plus">{{ ++$no }}</td>
                                    <td>{{ $order->order_no }}</td>
                                    <td>{{ date('d M Y', strtotime($order->rental_start_date)) }} - {{ date('d M Y', strtotime($order->rental_end_date)) }}</td>
                                    <td>
                                        @if ($order->discount_amount or $order->discount_percent)
                                            <span class="span-disc">Disc</span>
                                        @endif
                                        Rp {{ number_format($grand_total, 0, ",", ".") }} 
                                    </td>
                                    <td>
                                        {{ $order->status }}
                                        @foreach ($order->receipts as $receipt)
                                            <a href="#" data-toggle="modal" data-target="#receiptDetail{{ $receipt->id }}" type="button"> <i class="fa-solid fa-file-image {{ $receipt->status == "Invalid"?'color-danger':"" }}" data-toggle="tooltip" data-placement="top" title="Receipt {{ date('d M Y',strtotime($receipt->payment_date)) }}"></i></a>
                                            <div class="modal fade" id="receiptDetail{{ $receipt->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="modal-title" id="myLargeModalLabel">Payment Receipt</div>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img class="receipt-img" src="{{ asset('storage/receipts/'.$receipt->receipt_image) }}" alt="Order Receipt">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
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
                                @php
                                    if ($h_order->discount_amount) {
                                        $h_grand_total = $h_order->total_price - $h_order->discount_amount;
                                    }else {
                                        $h_grand_total = $h_order->total_price;
                                    }
                                    if ($h_order->discount_percent) {
                                        $h_grand_total = $h_order->total_price - ($h_order->total_price * ($h_order->discount_percent / 100));
                                    }else {
                                        $h_grand_total = $h_order->total_price;
                                    }
                                @endphp
                                <tr>
                                    <td class="table-plus">{{ ++$oh }}</td>
                                    <td>{{ $h_order->order_no }}</td>
                                    <td>{{ date('d M Y', strtotime($h_order->rental_start_date)) }} - {{ date('d M Y', strtotime($h_order->rental_end_date)) }}</td>
                                    <td>
                                        @if ($h_order->discount_amount or $h_order->discount_percent)
                                            <span class="span-disc">Disc</span>
                                        @endif
                                        Rp {{ number_format($h_grand_total, 0, ",", ".") }} 
                                    </td>
                                    <td>
                                        {{ $h_order->status == "Payment"?"Canceled":$h_order->status; }}
                                        @foreach ($h_order->receipts as $h_receipt)
                                            <a href="#" data-toggle="modal" data-target="#receiptDetail{{ $h_receipt->id }}" type="button"> <i class="fa-solid fa-file-image {{ $h_receipt->status == "Invalid"?'color-danger':"" }}" data-toggle="tooltip" data-placement="top" title="Receipt {{ date('d M Y',strtotime($h_receipt->payment_date)) }}"></i></a>
                                            <div class="modal fade" id="receiptDetail{{ $h_receipt->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myLargeModalLabel">Payment Receipt</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img class="receipt-img" src="{{ asset('storage/receipts/'.$h_receipt->receipt_image) }}" alt="Order Receipt">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
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