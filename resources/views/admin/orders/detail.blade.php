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
                    <div class="admin-navigation-list"><a href="/admin/orders">Orders</a></div>
                    <div class="admin-navigation-list active">{{ $order->order_no }}</div>
                </div>
            </div>
            
                <div class="row">
                    <div class="col-md-8 m-b-18">
                        <div class="card-box print-only">
                            <div class="card-box-body">
                                <div class="logo-document">
                                    <img src="{{ asset('logo/logo-kami-sewain-caption-color.png') }}"
                                        alt="Logo Kami Sewain">
                                    <div class="business-detail">
                                        <p>
                                            {{ $business->address }}<br>
                                            {{ $business->email }}<br>
                                            {{ $business->website }}<br>
                                            {{ $business->phone_number }}<br>
                                        </p>
                                    </div>
                                </div>
                                <div class="status-document">
                                    @if ($order->status == 'Paid')
                                        <img src="{{ asset('icons/paid.png') }}" alt="Paid Document">
                                    @elseif($order->status == 'Payment')
                                        <img src="{{ asset('icons/unpaid.png') }}" alt="Unpaid Document">
                                    @elseif($order->status == 'Rejected')
                                        <img src="{{ asset('icons/rejected.png') }}" alt="Rejected Document">
                                    @endif
                                </div>
                                <div class="header-document text-center">
                                    <h5>Order {{ $order->order_no }}</h5>
                                </div>
                                <div class="body-document">
                                    <h6>Shipping Details</h6>

                                    <div class="row m-b-18">
                                        <div class="col-6">
                                            <p>
                                                Recipient: <br><i>{{ $order->shipping?->recipient }}</i><br>
                                                Telephone: <br><i>{{ $order->shipping?->telephone }}</i><br>
                                                Address: <br><i>{{ $order->shipping?->address }},
                                                    {{ $order->shipping?->city }}, {{ $order->shipping?->country }},
                                                    ({{ $order->shipping?->postcode }})</i>
                                            </p>
                                        </div>
                                        <div class="col-6 text-right">
                                            <p>
                                                <strong>Duedate</strong>:
                                                <br><i class="{{ date('Ymd', strtotime($order->payment_duedate)) <= date('Ymd', strtotime($now)) ?"color-danger":""}}">{{ date('d M Y', strtotime($order->payment_duedate)) }}</i><br>
                                                Delivery Date:
                                                <br><i>{{ date('d M Y', strtotime($order->shipping?->delivery_date)) }}</i><br>
                                                Return Date:
                                                <br><i>{{ date('d M Y', strtotime($order->shipping?->return_date)) }}</i>
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="hr-light">
                                    <h6>Rental Details</h6>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Product</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->products as $no => $product)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ ++$no }}
                                                    </td>
                                                    <td>
                                                        {{ $product->name }}
                                                    </td>
                                                    <td class="text-center">
                                                        Rp {{ number_format($product->pivot->price, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $product->pivot->quantity }}
                                                    </td>
                                                    <td class="text-right">
                                                        Rp {{ number_format($product->pivot->total_price, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" class="text-right">Total Price</td>
                                                <td class="text-right">Rp {{ number_format($order->total, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right">Duration</td>
                                                <td class="text-right">{{ $order->rental_duration }}
                                                    {{ $order->rental_duration > 1 ? 'Days' : 'Day' }}</td>
                                            </tr>
                                            @if ($order->discount_amount or $order->discount_percent)
                                                <tr>
                                                    <td colspan="4" class="text-right">Total</td>
                                                    <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-right">Promotion / Discount</td>
                                                    @if ($order->discount_amount)
                                                        <td class="text-right color-secondary">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                                                    @elseif($order->discount_percent)
                                                        <td class="text-right color-secondary">- ({{ $order->discount_percent }}%) Rp {{ number_format((($order->total_price / 100)*$order->discount_percent), 0, ',', '.') }}</td>
                                                    @endif
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="4" class="text-right"> <strong>Grand Total</strong></td>
                                                <td class="text-right"> <strong>Rp {{ number_format($order->balance, 0, ',', '.') }}</strong></td>
                                            </tr>
                                            @if (count($receipt_paids)>0)
                                                @foreach ($receipt_paids as $nop=>$paid)
                                                <tr>
                                                    
                                                    <td colspan="4" class="text-right">Payment {{ ++$nop }}, {{ date('d M Y',strtotime($paid->payment_date)) }}</td>
                                                    <td class="text-right">Rp {{ number_format($paid->amount, 0, ',', '.') }}</td>
                                                </tr>
                                                @endforeach
                                                @if ($order->balance > 0)
                                                <tr>
                                                    <td colspan="4" class="text-right"> <strong>Balance</strong></td>
                                                    <td class="text-right"> <strong>Rp {{ number_format($order->balance, 0, ',', '.') }}</strong></td>
                                                </tr>
                                                @else
                                                <tr>
                                                    <td colspan="4" class="text-right"> <strong>Balance</strong></td>
                                                    <td class="text-right"> <strong>Paid</strong></td>
                                                </tr>
                                                @endif
                                            @endif
                                        </tbody>
                                    </table>
                                    <hr class="hr-light">
                                    <strong>Payment Method</strong>
                                    <div class="row m-b-18">
                                        <div class="col-sm-4">
                                            <p>
                                                Bank Name:<br>
                                                <i>{{ $order->bank?->name }}</i>
                                            </p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p>
                                                Account Name:<br>
                                                <i>{{ $order->bank?->account_name }}</i>
                                            </p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p>
                                                Account Number:<br>
                                                <i>{{ $order->bank?->account_number }}</i>
                                            </p>
                                        </div>
                                    </div>

                                    <hr class="hr-light">
                                    <div class="move-to-next-page">
                                        <strong>Terms and Conditions</strong>
                                        <h6>Booking and Payment</h6>
                                        <ul>
                                            <li>
                                                Bookings can be made online or in person.
                                            </li>
                                            <li>
                                                A booking is confirmed after a down payment of 50% of the total rental cost is
                                                made.
                                            </li>
                                            <li>
                                                The remaining balance must be paid no later than 7 days before the event. If
                                                payment is not completed by the due date, we reserve the right to cancel the
                                                booking without refunding the deposit.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if ($order->status == "Payment" && date('dmY',strtotime($order->rental_start_date)) > date('dmY',strtotime($now)) or $order->status == "Rejected" && date('dmY',strtotime($order->rental_start_date)) > date('dmY',strtotime($now)))
                                <div class="card-box-footer">
                                    <form id="setOrderToPaid{{ $order->id }}" action="{{ route('admin.order.set.paid', $order->id) }}" method="POST">
                                        @csrf
                                    </form>
                                    <form id="setOrderToPayment{{ $order->id }}" action="{{ route('admin.order.set.payment', $order->id) }}" method="POST">
                                        @csrf
                                    </form>
                                    <form id="setOrderToRejected{{ $order->id }}" action="{{ route('admin.order.set.reject', $order->id) }}" method="POST">
                                        @csrf
                                    </form>
                                    @if ($order->status == "Payment" && date('dmY',strtotime($order->rental_start_date)) > date('dmY',strtotime($now)))
                                        <button type="submit" form="setOrderToRejected{{ $order->id }}" class="btn button-danger"> <i class="fa fa-check"></i> Set Order Status to Rejected</button>
                                    @elseif($order->status == "Rejected" && date('dmY',strtotime($order->rental_start_date)) > date('dmY',strtotime($now)))
                                        <button type="submit" form="setOrderToPayment{{ $order->id }}" class="btn button-secondary"> <i class="fa fa-check"></i> Set Order Status to Payment</button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 no-print">
                        <div class="card-box">
                            <div class="card-box-body">
                                <div class="card-box-header">
                                    <div class="card-box-title">Receipts</div>
                                </div>
                                @foreach ($order->receipts as $no=>$receipt)
                                    <div class="card-box-card {{ $receipt->status == "Invalid"?"bg-danger":"" }}">
                                        <div class="row">
                                            <form id="deleteReceipt{{ $receipt->id }}" action="{{ route('admin.order.destroy.receipt', $receipt->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <div class="col-6"><strong>Receipt {{ ++$no }}</strong></div>
                                            <div class="col-6 text-right">
                                                <a class="btn-icon"  href="#" data-toggle="modal" data-target="#detailReceipt{{ $receipt->id }}" type="button"><i class="dw dw-eye"></i></a>
                                                @if($order->status == 'Payment')
                                                    <button type="submit" form="deleteReceipt{{ $receipt->id }}" class="btn-icon"> <i class="dw dw-delete-3"></i></button>
                                                @endif
                                            </div>
                                            <div class="col-6">Payment Date:</div>
                                            <div class="col-6 text-right">{{ date('d M y',strtotime($receipt->payment_date)) }}</div>
                                            <div class="col-6">Amount:</div>
                                            <div class="col-6 text-right">Rp {{ number_format($receipt->amount, 0, ',', '.') }}</div>
                                            <div class="col-6">Status:</div>
                                            <div class="col-6 text-right">{{ $receipt->status }}</div>
                                            <div class="modal fade bs-example-modal-lg" id="detailReceipt{{ $receipt->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="modal-title">Receipt {{ $order->order_no }}</div>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body-section">
                                                            <div class="modal-image-section">
                                                                <img class="receipt-img" src="{{ asset('storage/receipts/'.$receipt->receipt_image) }}" alt="Order Receipt">
                                                            </div>
                                                            <div class="modal-detail-section">
                                                                <div class="row">
                                                                    <div class="col-12"><strong>Payment Date</strong></div>
                                                                    <div class="col-12">
                                                                        <i>
                                                                            {{ date('d M Y',strtotime($receipt->payment_date)) }}
                                                                        </i>
                                                                    </div>
                                                                    <div class="col-12"><strong>Amount</strong></div>
                                                                    <div class="col-12 m-b-18">
                                                                        <i>
                                                                            Rp {{ number_format($receipt->amount, 0, ',', '.') }}
                                                                        </i>
                                                                    </div>
                                                                    <div class="col-12"><hr class="hr-light"></div>
                                                                    @if ($receipt->status == "Valid")
                                                                        <div class="col-12">
                                                                            <strong>Note</strong>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <i>{!! $receipt->note !!}</i>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-12">
                                                                            <form id="validateReceipt{{ $receipt->id }}" action="{{ route('admin.order.validate.receipt', $receipt->id) }}" method="POST">
                                                                                @csrf
                                                                                <div class="form-group">
                                                                                    <label for="note">Note</label>
                                                                                    <textarea name="note" class="form-control" rows="5" required>{!! $receipt->note !!}</textarea>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="status">Status</label>
                                                                                    <select class="form-control" id="status" name="status" required>
                                                                                        <option {{ $receipt->status == "Pending"?"selected":""; }} value="">Select Status</option>
                                                                                        <option {{ $receipt->status == "Valid"?"selected":""; }} value="Valid">Valid</option>
                                                                                        <option {{ $receipt->status == "Invalid"?"selected":""; }} value="Invalid">Invalid</option>
                                                                                    </select>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($receipt->status != "Valid")
                                                            <div class="modal-footer">
                                                                <button type="submit" form="validateReceipt{{ $receipt->id }}" class="btn button-secondary"><i class="fas fa-check"></i> Update</button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-12">
                                        @if ($order->balance > 0 or date('Ymd',strtotime($order->rental_end_date)) > date('Ymd',strtotime($now)))
                                            @if($order->status == "Payment" and date('Ymd',strtotime($order->rental_start_date)) > date('Ymd',strtotime($now)))
                                                <h5>Upload Receipts</h5>
                                                <form action="{{ route('admin.receipts.upload') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="payment_date">Payment Date</label>
                                                        <input type="text" name="payment_date" id="payment_date" class="form-control date-picker" placeholder="Select Date" required readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="amount">Amount</label>
                                                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="receipt_image">Upload Payment Receipt</label>
                                                        <input type="file" name="receipt_image" id="receipt_image" class="form-control" accept="image/*" required>
                                                    </div>
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <button type="submit" class="btn button-secondary">Submit Receipt</button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- FLOATING BUTTON --}}
            <a href="{{ route('admin.orders.index') }}" class="floating-btn" id="backButton">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        {{-- <script>
            document.getElementById('backButton').addEventListener('click', function (event) {
                event.preventDefault();
                window.history.back();
                setTimeout(function() {
                    window.location.reload();
                }, 100);
            });
        </script> --}}
    </main>
@endsection
