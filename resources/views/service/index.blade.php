@extends('layouts.master')

@section('title', 'Product')

@section('main')
    <main class="flex-shrink-0">
        <header class="header-container">
            <div class="header-caption">
                <div class="header-title">Services</div>
                <p>With this shop hompeage template</p>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="filters">
                            <div class="inner2">
                                <div class="ui-group">
                                    <div class="filter-title">Category</div>
                                    <div class="button-group js-radio-button-group">
                                        <button class="button filter-btn is-checked" data-filter="category" data-value="">All</button>
                                        <button class="button filter-btn" data-filter="category" data-value="arch">Arch</button>
                                        <button class="button filter-btn" data-filter="category" data-value="chair">Chair</button>
                                        <button class="button filter-btn" data-filter="category" data-value="cushion">Cushion</button>
                                        <button class="button filter-btn" data-filter="category" data-value="decoration">Decoration</button>
                                        <button class="button filter-btn" data-filter="category" data-value="glass">Glasses</button>
                                        <button class="button filter-btn" data-filter="category" data-value="lighting">Lighting</button>
                                        <button class="button filter-btn" data-filter="category" data-value="plate">Plate</button>
                                        <button class="button filter-btn" data-filter="category" data-value="table">Table</button>
                                    </div>
                                </div>
                                <br>
                                <div class="ui-group">
                                    <div class="filter-title">Model</div>
                                    <div class="button-group js-radio-button-group">
                                        <button class="button filter-btn is-checked" data-filter="type" data-value="">All</button>
                                        <button class="button filter-btn" data-filter="type" data-value="artistic">Artistic</button>
                                        <button class="button filter-btn" data-filter="type" data-value="classic">Classic</button>
                                        <button class="button filter-btn" data-filter="type" data-value="glamour">Glamour</button>
                                        <button class="button filter-btn" data-filter="type" data-value="modern">Modern</button>
                                        <button class="button filter-btn" data-filter="type" data-value="minimalist">Minimalist</button>
                                        <button class="button filter-btn" data-filter="type" data-value="other">Other</button>
                                    </div>
                                </div>
                                <br>
                                <div class="ui-group">
                                    <div class="filter-title">Material</div>
                                    <div class="button-group js-radio-button-group">
                                        <button class="button filter-btn is-checked" data-filter="material" data-value="">All</button>
                                        <button class="button filter-btn" data-filter="material" data-value="acrilic">Acrilic</button>
                                        <button class="button filter-btn" data-filter="material" data-value="ceramic">Ceramic</button>
                                        <button class="button filter-btn" data-filter="material" data-value="cloth">Cloth</button>
                                        <button class="button filter-btn" data-filter="material" data-value="glass">Glass</button>
                                        <button class="button filter-btn" data-filter="material" data-value="iron">Iron</button>
                                        <button class="button filter-btn" data-filter="material" data-value="organic">Organic</button>
                                        <button class="button filter-btn" data-filter="material" data-value="plastic">Plastic</button>
                                        <button class="button filter-btn" data-filter="material" data-value="resin">Resin</button>
                                        <button class="button filter-btn" data-filter="material" data-value="stainless">Stainless</button>
                                        <button class="button filter-btn" data-filter="material" data-value="wood">Wood</button>
                                        <button class="button filter-btn" data-filter="material" data-value="other">Other</button>
                                    </div>
                                </div>
                                <br>
                                <div class="ui-group">
                                    <div class="filter-title">Color</div>
                                    <div class="button-group js-radio-button-group">
                                        <button class="button filter-btn is-checked"  data-filter="color" data-value="">All</button>
                                        <button class="button filter-btn" data-filter="color" data-value="black">Black</button>
                                        <button class="button filter-btn" data-filter="color" data-value="blue">Blue</button>
                                        <button class="button filter-btn" data-filter="color" data-value="brown">Brown</button>
                                        <button class="button filter-btn" data-filter="color" data-value="dark">Dark</button>
                                        <button class="button filter-btn" data-filter="color" data-value="gray">Gray</button>
                                        <button class="button filter-btn" data-filter="color" data-value="green">Green</button>
                                        <button class="button filter-btn" data-filter="color" data-value="light">Light</button>
                                        <button class="button filter-btn" data-filter="color" data-value="orange">Orange</button>
                                        <button class="button filter-btn" data-filter="color" data-value="pink">Pink</button>
                                        <button class="button filter-btn" data-filter="color" data-value="purple">Purple</button>
                                        <button class="button filter-btn" data-filter="color" data-value="red">Red</button>
                                        <button class="button filter-btn" data-filter="color" data-value="white">White</button>
                                        <button class="button filter-btn" data-filter="color" data-value="yellow">Yellow</button>
                                    </div>
                                </div>
                                <br>
                                <div class="ui-group">
                                    <div class="filter-title">Popularity</div>
                                    <div class="button-group js-radio-button-group">
                                        <button  class="button filter-btn" data-filter="rating" data-value="5">5 Stars</button>
                                        <button  class="button filter-btn" data-filter="rating" data-value="4">4 Stars</button>
                                        <button  class="button filter-btn" data-filter="rating" data-value="3">3 Stars</button>
                                        <button  class="button filter-btn" data-filter="rating" data-value="2">2 Stars</button>
                                        <button  class="button filter-btn" data-filter="rating" data-value="1">1 Star</button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div id="products-container" class="product-container">
                            @foreach ($products as $product)
                                <div class="product-card" data-type="{{ $product->type }}" data-category="{{ $product->category }}" data-color="{{ $product->color }}" data-material="{{ $product->material }}">
                                    <div class="card h-100">
                                        <img class="card-img-service"
                                            src="{{ asset('/images/products/' . $product->cover) }}" alt="..." />
                                        <div class="card-body p-2 text-center">
                                            <div class="card-title">{{ $product->name }}</div>
                                            $40.00 - $80.00
                                        </div>
                                        <!-- Product actions-->
                                        <div class="card-footer p-2 pt-0 border-top-0 bg-transparent text-center">
                                            {{-- <a href="#" class="btn button-primary"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Add to Cart</a> --}}
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="btn button-primary">Add to Cart</button>
                                            </form>
                                        </div>
                                        <span id="popularity-count-{{ $product->id }}">{{ $product->popularity }}</span> Likes
        
                                        @if(Auth::user() && Auth::user()->ratedProducts->contains($product->id))
                                            <button class="heart-btn" disabled>❤️ You already rated</button>
                                        @else
                                            <button class="heart-btn" data-id="{{ $product->id }}">
                                                ❤️
                                            </button>
                                        @endif
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
                const filters = {
                    type: null,
                    category: null,
                    color: null,
                    material: null,
                    rating: null
                };
                const filterBadgesContainer = document.getElementById('filter-badges');
                let currentPage = 1;
                const productsPerPage = 8;
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
                            filteredProducts.push(product);
                        } else {
                            product.classList.add('hide');
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
                $(document).on('click', '.heart-btn', function() {
                    var productId = $(this).data('id');
                    $.ajax({
                        url: 'http://localhost:8000/product/' + productId + '/rate',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#popularity-count-' + productId).text(response.popularity);
                            } else if (response.error) {
                                alert(response.error);
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // Debugging: melihat respons error
                        }
                    });
                });
            </script>
        </section>
    </main>

@endsection
