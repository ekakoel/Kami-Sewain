@extends('layouts.base')

@section('title', 'Login')

@section('body')
<!-- main content -->
<main class="main main--sign" data-bg="img/bg/bg.png">
    <!-- registration form -->
    <div id="bg-sign" class="sign fade-in">
        <div class="sign-content">
            <form action="/login-perform" method="POST" class="sign-form">
                @csrf
                <a href="{{ route('home.index') }}" class="sign-logo">
                    {{-- <img src="{{ asset('images/logo/kami_sewain_logo.jpg') }}" alt="logo kami sewain"> --}}
                    <div class="logo">
                        <div class="logo-text">
                            Kami Sewain
                        </div>
                        <div class="logo-caption">
                            Exclusive Wedding Equipment
                        </div>
                    </div>
                </a>

                @if ($errors->has('email'))
                    <span class="text-danger text-center">{{ $errors->first('email') }}</span>
                @endif
                <div class="sign-group">
                    <input type="email" name="email" class="sign-input" placeholder="Email">
                </div>

                @if (isset ($errors) && count($errors) > 0 && !$errors->has('email'))
                    <span class="text-danger text-center">{{ "Invalid password" }}</span>
                @endif
                <div class="sign-group">
                    <input id="password" type="password" name="password" class="sign-input" placeholder="Password">
                    <span toggle="#password" class="fa fa-fw fa-eye field-icon-login toggle-password"></span>
                </div>


                <button class="sign-btn" type="submit"><span>Log in</span></button>
                <a href="{{ route('password.request') }}">Forgot Password</a>
                <span class="sign-text">Don't have an account yet?<a href="/register"> Register!</a></span>
            </form>
        </div>
    </div>
    <!-- end registration form -->
</main>
<!-- end main content -->
<script>
    window.addEventListener('load', function() {
        document.getElementById('bg-sign').classList.add('loaded');
    });
</script>
<script>
    // JavaScript untuk toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(item => {
        item.addEventListener('click', function () {
            let input = document.querySelector(this.getAttribute('toggle'));
            if (input.getAttribute('type') === 'password') {
                input.setAttribute('type', 'text');
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.setAttribute('type', 'password');
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
</script>
@endsection