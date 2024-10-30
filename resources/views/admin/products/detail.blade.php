@extends('admin.layouts.master')
@section('title', 'Product Details')
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
                <div class="admin-navigation-title">Products</div>
                <hr class="hr-admin-navigation">
                <div class="admin-navigation-list-container">
                    <div class="admin-navigation-list"><a href="{{ route('admin.products') }}">Products</a></div>
                    <div class="admin-navigation-list active">{{ $product->name }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card-box mb-30">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-image-detail">
                                    <div class="product-large-image">
                                        <img id="mainImage{{ $product->id }}" src="{{ asset('images/products/'.$product->cover) }}" alt="{{ $product->alt }}">
                                    </div>
                                    <div class="product-thumbnails">
                                            <img src="{{ asset('images/products/'.$product->cover) }}" alt="{{ $product->alt }}" class="product-thumbnail active" onclick="changeImage({{ $product->id }}, '{{ asset('images/products/'.$product->cover) }}',this)">
                                        @foreach ($product->secondaryImages as $thumbnail)
                                            <img src="{{ asset('images/products/'.$thumbnail->url) }}" alt="{{ $thumbnail->alt }}" class="product-thumbnail" onclick="changeImage({{ $product->id }}, '{{ asset('images/products/'.$thumbnail->url) }}',this)">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="description-item-container">
                                    <div class="card-title m-b-18"><h3>{{ $product->name }}</h3></div>
                                    <div class="rating-container">
                                        <p><strong><i class="fa fa-star" aria-hidden="true"></i></strong> {{ number_format($product->averageRating, 1) }}</p>
                                        <p><strong><i class="fa fa-heart" aria-hidden="true"></i></strong> {{ $product->likes()->count() }}</p>
                                    </div>
                                    <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                                    <p><strong>Material:</strong> {{ $product->material->name ?? 'N/A' }}</p>
                                    <p><strong>Color:</strong> {{ $product->color->name ?? 'N/A' }}</p>
                                    <p><strong>Available Stock:</strong> {{ $product->stock }}</p>
                                    <p><strong>Price:</strong> Rp {{ number_format($product->price, 2) }}</p>
                                    <p><strong>Description:</strong> {{ $product->description }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-box-footer">
                            <a href="{{ route('admin.products') }}">
                                <button class="btn button-dark"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                            </a>
                            <a href="{{ route('admin.products.edit',['id'=>$product->id]) }}">
                                <button class="btn button-secondary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        
        <script>
            function changeImage(productId, imageSrc, thumbnailElement) {
                document.getElementById('mainImage' + productId).src = imageSrc;
                const thumbnails = document.querySelectorAll('.product-thumbnail');
                thumbnails.forEach((thumbnail) => {
                    thumbnail.classList.remove('active');
                });
                thumbnailElement.classList.add('active');
            }
            window.onload = function() {
                const thumbnails = document.querySelectorAll('.product-thumbnail');
                if (thumbnails.length > 0) {
                    thumbnails[0].classList.add('active');
                }
            };
        </script>
    </main>
@endsection
