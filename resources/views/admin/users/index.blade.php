@extends('admin.layouts.master')

@section('title', 'User Manager')

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
            <div class="admin-navigation-title">User Manager</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active"><a href="/admin/portfolio">Users</a></div>
            </div>
        </div>
        <div class="card-box mb-30">
            @if($users->count() > 0)
                <table id="commentTable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Telephone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->telephone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->status }}</td>
                                <td>
                                    {{-- <a href="#" data-toggle="modal" data-target="#updateContact{{ $user->id }}" type="button"><i class="fa-solid fa-eye"></i></a> --}}
                                    <a href="#" data-toggle="modal" data-target="#updateUser{{ $user->id }}" type="button"><i class="fa-solid fa-pencil"></i></a>
                                    {{-- <a class="btn-icon" href="{{ route('admin.user.update', ['id' => $user->id]) }}"><i class="fa-solid fa-pencil"></i></a> --}}
                                    <a class="btn-icon" href="{{ route('admin.user.block',['id' => $user->id]) }}"><i class="fa-solid fa-ban"></i></a>
                                </td>
                                {{-- MODAL EDIT USER --}}
                                <div class="modal fade" id="updateUser{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel">Detail User</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-6">First Name</div>
                                                    <div class="col-6">: {{ $user->name }}</div>
                                                    <div class="col-6">Telephone</div>
                                                    <div class="col-6">: {{ $user->telephone }}</div>
                                                    <div class="col-6">Email</div>
                                                    <div class="col-6">: {{ $user->email }}</div>
                                                    <div class="col-6">Register Date</div>
                                                    <div class="col-6">: {{ date('d M Y',strtotime($user->created_at)) }}</div>
                                                    <div class="col-6">Status</div>
                                                    <div class="col-6 m-b-18">: {{ $user->status }}</div>
                                                    <div class="col-12"><hr class="hr-light"></div>

                                                </div>
                                                <form id="updateStatusUser{{ $user->id }}" action="{{ route('admin.update.status.user', $user->id) }}" method="POST" class="update-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status" required>
                                                        <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                        <option value="Pending" {{ $user->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="Block" {{ $user->status == 'Block' ? 'selected' : '' }}>Block</option>
                                                    </select>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                                <button type="submit" form="updateStatusUser{{ $user->id }}" class="btn button-secondary"><i class="fas fa-check"></i> Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No comments found.</p>
            @endif
        </div>
    </div>
</main>
@endsection