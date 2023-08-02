@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Company Attributes</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Industries</h6>
            @can('industry-create')
            <div class="col">
                <a href="{{ route('industry.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
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
                            <th>Industrial Name</th>
                            <th>Icon</th>
                            <th>Active Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($industries as $key => $industry)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $industry->name }}</td>
                            <td><i class="{{ $industry->icon }}"></i></td>
                            <td>@if($industry->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif </td>
                            <td>
                                @can('industry-edit')
                                <a href="{{ route('industry.edit', $industry->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('industry-delete')
                                <form method="POST" action="{{ route('industry.destroy', $industry->id) }}" class="d-inline">
                                    @csrf 
                                    @method('DELETE') 
                                        <button class="btn btn-danger btn-circle btn-sm delete-confirm text-light" type="submit"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection