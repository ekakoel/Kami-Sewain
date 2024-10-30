@extends('layouts.master')
@section('title', 'Portfolio')
@section('main')
    <main class="flex-shrink-0">
        <div class="header-container">
            <div class="header-caption">
                <div class="header-title m-b-18">{{ $page_properties?$page_properties->slider_title:"Portfolio"; }}</div>
                <p>{!! $page_properties?$page_properties->slider_caption:"Create a romantic and elegant atmosphere with our wedding equipment rentals.<br> From charming chairs to stunning lighting, we are here to meet all your wedding needs."; !!}</p>
            </div>
        </div>
        <div class="section-container">
            @if ($posts->isEmpty())
                <div class="alert alert-info text-center">
                    <strong>No portfolio available. Please check back later!</strong>
                </div>
            @else
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-lg-3 m-b-18">
                            <a href="/portfolio/{{ $post->slug }}">
                                <div class="card h-100 shadow border-0">
                                    <img class="post-img" src="{{ asset('images/portfolio/'.$post->featured_image) }}" alt="Image {{ $post->title }}" />
                                    <div class="card-body">
                                        <div class="badge-primary m-b-8">
                                            {{ $post->categories?->name }}
                                        </div>
                                        <div class="card-title mb-3">{{ $post->title }}</div>
                                        <p class="card-text p-b-18">{{ Str::limit($post->content, 150) }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $posts->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
    </main>
    @include('layouts.partials.footer-secondary')
@endsection
