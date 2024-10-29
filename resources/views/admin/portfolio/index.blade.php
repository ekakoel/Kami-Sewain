@extends('admin.layouts.master')

@section('title', 'Portfolio')

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
                <div class="admin-navigation-list active"><a href="/admin/portfolio">Portfolio</a></div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="pb-20">
                <table id="portfolioTable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">Published Date</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th class="datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $portfolio)
                            <tr>
                                <td class="table-plus">
                                    @if ($portfolio->published_at)
                                        {{ date('d F Y',strtotime($portfolio->published_at)) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $portfolio->title }}</td>
                                <td>{{ $portfolio->categories?->name }}</td>
                                <td>{{ count($portfolio->comments) }}</td>
                                <td>{{ $portfolio->status }}</td>
                               
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="{{ route('admin.portfolio.detail',['id'=>$portfolio->id]) }}"><i class="dw dw-eye"></i> View</a>
                                            <a class="dropdown-item" href="{{ route('admin.portfolio.edit',['id'=>$portfolio->id]) }}"><i class="dw dw-edit2"></i> Edit</a>
                                            <form action="{{ route('admin.portfolio.destroy', $portfolio->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this portfolio?');">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-box-footer">
                <a href="{{ route('admin.portfolio.create') }}">
                    <button class="btn button-secondary"><i class="fa fa-plus" aria-hidden="true"></i> Create Portfolio</button>
                </a>
            </div>
        </div>
    </div>
</main>
@endsection