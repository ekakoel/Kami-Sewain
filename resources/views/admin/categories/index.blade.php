@extends('admin.layouts.master')

@section('title', 'Product Category')

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
            <div class="admin-navigation-title">Product Categories</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active"><a href="/admin/categories">Categories</a></div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="pb-20">
                <table id="productTable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Icon</th>
                            <th>Products</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $no=>$category)
                            <tr>
                                <td class="table-plus">{{ ++$no }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->icon }}</td>
                                <td>{{ count($category->products) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#updateCategoryProduct{{ $category->id }}" type="button"><i class="dw dw-edit2"></i> Edit</a>
                                            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="button-delete">
                                                    <i class="dw dw-delete-3"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="updateCategoryProduct{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Edit Category</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.category.update',$category->id) }}" method="POST" id="updateCategoryForm{{ $category->id }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="name">Category Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" required>{!! $category->description !!}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="icon{{ $no }}">Icon Image</label>
                                                    <img id="EditIconPreview{{ $no }}" src="{{ asset('images/categories/'.$category->icon) }}" alt="Icon Preview" style="margin-top: 10px; width: 100px; height: auto; margin-bottom:18px;">
                                                    <input type="file" class="form-control" id="icon{{ $no }}" name="icon" accept="image/*" data-preview="EditIconPreview{{ $no }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="editBgImage{{ $no }}">Cover Image</label>
                                                    <img id="EditBgPreview{{ $no }}" src="{{ asset('images/categories/image/'.$category->cover) }}" alt="Image Preview" style="margin-top: 10px; width: 100px; height: auto; margin-bottom:18px;">
                                                    <input type="file" class="form-control" id="editBgImage{{ $no }}" name="background_image" accept="image/*" data-edit="EditBgPreview{{ $no }}">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            <button type="submit" form="updateCategoryForm{{ $category->id }}" class="btn button-secondary" id="saveCategoryButton"><i class="fas fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-box-footer">
                <a href="#" class="btn-block" data-toggle="modal" data-target="#addCategoryProduct" type="button">
                    <button class="btn button-secondary"><i class="fa fa-plus" aria-hidden="true"></i> Add More Category</button>
                </a>
                <div class="modal fade" id="addCategoryProduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Add Category</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.category.store') }}" method="POST" id="addCategoryForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Category Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="icon">Icon Image</label>
                                        <img id="iconPreview" src="#" alt="Icon Preview" style="display: none; margin-top: 10px; width: 100px; height: auto; margin-bottom:18px;">
                                        <input type="file" class="form-control" id="icon" name="icon" accept="image/*" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="bg_modal">Cover Image</label>
                                        <img id="bgModal" src="#" alt="background Preview" style="display: none; margin-top: 10px; width: 100px; height: auto; margin-bottom:18px;">
                                        <input type="file" class="form-control" id="bg_modal" name="bg_modal" accept="image/*" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                <button type="submit" form="addCategoryForm" class="btn button-secondary" id="saveCategoryButton"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Preview icon image
            $('#icon').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#iconPreview').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#iconPreview').hide();
                }
            });
        });
        $(document).ready(function() {
            // Preview icon image
            $('#bg_modal').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#bgModal').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#bgModal').hide();
                }
            });
        });

        $(document).ready(function() {
            // Preview icon image dynamically for each input in a foreach loop
            $('input[type="file"][id^="icon"]').on('change', function() {
                var input = $(this); // File input element
                var file = this.files[0];
                var previewId = input.data('preview'); // Get the preview element's ID from data attribute

                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#' + previewId).attr('src', e.target.result).show(); // Update the correct preview image
                    }
                    reader.readAsDataURL(file);
                }
            });
        });

        $(document).ready(function() {
            $('input[type="file"][id^="editBgImage"]').on('change', function() {
                var input = $(this); // File input element
                var file = this.files[0];
                var previewEditId = input.data('edit'); // Get the preview element's ID from data attribute

                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#' + previewEditId).attr('src', e.target.result).show(); // Update the correct preview image
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
        </script>
        
        
        
</main>
    
@endsection