@extends('admin.layouts.master')

@section('title', 'Portfolio')

@section('main')
<main>
    <div class="container-fluid px-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="admin-navigation">
            <div class="admin-navigation-title">Comments</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active"><a href="/admin/portfolio">Comments</a></div>
            </div>
        </div>
        <div class="card-box mb-30">
            @if($comments->count() > 0)
                <table id="commentTable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">#</th>
                            <th>Post</th>
                            <th class="text-center datatable-nosort">Comment | Replies</th>
                            <th class="text-center datatable-nosort">Pending</th>
                            <th class="text-center datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = 0;
                        @endphp
                        @foreach ($posts as $post)
                            @if (count($post->comments)>0)
                                <tr>
                                    <td class="table-plus">{{ ++$index }}</td>
                                    <td><a href="{{ route('admin.portfolio.detail', $post->id) }}" target="_blank">{{ $post->title }}</a></td>
                                    <td class="text-center">
                                        {{ count($post->comments->where('parent_id',null)) }} C | {{ count($post->comments->where('parent_id',!null)) }} R
                                    </td>
                                    <td class="text-center">
                                        {{ count($post->comments->where('status','pending')) }}
                                    </td>
                                    
                                    <td class="text-center">
                                        <a class="dropdown-item" href="{{ route('admin.comment.detail',$post->id) }}"><i class="dw dw-eye"></i> View</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No comments found.</p>
            @endif
        </div>
    </div>
</main>
@endsection