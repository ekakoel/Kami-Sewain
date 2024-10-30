@extends('layouts.master')
@section('title', $post?$post->title:"Portfolio")
@section('main')
    <main class="flex-shrink-0">
        <div class="header-container">
            <div class="header-caption">
                <h3>
                    <div class="header-title m-b-18">{{ $post->title }}</div>
                </h3>
                <p>{!! $post->meta_description !!}</p>
            </div>
        </div>
        <div class="section-container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card-box m-b-18">
                        <div class="card-box-body">

                            <article class="blog-post">
                                @if($post->featured_image)
                                    <img src="{{ asset('images/portfolio/' . $post->featured_image) }}" class="post-img img-fluid rounded mb-4" alt="{{ $post->title }}">
                                @endif
                                <h1 class="mb-3">{{ $post->title }}</h1>
                                <div class="post-meta mb-3 text-muted">
                                    <span><i class="bi bi-person-circle"></i> {{ $author_name ?? "Admin" }}</span> |
                                    <span><i class="bi bi-calendar"></i> {{ $post->created_at->format('M d, Y') }}</span> |
                                    <span><i class="bi bi-folder"> {{ $post->categories?->name }}</i></span>
                                </div>
                                <div class="post-content">
                                    {!! $post->content !!}
                                </div>
                                @if($post->tags->isNotEmpty())
                                    <h5>Tags:</h5>
                                    <div class="tags-container">
                                        @foreach($post->tags as $tag)
                                            <a href="{{ route('portfolio.tag', $tag->slug) }}">
                                                <div class="tag-badge">
                                                    {{ $tag->name }}
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </article>
                        </div>
                    </div>
                    <section id="postComment" class="comment-container">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($comments->total()>0)
                            <div class="comments-section m-b-18">
                                <h3>Comments ({{ $comments->total() }})</h3>
                                <div class="comments-list mt-4">
                                    @foreach ($comments as $comment)
                                        <div class="comment-card">
                                            <div class="comment-header">
                                                <strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="comment-body">
                                                {{ $comment->comment }}
                                            </div>
                                            <!-- Form untuk membalas komentar -->
                                            <div class="reply-form">
                                                @if($comment->replies->count() > 0)
                                                    <div class="replies-container">
                                                        @foreach ($comment->replies->where('status','approved') as $reply)
                                                        <div class="replies">
                                                            @if ($reply->user_id)
                                                                <strong>{{ $reply->user->name }}</strong>: {{ $reply->comment }}
                                                            @elseif($reply->admin_id)
                                                                <strong>{{ $reply->admin->username }}</strong>: {{ $reply->comment }}
                                                            @endif
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @if (Auth::check())
                                                    <div class="btn-container-right">
                                                        <button class="btn-replay" onclick="toggleReplyForm({{ $comment->id }})">Reply</button>
                                                    </div>
                                                    <form method="POST" action="{{ route('blog.comments.store', $post->id) }}" id="reply-form-{{ $comment->id }}" style="display:none; text-align: right;">
                                                        @csrf
                                                        <div class="form-group p-l-18">
                                                            <textarea name="comment" class="form-control" rows="2" required placeholder="Your reply..."></textarea>
                                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        </div>
                                                        <div class="btn-container-right">
                                                            <button type="submit" class="button-primary">Submit Reply</button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Menampilkan tautan pagination -->
                                <div class="pagination mt-4">
                                    {{ $comments->links() }}
                                </div>
                            </div>
                        @endif
                        <div class="comments-section">
                            @if (Auth::check())
                                <h4>Add a Comment</h4>
                                <form method="POST" action="{{ route('blog.comments.store', $post->id) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="comment">Your Comment:</label>
                                        <textarea id="comment" name="comment" class="form-control" rows="4" required></textarea>
                                    </div>
                                    <div class="btn-container-right">
                                        <button type="submit" class="button-primary">Submit Comment</button>
                                    </div>
                                </form>
                            @else
                                <p>You must be <a href="/login">logged in</a> to post a comment.</p>
                            @endif
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <div class="card-box">
                        <div class="card-box-body">
                            <h4 class="mb-4">Latest Posts</h4>
                            <ul class="list-group list-group-flush">
                                @foreach($latestPosts as $latest)
                                    <li class="list-group-item">
                                        <a href="/portfolio/{{ $latest->slug }}">{{ Str::limit($latest->title, 50) }}</a>
                                        <small class="text-muted d-block">{{ $latest->created_at->format('M d, Y') }}</small>
                                    </li>
                                @endforeach
                            </ul>
                            <h4 class="mt-5 mb-4">Categories</h4>
                            <ul class="list-group list-group-flush">
                                @foreach($categories as $category)
                                    @if (count($category->posts)>0)
                                        <li class="list-group-item">
                                            <a href="{{ route('portfolio.category', $category->slug) }}">{{ $category->name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
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
    @include('layouts.partials.footer-secondary')
@endsection
