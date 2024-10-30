
@extends('layouts.master')
@section('title', 'Home')
@section('main')
    <main class="flex-shrink-0">
        <!-- Header-->
        <section id="slider">
            <div class="main-slider-container">
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block" src="{{ asset('images/slider/slider_01.jpeg') }}" alt="kami sewain table" />
                        </div>
                        <div class="carousel-item">
                            <img class="d-block" src="{{ asset('images/slider/slider_02.jpeg') }}" alt="kami sewain table" />
                        </div>
                        <div class="carousel-item">
                            <img class="d-block" src="{{ asset('images/slider/slider_03.jpeg') }}" alt="kami sewain table" />
                        </div>
                    </div>
                </div>
                <div class="carousel-caption">
                    <div class="carousel-caption-title">{{ $page_properties?$page_properties->slider_title:"Exclusive Wedding Equipment for Unforgettable Moments"; }}</div>
                    <p>{{ $page_properties?$page_properties->slider_caption:"Transform your special day with our exclusive wedding equipment"; }}</p>
                </div>
            </div>
        </section>
        <!-- PRODUCT CATEGORY -->
        <div id="services" class="section-container" data-bs-ride="carousel">
            <div class="section-head">
                <div class="section-title">Product Category</div>
                <div class="section-subtitle">Discover our curated selection of top product category, carefully chosen to meet your needs and interests.</div>
            </div>
            <div class="service-inner">
                @foreach ($categories as $category)
                    <div class="service-item active card-fade-in">
                        <div class="service-item">
                            <img onclick="openModal({{ $category->id }})" class="zoom-img" src="{{ asset('/images/categories/'.$category->icon) }}" alt="Icon {{ $category->name }}">
                            <p>{{ $category->name }}</p>
                        </div>
                    </div>
                    <div id="categoryModal{{ $category->id }}" class="product-modal">
                        <div class="product-modal-content">
                            <button class="modal-close-btn" onclick="closeModal({{ $category->id }})">&times;</button>
                            <div class="product-modal-body">
                                <div class="product-image-section">
                                    <div class="product-large-image">
                                        <img id="mainImage{{ $category->id }}" src="{{ asset('/images/categories/image/'.$category->icon) }}" alt="{{ $category->name }}">
                                    </div>
                                </div>
                                <div class="product-details-section">
                                    <h2>{{ $category->name }}</h2>
                                    <p>{{ $category->description }}</p>
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <a href="/product">
                                                <button class="button-secondary">Start Shopping</button>
                                            </a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- SUBSCRIBE --}}
        <div id="callToAction" class="section-container bg-light ">
            <aside class="primary bg-gradient rounded-3 p-sm-5">
                <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
                    <div class="mb-4 mb-xl-0">
                        <div class="fs-3 fw-bold text-white">New products, delivered to you.</div>
                        <div class="text-white-50">Sign up for our newsletter for the latest updates.</div>
                    </div>
                    <div class="ms-xl-4">
                        <form id="subscribe-form" action="{{ route('subscribe') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div id="email-message" class="notification-danger hidden"></div>
                            <div class="input-group mb-2">
                                <input required name="email" id="email" class="form-control" type="email" placeholder="Email address..." aria-label="Email address..." aria-describedby="button-newsletter">
                                <button type="submit" class="btn btn-outline-light" id="button-newsletter" type="button" disabled>Sign up</button>
                            </div>
                        </form>
                        <div class="small text-white-50">We care about privacy, and will never share your data.</div>
                    </div>
                </div>
            </aside>
        </div>
        <!-- POPULAR PRODUCT -->
        <div id="popularProduct" class="section-container">
            <div class="section-head">
                <div class="section-title">Popular Product</div>
                <div class="section-subtitle">Popular Product refers to the most sought-after wedding equipment and facilities, frequently rented by customers.</div>
            </div>
            <div class="product-container">
                @foreach ($popularProducts as $index => $popular_product)
                    <div class="card card-fade-in card-fade-in-{{ $index + 1 }}">
                        <div class="card-img" onclick="openModalProduct({{ $popular_product->id }})">
                            <img src="{{ asset('images/products/'.$popular_product->cover) }}" class="product-img" alt="{{ $popular_product->category?->name }}">
                            <div class="badge-container">
                                <span class="badge-dark">{{ $popular_product->category?->name }}</span>
                            </div>
                            <div class="rating-like">
                                <span class="like-count" id="like-count-{{ $popular_product->id }}" {{ $popular_product->likes()->count() == 0 ? 'style=display:none;' : '' }}>
                                    <i class="fa fa-heart" aria-hidden="true"></i> {{ $popular_product->likes()->count() }}
                                </span>
                                <span class="like-count" id="rating-count-{{ $popular_product->id }}" {{ $popular_product->averageRating == 0 ? 'style=display:none;' : '' }}>
                                    <i class="far fa-star" aria-hidden="true"></i> {{ number_format($popular_product->averageRating, 1) }}
                                </span>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col-12 text-left">
                                    <div class="card-title">{{ $popular_product->name }}</div>
                                </div>
                                <div class="col-12 text-left">
                                    <span>{{ $popular_product->model?->name }} - {{ $popular_product->material?->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="productModal{{ $popular_product->id }}" class="product-modal">
                        <div class="product-modal-content">
                            <button class="modal-close-btn" onclick="closeModalProduct({{ $popular_product->id }})">&times;</button>
                            <div class="product-modal-body">
                                <div class="product-image-section">
                                    <div class="product-large-image">
                                        <img id="mainImage{{ $popular_product->id }}" src="{{ asset('images/products/'.$popular_product->cover) }}" alt="{{ $popular_product->alt }}">
                                    </div>
                                    <div class="rating-like-modal">
                                        <span class="like-count" id="like-count-{{ $popular_product->id }}" {{ $popular_product->likes()->count() == 0 ? 'style=display:none;' : '' }}>
                                            <i class="far fa-heart" aria-hidden="true"></i> {{ $popular_product->likes()->count() }}
                                        </span>
                                        <span class="like-count" id="like-count-{{ $popular_product->id }}" {{ $popular_product->averageRating == 0 ? 'style=display:none;' : '' }}>
                                            <i class="far fa-star" aria-hidden="true"></i> {{ number_format($popular_product->averageRating, 1) }}
                                        </span>
                                    </div>
                                    <div class="product-thumbnails">
                                        @foreach ($popular_product->secondaryImages as $thumbnail)
                                            <img src="{{ asset('/images/product/'.$thumbnail->url) }}" alt="{{ $thumbnail->alt }}" class="product-thumbnail" onclick="changeImage({{ $popular_product->id }}, '{{ asset('/images/product/'.$thumbnail->url) }}',this)">
                                        @endforeach
                                    </div>
                                </div>
                                <div class="product-details-section">
                                    <h2>{{ $popular_product->name }}</h2>
                                    <p><span>{{ $popular_product->material?->name }} - {{ $popular_product->model?->name }}</span></p>
                                    <p>{{ $popular_product->description }}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="quantity{{ $popular_product->id }}">Quantity</label>
                                            <div class="product-quantity-section">
                                                <button class="quantity-btn-min" onclick="changeQuantity({{ $popular_product->id }}, -1)">&#8722;</button>
                                                <form id="addToCart-{{ $popular_product->id }}" action="{{ route('cart.add', $popular_product->id) }}" method="POST">
                                                    @csrf
                                                    <input type="number" id="quantity{{ $popular_product->id }}" name="quantity" min="1" value="1" class="quantity-input" oninput="updatePrice({{ $popular_product->id }})">
                                                    <input type="hidden" name="products_id" value="{{ $popular_product->id }}">
                                                </form>
                                                <button class="quantity-btn-plus" onclick="changeQuantity({{ $popular_product->id }}, 1)">&#43;</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="quantity{{ $popular_product->id }}">Price</label>
                                            <div class="product-price-section">
                                                <div class="card-price-container">
                                                    <div class="card-price-kurs">/unit/pcs/pax</div>
                                                    <div class="card-price" id="price{{ $popular_product->id }}">
                                                        {{ number_format($popular_product->price, 0, ",", ".") }} IDR
                                                    </div>
                                                    
                                                </div>
                                                <div class="card-price-container">
                                                    
                                                    <div class="card-price-kurs">Total</div>
                                                    <div class="card-price-total" id="totalPrice{{ $popular_product->id }}">
                                                        {{ number_format($popular_product->price, 0, ",", ".") }} IDR
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 text-right">
                                            <button type="submit" form="addToCart-{{ $popular_product->id }}" class="button-secondary"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Add to Cart</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
         {{-- PROMOTION --}}
         @if (count($promotions) > 0)
            <div class="section-container bg-light">
                <div class="promo-container">
                    @foreach ($promotions as $promo)
                        @if ($promo->amount > $promo->users->count())
                            <div class="promo-item">
                                <div class="promo-bg">
                                    <img src="{{ asset('storage/images/promotion/bg-promo-white-02.png') }}" alt="">
                                </div>
                                <div class="promotion-title">{{ $promo->name }}</div>
                                @if ($promo->discount_amount)
                                    <div class="promotion-discount">{{ number_format($promo->discount_amount, 0, ",", ".") }} <span class="amount">IDR</span></div>
                                @endif
                                @if ($promo->discount_percent)
                                    <div class="promotion-discount">{!! $promo->discount_percent !!} <span class="percent">%</span></div>
                                @endif
                                <div class="promotion-content">{!! $promo->description !!}</div>
                                <div class="promotion-footer">
                                    <form action="{{ route('promotions.claim', $promo->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-promo-card">Get the promo</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="slider-controls">
                    <button class="prev-btn">&#10094;</button>
                    <button class="next-btn">&#10095;</button>
                </div>
            </div>
         @endif
        {{-- Portfolio --}}
        <section id="portfolio" class="section-container">
            <div class="section-head">
                <div class="section-title">Portfolio</div>
                <div class="section-subtitle">Dive into our showcase of past projects, discover our expertise and track record in delivering excellence.</div>
            </div>
                <div class="row">
                    @foreach ($latestPosts as $post)
                        <div class="col-lg-3 m-b-18">
                            <div class="card h-100 shadow border-0 card-fade-in">
                                <img class="post-img" src="{{ asset('images/portfolio/'.$post->featured_image) }}" alt="..." />
                                <div class="card-body">
                                    <div class="badge-primary m-b-8">
                                        {{ $post->categories?->name }}
                                    </div>
                                    <div class="card-title mb-3">{{ $post->title }}</div>
                                    <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                                </div>
                                <div class="card-footer text-right">
                                    <a href="/portfolio/{{ $post->slug }}">
                                        <button class="button-secondary">Read more</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
        </section>
        
    </main>
   
    <script>
        document.getElementById('email').addEventListener('input', function() {
            const email = this.value;
            const messageDiv = document.getElementById('email-message');
            const subscribeButton = document.getElementById('button-newsletter');
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email) {
                if (!emailPattern.test(email)) {
                    messageDiv.textContent = 'Please enter a valid email address.';
                    messageDiv.classList.remove('hidden');
                    subscribeButton.disabled = true;
                    return;
                } else {
                    messageDiv.classList.add('hidden');
                }

                fetch(`/check-email?email=${encodeURIComponent(email)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            messageDiv.textContent = 'This email is already subscribed.';
                            messageDiv.classList.remove('hidden');
                            subscribeButton.disabled = true;
                        } else {
                            messageDiv.textContent = '';
                            messageDiv.classList.add('hidden');
                            subscribeButton.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                messageDiv.textContent = '';
                messageDiv.classList.add('hidden');
                subscribeButton.disabled = true;
            }
        });



        function openModal(productId) {
            document.getElementById('categoryModal' + productId).style.display = 'block';
        }
        function closeModal(productId) {
            document.getElementById('categoryModal' + productId).style.display = 'none';
        }
        function openModalProduct(productId) {
            document.getElementById('productModal' + productId).style.display = 'block';
        }
        function closeModalProduct(productId) {
            document.getElementById('productModal' + productId).style.display = 'none';
        }

        function changeImage(productId, imageSrc, thumbnailElement) {
            document.getElementById('mainImage' + productId).src = imageSrc;
            const thumbnails = document.querySelectorAll('#productModal' + productId + ' .product-thumbnail');
            thumbnails.forEach((thumbnail) => {
                thumbnail.classList.remove('active');
            });
            thumbnailElement.classList.add('active');
        }
        window.onload = function() {
            @foreach ($products as $product)
                document.querySelector('#productModal{{ $product->id }} .product-thumbnail').classList.add('active');
            @endforeach
        };
        window.onclick = function(event) {
            @foreach ($products as $product)
                if (event.target == document.getElementById('productModal{{ $product->id }}')) {
                    document.getElementById('productModal{{ $product->id }}').style.display = 'none';
                }
            @endforeach
        };

        


        function changeQuantity(productId, amount) {
            const quantityInput = document.getElementById('quantity' + productId);
            let currentValue = parseInt(quantityInput.value);
            currentValue += amount;
            if (currentValue < 1) {
                currentValue = 1;
            }
            quantityInput.value = currentValue;
            updatePrice(productId);
        }

        function updatePrice(productId) {
            const quantityInput = document.getElementById('quantity' + productId);
            const priceElement = document.getElementById('price' + productId);
            const totalPriceElement = document.getElementById('totalPrice' + productId);
            const productPrice = parseFloat(priceElement.innerText.replace(/\./g, '').replace(',', '.')); 
            const totalPrice = productPrice * parseInt(quantityInput.value);
            totalPriceElement.innerText = number_format(totalPrice, 0, ",", ".") + ' IDR';
        }
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
        
        document.addEventListener("DOMContentLoaded", function() {
            let cards = document.querySelectorAll('.card-fade-in');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`; // Tambahkan delay dinamis
                card.classList.add('show');
            });
        });


    </script>
@include('layouts.partials.footer-secondary')

@endsection

