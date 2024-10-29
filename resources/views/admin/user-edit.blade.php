@extends('admin.layouts.master')

@section('title', "Edit {{ $user->name }}")

@section('main')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit informations l'utilisateur</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Welcome</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
            <li class="breadcrumb-item active">{{ $user->name }}</li>
        </ol>
        <!-- <div class="card mb-4">
            <div class="card-body">
                Ici vous pouvez Detail toute les car de notre parking.
            </div>
        </div>-->
        <div class="mb-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 my-2 col-form-label">First name :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telephone" class="col-sm-3 my-2 col-form-label">Telephone :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $user->telephone }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_of_birth" class="col-sm-3 my-2 col-form-label">Date of birth :</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ $user->date_of_birth }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 my-2 col-form-label">Email :</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 my-2 col-form-label">Password :</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Laissez vide si vous ne voulez pas Change password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="btn button-primary mr-2" disabled>Enregistrer</button>
                                <button type="button" class="btn btn-secondary" >Annuler</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection