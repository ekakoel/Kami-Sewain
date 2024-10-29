@extends('layouts.master')
@section('title', $post->title)
@section('main')
    <main class="flex-shrink-0">
        <div class="header-container">
            <div class="header-caption">
                <div class="header-title m-b-18">{{ $page_properties?$page_properties->slider_title:"Portfolio"; }}</div>
                <p>{!! $page_properties?$page_properties->slider_caption:"Create a romantic and elegant atmosphere with our wedding equipment rentals.<br> From charming chairs to stunning lighting, we are here to meet all your wedding needs."; !!}</p>
            </div>
        </div>
        <div class="section-container">
            <div class="row">
                <!-- Post Content -->
                <div class="col-md-8">
                    <article class="blog-post">
                        <!-- Post Image -->
                        @if($post->featured_image)
                            <img src="{{ asset('storage/images/portfolio/' . $post->featured_image) }}" class="post-img img-fluid rounded mb-4" alt="{{ $post->title }}">
                        @endif

                        <!-- Post Title -->
                        <h1 class="mb-3">{{ $post->title }}</h1>

                        <!-- Post Meta Data -->
                        <div class="post-meta mb-3 text-muted">
                            <span><i class="bi bi-person-circle"></i> {{ $post->user->name ?? "Admin" }}</span> |
                            <span><i class="bi bi-calendar"></i> {{ $post->created_at->format('M d, Y') }}</span> |
                            <span><i class="bi bi-folder"></i> 
                                @foreach($post->categories as $category)
                                    <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            </span>
                        </div>

                        <!-- Post Content -->
                        <div class="post-content">
                            {!! $post->content !!}
                        </div>

                        <!-- Tags -->
                        @if($post->tags->isNotEmpty())
                        <div class="tags mt-4">
                            <h5>Tags:</h5>
                            @foreach($post->tags as $tag)
                            <a href="{{ route('tag.show', $tag->id) }}" class="badge bg-primary">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                        @endif
                    </article>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="sidebar">
                        <!-- Latest Posts -->
                        <h4 class="mb-4">Latest Posts</h4>
                        <ul class="list-group list-group-flush">
                            @foreach($latestPosts as $latest)
                            <li class="list-group-item">
                                <a href="{{ route('blog.show', $latest->id) }}">{{ Str::limit($latest->title, 50) }}</a>
                                <small class="text-muted d-block">{{ $latest->created_at->format('M d, Y') }}</small>
                            </li>
                            @endforeach
                        </ul>

                        <!-- Categories -->
                        <h4 class="mt-5 mb-4">Categories</h4>
                        <ul class="list-group list-group-flush">
                            @foreach($categories as $category)
                            <li class="list-group-item">
                                <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.partials.footer-secondary')
@endsection
