@extends('admin.layouts.master')

@section('title', "Detail {{ $user->username.' '.$user->fullname }}")

@section('main')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Détails sur l'utilisateur</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Welcome</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
            <li class="breadcrumb-item active">{{ $user->username.' '.$user->fullname }}</li>
        </ol>
        <!-- <div class="card mb-4">
            <div class="card-body">
                Ici vous pouvez Detail toute les car de notre parking.
            </div>
        </div>-->
        <div class="mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">First name :</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $user->username }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Name :</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $user->fullname }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Telephone :</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $user->phone }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Date of birth :</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $user->date_of_birth }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email :</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $user->email }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password :</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ $user->password }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9 text-secondary">
                            <a type="button" class="btn button-primary mr-2" href="{{ route('admin.user.edit', ['id' => $user->id]) }}">Edit</a>
                            <button type="button" class="btn btn-danger" onclick="if(confirm('Êtes-vous sûr de vouloir Delete cet utilisateur?')) { document.getElementById('delete-form').submit(); }">Delete</button>
                            <form id="delete-form" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection