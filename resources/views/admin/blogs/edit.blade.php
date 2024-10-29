@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Edit Blog Post {{ $blogPost }} test</h1>

        <form action="{{ route('blog.update', $blogPost->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $blogPost->title }}" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control" rows="5" required>{{ old('content', $blogPost->content) }}</textarea>
            </div>

            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <input type="text" name="meta_description" class="form-control" value="{{ old('meta_description', $blogPost->meta_description) }}">
            </div>

            <div class="form-group">
                <label for="meta_keywords">Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $blogPost->meta_keywords) }}">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="draft" {{ $blogPost->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $blogPost->status == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div class="form-group">
                <label for="categories">Categories</label>
                <select name="categories[]" class="form-control" multiple required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, $blogPost->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tags">Tags</label>
                <select name="tags[]" class="form-control" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, $blogPost->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
@endsection
