@extends('admin.layouts.master')

@section('title', 'Promotions')

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
            <div class="admin-navigation-title">Promotions</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active"><a href="/admin/colors">Promotion</a></div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="card-box-header">
                <div class="card-box-title">
                    Active Promotions
                </div>
            </div>
            <div class="pb-20">
                <table id="productTable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Promotion</th>
                            <th>Amount</th>
                            <th>Discount</th>
                            <th>Status</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activePromotions as $no=>$promo)
                            <tr>
                                <td class="table-plus">{{ ++$no }}</td>
                                <td>{{ $promo->name }}</td>
                                <td>{{ $promo->amount }}</td>
                                <td>
                                    @if ($promo->discount_percent)
                                        {{ $promo->discount_percent }} %
                                    @endif
                                    @if ($promo->discount_amount)
                                        Rp {{ number_format($promo->discount_amount, 0, ",", ".") }}
                                    @endif
                                </td>
                                <td>{{ $promo->status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item"  href="#" data-toggle="modal" data-target="#updatePromotionProduct{{ $promo->id }}" type="button"><i class="dw dw-edit2"></i> Edit</a>
                                            <form class="promoForm" action="{{ route('promotions.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this promotion?');">
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
                            <div class="modal fade" id="updatePromotionProduct{{ $promo->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Edit Promotion</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="promoForm" action="{{ route('promotions.update', $promo->id) }}" method="POST" id="updatePromotionForm{{ $promo->id }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="edit_status">Status</label>
                                                    <select class="form-control" id="edit_status" name="status" required>
                                                        <option value="Active" {{ $promo->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                        <option value="Draft" {{ $promo->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                                        <option value="Expired" {{ $promo->status == 'Expired' ? 'selected' : '' }}>Expired</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_type-{{ $promo->id }}">Type</label>
                                                    <select class="form-control" id="edit_type-{{ $promo->id }}" data-id="{{ $promo->id }}" name="edit_type" required onchange="toggleEditDiscountInput({{ $promo->id }}, this.value)">
                                                        <option {{ $promo->discount_percent?"selected":""; }} value="percent">Percent (%)</option>
                                                        <option {{ $promo->discount_amount?"selected":""; }} value="amount">Amount (IDR)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_name">Name <span>*</span></label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name" name="name" value="{{ $promo->name }}" required>
                                                    @error('name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_promotion_code">Promo CODE</label>
                                                    <input type="text" class="form-control  @error('promotion_code') is-invalid @enderror" id="edit_promotion_code" name="promotion_code" value="{{ $promo->promotion_code }}" required>
                                                    @error('promotion_code')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_description">Description</label>
                                                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="edit_description" name="description" value="{{ $promo->description }}" required>
                                                    @error('description')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group" id="discount_percent_group-{{ $promo->id }}" style="{{ $promo->discount_amount?"display: none":"" }}">
                                                    <label for="edit_discount_percent">Discounts (%)</label>
                                                    <input type="number" max="50" class="form-control @error('discount_percent') is-invalid @enderror" id="edit_discount_percent-{{ $promo->id }}" name="discount_percent" value="{{ $promo->discount_percent }}">
                                                    @error('discount_percent')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group" id="discount_amount_group-{{ $promo->id }}" style="{{ $promo->discount_percent?"display: none":"" }}" >
                                                    <label for="edit_discount_amount">Discounts (IDR)</label>
                                                    <input type="number" class="form-control @error('discount_amount') is-invalid @enderror" id="edit_discount_amount-{{ $promo->id }}" name="discount_amount" value="{{ $promo->discount_amount }}">
                                                    @error('discount_amount')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_amount">Amount</label>
                                                    <input type="number" min="1" class="form-control @error('amount') is-invalid @enderror" id="edit_amount" name="amount" value="{{ $promo->amount }}" required>
                                                    @error('amount')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_expired_date">Expired Date</label>
                                                    <input type="date" class="form-control @error('expired_date') is-invalid @enderror" id="edit_expired_date" name="expired_date" value="{{ date('Y-m-d',strtotime($promo->expired_date)) }}" required>
                                                    @error('expired_date')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            <button type="submit" form="updatePromotionForm{{ $promo->id }}" class="btn button-secondary" id="savePromotionButton"><i class="fas fa-save"></i> Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-box-footer">
                <a href="#" data-toggle="modal" data-target="#addPromotionProduct">
                    <button class="btn button-secondary"><i class="fa fa-plus" aria-hidden="true"></i> Add New Promotion</button>
                </a>
                <div class="modal fade" id="addPromotionProduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Add Promotion</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="promoForm" id="addPromotionForm" action="{{ route('promotions.store') }}" method="POST" enctype="multipart/form-data">
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
                                <button type="submit" form="addPromotionForm" class="btn button-secondary" id="savePromotionButton"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
        @if (count($expiredPromotions)>0)
            <div class="card-box mb-30">
                <div class="card-box-header">
                    <div class="card-box-title">
                        Expired Promotions
                    </div>
                </div>
                <div class="pb-20">
                    <table id="productTable" class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Promotion</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>Claimed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expiredPromotions as $no=>$ex_promo)
                                <tr>
                                    <td class="table-plus">{{ ++$no }}</td>
                                    <td>{{ $ex_promo->name }}</td>
                                    <td>{{ $ex_promo->amount }}</td>
                                    <td>
                                        @if ($ex_promo->discount_percent)
                                            {{ $ex_promo->discount_percent }} %
                                        @endif
                                        @if ($ex_promo->discount_amount)
                                            Rp {{ number_format($ex_promo->discount_amount, 0, ",", ".") }}
                                        @endif
                                    </td>
                                    <td>{{ $ex_promo->claimed_count }}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        @endif
    </div>
    <div id="loading" style="display: none;">
        <div class="spinner-container">
            <i class="fas fa-spinner fa-spin"></i> <!-- Ikon berputar -->
            <p class="loading-text">Loading...</p>
        </div>
    </div>
</main>
<script>
      document.querySelectorAll('.promoForm').forEach(form => {
        form.addEventListener('submit', function() {
            document.getElementById('loading').style.display = 'flex'; // Tampilkan elemen loading
        });
    });

    function toggleDiscountInput() {
        const type = document.getElementById('type_discount').value;
        const discountPercentGroup = document.getElementById('discount_percent_group');
        const discountAmountGroup = document.getElementById('discount_amount_group');

        if (type === 'percent') {
            discountPercentGroup.style.display = 'block';
            discountAmountGroup.style.display = 'none';
        } else if (type === 'amount') {
            discountPercentGroup.style.display = 'none';
            discountAmountGroup.style.display = 'block';
        }
    }

    // Inisialisasi tampilan input berdasarkan nilai select saat halaman dimuat
    document.addEventListener("DOMContentLoaded", toggleDiscountInput);

    // Fungsi untuk menampilkan input berdasarkan pilihan tipe
    function toggleEditDiscountInput(id, type) {
        const discountPercentGroup = document.getElementById(`discount_percent_group-${id}`);
        const discountAmountGroup = document.getElementById(`discount_amount_group-${id}`);
        
        if (type === 'percent') {
            discountPercentGroup.style.display = 'block';
            discountAmountGroup.style.display = 'none';
        } else if (type === 'amount') {
            discountPercentGroup.style.display = 'none';
            discountAmountGroup.style.display = 'block';
        }
    }

    // Mengambil semua select dengan class 'promo-type'
    document.querySelectorAll('.promo-type').forEach(select => {
        // Ketika nilai select berubah, jalankan toggleDiscountInput dengan id yang sesuai
        select.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            toggleEditDiscountInput(id, this.value);
        });

        // Panggil toggleDiscountInput pada load untuk tiap item dalam loop
        toggleEditDiscountInput(select.getAttribute('data-id'), select.value);
    });
</script>
@endsection