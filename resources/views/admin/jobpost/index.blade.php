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
            <div class="col">
                <a href="{{ route('job-posts.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    @can('job-post-create')
                    <span class="text">Add New</span>
                    @endcan
                </a>
            </div>
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Job Title</th>
                            <th>Company Name</th>
                            <th>Industry</th>
                            <th>Main Functional Area</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobPosts as $key => $jobPost)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $jobPost->job_title }}</td>
                            <td>{{ $jobPost->Employer->name }}</td>
                            <td>{{ $jobPost->Industry->name }}</td>
                            <td>{{ $jobPost->MainFunctinalArea->name }}</td>
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