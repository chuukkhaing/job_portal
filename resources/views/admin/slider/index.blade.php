@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sliders</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Sliders</h6>
            @can('slider-create')
            <div class="col">
                <a href="{{ route('slider.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
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
                            <th>Slider Image</th>
                            <th>Employer Name</th>
                            <th>Serial No.</th>
                            <th>Active Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sliders as $key => $slider)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>@if(isset($slider->image)) <img style="width: 70px" src="{{ asset('storage/slider'.'/'.$slider->image) }}" alt="{{ $slider->Employer->name }}"> @else - @endif</td>
                            <td><a href="{{ route('employers.show', $slider->Employer->id) }}" class="text-decoration-none">{{ $slider->Employer->name }}</a></td>
                            <td>{{ $slider->serial_no }}</td>
                            <td>@if($slider->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif </td>
                            <td>
                                @can('slider-edit')
                                <a href="{{ route('slider.edit', $slider->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                                @endcan
                                @can('slider-delete')
                                <form method="POST" action="{{ route('slider.destroy', $slider->id) }}" class="d-inline">
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