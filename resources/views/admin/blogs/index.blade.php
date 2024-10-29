@extends('admin.layouts.master')

@section('title', 'Blogs')

@section('main')
    <div class="container">
        <h1>Manage Blog Posts</h1>
        <a href="{{ route('blog.create') }}" class="btn btn-primary mb-3">Create New Post</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ ucfirst($post->status) }}</td>
                        <td>
                            <a href="{{ route('blog.edit',$post->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('blog.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $posts->links() }}
    </div>
@endsection
