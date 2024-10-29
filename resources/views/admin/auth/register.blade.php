@extends('layouts.base')

@section('title', 'Register')

@section('body')
<!-- main content -->
<main class="main main--sign" data-bg="img/bg/bg.png">   
<!-- registration form -->
    <div class="sign">
        <div class="sign-content">
            {{-- <form action="{{ route('admin.register.perform') }}" method="POST" class="sign-form">
                @csrf
                <h2>Administration</h2> 
                <a href="{{ route('home.index') }}" class="sign-logo">
                    <img src="{{ asset('img/logo.svg') }}" alt="">
                </a>

                @if ($errors->has('username'))
                    <span class="text-danger text-center">{{ $errors->first('username') }}</span>
                @endif
                <div class="sign-group">
                    <input type="text" name="username" class="sign-input" placeholder=" Administrator name">
                </div>
    
                @if ($errors->has('fullname'))
                    <span class="text-danger text-center">{{ $errors->first('fullname') }}</span>
                @endif
                <div class="sign-group">
                    <input type="text" name="fullname" class="sign-input" placeholder="Full name">
                </div>
                
                @if ($errors->has('email'))
                    <span class="text-danger text-center">{{ $errors->first('email') }}</span>
                @endif
                <div class="sign-group">
                    <input type="email" name="email" class="sign-input" placeholder="Email">
                </div>

                @if ($errors->has('password'))
                    <span class="text-danger text-center">{{ $errors->first('password') }}</span>
                @endif
                <div class="sign-group">
                    <input type="password" name="password" class="sign-input" placeholder="Password">
                </div>


                <button class="sign-btn" type="submit"><span>S'inscrire</span></button>

                <span class="sign-text">Do you already have an account? <a href="{{ route('admin.login.show') }}">Log in!</a></span>
            </form> --}}
        </div>
    </div>
    <!-- end registration form -->
</main>
<!-- end main content -->
@endsection