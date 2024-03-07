@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Job Applications</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Job Applications</h6>
            
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
                            <th>No. of Applied Candidate</th>
                            <th>Job Post Status</th>
                            <th>Activate/Deactivate Job Post </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($job_applies as $key => $job_apply)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $job_apply->JobPost->job_title }}</td>
                            <td>
                                @if(isset($job_apply->Employer->MainEmployer))
                                <a href="{{ route('employers.edit', $job_apply->Employer->employer_id) }}" class="text-decoration-none text-black">{{ $job_apply->Employer->MainEmployer->name }}</a>@if($job_apply->Employer->MainEmployer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif
                                @elseif(isset($job_apply->Employer))
                                <a href="{{ route('employers.edit', $job_apply->Employer->id) }}" class="text-decoration-none text-black">{{ $job_apply->Employer->name }}</a>@if($job_apply->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif
                                @endif
                            </td>
                            <td><a href="{{ route('job-apply.seeker',$job_apply->job_post_id) }}" class="btn btn-sm">{{ getJobApplyCount($job_apply->job_post_id) }}</a></td>
                            <td>
                                @if($job_apply->JobPost->status == 'Pending')
                                <span class="badge text-light bg-secondary">{{ $job_apply->JobPost->status }}</span>
                                @elseif($job_apply->JobPost->status == 'Online')
                                <span class="badge text-light bg-success">{{ $job_apply->JobPost->status }}</span>
                                @elseif($job_apply->JobPost->status == 'Reject')
                                <span class="badge text-dark bg-warning">{{ $job_apply->JobPost->status }}</span>
                                @elseif($job_apply->JobPost->status == 'Expire')
                                <span class="badge text-light bg-danger">{{ $job_apply->JobPost->status }}</span>
                                @elseif($job_apply->JobPost->status == 'Draft')
                                <span class="badge text-light bg-dark">{{ $job_apply->JobPost->status }}</span>
                                @endif
                            </td>
                            <td>@if($job_apply->JobPost->is_active == 1)<span class="badge text-light bg-success">Activate</span>@else <span class="badge text-light bg-danger">Deactivate</span> @endif </td>
                            
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