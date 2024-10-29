@extends('admin.layouts.master')

@section('title', "Edit location")

@section('main')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit une location</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Welcome</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Locations</a></li>
            <li class="breadcrumb-item active">Edit {{ $rent->id }}</li>
        </ol>
        <!-- <div class="card mb-4">
            <div class="card-body">
                Ici vous pouvez Detail toute les car de notre parking.
            </div>
        </div>-->
        <div class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4>Location n{{ $rent->id }}</h4>
                </div>
                <div class="card-body">
                    En developpement...    
                </div>
            </div>

        </div>
    </div>
</main>
@endsection