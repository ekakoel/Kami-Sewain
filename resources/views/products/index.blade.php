@extends('layouts.master')
@section('title', 'Product')
@section('main')
    <main class="flex-shrink-0">
        <div class="header-container">
            <div class="header-caption">
                <div class="header-title">{!! $page_properties?$page_properties->slider_title:"Products"; !!}</div>
                <p>{!! $page_properties?$page_properties->slider_caption:"Wedding Equipment and Facilities"; !!}</p>
            </div>
        </div>
        
        <!-- Section-->
            <div class="section-container">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <div class="filter-container">
                            <div class="filter-content">
                                <div class="filters" id="filters">
                                    <div class="inner2">
                                        <div class="ui-group">
                                            <div class="filter-title">Category</div>
                                            <div class="button-group js-radio-button-group">
                                                <button class="button filter-btn is-checked" data-filter="category" data-value="">All</button>
                                                @foreach ($categories as $category)
                                                    @if (count($category->products->where('status','Active'))>0)
                                                        <button class="button filter-btn" data-filter="category" data-value="{{ $category->name }}">{{ $category->name }}</button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <br>
                                        <div class="ui-group">
                                            <div class="filter-title">Model</div>
                                            <div class="button-group js-radio-button-group">
                                                <button class="button filter-btn is-checked" data-filter="type" data-value="">All</button>
                                                @foreach ($models as $model)
                                                    @if (count($model->products->where('status','Active'))>0)
                                                        <button class="button filter-btn" data-filter="type" data-value="{{ $model->name }}">{{ $model->name }}</button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <br>
                                        <div class="ui-group">
                                            <div class="filter-title">Material</div>
                                            <div class="button-group js-radio-button-group">
                                                <button class="button filter-btn is-checked" data-filter="material" data-value="">All</button>
                                                @foreach ($materials as $material)
                                                    @if (count($material->products->where('status','Active'))>0)
                                                        <button class="button filter-btn" data-filter="material" data-value="{{ $material->name }}">{{ $material->name }}</button>
                                                    @endif
                                                @endforeach
                                               
                                            </div>
                                        </div>
                                        <br>
                                        <div class="ui-group">
                                            <div class="filter-title">Color</div>
                                            <div class="button-group js-radio-button-group">
                                                <button class="button filter-btn is-checked"  data-filter="color" data-value="">All</button>
                                                @foreach ($colors as $color)
                                                    @if (count($color->products->where('status','Active'))>0)
                                                        <button class="button filter-btn" data-filter="color" data-value="{{ $color->name }}">{{ $color->name }}</button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div id="productsContainer" class="product-filter-container">
                            @foreach ($products as $index => $product)
                                <div id="categoryProduct-{{ $index }}" class="product-card" data-type="{{ $product->model->name }}" data-category="{{ $product->category->name }}" data-color="{{ $product->color->name }}" data-material="{{ $product->material->name }}" data-id="{{ $product->id }}" data-product-id="{{ $index }}">
                                    <div class="card h-100">
                                        <div class="card-img-service">
                                            <img class="product-img" onclick="openModal({{ $product->id }})" src="{{ asset('images/products/' . $product->cover) }}" alt="{{ $product->alt }}" />
                                            @auth
                                                <div class="like-icon">
                                                    <button class="like-button" data-product-id="{{ $product->id }}">
                                                        <i class="fa fa-heart {{ $product->isLikedByUser(auth()->id()) ? 'liked' : '' }}"></i>
                                                    </button>
                                                </div>
                                            @endauth
                                            <div class="rating-like">
                                                <span class="like-count" id="like-count-{{ $product->id }}" {{ $product->likes()->count() == 0 ? 'style=display:none;' : '' }}>
                                                    <i class="far fa-heart"></i> {{ $product->likes()->count() }}
                                                </span>
                                                <span class="like-count" id="rating-count-{{ $product->id }}" {{ $product->averageRating == 0 ? 'style=display:none;' : '' }}>
                                                    <i class="far fa-star"></i> {{ number_format($product->averageRating, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-title">
                                                {{ $product->name }}
                                            </div>
                                            <p>{{ $product->model->name }} | {{ $product->material->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                  
                                <div id="productModal{{ $product->id }}" class="product-modal">
                                    <div class="product-modal-content">
                                        <button class="modal-close-btn" onclick="closeModal({{ $product->id }})">&times;</button>
                                        <div class="product-modal-body">
                                            <div class="product-image-section">
                                                <div class="product-large-image">
                                                    <img id="mainImage{{ $product->id }}" src="{{ asset('images/products/'.$product->cover) }}" alt="{{ $product->alt }}">
                                                </div>
                                                <div class="rating-like-modal">
                                                    <span class="like-count" id="like-count-{{ $product->id }}" {{ $product->likes()->count() == 0 ? 'style=display:none;' : '' }}>
                                                        <i class="fa fa-heart-o" aria-hidden="true"></i> {{ $product->likes()->count() }}
                                                    </span>
                                                    <span class="like-count" id="like-count-{{ $product->id }}" {{ $product->averageRating == 0 ? 'style=display:none;' : '' }}>
                                                        <i class="fa fa-star-o" aria-hidden="true"></i> {{ number_format($product->averageRating, 5) }}
                                                    </span>
                                                </div>
                                                <div class="product-thumbnails">
                                                    @foreach ($product->secondaryImages as $thumbnail)
                                                        <img src="{{ asset('images/products/'.$thumbnail->url) }}" alt="{{ $thumbnail->alt }}" class="product-thumbnail" onclick="changeImage({{ $product->id }}, '{{ asset('images/products/'.$thumbnail->url) }}',this)">
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="product-details-section">
                                                <h2>{{ $product->name }}</h2>
                                                @auth
                                                    <form method="POST" action="{{ route('products.rate', $product->id) }}" id="rating-form-{{ $product->id }}">
                                                        @csrf
                                                        <input type="hidden" name="rating" id="rating-input-{{ $product->id }}">
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <div class="star-rating" data-product-id="{{ $product->id }}">
                                                            <p>
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <span class="fa fa-star {{ isset($userRatings[$product->id]) && $userRatings[$product->id]->rating >= $i ? 'selected' : '' }}" data-value="{{ $i }}"></span>
                                                                @endfor
                                                                <i class="fa fa-hand-o-left" aria-hidden="true"></i> Rate this product by clicking this star icon.
                                                            </p>
                                                        </div>
                                                        <button type="submit" style="display:none" id="submit-rating-{{ $product->id }}">Rate</button>
                                                    </form>
                                                @endauth
                                                <p><span>{{ $product->material->name }} - {{ $product->model->name }}</span></p>
                                                <p>{{ $product->description }}</p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="quantity{{ $product->id }}">Quantity</label>
                                                        <div class="product-quantity-section">
                                                            <button class="quantity-btn-min" onclick="changeQuantity({{ $product->id }}, -1)">&#8722;</button>
                                                            <form id="addToCart-{{ $product->id }}" action="{{ route('cart.add', $product->id) }}" method="POST">
                                                                @csrf
                                                                <input type="number" id="quantity{{ $product->id }}" name="quantity" min="1" value="1" class="quantity-input" oninput="updatePrice({{ $product->id }})">
                                                                <input type="hidden" name="products_id" value="{{ $product->id }}">
                                                            </form>
                                                            <button class="quantity-btn-plus" onclick="changeQuantity({{ $product->id }}, 1)">&#43;</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="quantity{{ $product->id }}">Price</label>
                                                        <div class="product-price-section">
                                                            <div class="card-price-container">
                                                                <div class="card-price-kurs">/unit/pcs/pax</div>
                                                                <div class="card-price" id="price{{ $product->id }}">
                                                                    {{ number_format($product->price, 0, ",", ".") }} IDR
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="card-price-container">
                                                                <div class="card-price-kurs">Total</div>
                                                                <div class="card-price-total" id="totalPrice{{ $product->id }}">
                                                                    {{ number_format($product->price, 0, ",", ".") }} IDR
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12 text-right">
                                                        <button type="submit" form="addToCart-{{ $product->id }}" class="button-secondary"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Add to Cart</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                        <div id="pagination-controls">
                            <button id="prev-page"><i class="fa fa-step-backward" aria-hidden="true"></i></button>
                            <span id="page-info"></span>
                            <button id="next-page"><i class="fa fa-step-forward" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
                
            </div>
            

            
            <script>
                
                document.querySelectorAll('.star-rating .fa').forEach(function(star) {
                    star.addEventListener('click', function() {
                        let value = this.getAttribute('data-value');
                        let productId = this.closest('.star-rating').getAttribute('data-product-id');
                        
                        document.getElementById('rating-input-' + productId).value = value;
                        
                        let stars = this.parentElement.querySelectorAll('.fa');
                        stars.forEach(function(star, index) {
                            if (index < value) {
                                star.classList.add('selected');
                            } else {
                                star.classList.remove('selected');
                            }
                        });
                        
                        document.getElementById('rating-form-' + productId).submit();
                    });
                });

                // Open Modal for Specific Product
                function openModal(productId) {
                    document.getElementById('productModal' + productId).style.display = 'block';
                    // Disable scrolling when modal opens
                    // document.body.style.overflow = 'hidden';
                }

                // Change Large Image when Thumbnail Clicked
                function changeImage(productId, imageSrc, thumbnailElement) {
                    // Change the main large image
                    document.getElementById('mainImage' + productId).src = imageSrc;

                    // Remove the 'active' class from all thumbnails for this specific product
                    const thumbnails = document.querySelectorAll('#productModal' + productId + ' .product-thumbnail');
                    thumbnails.forEach((thumbnail) => {
                        thumbnail.classList.remove('active');
                    });

                    // Add 'active' class to the clicked thumbnail
                    thumbnailElement.classList.add('active');
                }

                // Set default first image as active on page load for each product modal
                window.onload = function() {
                    @foreach ($products as $product)
                        document.querySelector('#productModal{{ $product->id }} .product-thumbnail').classList.add('active');
                    @endforeach
                };

                // Close Modal when clicking outside of modal-content
                window.onclick = function(event) {
                    @foreach ($products as $product)
                        if (event.target == document.getElementById('productModal{{ $product->id }}')) {
                            document.getElementById('productModal{{ $product->id }}').style.display = 'none';
                        }
                    @endforeach
                    // Enable scrolling when modal closes
                    // document.body.style.overflow = 'auto';
                };
                function closeModal(productId) {
                    document.getElementById('productModal' + productId).style.display = 'none';
                    // Re-enable scrolling when modal closes
                    // document.body.style.overflow = 'auto';
                }


                function changeQuantity(productId, amount) {
                    const quantityInput = document.getElementById('quantity' + productId);
                    let currentValue = parseInt(quantityInput.value); // Get current quantity
                    currentValue += amount; // Change quantity by the amount (1 or -1)

                    // Ensure the quantity does not go below 1
                    if (currentValue < 1) {
                        currentValue = 1;
                    }

                    // Update the input field with the new quantity
                    quantityInput.value = currentValue;

                    // Update the total price
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
                    totalPriceElement.innerText = number_format(totalPrice, 0, ",", ".") + ' IDR';
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
            <script>
                const filters = {
                    type: null,
                    category: null,
                    color: null,
                    material: null,
                    rating: null
                };
                const filterBadgesContainer = document.getElementById('filter-badges');
                let currentPage = 1;
                const productsPerPage = 16;
                document.querySelectorAll('.filter-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const filterType = this.getAttribute('data-filter');
                        const filterValue = this.getAttribute('data-value');

                        if (this.classList.contains('is-checked')) {
                            this.classList.remove('is-checked');
                            filters[filterType] = null;
                        } else {
                            document.querySelectorAll(`[data-filter="${filterType}"]`).forEach(btn => {
                                btn.classList.remove('is-checked');
                            });
                            this.classList.add('is-checked');
                            filters[filterType] = filterValue;
                        }

                        currentPage = 1;
                        updateProducts();
                        updateBadges();
                    });
                });
                function updateProducts() {
                    const products = document.querySelectorAll('.product-card');
                    let filteredProducts = [];
                    products.forEach(product => {
                        const typeMatch = !filters.type || product.getAttribute('data-type') === filters.type;
                        const categoryMatch = !filters.category || product.getAttribute('data-category') === filters.category;
                        const colorMatch = !filters.color || product.getAttribute('data-color') === filters.color;
                        const materialMatch = !filters.material || product.getAttribute('data-material') === filters.material;
                        const ratingMatch = !filters.rating || product.getAttribute('data-rating') === filters.rating;

                        if (typeMatch && categoryMatch && colorMatch && materialMatch && ratingMatch) {
                            product.classList.add('show');
                            product.classList.remove('hide');
                            product.style.display = 'block';
                            filteredProducts.push(product);
                        } else {
                            product.classList.add('hide');
                            product.style.display = 'none';
                            product.classList.remove('show');
                        }
                    });
                    updatePagination(filteredProducts);
                }
                function updateBadges() {
                    filterBadgesContainer.innerHTML = '';

                    for (const [key, value] of Object.entries(filters)) {
                        if (value) {
                            const badge = document.createElement('span');
                            badge.classList.add('badge');
                            badge.innerHTML = `${key.charAt(0).toUpperCase() + key.slice(1)}: ${value} <span class="remove-badge" data-filter="${key}">x</span>`;
                            filterBadgesContainer.appendChild(badge);
                        }
                    }
                    document.querySelectorAll('.remove-badge').forEach(removeBtn => {
                        removeBtn.addEventListener('click', function () {
                            const filterType = this.getAttribute('data-filter');
                            filters[filterType] = null;
                            document.querySelectorAll(`[data-filter="${filterType}"]`).forEach(btn => {
                                btn.classList.remove('is-checked');
                            });

                            currentPage = 1;
                            updateProducts();
                            updateBadges();
                        });
                    });
                }
                function updatePagination(filteredProducts) {
                    const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
                    const start = (currentPage - 1) * productsPerPage;
                    const end = start + productsPerPage;
                    filteredProducts.forEach((product, index) => {
                        if (index >= start && index < end) {
                            product.style.display = 'block';
                        } else {
                            product.style.display = 'none';
                        }
                    });
                    const paginationControls = document.getElementById('pagination-controls');

                    if (totalPages <= 1) {
                        paginationControls.style.display = 'none';
                    } else {
                        paginationControls.style.display = 'block';
                        document.getElementById('page-info').textContent = `Page ${currentPage} of ${totalPages}`;
                        document.getElementById('prev-page').disabled = currentPage === 1;
                        document.getElementById('next-page').disabled = currentPage === totalPages;
                    }
                }
                document.getElementById('prev-page').addEventListener('click', function () {
                    if (currentPage > 1) {
                        currentPage--;
                        updateProducts();
                    }
                });
                document.getElementById('next-page').addEventListener('click', function () {
                    const products = document.querySelectorAll('.product-card.show');
                    const totalPages = Math.ceil(products.length / productsPerPage);

                    if (currentPage < totalPages) {
                        currentPage++;
                        updateProducts();
                    }
                });
                updateProducts();
            </script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $('.heart-btn').on('click', function() {
                    var productId = $(this).data('id');
                    var ratingValue = $('#ratingInput-' + productId).val();
                    var isDislike = $(this).attr('id') == 'unrateButton-' + productId;

                    console.log('Product ID:', productId);
                    console.log('Is Dislike:', isDislike);
                    console.log('Rating Value:', ratingValue);

                    $.ajax({
                        url: '/product/' + productId + '/rate',
                        type: 'POST',
                        data: {
                            rating: isDislike ? 0 : ratingValue,
                            _token: '{{ csrf_token() }}'
                        },
                    });
                });
                document.addEventListener('DOMContentLoaded', function () {
                    const heartButtons = document.querySelectorAll('.heart-btn');
                    heartButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const heartIcon = this.querySelector('i');
                            const productId = this.getAttribute('data-id');
                            const ratingInput = document.getElementById(`ratingInput-${productId}`);
                            if (heartIcon.style.color === 'red') {
                                heartIcon.style.color = 'gray';
                                this.id = `rateButton-${productId}`;
                                ratingInput.value = '1';
                            } else {
                                heartIcon.style.color = 'red';
                                this.id = `unrateButton-${productId}`;
                                ratingInput.value = '0';
                            }
                        });
                    });
                });
            </script>
            <script>
                document.querySelectorAll('.like-button').forEach(button => {
                    button.addEventListener('click', function() {
                        let productId = this.getAttribute('data-product-id');
                        fetch(`/product/${productId}/like`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                let icon = this.querySelector('i');
                                icon.classList.toggle('liked'); // Ganti status like
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    });
                });
            </script>
    </main>
    @include('layouts.partials.footer-secondary')
@endsection
