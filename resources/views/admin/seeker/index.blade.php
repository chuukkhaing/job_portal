@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Seekers</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Seekers</h6>
            
            {{--<div class="col">
                <a href="{{ route('seeker.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New</span>
                </a>
            </div>--}}
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>State and Division</th>
                            <th>Township / City</th>
                            <th>Active Status</th>
                            <th>Activation Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seekers as $key => $seeker)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $seeker->first_name .' '. $seeker->last_name }}</td>
                            <td><a href="tel:+{{ $seeker->phone }}" class="text-decoration-none">{{ $seeker->phone }}</a></td>
                            <td><a href="mailto:{{ $seeker->email }}" class="text-decoration-none">{{ $seeker->email }}</a></td>
                            <td>{{ $seeker->State->name ?? '' }}</td>
                            <td>{{ $seeker->Township->name ?? '' }}</td>
                            <td>@if($seeker->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif </td>
                            <td>@if($seeker->email_verified_at){{ date('d-m-Y', strtotime($seeker->email_verified_at)) }}@else @endif</td>
                            <td>
                                <a href="{{ route('seeker.show', $seeker->id) }}" class="btn btn-success btn-circle btn-sm"><i class="fas fa-eye"></i></a>
                                {{--<a href="{{ route('seeker.edit', $seeker->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>--}}
                                <a href="{{ route('ic-format-cv', $seeker->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Download IC Format CV" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-download"></i></a>
                                @if($seeker->SeekerAttach->last())
                                <a href="{{ url('/storage/seeker/cv/'.$seeker->SeekerAttach->last()->name) }}" download data-bs-toggle="tooltip" data-bs-placement="top" title="Download CV Attachment" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-file-arrow-down"></i></a>
                                @endif
                                @can(['seeker-delete'])
                                <form method="POST" action="{{ route('seeker.destroy', $seeker->id) }}" class="d-inline">
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