@extends('layouts.master')
@section('title', 'Blog Category')
@section('main')
    <div class="header-container">
        <div class="header-caption">
            <div class="header-title m-b-18">Category</div>
            <p>
                {{ $category->name }}
            </p>
        </div>
    </div>
    <div class="section-container m-b-44">
        @if (count($posts)>0)
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow border-0">
                            <img class="post-img" src="{{ asset('storage/images/portfolio/'.$post->featured_image) }}" alt="..." />
                            <div class="card-body">
                                @if($post->categories)
                                    <div class="badge-primary m-b-8">
                                        {{ $post->categories->name }}
                                    </div>
                                @endif
                                <div class="card-title mb-3">{{ $post->title }}</div>
                                <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                            </div>
                            <div class="card-footer text-right">
                                <a href="/portfolio/{{ $post->slug }}">
                                    <button class="button-secondary">Read more</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">
                <strong>No posts available in this category.</strong>
            </div>
        @endif
        <div class="text-center mt-4" style="padding-bottom: 44px !important;">
            <button onclick="window.history.back()" class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
            {{-- <a href="{{ route('blog.index') }}" class="btn btn-secondary">Back to Blog</a> --}}
        </div>
    </div>
@endsection
