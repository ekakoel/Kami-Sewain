@extends('layouts.user-base')
@section('title', 'Cart')
@section('main')
    <main class="flex-shrink-0">
        <header class="header-container">
            <div class="header-caption">
                <div class="header-title">Cart</div>
                <p>From elegant decor to essential rentals, every item in your cart is ready to elevate your special day.<br>Make sure everything is perfect before you check out!</p>
            </div>
        </header>
        <section class="py-5">
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <h2 class="mb-4">Your Cart</h2>
                @if(session('cart') && count(session('cart')) > 0)
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card-box m-b-18">
                                <div class="card-box-body">
                                    <table id="cartTable" class="data-table table stripe hover nowrap">
                                        <thead>
                                            <tr>
                                                <th class="table-plus datatable-nosort">Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th class="datatable-nosort">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(session('cart') as $id => $product)
                                            <tr>
                                                <td>
                                                    <div class="cart-item">
                                                        {{ $product['name'] }}<br>
                                                        <img src="{{ isset($product['image']) ? asset('images/products/' . $product['image']) : asset('images/products/default.jpeg') }}" alt="{{ $product['name'] }}" width="60" class="img-thumbnail">
                                                    </div>
                                                </td>
                                                <td>Rp {{ number_format($product['price'], 0, ",", ".") }}</td>
                                                <td>{{ $product['quantity'] }}</td>
                                                <td>Rp {{ number_format($product['quantity'] * $product['price'], 0, ",", ".") }}</td>
                                                <td class="text-right">
                                                    
                                                    <div class="dropdown">
                                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                            <i class="dw dw-more"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#detail-{{ $id }}" type="button"><i class="dw dw-edit2"></i> Edit</a>
                                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="dw dw-delete-3"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="detail-{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myLargeModalLabel">{{ $product['name'] }}</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label for="quantity{{ $product['id'] }}">Quantity</label>
                                                                            <div class="product-quantity-section">
                                                                                <button class="quantity-btn-min" onclick="changeQuantity({{ $product['id'] }}, -1, event)">&#8722;</button>
                                                                                <form id="updateCart-{{ $product['id'] }}" action="{{ route('cart.update',$product['id']) }}" method="POST">
                                                                                    @csrf
                                                                                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                                                                                    <input type="number" id="quantity{{ $product['id'] }}" name="quantity" min="1" value="{{ $product['quantity'] }}" class="quantity-input" oninput="updatePrice({{ $product['id'] }})">
                                                                                </form>
                                                                                <button class="quantity-btn-plus" onclick="changeQuantity({{ $product['id'] }}, 1)">&#43;</button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="quantity{{ $product['id'] }}">Price</label>
                                                                            <div class="product-price-section">
                                                                                <div class="card-price-container">
                                                                                    <div class="card-price-kurs">/unit/pcs/pax</div>
                                                                                    <div class="card-price" id="price{{ $product['id'] }}">
                                                                                        {{ number_format($product['price'], 0, ",", ".") }} IDR
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                                <div class="card-price-container">
                                                                                    <div class="card-price-kurs">Total</div>
                                                                                    <div class="card-price-total" id="totalPrice{{ $product['id'] }}">
                                                                                        {{ number_format($product['quantity'] * $product['price'], 0, ",", ".") }} IDR
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" form="updateCart-{{ $product['id'] }}" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            
                            <div class="cart-summary p-4 border rounded bg-light">
                                <h4>Cart Summary</h4>
                                <hr>
                                <div class="row">
                                    @if (count($promotions)>0)
                                        <div class="col-md-12 text-right">
                                            @if (session('promotion'))
                                                @php
                                                    $promo = $promos->where('id',session('promotion')['id'])->first();
                                                    $total_transaction = array_sum(array_map(fn($product) => $product['quantity'] * $product['price'], session('cart')));
                                                @endphp
                                                <p style="text-transform: uppercase">{{ $promo->name }}</p>
                                                @if ($promo->minimum_transaction > $total_transaction)
                                                    <p style="color:brown !important;">You cannot use this promotion because of the minimum transaction</p>
                                                @endif
                                                <div class="btn-container">
                                                    @if (count($promotions)>1)
                                                        <a data-toggle="modal" data-target="#addPromo" type="button">
                                                            <button type="submit" class="btn btn-primary">Change Promo</button>
                                                        </a>
                                                    @endif
                                                    <form action="{{ route('promotion.remove') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Remove Promo</button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="btn-container">
                                                    <a data-toggle="modal" data-target="#addPromo" type="button">
                                                        <button type="submit" class="btn btn-primary">Add Promo</button>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        @if (session('promotion'))
                                            @if ($promo->minimum_transaction <= $total_transaction)
                                                <div class="col-md-6"><p>Total</p></div>
                                                <div class="col-md-6 text-right"><p>Rp {{ number_format(array_sum(array_map(fn($product) => $product['quantity'] * $product['price'], session('cart'))), 0, ",", ".") }}</p></div>
                                                <div class="col-md-6"><p>Promotion</p></div>
                                                @if ($promo->discount_percent)
                                                    @php
                                                        $ttl = array_sum(array_map(fn($product) => $product['quantity'] * $product['price'], session('cart')));
                                                        $total = ($ttl / 100)*$promo->discount_percent;
                                                        $grand_total = $ttl - $total;
                                                    @endphp
                                                    <div class="col-md-6 text-right color-secondary"><p>({{ $promo->discount_percent }}%) Rp {{ number_format($total, 0, ",", ".") }}</p></div>
                                                @elseif ($promo->discount_amount)
                                                    @php
                                                        $ttl = array_sum(array_map(fn($product) => $product['quantity'] * $product['price'], session('cart')));
                                                        $grand_total = $ttl - $promo->discount_amount;
                                                    @endphp
                                                    <div class="col-md-6 text-right color-secondary"><p>Rp {{ number_format($promo->discount_amount, 0, ",", ".") }}</p></div>
                                                @endif
                                                <div class="col-md-6"><p>Grand Total</p></div>
                                                <div class="col-md-6 text-right"><p><strong>Rp {{ number_format($grand_total, 0, ",", ".") }}</strong></p></div>
                                            @else
                                                <div class="col-md-6"><p>Total</p></div>
                                                <div class="col-md-6 text-right"><p><strong>Rp {{ number_format(array_sum(array_map(fn($product) => $product['quantity'] * $product['price'], session('cart'))), 0, ",", ".") }}</strong></p></div>
                                            @endif
                                        @else
                                            <div class="col-md-6"><p>Total</p></div>
                                            <div class="col-md-6 text-right"><p><strong>Rp {{ number_format(array_sum(array_map(fn($product) => $product['quantity'] * $product['price'], session('cart'))), 0, ",", ".") }}</strong></p></div>
                                        @endif
                                    @else
                                        <div class="col-md-6"><p>Total</p></div>
                                        <div class="col-md-6 text-right"><p><strong>Rp {{ number_format(array_sum(array_map(fn($product) => $product['quantity'] * $product['price'], session('cart'))), 0, ",", ".") }}</strong></p></div>
                                    @endif
                                </div>
                                <a href="{{ route('products.index') }}" class="btn button-secondary w-100 m-b-8">Add More Product</a>
                                <a href="{{ route('checkout') }}" class="btn button-secondary w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                        <div class="modal fade" id="addPromo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myLargeModalLabel">Select Promotion</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            @foreach($promotions as $promotion)
                                                @if (session('promotion'))
                                                    @if ($promotion->id != $promo->id)
                                                        
                                                        <div class="col-md-6">
                                                            <div class="card mb-4">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ $promotion->name }}</h5>
                                                                    <p class="card-text">Code: <strong>{{ $promotion->promotion_code }}</strong></p>
                                                                    @if ($promotion->discount_amount)
                                                                        <p class="card-text">Discount: <strong>Rp {{ number_format($promotion->discount_amount, 0, ",", ".") }}</strong></p>
                                                                    @else
                                                                        <p class="card-text">Discount: <strong>{{ $promotion->discount_percent }}%</strong></p>
                                                                    @endif
                                                                    <div class="card-form text-right">
                                                                        <form action="{{ route('cart.promotions.use', $promotion->id) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-primary w-100">Use Promotion</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="col-md-6">
                                                        <div class="card mb-4">
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $promotion->name }}</h5>
                                                                <p class="card-text">Code: <strong>{{ $promotion->promotion_code }}</strong></p>
                                                                @if ($promotion->discount_amount)
                                                                    <p class="card-text">Discount: <strong>Rp {{ number_format($promotion->discount_amount, 0, ",", ".") }}</strong></p>
                                                                @else
                                                                    <p class="card-text">Discount: <strong>{{ $promotion->discount_percent }}%</strong></p>
                                                                @endif
                                                                <div class="card-form text-right">
                                                                    <form action="{{ route('cart.promotions.use', $promotion->id) }}" method="POST">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-primary w-100">Use Promotion</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    </div>
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
        </section>
        <script>
           function changeQuantity(productId, amount, event) {
                // Prevent button's default behavior (form submission)
                if (event) {
                    event.preventDefault();
                }

                // Get quantity input field
                const quantityInput = document.getElementById('quantity' + productId);
                let currentValue = parseInt(quantityInput.value);

                // Update quantity value
                currentValue += amount;
                if (currentValue < 1) {
                    currentValue = 1; // Prevent quantity going below 1
                }

                quantityInput.value = currentValue;

                // Optionally update price based on quantity (if needed)
                updatePrice(productId);
            }
                function updatePrice(productId) {
                    const quantityInput = document.getElementById('quantity' + productId);
                    const priceElement = document.getElementById('price' + productId);
                    const totalPriceElement = document.getElementById('totalPrice' + productId);

                    // Get the price of the product
                    const productPrice = parseFloat(priceElement.innerText.replace(/\./g, '').replace(',', '.')); // Convert to float

                    // Calculate the total price
                    const totalPrice = productPrice * parseInt(quantityInput.value);

                    // Update the total price display
                    totalPriceElement.innerText = number_format(totalPrice, 0, ",", ".") + ' IDR' ;
                }

                // Utility function to format numbers
                function number_format(number, decimals, dec_point, thousands_sep) {
                    number = (number + '').replace(',', '').replace(' ', '');
                    var n = !isFinite(+number) ? 0 : +number,
                        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                        sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
                        dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
                        toFixedFix = function(n, prec) {
                            var k = Math.pow(10, prec);
                            return '' + Math.round(n * k) / k;
                        };
                    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                    var s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                    if (s[0].length > 3) {
                        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                    }
                    if ((s[1] || '').length < prec) {
                        s[1] = s[1] || '';
                        s[1] += new Array(prec - s[1].length + 1).join('0');
                    }
                    return s.join(dec);
                }
        </script>
        {{-- FLOATING BUTTON --}}
        <a href="#" class="floating-btn" id="backButton">
            <i class="fas fa-arrow-left"></i>
        </a>
        <script>
            document.getElementById('backButton').addEventListener('click', function (event) {
                event.preventDefault();  // Prevent default anchor behavior
                window.history.back();   // Navigate to the previous page
                setTimeout(function() {  // Delay reload to ensure history.back() completes
                    window.location.reload(); // Force page reload after navigation
                }, 100);
            });
        </script>
    </main>
    @include('layouts.partials.footer-secondary')
@endsection