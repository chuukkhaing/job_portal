@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Functional Areas</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Sub Functional Areas</h6>
            @can('sub-functional-area-create')
            <div class="col">
                <a href="{{ route('sub-functional-area.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
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
                            <th>Sub Functional Area Name</th>
                            <th>Main Functional Area Name</th>
                            <th>Active Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($functional_areas as $key => $functional_area)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $functional_area->name }}</td>
                            <td class="text-success">{{ $functional_area->MainFunctionalArea->name }}</td>
                            <td>@if($functional_area->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif </td>
                            <td>
                                @can('sub-functional-area-edit')
                                <a href="{{ route('sub-functional-area.edit', $functional_area->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('main-functional-area-delete')
                                <form method="POST" action="{{ route('sub-functional-area.destroy', $functional_area->id) }}" class="d-inline">
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