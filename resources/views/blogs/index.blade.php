@extends('layouts.master')
@section('title', 'Blogs Admin')
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
                        <div class="col-lg-3">
                            <div class="card h-100 shadow border-0">
                                <img class="card-img" src="{{ asset('storage/images/portfolio/'.$post->featured_image) }}" alt="..." />
                                <div class="card-body">
                                    @if($post->categories->isNotEmpty())
                                        @foreach($post->categories as $category)
                                            <div class="badge-primary m-b-8">
                                                {{ $category->name }}
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="card-title mb-3">{{ $post->title }}</div>
                                    <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                                </div>
                                <div class="card-footer text-right">
                                    <a href="/blog/{{ $post->id }}">
                                        <button class="button-secondary">Read more</button>
                                    </a>
                                </div>
                            </div>
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
