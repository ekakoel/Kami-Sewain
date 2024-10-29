@extends('layouts.master')
@section('title', 'Create Post')
@section('main')
    <div class="container">
        <h1>Create Blog Post</h1>

        <form action="{{ route('blog.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
            </div>

            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <input type="text" name="meta_description" class="form-control" value="{{ old('meta_description') }}">
            </div>

            <div class="form-group">
                <label for="meta_keywords">Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <div class="form-group">
                <label for="categories">Categories</label>
                <select name="categories[]" class="form-control" multiple required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tags">Tags</label>
                <select name="tags[]" class="form-control" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>
@endsection
