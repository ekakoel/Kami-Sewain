@extends('layouts.master')
@section('title', 'Blog Category')
@section('main')
    <div class="header-container">
        <div class="header-caption">
            <div class="header-title m-b-18">Category</div>
            <p>
                @foreach ($posts as $post)
                    @if($post->categories->isNotEmpty())
                        @foreach($post->categories as $category)
                            {{ $category->name }}
                        @endforeach
                    @endif
                @endforeach
            </p>
        </div>
    </div>
    <div class="section-container">
        @if ($posts->isEmpty())
            <div class="alert alert-info text-center">
                <strong>No posts available in this category.</strong>
            </div>
        @else
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow border-0">
                            <img class="card-img" src="{{ asset('images/portfolio/'.$post->featured_image) }}" alt="..." />
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
                {{ $posts->links() }} <!-- Tautan pagination -->
            </div>
        @endif
        <div class="text-center mt-4">
            <button onclick="window.history.back()" class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
            {{-- <a href="{{ route('blog.index') }}" class="btn btn-secondary">Back to Blog</a> --}}
        </div>
    </div>
@endsection
