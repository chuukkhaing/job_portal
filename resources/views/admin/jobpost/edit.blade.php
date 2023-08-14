@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Job Post Manage</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Job Post Edit</h6>
            <div class="col">
                <a href="{{ route('job-posts.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('job-posts.update', $jobPost->id) }}" method="post">
                @csrf 
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-approve @if($jobPost->status == 'Online') btn-success @else btn-outline-success @endif">Approve <i class="approve-icon fa-solid fa-check @if($jobPost->status == 'Online') @else d-none @endif"></i></button>
                        <button type="button" class="btn btn-reject @if($jobPost->status == 'Reject') btn-danger @else btn-outline-danger @endif">Reject <i class="reject-icon fa-solid fa-check @if($jobPost->status == 'Reject') @else d-none @endif"></i></button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    <input type="hidden" name="status" id="job_post_status" value="">
                    <div class="col-4 py-3">
                        @if($jobPost->Employer->logo)
                        <img src="{{ asset('storage/employer_logo/'.$jobPost->Employer->logo) }}" alt="Employer Logo" class="p-2 img-responsive rounded-3" style="background: #0355D0" width="120px" height="120px">
                        @else
                        <img src="{{ asset('frontend/img/logo/white_logo.svg') }}" alt="Employer Logo" class="p-2 img-responsive rounded-3" style="background: #0355D0" width="120px" height="120px">
                        @endif
                    </div>
                    <div class="col-12">
                        <h3 class="fw-bold mb-0">{{ $jobPost->job_title }}</h3>
                        <h3>{{ $jobPost->career_level }} - {{ $jobPost->gender }} @if($jobPost->no_of_candidate) ( {{ $jobPost->no_of_candidate }} - Posts ) @endif</h3>
                        <p class="mt-0">{{ $jobPost->Employer->name }} @if($jobPost->hide_company == 1) Post with Anonymous @endif</p>
                        <p class="mb-2">@if($jobPost->country == 'Myanmar') {{ $jobPost->State->name }} , {{ $jobPost->country }} @else {{ $jobPost->country }} @endif</p>
                        <h5 class="fw-bold">@if($jobPost->hide_salary != 1) {{ $jobPost->salary_range }} {{ $jobPost->currency }} - @else Negotiate - @endif {{ $jobPost->job_type }}</h5>
                        <div class="row">
                            <div class="col-3">Industry </div><div class="col-9 fw-bold">- {{ $jobPost->Industry->name }}</div>
                            <div class="col-3">Main Functional Area </div><div class="col-9 fw-bold">- {{ $jobPost->MainFunctionalArea->name }}</div>
                            <div class="col-3">Sub Functional Area </div><div class="col-9 fw-bold">- {{ $jobPost->SubFunctionalArea->name }}</div>
                            <div class="col-3">Experience Level </div><div class="col-9 fw-bold">- {{ $jobPost->experience_level }}</div>
                            <div class="col-3">Requirement Education/ Qualification </div><div class="col-9 fw-bold">- {{ $jobPost->degree }}</div>
                            @if($jobPost->recruiter_name)
                            <div class="col-3">Recruiter name </div><div class="col-9 fw-bold">- {{ $jobPost->recruiter_name }}</div>
                            @endif
                            @if($jobPost->recruiter_email)
                            <div class="col-3">Recruiter email </div><div class="col-9 fw-bold">- {{ $jobPost->recruiter_email }}</div>
                            @endif
                            @if($jobPost->job_post_type)
                            <div class="col-3">Job Post Type </div><div class="col-9 fw-bold">- @if($jobPost->job_post_type == 'standard') Standard Job Post @elseif($jobPost->job_post_type == 'feature') Feature Job Post @elseif($jobPost->job_post_type == 'trending') Trending Job Post @endif</div>
                            @endif
                        </div>
                    </div>
                    @if($jobPost->JobPostSkill->count() > 0)
                    <div class="col-12 pt-3">
                        <h6 class="fw-bold">Skill</h6>
                        @foreach($jobPost->JobPostSkill as $jobPostSkill)
                        <span class="badge text-light bg-success">{{ $jobPostSkill->Skill->name }}</span>
                        @endforeach
                    </div>
                    @endif
                    @if($jobPost->JobPostQuestion->count() > 0)
                    <div class="col-12 pt-3">
                        <table class="table table-bordered job-post-question">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobPost->JobPostQuestion as $question)
                                <tr>
                                    <td>{{ $question->question }}</td>
                                    <td>{{ $question->answer }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <div class="col-12 pt-3">
                        <h6 class="fw-bold">Job Description</h6>
                        <p>{!! $jobPost->job_description ?? '-' !!}</p>
                    </div>
                    <div class="col-12 pt-3">
                        <h6 class="fw-bold">Job Requirement</h6>
                        <p>{!! $jobPost->job_requirement ?? '-' !!}</p>
                    </div>
                    <div class="col-12 pt-3">
                        <h6 class="fw-bold">Job Benefit:</h6>
                        <p>{!! $jobPost->benefit ?? '-' !!}</p>
                    </div>
                    <div class="col-12 pt-3">
                        <h6 class="fw-bold">Job Highlight:</h6>
                        <p>{!! $jobPost->job_highlight ?? '-' !!}</p>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
@push('script')
<script>
    $(".btn-approve").click(function(){
        $(this).removeClass('btn-outline-success');
        $(this).addClass('btn-success');
        $('.approve-icon').removeClass('d-none');
        $('.btn-reject').removeClass('btn-danger');
        $('.btn-reject').addClass('btn-outline-danger');
        $('.reject-icon').addClass('d-none');
        $('#job_post_status').val('Online');
    })

    $(".btn-reject").click(function(){
        $(this).removeClass('btn-outline-danger');
        $(this).addClass('btn-danger');
        $('.reject-icon').removeClass('d-none');
        $('.btn-approve').removeClass('btn-success');
        $('.btn-approve').addClass('btn-outline-success');
        $('.approve-icon').addClass('d-none');
        $('#job_post_status').val('Reject');
    })
</script>
@endpush