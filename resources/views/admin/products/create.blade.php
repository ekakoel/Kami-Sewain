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
                <div class="admin-navigation-title">Create Product</div>
                <hr class="hr-admin-navigation">
                <div class="admin-navigation-list-container">
                    <div class="admin-navigation-list"><a href="{{ route('admin.products') }}">Products</a></div>
                    <div class="admin-navigation-list active">Create Product</div>
                </div>
            </div>

            <!-- Form Edit Product -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card-box mb-30">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
        
                            <!-- Product Details -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-title">Detail Product</div>
                                     <!-- Cover Image -->
                                     <div class="form-group">
                                        <label for="cover">Cover Image</label>
                                        <div class="form-cover-img-preview">
                                            <img id="coverPreview" src="{{ asset('images/properties/default-img.jpg') }}" alt="" width="100">
                                        </div>
                                        <input id="cover" type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" onchange="previewCoverImage(event)" value="{{ old('cover') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="sku">SKU<span>*</span></label>
                                        <input id="sku" type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}" required>
                                        @error('sku')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div id="sku-message" class="alert alert-danger mt-2" style="display:none;"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Product Name<span>*</span></label>
                                        <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label for="description">Description<span>*</span></label>
                                        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="6" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label for="category_id">Category<span>*</span></label>
                                        <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                            @error('category_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </select>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="material_id">Material<span>*</span></label>
                                        <select id="material_id" name="material_id" class="form-control @error('material_id') is-invalid @enderror" required>
                                            <option selected value="">Select Material</option>
                                            @foreach ($materials as $material)
                                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('material_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <label for="model_id">Model<span>*</span></label>
                                        <select id="model_id" name="model_id" class="form-control @error('model_id') is-invalid @enderror" required>
                                            <option selected value="">Select Model</option>
                                            @foreach ($models as $model)
                                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('model_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
        
                                    <div class="form-group color-select">
                                        <label for="color_id">Select Color<span>*</span></label>
                                        <div id="colorPalate" class="color-palate"></div>
                                        <select id="color_id" name="color_id" class="form-control custom-color-select @error('color_id') is-invalid @enderror" onchange="updateSelectColor()">
                                            <option selected value="" style="color:#000; background-color: #fff !important;">Select Color</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}" style="color:{{ $color->code }} !important" class="color-option" data-color="{{ $color->name }}">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('color_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price<span>*</span></label>
                                        <input id="price" type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                                        @error('price')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="stock">Stock<span>*</span></label>
                                        <input id="stock" type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" required>
                                        @error('stock')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="production_date">Production Date<span>*</span></label>
                                        <input id="production_date" type="date" name="production_date" class="form-control @error('production_date') is-invalid @enderror" value="{{ old('production_date') }}" required>
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
                                            <div class="form-group">
                                                <label for="image_{{ $index }}">{{ $imageName }} Image</label>
                                                
                                                <div class="form-img-preview">
                                                    <img id="previewImage{{ $index }}" src="" alt="No image" width="100" style="display: none;">
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
                                <button type="submit" class="btn button-secondary"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
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
        function updateSelectColor() {
            var select = document.getElementById('color_id');
            var colorPalate = document.getElementById('colorPalate');
            var selectedOption = select.options[select.selectedIndex];
            var colorCode = selectedOption.getAttribute('data-color');
            colorPalate.style.backgroundColor = colorCode || '#fff';
        }
        document.addEventListener("DOMContentLoaded", updateSelectColor);
    </script>
    
@endsection
