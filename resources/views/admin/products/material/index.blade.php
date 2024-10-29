@extends('admin.layouts.master')

@section('title', 'Product Material')

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
            <div class="admin-navigation-title">Product Material</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active"><a href="/admin/materials">Material</a></div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="pb-20">
                <table id="productTable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Material</th>
                            <th>Product</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $no=>$material)
                            <tr>
                                <td class="table-plus">{{ ++$no }}</td>
                                <td>{{ $material->name }}</td>
                                <td>{{ count($material->products) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item"  href="#" data-toggle="modal" data-target="#updateMaterialProduct{{ $material->id }}" type="button"><i class="dw dw-edit2"></i> Edit</a>
                                            <form action="{{ route('admin.material.destroy', $material->id) }}" method="POST" class="delete-form">
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
                            <div class="modal fade" id="updateMaterialProduct{{ $material->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Edit Material</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.material.update',$material->id) }}" method="POST" id="updateMaterialForm{{ $material->id }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="name">Material Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $material->name }}" required>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            <button type="submit" form="updateMaterialForm{{ $material->id }}" class="btn button-secondary" id="saveMaterialButton"><i class="fas fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-box-footer">
                <a href="#" class="btn-block" data-toggle="modal" data-target="#addMaterialProduct" type="button">
                    <button class="btn button-secondary"><i class="fa fa-plus" aria-hidden="true"></i> Add New Material</button>
                </a>
                <div class="modal fade" id="addMaterialProduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Add Material</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.material.store') }}" method="POST" id="addMaterialForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Material Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                <button type="submit" form="addMaterialForm" class="btn button-secondary" id="saveMaterialButton"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</main>
    
@endsection