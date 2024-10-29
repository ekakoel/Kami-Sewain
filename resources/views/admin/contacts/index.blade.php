@extends('admin.layouts.master')

@section('title', 'Contacts')

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
            <div class="admin-navigation-title">Contacts</div>
            <hr class="hr-admin-navigation">
            <div class="admin-navigation-list-container">
                <div class="admin-navigation-list active"><a href="/admin/portfolio">Contacts</a></div>
            </div>
        </div>
        <div class="card-box mb-30">
            @if($contacts->count() > 0)
                <table id="commentTable" class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">#</th>
                            <th>User</th>
                            <th class="datatable-nosort">Messages</th>
                            <th class="text-center datatable-nosort">Status</th>
                            <th class="text-center datatable-nosort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = 0;
                        @endphp
                        @foreach ($contacts as $index=>$contact)
                            @if (count($contacts)>0)
                                <tr>
                                    <td class="table-plus">{{ ++$index }}</td>
                                    <td>
                                        {{ $contact->user->name }}<br>
                                        {{ $contact->user->email }}
                                    </td>
                                    <td>
                                        {{ $contact->subject }}<br>
                                        {!! $contact->message !!}
                                    </td>
                                    <td class="text-center">
                                        {{ $contact->status }}
                                    </td>
                                    <td class="text-center">
                                        <a href="#" data-toggle="modal" data-target="#viewContact{{ $contact->id }}" type="button"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="viewContact{{ $contact->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myLargeModalLabel">Detail Contacts</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Date: </strong> <span>{{ date('d M Y',strtotime($contact->created_at)) }}</span></p>
                                                <p><strong>User: </strong> <span>{{ $contact->user->name }}<br></span></p>
                                                <p><strong>Subject: </strong> <span>{{ $contact->subject }}</span></p>
                                                <p><strong>Message: </strong></p>
                                                <p>{!! $contact->message !!}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn button-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>       
                            @endif
                        @endforeach
                    </tbody>
                </table>
                         
            @else
                <p>No contacts found.</p>
            @endif
        </div>
    </div>
    
    </script>
    
</main>
@endsection