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
                <div class="admin-navigation-title">Comment Detail</div>
                <hr class="hr-admin-navigation">
                <div class="admin-navigation-list-container">
                    <div class="admin-navigation-list"><a href="{{ route('admin.comments') }}">Comments</a></div>
                    <div class="admin-navigation-list active">Comment on {{ $post->slug }}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    
                    <div class="card-box mb-30">
                        <div class="card-box-header d-flex justify-content-between">
                            <h3 class="mb-0">{{ $post->title }}</h3>
                            <a href="{{ route('admin.portfolio.detail', $post->id) }}" target="_blank" class="btn button-secondary"><i class="dw dw-eye"></i> View Portfolio</a>
                        </div>
                        <div class="card-box-body">
                            @foreach ($post->comments as $comment)
                                <span id="comment-{{ $comment->id }}"></span>
                                @if (!$comment->parent_id)
                                    <div class="comment-card">
                                        <div class="comment-header">
                                            <strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>
                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="comment-container">
                                            <div class="comment-body">
                                                <span id="comment-status-{{ $comment->id }}">
                                                    @if ($comment->status == 'approved')
                                                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                    @elseif($comment->status == 'pending')
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                    @elseif($comment->status == 'rejected')
                                                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                    @endif
                                                </span>
                                                {{ $comment->comment }}
                                            </div>
                                            
                                            <div class="inline-flex" id="comment-actions-{{ $comment->id }}">
                                                @if ($comment->status == "pending")
                                                    <button class="btn-action-reject" onclick="rejectComment({{ $comment->id }})"><i class="fas fa-times"></i> Reject</button>
                                                    <button class="btn-action-approve" onclick="approveComment({{ $comment->id }})"><i class="fas fa-check"></i> Approve</button>
                                                @elseif($comment->status == "approved")
                                                    <button class="btn-action-reject" onclick="rejectComment({{ $comment->id }})"><i class="fas fa-times"></i> Reject</button>
                                                @elseif($comment->status == "rejected")
                                                    <button class="btn-action-approve" onclick="approveComment({{ $comment->id }})"><i class="fas fa-check"></i> Approve</button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="reply-form">
                                            @if($comment->replies->count() > 0)
                                                <div class="replies-container">
                                                    @foreach ($comment->replies as $reply)
                                                        <div class="comment-container">
                                                            @if ($reply->user_id)
                                                                <div class="replies">
                                                                    <span id="comment-status-{{ $reply->id }}">
                                                                        @if ($reply->status == 'approved')
                                                                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                                        @elseif($reply->status == 'pending')
                                                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                                        @elseif($reply->status == 'rejected')
                                                                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                                        @endif
                                                                    </span>
                                                                    <strong>{{ $reply->user->name }}</strong>: {{ $reply->comment }}
                                                                </div>
                                                            @elseif($reply->admin_id)
                                                                <div class="replies">
                                                                    <span id="comment-status-{{ $reply->id }}">
                                                                        @if ($reply->status == 'approved')
                                                                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                                        @elseif($reply->status == 'pending')
                                                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                                        @elseif($reply->status == 'rejected')
                                                                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                                        @endif
                                                                    </span>
                                                                    <strong>{{ $reply->admin->username }}</strong>: {{ $reply->comment }}
                                                                </div>
                                                            @endif
                                                            <div class="inline-flex" id="comment-actions-{{ $reply->id }}">
                                                                @if ($reply->status == "pending")
                                                                    <button class="btn-action-reject" onclick="rejectComment({{ $reply->id }})"><i class="fas fa-times"></i> Reject</button>
                                                                    <button class="btn-action-approve" onclick="approveComment({{ $reply->id }})"><i class="fas fa-check"></i> Approve</button>
                                                                @elseif($reply->status == "approved")
                                                                    <button class="btn-action-reject" onclick="rejectComment({{ $reply->id }})"><i class="fas fa-times"></i> Reject</button>
                                                                @elseif($reply->status == "rejected")
                                                                    <button class="btn-action-approve" onclick="approveComment({{ $reply->id }})"><i class="fas fa-check"></i> Approve</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="btn-container-right">
                                            <button class="btn-replay" onclick="toggleReplyForm({{ $comment->id }})">Reply</button><br>
                                        </div>
                                        <form method="POST" action="{{ route('portfolio.comments.store', $post->id) }}" id="reply-form-{{ $comment->id }}" style="display:none; text-align: right;">
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
                <div class="col-md-4">
                    <div class="card-box mb-30">
                        <h5>Comments</h5>
                        
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function approveComment(commentId) {
            $.ajax({
                url: '/admin/comment/' + commentId + '/approve',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $('#comment-status-' + commentId).html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
                    $('#comment-actions-' + commentId).html(`<button class="btn-action-reject" onclick="rejectComment(${commentId})"><i class="fas fa-times"></i> Reject</button>`);
                },
                error: function(xhr) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        }
    
        function rejectComment(commentId) {
            $.ajax({
                url: '/admin/comment/' + commentId + '/reject',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    $('#comment-status-' + commentId).html('<i class="fa fa-times-circle" aria-hidden="true"></i>');
                    $('#comment-actions-' + commentId).html(`<button class="btn-action-approve" onclick="approveComment(${commentId})"><i class="fas fa-check"></i> Approve</button>`);
                },
                error: function(xhr) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        }
    </script>
@endsection
