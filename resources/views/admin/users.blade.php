@extends('admin.layouts.master')

@section('title', 'Utiisateurs')

@section('main')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">List of Users</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Welcome</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol>
        <!-- <div class="card mb-4">
            <div class="card-body">
                Ici vous pouvez Detail toute les car de notre parking.
            </div>
        </div>-->
        <div class="mb-4">
            <div>
                <a class="btn button-primary m-3 disabled" href="#" role="button" >Add</a>
            </div>
            <div class="table-responsif">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->telephone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="dropdown open">
                                    <button class="btn button-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Options
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.user.show', ['id' => $user->id]) }}">Detail</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.user.edit', ['id' => $user->id]) }}">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</main>
@endsection