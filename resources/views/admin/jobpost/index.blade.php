@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Manage Job Post</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Job Post</h6>
            @can('job-post-create')
            <div class="col">
                <a href="{{ route('job-posts.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
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
                            <th>Job Title</th>
                            <th>Employer Name</th>
                            <th>Industry</th>
                            <th>Main Functional Area</th>
                            <th>Activation</th>
                            <th>Job Post Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobPosts as $key => $jobPost)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $jobPost->job_title }}</td>
                            <td><a href="{{ route('employers.edit', $jobPost->Employer->id) }}" class="text-decoration-none text-black">{{ $jobPost->Employer->name }}</a>@if($jobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</td>
                            <td>{{ $jobPost->Industry->name }}</td>
                            <td>{{ $jobPost->MainFunctionalArea->name }}</td>
                            <td>@if($jobPost->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif </td>
                            <td>
                                @if($jobPost->status == 'Pending')
                                <span class="badge text-light bg-secondary">{{ $jobPost->status }}</span>
                                @elseif($jobPost->status == 'Online')
                                <span class="badge text-light bg-success">{{ $jobPost->status }}</span>
                                @elseif($jobPost->status == 'Reject')
                                <span class="badge text-dark bg-warning">{{ $jobPost->status }}</span>
                                @elseif($jobPost->status == 'Expire')
                                <span class="badge text-light bg-danger">{{ $jobPost->status }}</span>
                                @endif
                            </td>
                            <td>
                                @can('job-post-edit')
                                <a href="{{ route('job-posts.edit', $jobPost->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
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