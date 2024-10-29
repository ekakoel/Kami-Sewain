@extends('layouts.base')

@section('title', 'Not found')

@section('body')
    <!-- main content -->
	<main class="main main--sign" data-bg="img/bg/bg.png">
		<!-- error -->
		<div class="page-404">
			<div class="page-404-wrap">
				<div class="page-404-content">
					<h1 class="page-404-title">404</h1>
					<p class="page-404-text">The page you are looking for is not Available!</p>
					<a href="{{ route('home.index') }}" class="page-404-btn"><span>Back to Home Page</span></a>
				</div>
			</div>
		</div>
		<!-- end error -->
	</main>
	<!-- end main content -->
@endsection