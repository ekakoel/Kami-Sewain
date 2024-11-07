@extends('layouts.user-base')
@section('title', 'Orders')
@section('main')
    <main class="flex-shrink-0">
        <div class="header-container no-print">
            <div class="header-caption">
                <div class="header-title">{{ $page_properties ? $page_properties->slider_title : 'Detail Orders' }}</div>
                <p>{{ $page_properties ? $page_properties->slider_caption : 'All Orders' }}</p>
            </div>
        </div>
        <div class="section-container">
            <div class="row">
                <div class="col-md-8 m-b-18">
                    @if ($orders)
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
                                    @else
                                        <img src="{{ asset('icons/unpaid.png') }}" alt="Unpaid Document">
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
                                                Duedate:<br>
                                                <strong>{{ date('d M Y', strtotime($order->payment_duedate)) }}</strong><br>
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
                                                <td colspan="4" class="text-right">Daily Price</td>
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
                        </div>
                    @else
                      <div class="alert alert-warning" role="alert">
                          Your cart is empty. <a href="{{ route('products.index') }}" class="alert-link">Start shopping!</a>
                      </div>

                    @endif
                </div>
                
                <div class="col-md-4 no-print">
                    <div class="card-box">
                        <div class="card-box-header">
                            <div class="card-box-title">
                                Receipts
                            </div>
                        </div>
                        <div class="card-box-body">
                            
                            @if (count($order->receipts)>0)
                                @foreach ($order->receipts as $no=>$receipt)
                                    <div class="card-box-card {{ $receipt->status == "Invalid"?"bg-danger":"" }}">
                                        <div class="row">
                                            <div class="col-12"><strong>Receipt {{ ++$no }}</strong></div>
                                            <div class="col-6">Payment Date:</div>
                                            <div class="col-6 text-right">
                                                <i>{{ date('d M y',strtotime($receipt->payment_date)) }}</i>
                                            </div>
                                            <div class="col-6">Amount:</div>
                                            <div class="col-6 text-right">
                                                <i>Rp {{ number_format($receipt->amount, 0, ',', '.') }}</i>
                                            </div>
                                            <div class="col-6">Status:</div>
                                            <div class="col-6 text-right">
                                                <i>{{ $receipt->status }}</i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                              <p>You have not made a payment for this order. Please upload the payment receipt in the form below if you have already made the payment!</p>
                            @endif
                            @if ($order->balance > 0)
                                @if ($order->status == "Payment")
                                    <hr class="hr-light">
                                    <h5>Send Receipts</h5>
                                    <form action="{{ route('receipts.store') }}" method="POST" enctype="multipart/form-data">
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
        {{-- FLOATING BUTTON --}}
        <a href="#" class="floating-btn no-print" id="backButton">
          <i class="fas fa-arrow-left"></i>
        </a>
        <script>
            document.getElementById('backButton').addEventListener('click', function (event) {
                event.preventDefault();
                window.history.back();
                setTimeout(function() {
                    window.location.reload();
                }, 100);
            });
        </script>
    </main>
    @include('layouts.partials.footer-secondary')
@endsection
