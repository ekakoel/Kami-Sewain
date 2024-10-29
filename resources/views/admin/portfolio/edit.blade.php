{{-- @extends('admin.layouts.master')
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
                            <form id="updatePortfolio" action="{{ route('admin.portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="cover">Cover Image</label>
                                    <div class="post-cover-img-preview">
                                        <img id="coverPreview" src="{{ asset('/storage/images/portfolio/'.$portfolio->featured_image) }}" alt="{{ $portfolio->alt }}" width="100">
                                    </div>
                                    <input id="cover" type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" onchange="previewCoverImage(event)" value="{{ $portfolio->featured_image }}">
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $portfolio->title }}" required>
                                </div>
                
                                <div class="mb-3">
                                    <label for="categories" class="form-label">Category {{ $portfolio->categories }}</label>
                                    <select class="form-select" id="categories" name="categories" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $portfolio->categories->id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea class="textarea_editor form-control" id="content" name="content"  style="height: 800px !important;" required>{{ $portfolio->content }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    <div id="tagsContainer" class="tags-container">
                                        @foreach($portfolio->tags as $tag)
                                            <span class="tag-badge" data-tag="{{ $tag->name }}">
                                                {{ $tag->name }} <i class="fas fa-times ms-1 remove-tag"></i>
                                            </span>
                                        @endforeach
                                    </div>
                                    <input type="text" class="form-control" id="tagInput" placeholder="Enter tags separated by commas">
                                    <input type="hidden" name="tags" id="hiddenTags" value="{{ implode(',', $portfolio->tags->pluck('name')->toArray()) }}">
                                </div>
                            </form>
                        </div>

                        <div class="card-box-footer">
                            <button type="submit" form="updatePortfolio" class="btn btn-success">Save Changes</button>
                            <a href="{{ route('admin.portfolio.detail', $portfolio->id) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagInput = document.getElementById('tagInput');
            const hiddenTags = document.getElementById('hiddenTags');
            const tagsContainer = document.getElementById('tagsContainer');
            let tagsArray = hiddenTags.value ? hiddenTags.value.split(',') : [];
            function updateTags() {
                tagsContainer.innerHTML = '';
                tagsArray.forEach(tag => {
                    const badge = document.createElement('span');
                    badge.classList.add('tag-badge');
                    badge.setAttribute('data-tag', tag);
                    badge.innerHTML = `${tag} <i class="fas fa-times ms-1"></i>`;
                    tagsContainer.appendChild(badge);
                });
                hiddenTags.value = tagsArray.join(',');
            }

            tagInput.addEventListener('keyup', function(event) {
                if (event.key === ',') {
                    let tag = tagInput.value.trim().replace(',', '');
                    if (tag && !tagsArray.includes(tag)) {
                        tagsArray.push(tag);
                    }
                    tagInput.value = '';
                    updateTags();
                }
            });
            tagsContainer.addEventListener('click', function(event) {
                if (event.target.tagName === 'I') { 
                    const badge = event.target.closest('.tag-badge');
                    const tag = badge.getAttribute('data-tag');
                    tagsArray = tagsArray.filter(t => t !== tag);
                    updateTags();
                }
            });
        });
    </script>
@endsection --}}


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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="admin-navigation">
                <div class="admin-navigation-title">Portfolio</div>
                <hr class="hr-admin-navigation">
                <div class="admin-navigation-list-container">
                    <div class="admin-navigation-list"><a href="{{ route('admin.portfolio') }}">Portfolio</a></div>
                    <div class="admin-navigation-list"><a href="{{ route('admin.portfolio.detail',$portfolio->id) }}">{{ $portfolio->title }}</a></div>
                    <div class="admin-navigation-list active">Edit Portfolio</div>
                </div>
            </div>
            
            <form id="updatePortfolio" action="{{ route('admin.portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card-box mb-30">
                            <div class="card-box-header d-flex justify-content-between">
                                <h3 class="mb-0">Edit Portfolio</h3>
                            </div>
                            <div class="card-box-body">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $portfolio->title }}" required>
                                    @error('title')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea class="textarea_editor form-control" id="content" name="content"  style="height: 800px !important;" required>{!! $portfolio->content !!}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description"  style="height: 180px !important;" required>{!! $portfolio->meta_description !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-box mb-30">
                            <div class="card-box-header text-right">
                                <button type="submit" form="updatePortfolio" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                <a href="{{ route('admin.portfolio.detail',$portfolio->id) }}" class="btn btn-secondary"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
                            </div>
                            <div class="form-group">
                                <label for="featured_image">Cover Image</label>
                                <div class="post-cover-img-preview">
                                    <img id="coverPreview" src="{{ asset('storage/images/portfolio/'.$portfolio->featured_image) }}" alt="Image {{ $portfolio->title }}" width="100">
                                </div>
                                <input id="featured_image" type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" onchange="previewCoverImage(event)" value="">
                            </div>
                            <div class="card-box-body">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option {{ $portfolio->status == "draft"?"selected":""; }} value="draft">Draft</option>
                                        <option {{ $portfolio->status == "published"?"selected":""; }} value="published">Published</option>
                                        <option {{ $portfolio->status == "archived"?"selected":""; }} value="archived">Archived</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option {{ $portfolio->categories?->id == $category->id?"selected":""; }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tags" class="form-label">Tags</label>
                                    <div id="tagsContainer" class="tags-container">
                                        @foreach ($portfolio->tags as $tag)
                                            <span class="tag-badge" data-tag="{{ $tag->name }}">{{ $tag->name }} <i class="fas fa-times ms-1"></i></span>
                                        @endforeach
                                    </div>
                                    <input type="text" class="form-control" id="tagInput" placeholder="Enter tags separated by commas">
                                    <input type="hidden" name="tags" id="hiddenTags" value="{{ implode(',', $portfolio->tags->pluck('name')->toArray()) }}">
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords" class="form-label">Keyword</label>
                                    <textarea class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords"  style="height: 80px !important;" required>{!! $portfolio->meta_keywords !!}</textarea>
                                    @error('meta_keywords')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tagInput = document.getElementById('tagInput');
            const hiddenTags = document.getElementById('hiddenTags');
            const tagsContainer = document.getElementById('tagsContainer');
            let tagsArray = hiddenTags.value ? hiddenTags.value.split(',') : [];
            function updateTags() {
                tagsContainer.innerHTML = '';
                tagsArray.forEach(tag => {
                    const badge = document.createElement('span');
                    badge.classList.add('tag-badge');
                    badge.setAttribute('data-tag', tag);
                    badge.innerHTML = `${tag} <i class="fas fa-times ms-1"></i>`;
                    tagsContainer.appendChild(badge);
                });
                hiddenTags.value = tagsArray.join(',');
            }

            tagInput.addEventListener('keyup', function(event) {
                if (event.key === ',') {
                    let tag = tagInput.value.trim().replace(',', '');
                    if (tag && !tagsArray.includes(tag)) {
                        tagsArray.push(tag);
                    }
                    tagInput.value = '';
                    updateTags();
                }
            });
            tagsContainer.addEventListener('click', function(event) {
                if (event.target.tagName === 'I') { 
                    const badge = event.target.closest('.tag-badge');
                    const tag = badge.getAttribute('data-tag');
                    tagsArray = tagsArray.filter(t => t !== tag);
                    updateTags();
                }
            });
        });
        function previewCoverImage(event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function(){
                var preview = document.getElementById('coverPreview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
