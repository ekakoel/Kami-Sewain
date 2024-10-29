@extends('admin.layouts.master')

@section('title', 'Welcome')

@section('main')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><p>Welcome, <b>{{ auth('admin')->user()->username }}</b></p></li>
        </ol>
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card bg-light text-white mb-4">
                    <div class="card-body text-dark">Number of Product</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="text-dark">{{ count($activeProducts) }} Active Products</p>
                        <p class="text-dark">{{ count($draftProducts) }} Draft Products</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-light text-white mb-4">
                    <div class="card-body text-dark">Number of Category</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="text-dark">{{ count($productCategories) }} Category</p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-4 col-md-6">
                <div class="card bg-light text-white mb-4">
                    <div class="card-body text-dark">Number of Users</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="text-dark fs-4" href="#">Unavailable</p>
                        <div class="small"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card bg-light text-white mb-4">
                    <div class="card-body text-dark">Number of current rentals</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="text-dark fs-4" href="#">Unavailable</p>
                        <div class="small"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div> --}}
            
        </div>
    </div>
</main>
@endsection