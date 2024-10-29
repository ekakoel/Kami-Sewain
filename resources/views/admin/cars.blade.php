@extends('admin.layouts.master')

@section('title', 'car')

@section('main')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">List of vehicles</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Welcome</a></li>
            <li class="breadcrumb-item active">car</li>
        </ol>
        <!-- <div class="card mb-4">
            <div class="card-body">
                Ici vous pouvez Detail toute les car de notre parking.
            </div>
        </div>-->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="mb-4">
            <div>
                <a class="btn button-primary m-3" href="{{ route('admin.car.create') }}" role="button">Add</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Model</th>
                            <th>Brand</th>
                            <th>Price per day</th>
                            <th>Available</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                        <tr>
                            <td>{{ $car->id }}</td>
                            <td>{{ $car->model}}</td>
                            <td>{{ $car->brand }}</td>
                            <td>{{ $car->daily_rate }}</td>
                            <td>{{ $car->available ? 'Vrai' : 'Faux' }}</td>
                            <td>
                                <div class="dropdown open">
                                    <button class="btn button-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Options
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.car.show', ['id' => $car->id]) }}">Detail</a></li>
                                        <li><a class="dropdown-item disabled" href="{{ route('admin.car.edit', ['id' => $car->id]) }}">Edit</a></li>
                                        <li><button type="button" class="dropdown-item" onclick="if(confirm('Êtes-vous sûr de vouloir Delete cette voiture?')) { document.getElementById('delete-form').submit(); }">Delete</button>
                                            <form id="delete-form" action="{{ route('admin.car.destroy', ['id' => $car->id]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $cars->links() }}
            </div>
        </div>
    </div>
</main>
@endsection