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
                    <div class="admin-navigation-list active">Create Portfolio</div>
                </div>
            </div>
            
            <form id="addPortfolio" action="{{ route('admin.portfolio.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card-box mb-30">
                            <div class="card-box-header d-flex justify-content-between">
                                <h3 class="mb-0">New Portfolio</h3>
                            </div>
                            <div class="card-box-body">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea class="textarea_editor form-control" id="content" name="content"  style="height: 800px !important;" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description"  style="height: 180px !important;" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-box mb-30">
                            <div class="card-box-header text-right">
                                <button type="submit" form="addPortfolio" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                <a href="{{ route('admin.portfolio') }}" class="btn btn-secondary"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
                            </div>
                            <div class="form-group">
                                <label for="cover">Cover Image</label>
                                <div class="post-cover-img-preview">
                                    <img id="coverPreview" src="{{ asset('/images/default-img.jpg') }}" alt="" width="100">
                                </div>
                                <input id="cover" type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" onchange="previewCoverImage(event)" value="">
                            </div>
                            <div class="card-box-body">
                                <div class="form-group">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option selected value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tags" class="form-label">Tags</label>
                                    <div id="tagsContainer" class="tags-container"></div>
                                    
                                    <!-- Input tag utama yang dipisahkan koma -->
                                    <input type="text" class="form-control" id="tagInput" placeholder="Enter tags separated by commas">
                                    
                                    <!-- Input tersembunyi dengan notasi array pada 'name' untuk menghasilkan array -->
                                    <input type="hidden" name="tags" id="hiddenTags" value="">
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords" class="form-label">Keyword</label>
                                    <textarea class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords"  style="height: 80px !important;" required></textarea>
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
