@extends('layouts.base')

@section('title', 'Register')

@section('body')
<!-- main content -->
<main class="main main--sign" data-bg="img/bg/bg.png">
    <!-- registration form -->
    <div class="sign">
        <div class="sign-content">
            <form action="/register-perform" method="POST" class="sign-form">
                @csrf
                <a href="{{ route('home.index') }}" class="sign-logo">
                    <div class="logo">
                        <div class="logo-text">
                            Kami Sewain
                        </div>
                        <div class="logo-caption">
                            Exclusive Wedding Equipment
                        </div>
                    </div>
                </a>

                @if ($errors->has('name'))
                    <span class="text-danger text-center">{{ $errors->first('name') }}</span>
                @endif
                <div class="sign-group">
                    <input type="text" name="name" class="sign-input" placeholder="Name" value="{{ old('name') }}">
                </div>

                @if ($errors->has('email'))
                    <span class="text-danger text-center">{{ $errors->first('email') }}</span>
                @endif
                <div class="sign-group">
                    <input type="email" name="email" class="sign-input" placeholder="Email" value="{{ old('email') }}">
                </div>

                @if ($errors->has('telephone'))
                    <span class="text-danger text-center">{{ $errors->first('telephone') }}</span>
                @endif
                <div class="sign-group">
                    <input type="text" name="telephone" class="sign-input" placeholder="Telephone" value="{{ old('telephone') }}">
                </div>
                @if ($errors->has('password'))
                    <span class="text-danger text-center">{{ $errors->first('password') }}</span>
                @endif
                <div class="sign-group">
                    <input id="password" type="password" name="password" class="sign-input" placeholder="Password" value="{{ old('password') }}">
                    <span toggle="#password" class="fa fa-fw fa-eye field-icon-login toggle-password"></span>
                </div>
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger text-center">{{ $errors->first('password_confirmation') }}</span>
                @endif
                <div class="sign-group">
                    <input id="passwordConfirm" type="password" name="password_confirmation" class="sign-input" placeholder="Confirm Password">
                    <span toggle="#passwordConfirm" class="fa fa-fw fa-eye field-icon-login toggle-password"></span>
                </div>
                <button class="sign-btn" type="submit"><span>Register</span></button>
                <span class="sign-text">Do you already have an account? <a href="/login">Log in!</a></span>
            </form>
        </div>
    </div>
    <div id="loading" style="display: none;">
        <div class="spinner-container">
            <i class="fas fa-spinner fa-spin"></i> <!-- Ikon berputar -->
        </div>
    </div>
    <script>
        document.querySelectorAll('.sign-form').forEach(form => {
            form.addEventListener('submit', function() {
                document.getElementById('loading').style.display = 'flex'; // Tampilkan elemen loading
            });
        });
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
</main>
<!-- end main content -->
@endsection