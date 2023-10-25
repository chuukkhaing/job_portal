@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Employers</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Employers</h6>
            @can('employer-create')
            <div class="col">
                <a href="{{ route('employers.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New</span>
                </a>
            </div>
            @endcan
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Employer Name</th>
                            <th>Employer Email</th>
                            <th>Package Name</th>
                            <th>Package Effective Date</th>
                            <th>Number of Member</th>
                            <th>Active Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employers as $key => $employer)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $employer->name ?? '' }} @if($employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</td>
                            <td>{{ $employer->email }}</td>
                            <td>{{ $employer->Package->name ?? '' }}</td>
                            <td>{{ $employer->package_start_date }}</td>
                            <td>
                                @if($employer->Member->count() > 0)
                                <a data-bs-toggle="modal" data-bs-target="#memberModal{{ $employer->id }}" class="text-blue text-decoration-none" style="cursor:pointer">{{ $employer->Member->count()}}</a>
                                @else
                                -
                                @endif
                            </td>
                            <td>@if($employer->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif </td>
                            <td>
                                
                                @can('employer-edit')
                                <a href="{{ route('employers.edit', $employer->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('employer-delete')
                                <form method="POST" action="{{ route('employers.destroy', $employer->id) }}" class="d-inline">
                                    @csrf 
                                    @method('DELETE') 
                                        <button class="btn btn-danger btn-circle btn-sm delete-confirm text-light" type="submit"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @if($employer->Member->count() > 0)
                        <div class="modal fade" id="memberModal{{ $employer->id }}" tabindex="-1" aria-labelledby="memberModal{{ $employer->id }}Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="memberModal{{ $employer->id }}Label">Member Info Detail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-5 py-2 border-top border-bottom border-right">
                                                <span class="fw-bold">Email</span>
                                            </div>
                                            <div class="col-5 py-2 border-top border-bottom border-right">
                                                <span class="fw-bold">Permission</span>
                                            </div>
                                            <div class="col-2 py-2 border-top border-bottom">
                                                <span class="fw-bold">Status</span>
                                            </div>
                                        </div>
                                        @foreach($employer->Member as $member)
                                        <div class="row">
                                            <div class="col-5 py-2 border-bottom border-right">
                                                {{ $member->email }}
                                            </div>
                                            <div class="col-5 py-2 border-bottom border-right">
                                                @foreach($member->MemberPermission as $permission)
                                                    {{ $permission->name }} {{ $loop->last ? '' : ',' }}
                                                @endforeach
                                            </div>
                                            <div class="col-2 py-2 border-bottom">
                                                @if($member->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection