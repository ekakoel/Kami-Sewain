@extends('admin.layouts.master')

@section('title', 'Products')

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
                <div class="admin-navigation-list active"><a href="/admin/products">Products</a></div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="pb-20">
                <table id="productTable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th class="table-plus datatable-nosort">Name</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Rating / Like</th>
                            <th>Status</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="table-plus">{{ $product->sku }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category?->name }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <i class="fa fa-star icon-dark" aria-hidden="true"></i> {{ number_format($product->averageRating, 2) }}, 
                                    <i class="fa fa-heart icon-dark" aria-hidden="true"></i> {{ $product->likes()->count() }}
                                </td>
                                <td class="{{ $product->status == "Active"?"color-secondary":"color-dark" }}">{{ $product->status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="{{ route('admin.products.detail',['id'=>$product->id]) }}"><i class="dw dw-eye"></i> View</a>
                                            <a class="dropdown-item" href="{{ route('admin.products.edit',['id'=>$product->id]) }}"><i class="dw dw-edit2"></i> Edit</a>
                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="button-delete">
                                                    <i class="dw dw-delete-3"></i> Delete
                                                </button>
                                                {{-- <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a> --}}
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-box-footer">
                <a href="{{ route('admin.products.create') }}">
                    <button class="btn button-secondary"><i class="fa fa-plus" aria-hidden="true"></i> Add Product</button>
                </a>
            </div>
        </div>
        {{-- <div class="row">
            @if (!empty($noProductsMessage))
                <div class="alert alert-warning">
                    {{ $noProductsMessage }}
                </div>
            @else
                <ul>
                    @foreach ($allProducts as $product)
                        <li>{{ $product->name }} - {{ $product->price }}</li>
                    @endforeach
                </ul>
            @endif
        </div> --}}
    </div>
</main>
@endsection