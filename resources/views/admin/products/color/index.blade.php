@extends('admin.layouts.master')

@section('title', 'Product Color')

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
            <div class="admin-navigation-title">Product Color</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active"><a href="/admin/colors">Color</a></div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="pb-20">
                <table id="productTable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Color</th>
                            <th>Product</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colors as $no=>$color)
                            <tr>
                                <td class="table-plus">{{ ++$no }}</td>
                                <td><span style="color:{{ $color->color_code }}"><i class="fa fa-circle" aria-hidden="true"></i></span> {{ $color->name }}</td>
                                <td>{{ count($color->products) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item"  href="#" data-toggle="modal" data-target="#updateColorProduct{{ $color->id }}" type="button"><i class="dw dw-edit2"></i> Edit</a>
                                            <form action="{{ route('admin.color.destroy', $color->id) }}" method="POST" class="delete-form">
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
                            <div class="modal fade" id="updateColorProduct{{ $color->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Color</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="updateColorForm{{ $color->id }}" action="{{ route('admin.color.update', $color->id) }}" method="POST"  enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="name">Color Name</label>
                                                    <input type="text" class="form-control" name="name" value="{{ $color->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="color_code">Color Code</label>
                                                    <input type="text" name="color_code" class="form-control" value="{{ $color->color_code }}" required>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            <button type="submit" form="updateColorForm{{ $color->id }}" class="btn button-secondary"><i class="fas fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-box-footer">
                <a href="#" data-toggle="modal" data-target="#addColorProduct">
                    <button class="btn button-secondary"><i class="fa fa-plus" aria-hidden="true"></i> Add New Color</button>
                </a>
                <div class="modal fade" id="addColorProduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Add Color</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.color.store') }}" method="POST" id="addColorForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Color Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="color_code">Color Code</label>
                                        <input type="text" class="form-control" name="color_code" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                <button type="submit" form="addColorForm" class="btn button-secondary" id="saveColorButton"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</main>
    
@endsection