@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">{{ $job_post->job_title }}'s Candidates</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">{{ $job_post->job_title }}'s Candidates</h6>
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Candidate Name</th>
                            <th>Status</th>
                            <th>Experienced Position</th>
                            <th>Applied Date</th>
                            <th>Attach CVs </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($job_apply_seekers as $key => $seeker)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><a href="{{ route('seeker.show', $seeker->seeker_id) }}" class="text-decoration-none">{{ $seeker->Seeker->first_name }} {{ $seeker->Seeker->last_name }}</a></td>
                            <td>
                                @if($seeker->status == 'received')
                                <span class="badge text-light bg-secondary">Received</span>
                                @elseif($seeker->status == 'viewed')
                                <span class="badge text-light bg-warning">Viewed</span>
                                @elseif($seeker->status == 'short-listed')
                                <span class="badge text-light bg-info">Shorted List</span>
                                @elseif($seeker->status == 'interview')
                                <span class="badge text-light bg-primary">Interview</span>
                                @elseif($seeker->status == 'hire')
                                <span class="badge text-light bg-success">Hire</span>
                                @elseif($seeker->status == 'notsuitable')
                                <span class="badge text-light bg-danger">Not Suitable</span>
                                @endif
                            </td>
                            <td>
                                @foreach($seeker->Seeker->SeekerExperience->pluck('job_title')->toArray() as $job_title)
                                {{ $job_title }} {{ $loop->last ? '' : ',' }}
                                @endforeach
                            </td>
                            <td>
                                {{ date('d-M-Y', strtotime($seeker->created_at)) }}
                            </td>
                            
                            <td>
                                <a href="{{ route('ic-format-cv', $seeker->Seeker->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Download IC Format CV" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-download"></i></a>
                                @if($seeker->Seeker->SeekerAttach->last())
                                <a href="{{ getS3File('seeker/cv',$seeker->Seeker->SeekerAttach->last()->name) }}" download data-bs-toggle="tooltip" data-bs-placement="top" title="Download CV Attachment" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-file-arrow-down"></i></a>
                                @endif
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