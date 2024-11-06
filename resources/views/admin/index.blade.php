@extends('admin.layouts.master')

@section('title', 'Welcome')

@section('main')
<main>
    <div class="container-fluid px-4">
        {{-- <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><p>Welcome, <b>{{ auth('admin')->user()->username }}</b></p></li>
        </ol> --}}
        <div class="admin-navigation">
            <div class="admin-navigation-title">Dashboard</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active">Statistics</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
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
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-light text-white">
                            <div class="card-header text-dark">User</div>
                            <div class="card-body align-items-center ">
                            {{-- <div class="card-footer d-flex align-items-center justify-content-between"> --}}
                                <p class="text-dark">
                                    Active: {{ count($users->where('status','Active')) }} | 
                                    Blocked: {{ count($users->where('status','Block')) }} | 
                                    Pending: {{ count($users->where('status','Pending')) }} | 
                                    Total: {{ count($users) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12">
                <hr class="hr-clear">
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-light text-white mb-4">
                            <div class="card-header text-dark">Products</div>
                            <div class="card-body">
                                <p class="text-dark">
                                    Active: {{ count($activeProducts) }} | 
                                    Draft: {{ count($draftProducts) }} | 
                                    Total: {{ count($products) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-light text-white mb-4">
                            <div class="card-header text-dark">Product Categories</div>
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <p class="text-dark">
                                    {{ count($productCategories) }} Category
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-light text-white mb-4">
                            <div class="card-header text-dark">Product Models</div>
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <p class="text-dark">
                                    {{ count($models) }} Model
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-light text-white">
                            <div class="card-header text-dark">Product Materials</div>
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <p class="text-dark">
                                    {{ count($materials) }} Type
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-light text-white">
                            <div class="card-header text-dark">Product Colors</div>
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <p class="text-dark">
                                    {{ count($colors) }} Colors
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12">
                <hr class="hr-clear">
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-light text-white">
                            <div class="card-header text-dark">Promotions</div>
                            <div class="card-body">
                                <p class="text-dark">
                                    Active: {{ count($promotions->where('status','Active')) }} | 
                                    Draft: {{ count($promotions->where('status','Draft')) }} | 
                                    Expired: {{ count($promotions->where('status','Expired')) }} | 
                                    Total: {{ count($promotions) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12">
                <hr class="hr-clear">
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="card bg-light text-white">
                            <div class="card-header text-dark">Orders</div>
                            <div class="card-body">
                                <p class="text-dark">
                                    Pending: {{ count($orders->where('status','Pending')) }} | 
                                    Payment: {{ count($orders->where('status','Payment')) }} | 
                                    Paid: {{ count($orders->where('status','Paid')) }} | 
                                    Total: {{ count($orders) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection