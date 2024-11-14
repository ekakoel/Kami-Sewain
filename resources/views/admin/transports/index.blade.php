@extends('admin.layouts.master')

@section('title', 'Transports')

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
            <div class="admin-navigation-title">Transports</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active"><a href="/admin/colors">Transports</a></div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="card-box-header">
                <div class="card-box-title">
                    Transports
                </div>
            </div>
            <div class="pb-20">
                <table id="productTable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Transports</th>
                            <th>Type</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transports as $no=>$transport)
                            <tr>
                                <td class="table-plus">{{ ++$no }}</td>
                                <td>{{ $transport->brand." - ".$transport->name }} ({{ $transport->no_polisi }})</td>
                                <td>{{ $transport->type }}</td>
                                <td>{{ $transport->capacity }}</td>
                                <td>{{ $transport->status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item"  href="#" data-toggle="modal" data-target="#updateTransportProduct{{ $transport->id }}" type="button"><i class="dw dw-edit2"></i> Edit</a>
                                            <form class="promoForm" action="{{ route('admin.transport.destroy', $transport->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this transport?');">
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
                            {{-- SAMPAI DISINI - LANJUT KE CONTROLLER UNTUK EKSEKUSI FORM --}}
                            <div class="modal fade" id="updateTransportProduct{{ $transport->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="modal-title" id="myLargeModalLabel">Edit Transport</div>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="promoForm" action="{{ route('admin.transport.update', $transport->id) }}" method="POST" id="updateTransportForm{{ $transport->id }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="edit_status">Status</label>
                                                    <select class="form-control" id="edit_status" name="status" required>
                                                        <option value="Active" {{ $transport->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                        <option value="Draft" {{ $transport->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="no_polisi">License Plate<span>*</span></label>
                                                    <input type="text" class="form-control @error('no_polisi') is-invalid @enderror" id="no_polisi" name="no_polisi" value="{{ $transport->no_polisi }}" required>
                                                    @error('no_polisi')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Name<span>*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $transport->name }}" required>
                                                    @error('name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="brand">Brand<span>*</span></label>
                                                    <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ $transport->brand }}" required>
                                                    @error('brand')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="type">Type</label>
                                                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                                        <option value="Pickup" {{ $transport->type == 'Pickup' ? 'selected' : '' }}>Pickup</option>
                                                        <option value="Truck" {{ $transport->type == 'Truck' ? 'selected' : '' }}>Truck</option>
                                                        <option value="Box" {{ $transport->type == 'Box' ? 'selected' : '' }}>Box</option>
                                                        <option value="Minibus" {{ $transport->type == 'Minibus' ? 'selected' : '' }}>Mini Bus</option>
                                                    </select>
                                                    @error('type')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            <button type="submit" form="updateTransportForm{{ $transport->id }}" class="btn button-secondary" id="saveTransportButton"><i class="fas fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-box-footer">
                <a href="#" data-toggle="modal" data-target="#addTransportProduct">
                    <button class="btn button-secondary"><i class="fa fa-plus" aria-hidden="true"></i> Add New Transport</button>
                </a>
                <div class="modal fade" id="addTransportProduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Add Transport</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="promoForm" id="addTransportForm" action="{{ route('admin.transport.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="type_discount">Type</label>
                                        <select class="form-control" id="type_discount" name="type_discount" required onchange="toggleDiscountInput()">
                                            <option selected value="percent">Percent (%)</option>
                                            <option value="amount">Amount (IDR)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name <span>*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="promotion_code">Promo CODE</label>
                                        <input type="text" class="form-control  @error('promotion_code') is-invalid @enderror" id="promotion_code" name="promotion_code" value="{{ old('promotion_code') }}" required>
                                        @error('promotion_code')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') }}" required>
                                        @error('description')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="discount_percent_group">
                                        <label for="discount_percent">Discounts (%)</label>
                                        <input type="number" max="50" class="form-control @error('discount_percent') is-invalid @enderror" id="discount_percent" name="discount_percent" value="{{ old('discount_percent') }}">
                                        @error('discount_percent')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="minimumTransaction">
                                        <label for="minimum_transaction">Minimum Transaction</label>
                                        <input type="text" class="form-control @error('minimum_transaction') is-invalid @enderror" id="minimum_transaction" name="minimum_transaction" value="{{ old('minimum_transaction') }}">
                                        @error('minimum_transaction')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="discount_amount_group" style="display: none;">
                                        <label for="discount_amount">Discounts (IDR)</label>
                                        <input type="number" class="form-control @error('discount_amount') is-invalid @enderror" id="discount_amount" name="discount_amount" value="{{ old('discount_amount') }}">
                                        @error('discount_amount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" min="1" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" required>
                                        @error('amount')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="expired_date">Expired Date</label>
                                        <input type="date" class="form-control @error('expired_date') is-invalid @enderror" id="expired_date" name="expired_date" value="{{ old('expired_date') }}" required>
                                        @error('expired_date')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                <button type="submit" form="addTransportForm" class="btn button-secondary" id="saveTransportButton"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
        
    </div>
    <div id="loading" style="display: none;">
        <div class="spinner-container">
            <i class="fas fa-spinner fa-spin"></i> <!-- Ikon berputar -->
            <p class="loading-text">Loading...</p>
        </div>
    </div>
</main>

@endsection