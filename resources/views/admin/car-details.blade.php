@extends('admin.layouts.master')

@section('title', "Detail {{ $car->model }}")

@section('main')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Détails sur la voiture</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Welcome</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.car.index') }}">Voiture</a></li>
            <li class="breadcrumb-item active">{{ $car->model.' '.$car->brand }}</li>
        </ol>
        <!-- <div class="card mb-4">
            <div class="card-body">
                Ici vous pouvez Detail toute les car de notre parking.
            </div>
        </div>-->
        <div class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $car->brand }} {{ $car->model }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ Storage::url($car->image_url) }}" class="img-fluid" alt="Main image de la voiture">
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Year of manufacture:</strong> {{ $car->make_year }}</li>
                                <li class="list-group-item"><strong>Number of seats:</strong> {{ $car->passenger_capacity }}</li>
                                <li class="list-group-item"><strong>Kilomètres par litre:</strong> {{ $car->kilometers_per_liter }}</li>
                                <li class="list-group-item"><strong>Fuel type:</strong> {{ $car->fuel_type }}</li>
                                <li class="list-group-item"><strong>Transmission type:</strong> {{ $car->transmission_type }}</li>
                                <li class="list-group-item"><strong>Rental price per day:</strong> {{ $car->daily_rate }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5>Images secondaires:</h5>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($car->secondaryImages as $image)
                        <div class="col-md-4 mt-3">
                            <img src="{{ Storage::url($image->url) }}" class="img-fluid" alt="Image secondaire de la voiture">
                        </div>
                        @endforeach
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="text-center">
                                <a type="button" class="btn button-primary mr-2 disabled" href="{{ route('admin.car.edit', ['id' => $car->id]) }}">Edit</a>
                                <button type="button" class="btn btn-danger" onclick="if(confirm('Êtes-vous sûr de vouloir Delete cette voiture?')) { document.getElementById('delete-form').submit(); }">Delete</button>
                                <form id="delete-form" action="{{ route('admin.car.destroy', ['id' => $car->id]) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection