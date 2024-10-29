@extends('layouts.base')

@section('title', 'Login')

@section('body')
<!-- main content -->
<main class="main main--sign" data-bg="img/bg/bg.png">
    <!-- login form -->
    <div class="sign">
        <div class="sign-content">
            <form action="{{ route('admin.login.perform') }}" method="POST" class="sign-form">
                @csrf
                <a href="{{ route('home.index') }}" class="sign-logo">
                    <div class="logo">
                        <img src="{{ asset('/logo/logo-kami-sewain-caption-color.png') }}" alt="Logo Kami Sewain">
                        
                        {{-- <div class="logo-caption">
                            Exclusive Wedding Equipment
                        </div> --}}
                    </div>
                </a>

                @if ($errors->has('username'))
                    <span class="text-danger text-center">{{ $errors->first('username') }}</span>
                @endif
                <div class="sign-group">
                    <input type="text" name="username" class="sign-input" placeholder="Administrator name">
                </div>

                @if (isset ($errors) && count($errors) > 0 && !$errors->has('username'))
                    <span class="text-danger text-center">{{ "Invalid password" }}</span>
                @endif
                <div class="sign-group">
                    <input id="password" type="password" name="password" class="sign-input" placeholder="Password">
                    <span toggle="#password" class="fa fa-fw fa-eye field-icon-login toggle-password"></span>
                </div>


                <button class="sign-btn" type="submit"><span>Log in</span></button>

                {{-- <span class="sign-text">Don't have an account yet? <a href="{{ route('admin.register.show') }}"> Register!</a></span> --}}
            </form>
        </div>
    </div>
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
</main>
<!-- end main content -->
@endsection