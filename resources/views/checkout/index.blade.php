@extends('layouts.user-base')

@section('title', 'Checkout')
@section('main')
    <main class="flex-shrink-0">
        <header class="header-container">
            <div class="header-caption">
                <div class="header-title">Checkout</div>
                <p>
                    Complete Your Purchase and Bring Your Dream Event to Life!<br>
                    You're just a few steps away from securing your order.<br>
                    Review your details, finalize payment, and get ready to enjoy an unforgettable experience with our
                    premium services. Thank you for choosing us!
                </p>
            </div>
        </header>
        <div class="container py-5">
            <h2 class="mb-4">Checkout</h2>

            @if (session('cart') && count(session('cart')) > 0)
                @php
                    if (!isset($product_id)) {
                        $product_id = [];
                    }
                    if (!isset($product_price)) {
                        $product_price = [];
                    }
                    if (session('promotion')) {
                        $promo = $promos->where('id', session('promotion')['id'])->first();
                        $total = array_sum(
                            array_map(fn($product) => $product['quantity'] * $product['price'], session('cart')),
                        );
                        if ($promo->discount_percent) {
                            $ttl = ($total / 100) * $promo->discount_percent;
                            $grand_total = $total;
                            $discount = $ttl;
                            $type = 0;
                            $disc_amount = $promo->discount_percent;
                        } elseif ($promo->discount_amount) {
                            $grand_total = $total;
                            $discount = $promo->discount_amount;
                            $type = 1;
                            $disc_amount = $promo->discount_amount;
                        }
                    } else {
                        $type = 3;
                        $disc_amount = 0;
                        $discount = 0;
                        $total = array_sum(
                            array_map(fn($product) => $product['quantity'] * $product['price'], session('cart')),
                        );
                        $grand_total = array_sum(
                            array_map(fn($product) => $product['quantity'] * $product['price'], session('cart')),
                        );
                    }
                @endphp
                <div class="row">
                    <!-- Order Summary -->
                    <div class="col-lg-8">
                        <div class="card-box">
                            <div class="card-box-body">
                                <h4>Order Summary</h4>
                                <table id="sumaryProductTable" class="data-table table stripe hover nowrap">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (session('cart') as $id => $product)
                                            @php
                                                $pr_id = $product['id'];
                                                $pr_price = $product['price'];
                                                array_push($product_id, $pr_id);
                                                array_push($product_price, $pr_price);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="order-item">
                                                        <span>{{ $product['name'] }}</span>
                                                    </div>
                                                </td>
                                                <td>Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                                                <td>{{ $product['quantity'] }}</td>
                                                <td>Rp
                                                    {{ number_format($product['quantity'] * $product['price'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="order-total mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>Daily Price</p>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <p>Rp {{ number_format($total, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p>Duration (Day)</p>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <p><span id="duration">1</span></p>
                                        </div>
                                        @if (isset($promo))
                                            <div class="col-md-12" id="no-promotion-section"
                                                style="display: {{ $promo->minimum_transaction > $total ? 'block' : 'none' }};">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="m-0">Grand Total</h5>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <h5 class="m-0">Rp <span
                                                                id="no-promo-grand_total">{{ number_format($grand_total, 0, ',', '.') }}</span>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="promotion-section"
                                                style="display: {{ $promo->minimum_transaction > $total ? 'none' : 'block' }};">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p>Total</p>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <p>Rp <span
                                                                id="total_price">{{ number_format($total, 0, ',', '.') }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>Promotion / Discount</p>
                                                    </div>
                                                    <div class="col-md-6 text-right color-secondary">
                                                        <p>
                                                            @if ($promo->discount_percent)
                                                                - ({{ $promo->discount_percent }}%) Rp <span
                                                                    id="disc_amount">{{ number_format($discount, 0, ',', '.') }}</span>
                                                            @elseif($promo->discount_amount)
                                                                - Rp <span
                                                                    id="disc_amount">{{ number_format($discount, 0, ',', '.') }}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5 class="m-0">Grand Total</h5>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <h5 class="m-0">Rp <span
                                                                id="grand_total">{{ number_format($grand_total, 0, ',', '.') }}</span>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12" id="promotion-section" style="display: none;">
                                            </div>
                                            <div class="col-md-12" id="no-promotion-section" style="display: block;">
                                                <div class="row">
                                                    <div class="col-md-6 text-right display-none">
                                                        <h5 class="m-0">Rp <span
                                                                id="total_price">{{ number_format($grand_total, 0, ',', '.') }}</span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5 class="m-0">Grand Total</h5>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <h5 class="m-0">Rp <span
                                                                id="grand_total">{{ number_format($grand_total, 0, ',', '.') }}</span>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $productId = json_encode($product_id);
                        $productPrice = json_encode($product_price);
                    @endphp
                    <!-- Shipping Details Form -->
                    <div class="col-lg-4">
                        <div class="card-box">
                            <div class="card-box-body">
                                <form action="{{ route('checkout.process') }}" method="POST">
                                    @csrf
                                    <h4>Payment</h4>
                                    <div class="form-group m-b-18">
                                        <label for="bank_id" class="form-label">Select Bank</label>
                                        <select class="form-select" id="bank_id" name="bank_id" required>
                                            <option value="">Select Bank</option>
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <h4>Rental Details</h4>
                                    <div class="form-group">
                                        <label for="rental_start_date">Rental Start Date</label>
                                        <input type="date" class="form-control" id="rental_start_date"
                                            name="rental_start_date" required onkeydown="return false;">
                                    </div>
                                    <div class="form-group">
                                        <label for="rental_end_date">Rental End Date</label>
                                        <input type="date" class="form-control" id="rental_end_date"
                                            name="rental_end_date" required onkeydown="return false;">
                                    </div>
                                    <h4>Shipping Details</h4>
                                    <div class="form-group">
                                        <label for="recipient">Recipient Name</label>
                                        <input type="text" class="form-control" id="recipient" name="recipient" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="telephone">Telephone</label>
                                        <input type="telephone" class="form-control" id="telephone" name="telephone"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="postcode">Postal Code</label>
                                        <input type="text" class="form-control" id="postcode" name="postcode"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" class="form-control" id="country" name="country"
                                            required>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $productId }}">
                                    <input type="hidden" name="product_price" value="{{ $productPrice }}">
                                    <button type="submit" class="btn button-secondary w-100">Complete Purchase</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    Your cart is empty. <a href="{{ route('cart.view') }}" class="alert-link">Return to cart</a> to add
                    items.
                </div>
            @endif
        </div>
        {{-- FLOATING BUTTON --}}
        <a href="#" class="floating-btn" id="backButton">
            <i class="fas fa-arrow-left"></i>
        </a>
        <script>
            document.getElementById('backButton').addEventListener('click', function(event) {
                event.preventDefault();
                window.history.back();
                setTimeout(function() {
                    window.location.reload();
                }, 100);
            });
        </script>
    </main>
    @include('layouts.partials.footer-secondary')
    <script>
        const rentalStartDateInput = document.getElementById('rental_start_date');
        const rentalEndDateInput = document.getElementById('rental_end_date');
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const formattedTomorrow = tomorrow.toISOString().split('T')[0];
        rentalStartDateInput.setAttribute('min', formattedTomorrow);
        rentalStartDateInput.addEventListener('change', function() {
            const startDate = new Date(this.value);
            startDate.setDate(startDate.getDate() + 1);
            const formattedStartDate = startDate.toISOString().split('T')[0];
            rentalEndDateInput.setAttribute('min', formattedStartDate);
        });
    </script>

    <script>
        document.getElementById('rental_start_date').addEventListener('change', calculateTotal);
        document.getElementById('rental_end_date').addEventListener('change', calculateTotal);

        function calculateTotal() {
            const startDate = new Date(document.getElementById('rental_start_date').value);
            const endDate = new Date(document.getElementById('rental_end_date').value);
            const dailyPrice = {{ $total }};
            const defaultDay = 1;
            const grandTotal = {{ $grand_total }};
            @if (isset($promo))
                const typeDiscount = {{ $type }};
                @if ($type == 0)
                    const totalDiscount = {{ $promo->discount_percent }};
                @elseif ($type == 1)
                    const totalDiscount = {{ $promo->discount_amount ?? 0 }};
                @else
                    const totalDiscount = 3;
                @endif
                const minimumTransaction = {{ $promo->minimum_transaction }};
            @else
                const typeDiscount = 3;
                const totalDiscount = 0;
                const minimumTransaction = 0;
            @endif
            var discountAmount = 0;
            var grandTotalPrice = 0;
            const timeDifference = endDate - startDate;
            const days = timeDifference / (1000 * 3600 * 24);
            if (days > 0) {
                const total = dailyPrice * days;
                document.getElementById('total_price').innerText = new Intl.NumberFormat('id-ID').format(total);
                document.getElementById('duration').innerText = new Intl.NumberFormat('id-ID').format(days);
                if (typeDiscount !== null && total >= minimumTransaction) {
                    if (typeDiscount == 0) {
                        document.getElementById('promotion-section').style.display = 'block';
                        document.getElementById('no-promotion-section').style.display = 'none';
                        discountAmount = Math.round((total / 100) * totalDiscount);
                        grandTotalPrice = Math.round(total - discountAmount);
                        document.getElementById('disc_amount').innerText = new Intl.NumberFormat('id-ID').format(
                            discountAmount);
                    } else if (typeDiscount == 1) {
                        document.getElementById('promotion-section').style.display = 'block';
                        document.getElementById('no-promotion-section').style.display = 'none';
                        discountAmount = totalDiscount;
                        grandTotalPrice = total - totalDiscount;
                        document.getElementById('disc_amount').innerText = new Intl.NumberFormat('id-ID').format(
                            discountAmount);
                    } else {
                        document.getElementById('promotion-section').style.display = 'none';
                        document.getElementById('no-promotion-section').style.display = 'block';
                        discountAmount = 0;
                        grandTotalPrice = total;
                    }
                } else {
                    document.getElementById('promotion-section').style.display = 'none';
                    document.getElementById('no-promotion-section').style.display = 'block';
                    grandTotalPrice = total;
                }
                document.getElementById('grand_total').innerText = new Intl.NumberFormat('id-ID').format(grandTotalPrice);
            } else {
                document.getElementById('grand_total').innerText = new Intl.NumberFormat('id-ID').format(grandTotal);
            }
        }
    </script>
@endsection
