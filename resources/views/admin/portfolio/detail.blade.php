@extends('admin.layouts.master')
@section('title', 'Detail Portfolio')
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
                <div class="admin-navigation-title">Portfolio</div>
                <hr class="hr-admin-navigation">
                <div class="admin-navigation-list-container">
                    <div class="admin-navigation-list"><a href="{{ route('admin.portfolio') }}">Portfolio</a></div>
                    <div class="admin-navigation-list active">{{ $portfolio->slug }}</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card-box mb-30">
                        <div class="card-box-header d-flex justify-content-between">
                            <h3 class="mb-0">{{ $portfolio->title }}</h3>
                            <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}" class="btn button-secondary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit Post</a>
                        </div>
                        <div class="card-box-body">
                            <div class="post-caption-container d-flex justify-content-between">
                                <div class="post-status">{{ $portfolio->status }}</div>
                                @if ($portfolio->status == "published")
                                    <p class="text-muted mb-2">Published on: {{ $portfolio->created_at->format('M d, Y') }}</p>
                                @endif
                            </div>
                            <div class="post-cover-image">
                                <img src="{{ asset('images/portfolio/'.$portfolio->featured_image) }}" alt="{{ $portfolio->title }}" class="img-fluid rounded">
                            </div>
                            <div>
                                {!! $portfolio->content !!}
                            </div>
                            @if($portfolio->tags->isNotEmpty())
                            <br>
                                <h5>Tags:</h5>
                                <div class="tags-container">
                                    @foreach($portfolio->tags as $tag)
                                        <a href="{{ route('portfolio.tag', $tag->slug) }}" class="tag-badge">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="card-box-footer">
                            <p>Author: {{ $portfolio->author->fullname }}</p>
                            <p>Category: {{ $portfolio->categories->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-box mb-30">
                        <h5>Meta Description</h5>
                        {!! $portfolio->meta_description !!}
                        <hr>
                        <h5>Keywords</h5>
                        {!! $portfolio->meta_keywords !!}
                    </div>
                    <div class="card-box mb-30">
                        <h5>Comments</h5>
                        @foreach ($portfolio->comments as $comment)
                            @if (!$comment->parent_id)
                                <div class="comment-card">
                                    <div class="comment-header">
                                        <strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="comment-body">
                                        @if ($comment->status == 'approved')
                                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                                        @elseif($comment->status == 'pending')
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        @elseif($comment->status == 'rejected')
                                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                                        @endif
                                        {{ $comment->comment }}
                                    </div>
                                    <div class="reply-form">
                                        @if($comment->replies->count() > 0)
                                            <div class="replies-container">
                                                @foreach ($comment->replies as $reply)
                                                    <div class="replies">
                                                        @if ($reply->user_id)
                                                            @if ($reply->status == 'approved')
                                                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                            @elseif($reply->status == 'pending')
                                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                            @elseif($reply->status == 'rejected')
                                                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                            @endif
                                                            <strong>{{ $reply->user->name }}</strong>: {{ $reply->comment }}
                                                            
                                                        @elseif($reply->admin_id)
                                                            @if ($reply->status == 'approved')
                                                                <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                            @elseif($reply->status == 'pending')
                                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                            @elseif($reply->status == 'rejected')
                                                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                            @endif
                                                            <strong>{{ $reply->admin->username }}</strong>: {{ $reply->comment }}
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="btn-container-right">
                                        <button class="btn-replay" onclick="toggleReplyForm({{ $comment->id }})">Reply</button><br>
                                    </div>
                                    <form method="POST" action="{{ route('portfolio.comments.store', $portfolio->id) }}" id="reply-form-{{ $comment->id }}" style="display:none; text-align: right;">
                                        @csrf
                                        <div class="form-group p-l-18">
                                            <textarea name="comment" class="form-control" rows="2" required placeholder="Your reply..."></textarea>
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        </div>
                                        <button type="submit" class="button-primary">Submit Reply</button>
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.approve-comment', function () {
                console.log("Approve icon clicked!"); // Log untuk memastikan klik terdeteksi
                var replyId = $(this).data('id');
                console.log("Reply ID:", replyId); // Log untuk memeriksa apakah ID diambil
    
                var icon = $(this);
                $.ajax({
                    url: "{{ route('comment.approve') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        reply_id: replyId,
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            icon.css('color', 'green');
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
    
@endsection
