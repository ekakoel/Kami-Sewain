@extends('layouts.base')

@section('body')
  @include('layouts.partials.header')
    <main class="main">
        @yield('main')
    </main>
@endsection
