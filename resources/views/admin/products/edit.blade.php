@extends('admin.layouts.master')

@section('title', 'Edit Product')

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

            <!-- Admin Navigation -->
            <div class="admin-navigation">
                <div class="admin-navigation-title">Edit Product</div>
                <hr class="hr-admin-navigation">
                <div class="admin-navigation-list-container">
                    <div class="admin-navigation-list"><a href="{{ route('admin.products') }}">Products</a></div>
                    <div class="admin-navigation-list"><a href="{{ route('admin.products.detail',['id'=>$product->id]) }}">{{ $product->name }}</a></div>
                    <div class="admin-navigation-list active">Edit</div>
                </div>
            </div>

            <!-- Form Edit Product -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card-box mb-30">
                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
        
                            <!-- Product Details -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-title">Detail Product</div>
                                    <div class="form-group">
                                        <label for="status">Status<span>*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="Active" {{ $product->status == "Active" ? 'selected' : '' }}>Active</option>
                                            <option value="Draft" {{ $product->status == "Draft" ? 'selected' : '' }}>Draft</option>
                                        </select>
                                    </div>
                                     <div class="form-group">
                                        <label for="cover">Cover Image</label>
                                        <div class="form-cover-img-preview">
                                            <img id="coverPreview" src="{{ asset('images/products/'.$product->cover) }}" alt="{{ $product->alt }}" width="100">
                                        </div>
                                        <input id="cover" type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" onchange="previewCoverImage(event)" value="{{ $product->cover }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="sku">SKU<span>*</span></label>
                                        <input id="sku" type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ $product->sku }}" required>
                                        @error('sku')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div id="sku-message" class="alert alert-danger mt-2" style="display:none;"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Product Name<span>*</span></label>
                                        <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $product->name }}" required>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label for="description">Description<span>*</span></label>
                                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="6" required>{{ $product->description }}</textarea>
                                        @error('description')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label for="category_id">Category<span>*</span></label>
                                        <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                            <option value="" {{ $product->category_id ? 'selected' : '' }}>Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                            @error('category_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </select>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="material">Material<span>*</span></label>
                                        <select id="material" name="material" class="form-control @error('material') is-invalid @enderror" required>
                                            <option value="" {{ $product->material_id ? 'selected' : '' }}>Select Material</option>
                                            @foreach ($materials as $material)
                                                <option {{ $product->material?->name == $material->name?"selected":"" }} value="{{ $material->id }}">{{ $material->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('material')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="model">Model<span>*</span></label>
                                        <select id="model" name="model" class="form-control">
                                            <option value="" {{ $product->model_id ? 'selected' : '' }}>Select Model</option>
                                            @foreach ($models as $model)
                                                <option {{ $product->model?->name == $model->name?"selected":"" }} value="{{ $model->id }}">{{ $model->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="color">Choose Color {{ $product->color?->name }}<span>*</span></label>
                                        <select name="color" class="form-select form-select-sm mt-3">
                                            <option value="" {{ $product->color_id ? 'selected' : '' }}>Select Color</option>
                                            @foreach ($colors as $color)
                                                <option {{ $product->color?->name === $color->name ? "selected" : "" }} value="{{ $color->id }}" class="color-option" data-color="{{ $color->name }}">⬤ {{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="price">Price<span>*</span></label>
                                        <input id="price" type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ $product->price }}" required>
                                        @error('price')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label for="stock">Stock<span>*</span></label>
                                        <input id="stock" type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ $product->stock }}" required>
                                        @error('stock')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label for="production_date">Production Date<span>*</span></label>
                                        <input id="production_date" type="date" name="production_date" class="form-control @error('production_date') is-invalid @enderror" value="{{ $product->production_date }}" required>
                                        @error('production_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
        
                                    
                                </div>
        
                                <!-- Product Images -->
                                <div class="col-md-6">
                                    
                                    <div class="form-title">Product Images (Max 5)</div>
                                    <div class="form-group">
                                        @php
                                            $imageNames = ['Front', 'Right', 'Left', 'Back', 'Top'];
                                        @endphp
                                        @foreach ($imageNames as $index => $imageName)
                                            @php
                                                $secondary_image = $product->secondaryImages->where('name',$imageName)->first();
                                            @endphp
                                            <div class="form-group">
                                                <label for="image_{{ $index }}">{{ $imageName }} Image</label>
                                                <div class="form-img-preview">
                                                    @if($secondary_image)
                                                        <img id="previewImage{{ $index }}" src="{{ asset('images/products/'.$secondary_image->url) }}" alt="{{ "Product ".$secondary_image->name." image" }}" width="100">
                                                        <i id="btnRemoveImage{{ $index }}" class="delete-image fas fa-times" style="background: none; border: none; cursor: pointer; color: red;" data-id="{{ $secondary_image->id }}" data-index="{{ $index }}"></i>
                                                        {{-- <button class="delete-image" data-id="{{ $secondary_image->id }}" >&times;</button> --}}
                                                    @else
                                                        <img id="previewImage{{ $index }}" src="" alt="No image" width="100" style="display: none;">
                                                    @endif
                                                </div>
                                                <input type="file" name="images[{{ $index }}]" id="imageInput{{ $index }}" class="form-control mt-2" onchange="previewImage(event, {{ $index }})">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-box-footer text-right">
                                <a href="{{ route('admin.products') }}">
                                    <div class="btn button-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</div>
                                </a>
                                <button type="submit" class="btn button-secondary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
            
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function previewImage(event, index) {
            var input = event.target;
            var reader = new FileReader();
    
            reader.onload = function(){
                var preview = document.getElementById('previewImage' + index);
                preview.src = reader.result;
                preview.style.display = 'block';
            };
    
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
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

        $(document).ready(function() {
            $('#sku').on('input', function() {
                let sku = $(this).val();
                if (sku) {
                    $.ajax({
                        url: '{{ route("check.sku") }}',
                        type: 'POST',
                        data: {
                            sku: sku,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.exists) {
                                $('#sku-message').text('SKU has already been used. Please enter a different SKU.').show();
                            } else {
                                $('#sku-message').hide();
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            $('#sku-message').text('An error occurred while checking the SKU.').show();
                        }
                    });
                } else {
                    $('#sku-message').hide();
                }
            });
        });
    </script>
    <script>
       $(document).on('click', '.delete-image', function() {
        var imageId = $(this).data('id');
        var index = $(this).data('index');
        var url = '/admin/image/' + imageId + '/delete';
        if (confirm('Are you sure you want to delete this image?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#previewImage' + index).fadeOut();
                    $('#btnRemoveImage' + index).fadeOut();
                    alert(response.success);
                },
                error: function(xhr) {
                    alert('Error deleting image.');
                }
            });
        }
    });
    </script>
@endsection
