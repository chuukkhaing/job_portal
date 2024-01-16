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
            <form action="{{ route('job-posts.update', $jobpost->id) }}" method="post">
                @csrf 
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-approve @if($jobpost->status == 'Online') btn-success @else btn-outline-success @endif">Approve <i class="approve-icon fa-solid fa-check @if($jobpost->status == 'Online') @else d-none @endif"></i></button>
                        <button type="button" class="btn btn-reject @if($jobpost->status == 'Reject') btn-danger @else btn-outline-danger @endif">Reject <i class="reject-icon fa-solid fa-check @if($jobpost->status == 'Reject') @else d-none @endif"></i></button>
                    </div>
                    <input type="hidden" name="status" id="job_post_status" value="">
                    <button type="submit" class="btn btn-primary d-none" id="update_submit">Update</button>
                    @if(isset($jobpost->Employer->MainEmployer))
                    <div class="container my-5" id="">
                        <div class="card shadow" id="edit-profile-body">
                            <div class="card-header bg-transparent">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-4 mb-2 d-flex">
                                        @if($jobpost->Employer->MainEmployer->logo)
                                        <img src="{{ getS3File('employer_logo',$jobpost->Employer->MainEmployer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobpost->Employer->MainEmployer->name }}">
                                        @else
                                        <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobpost->Employer->MainEmployer->name }}">
                                        @endif
                                        <div class="align-self-center">
                                            <span class="h4 fw-bold">{{ $jobpost->job_title }} @if($jobpost->no_of_candidate) ( {{ $jobpost->no_of_candidate }} - Posts ) @endif</span>
                                            <div><a class="text-muted h6 text-decoration-none" href="">{{ $jobpost->Employer->MainEmployer->name }}</a></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 mb-2 align-self-center">
                                        <div>
                                            <span>{{ $jobpost->job_type }} @if($jobpost->country == 'Myanmar') | {{ $jobpost->State->name ?? '' }}, {{ $jobpost->Township->name ?? '' }} @endif {{ $jobpost->gender }}</span>
                                        </div>
                                        <div>
                                            <span class="text-muted">Salary Range:</span>
                                            <span class="h5 fw-bold">@if($jobpost->hide_salary == 1) Negotiate @else {{ $jobpost->salary_range }} {{ $jobpost->currency }} @endif</span>
                                        </div>
                                    </div>
                                    
                                </div>  
                            </div>
                            <div class="card-body p-0">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="p-md-3 p-2 job-post-detail nav-link active" id="nav-job-description-tab" data-bs-toggle="tab" data-bs-target="#nav-job-description" type="button" role="tab" aria-controls="nav-job-description" aria-selected="true">Job Description</button>
                                        <button class="p-md-3 p-2 job-post-detail nav-link" id="nav-company-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-company-profile" type="button" role="tab" aria-controls="nav-company-profile" aria-selected="false">Company Profile</button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane p-3 fade show active" id="nav-job-description" role="tabpanel" aria-labelledby="nav-job-description-tab">
                                        @if($jobpost->JobPostSkill->count() > 0)
                                        <h5 class="fw-bold text-black">Skills</h5>
                                        <div class="badge-group mb-3">
                                            @foreach($jobpost->JobPostSkill as $jobpostSkill)
                                            <span class="my-1 badge text-white fz14 rounede-3 py-2 px-3 text-wrap" style="background: #0355d0">{{ $jobpostSkill->Skill->name }}</span>
                                            @endforeach
                                        </div>
                                        @endif
                                        <h5 class="fw-bold text-black">Experience Level :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $jobpost->experience_level }}</div>
                                        <h5 class="fw-bold text-black">Qualification :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $jobpost->degree }}</div>
                                        <h5 class="fw-bold text-black">Job Specializations :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $jobpost->MainFunctionalArea ? $jobpost->MainFunctionalArea->name : '' }} , {{ $jobpost->SubFunctionalArea ? $jobpost->SubFunctionalArea->name : '' }}</div>
                                        @if($jobpost->job_description)
                                        <h5 class="fw-bold text-black">Job Description</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobpost->job_description ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($jobpost->job_requirement)
                                        <h5 class="fw-bold text-black">Job Requirement</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobpost->job_requirement ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($jobpost->benefit)
                                        <h5 class="fw-bold text-black">Job Benefit</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobpost->benefit ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($jobpost->job_highlight)
                                        <h5 class="fw-bold text-black">Job Highlight</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobpost->job_highlight ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="nav-company-profile" role="tabpanel" aria-labelledby="nav-company-profile-tab">
                                        <div class="p-md-5 p-1 pt-5 d-none d-lg-block">
                                            <div class="row py-3">
                                                <div class="col-2">
                                                    
                                                </div>
                                                <div class="col-10">
                                                    <h4 class="fw-bold text-black">{{ $jobpost->Employer->MainEmployer->name }}</h4>
                                                </div>
                                            </div>
                                            <div class="card job-post-detail-company-profile mb-2">
                                                <div class="header">
                                                    <div class="row">
                                                        <div class="col-2 px-5">
                                                            @if($jobpost->Employer->MainEmployer->logo)
                                                            <img src="{{ getS3File('employer_logo',$jobpost->Employer->MainEmployer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $jobpost->Employer->MainEmployer->name }}">
                                                            @else
                                                            <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $jobpost->Employer->MainEmployer->name }}">
                                                            @endif
                                                        </div>
                                                        <div class="col-10 py-4">
                                                            <h5 class="fw-bold text-dark">Company Overview</h5>
                                                            @if($jobpost->Employer->MainEmployer->summary)
                                                            <p class="mb-4">
                                                                {!! $jobpost->Employer->MainEmployer->summary !!}
                                                            </p>
                                                            @endif
                                                            <h5 class="fw-bold text-dark">Specialties:</h5>
                                                            @if($jobpost->Employer->MainEmployer->Industry->name)
                                                            <span class="mb-4 btn border seeker_image_input_label">
                                                                {{ $jobpost->Employer->MainEmployer->Industry->name }}
                                                            </span>
                                                            @endif
                                                            @if($jobpost->Employer->MainEmployer->website)
                                                            <h5 class="fw-bold text-dark">Company Website:</h5>
                                                            <p class="mb-4">
                                                                <a href="{{ $jobpost->Employer->MainEmployer->website }}" target="_blank"><small><strong>{{ $jobpost->Employer->MainEmployer->website }}</strong></small></a>
                                                            </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card job-post-detail-company-profile">
                                                <div class="px-5 py-3">
                                                    <h5 class="fw-bold text-dark">Company Details</h5>
                                                    <div class="row">
                                                        @if($jobpost->Employer->MainEmployer->Industry->name)
                                                        <div class="col">
                                                            <h6 class="fw-bold text-dark">Industry Type</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobpost->Employer->MainEmployer->Industry->name }}
                                                            </p>
                                                        </div>
                                                        @endif
                                                        <div class="col">
                                                            <h6 class="fw-bold text-dark">Company Size:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $employer->no_of_employees ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="fw-bold text-dark">Company Founded In:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                -
                                                            </p>
                                                        </div>
                                                        <h5 class="fw-bold text-dark">Vision, Mission, Value</h5>
                                                        <p class="mb-4">
                                                            {!! $jobPost->Employer->MainEmployer->value ?? '-' !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-md-5 p-1 pt-5 d-lg-none d-block company-detail-media">
                                            
                                            <div class="card job-post-detail-company-profile mb-2">
                                                <div class="header">
                                                    <div class="row px-2 pt-4">
                                                        
                                                        <div class="col py-4" >
                                                            <div class="col-6 mx-auto text-center">
                                                                @if($jobpost->Employer->MainEmployer->logo)
                                                                <img src="{{ getS3File('employer_logo',$jobpost->Employer->MainEmployer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $jobpost->Employer->MainEmployer->name }}">
                                                                @else
                                                                <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $jobpost->Employer->MainEmployer->name }}">
                                                                @endif
                                                            </div>
                                                            <h4 class="fw-bold text-black job-post-company-name">{{ $jobpost->Employer->MainEmployer->name }}</h4>
                                                            <h5 class="fw-bold text-dark">Company Overview</h5>
                                                            @if($jobpost->Employer->MainEmployer->summary)
                                                            <p class="mb-4">
                                                                {!! $jobpost->Employer->MainEmployer->summary !!}
                                                            </p>
                                                            @endif
                                                            @if($jobpost->Employer->MainEmployer->EmployerAddress->count() > 0)
                                                            <h5 class="fw-bold text-dark">Address:</h5>
                                                            <span class="mb-4 btn border seeker_image_input_label">
                                                                
                                                                    @if($jobpost->Employer->MainEmployer->EmployerAddress->first()->address_detail)
                                                                    <p>{{ $jobpost->Employer->MainEmployer->EmployerAddress->first()->address_detail }}</p>
                                                                    @else
                                                                    <p>@if($jobpost->Employer->MainEmployer->EmployerAddress->first()->country == 'Myanmar') {{ $jobpost->Employer->MainEmployer->EmployerAddress->first()->State->name ?? '' }}, @if($jobpost->Employer->MainEmployer->EmployerAddress->first()->township_id) {{ $jobpost->Employer->MainEmployer->EmployerAddress->first()->Township->name }}, @endif {{ $jobpost->Employer->MainEmployer->EmployerAddress->first()->country }} @endif</p>
                                                                    @endif
                                                                
                                                            </span>
                                                            @endif
                                                            @if($jobpost->Employer->MainEmployer->website)
                                                            <h5 class="fw-bold text-dark">Company Website:</h5>
                                                            <p class="mb-4">
                                                                <a href="{{ $jobpost->Employer->MainEmployer->website }}" target="_blank"><small><strong>{{ $jobpost->Employer->MainEmployer->website }}</strong></small></a>
                                                            </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card job-post-detail-company-profile">
                                                <div class="px-2 px-md-5 py-3">
                                                    <h5 class="fw-bold text-dark">Company Details</h5>
                                                    <div class="row">
                                                        @if($jobpost->Employer->MainEmployer->Industry->name)
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">Industry Type</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobpost->Employer->MainEmployer->Industry->name }}
                                                            </p>
                                                        </div>
                                                        @endif
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">Company Size:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobpost->Employer->MainEmployer->no_of_employees ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">No of Office:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobpost->Employer->MainEmployer->no_of_offices ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <h5 class="fw-bold text-dark">Vision, Mission, Value</h5>
                                                        <p class="mb-4">
                                                            {!! $jobPost->Employer->MainEmployer->value ?? '-' !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    @else
                    <div class="container my-5" id="">
                        <div class="card shadow" id="edit-profile-body">
                            <div class="card-header bg-transparent">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-4 mb-2 d-flex">
                                        @if($jobpost->Employer->logo)
                                        <img src="{{ getS3File('employer_logo',$jobpost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobpost->Employer->name }}">
                                        @else
                                        <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobpost->Employer->name }}">
                                        @endif
                                        <div class="align-self-center">
                                            <span class="h4 fw-bold">{{ $jobpost->job_title }} @if($jobpost->no_of_candidate) ( {{ $jobpost->no_of_candidate }} - Posts ) @endif</span>
                                            <div><a class="text-muted h6 text-decoration-none" href="#">{{ $jobpost->Employer->name }}</a></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 mb-2 align-self-center">
                                        <div>
                                            <span>{{ $jobpost->job_type }} @if($jobpost->country == 'Myanmar') | {{ $jobpost->State->name ?? '' }}, {{ $jobpost->Township->name ?? '' }} @endif {{ $jobpost->gender }}</span>
                                        </div>
                                        <div>
                                            <span class="text-muted">Salary Range:</span>
                                            <span class="h5 fw-bold">@if($jobpost->hide_salary == 1) Negotiate @else {{ $jobpost->salary_range }} {{ $jobpost->currency }} @endif</span>
                                        </div>
                                    </div>
                                    
                                </div>  
                            </div>
                            <div class="card-body p-0">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="p-md-3 p-2 job-post-detail nav-link active" id="nav-job-description-tab" data-bs-toggle="tab" data-bs-target="#nav-job-description" type="button" role="tab" aria-controls="nav-job-description" aria-selected="true">Job Description</button>
                                        <button class="p-md-3 p-2 job-post-detail nav-link" id="nav-company-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-company-profile" type="button" role="tab" aria-controls="nav-company-profile" aria-selected="false">Company Profile</button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane p-3 fade show active" id="nav-job-description" role="tabpanel" aria-labelledby="nav-job-description-tab">
                                        @if($jobpost->JobPostSkill->count() > 0)
                                        <h5 class="fw-bold text-black">Skills</h5>
                                        <div class="badge-group mb-3">
                                            @foreach($jobpost->JobPostSkill as $jobpostSkill)
                                            <span class="my-1 badge text-white fz14 rounede-3 py-2 px-3 text-wrap" style="background: #0355d0">{{ $jobpostSkill->Skill->name }}</span>
                                            @endforeach
                                        </div>
                                        @endif
                                        <h5 class="fw-bold text-black">Experience Level :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $jobpost->experience_level }}</div>
                                        <h5 class="fw-bold text-black">Qualification :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $jobpost->degree }}</div>
                                        <h5 class="fw-bold text-black">Job Specializations :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $jobpost->MainFunctionalArea ? $jobpost->MainFunctionalArea->name : '' }} , {{ $jobpost->SubFunctionalArea ? $jobpost->SubFunctionalArea->name : '' }}</div>
                                        @if($jobpost->job_description)
                                        <h5 class="fw-bold text-black">Job Description</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobpost->job_description ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($jobpost->job_requirement)
                                        <h5 class="fw-bold text-black">Job Requirement</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobpost->job_requirement ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($jobpost->benefit)
                                        <h5 class="fw-bold text-black">Job Benefit</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobpost->benefit ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($jobpost->job_highlight)
                                        <h5 class="fw-bold text-black">Job Highlight</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobpost->job_highlight ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="nav-company-profile" role="tabpanel" aria-labelledby="nav-company-profile-tab">
                                        <div class="p-md-5 p-1 pt-5 d-none d-lg-block">
                                            <div class="row py-3">
                                                <div class="col-2">
                                                    
                                                </div>
                                                <div class="col-10">
                                                    <h4 class="fw-bold text-black">{{ $jobpost->Employer->name }}</h4>
                                                </div>
                                            </div>
                                            <div class="card job-post-detail-company-profile mb-2">
                                                <div class="header">
                                                    <div class="row">
                                                        <div class="col-2 px-5">
                                                            @if($jobpost->Employer->logo)
                                                            <img src="{{ getS3File('employer_logo',$jobpost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $jobpost->Employer->name }}">
                                                            @else
                                                            <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $jobpost->Employer->name }}">
                                                            @endif
                                                        </div>
                                                        <div class="col-10 py-4">
                                                            <h5 class="fw-bold text-dark">Company Overview</h5>
                                                            @if($jobpost->Employer->summary)
                                                            <p class="mb-4">
                                                                {!! $jobpost->Employer->summary !!}
                                                            </p>
                                                            @endif
                                                            <h5 class="fw-bold text-dark">Specialties:</h5>
                                                            @if($jobpost->Employer->Industry->name)
                                                            <span class="mb-4 btn border seeker_image_input_label">
                                                                {{ $jobpost->Employer->Industry->name }}
                                                            </span>
                                                            @endif
                                                            @if($jobpost->Employer->website)
                                                            <h5 class="fw-bold text-dark">Company Website:</h5>
                                                            <p class="mb-4">
                                                                <a href="{{ $jobpost->Employer->website }}" target="_blank"><small><strong>{{ $jobpost->Employer->website }}</strong></small></a>
                                                            </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card job-post-detail-company-profile">
                                                <div class="px-5 py-3">
                                                    <h5 class="fw-bold text-dark">Company Details</h5>
                                                    <div class="row">
                                                        @if($jobpost->Employer->Industry->name)
                                                        <div class="col">
                                                            <h6 class="fw-bold text-dark">Industry Type</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobpost->Employer->Industry->name }}
                                                            </p>
                                                        </div>
                                                        @endif
                                                        <div class="col">
                                                            <h6 class="fw-bold text-dark">Company Size:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $employer->no_of_employees ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="fw-bold text-dark">Company Founded In:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                -
                                                            </p>
                                                        </div>
                                                        <h5 class="fw-bold text-dark">Vision, Mission, Value</h5>
                                                        <p class="mb-4">
                                                            {!! $jobPost->Employer->value ?? '-' !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-md-5 p-1 pt-5 d-lg-none d-block company-detail-media">
                                            
                                            <div class="card job-post-detail-company-profile mb-2">
                                                <div class="header">
                                                    <div class="row px-2 pt-4">
                                                        
                                                        <div class="col py-4" >
                                                            <div class="col-6 mx-auto text-center">
                                                                @if($jobpost->Employer->logo)
                                                                <img src="{{ getS3File('employer_logo',$jobpost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $jobpost->Employer->name }}">
                                                                @else
                                                                <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $jobpost->Employer->name }}">
                                                                @endif
                                                            </div>
                                                            <h4 class="fw-bold text-black job-post-company-name">{{ $jobpost->Employer->name }}</h4>
                                                            <h5 class="fw-bold text-dark">Company Overview</h5>
                                                            @if($jobpost->Employer->summary)
                                                            <p class="mb-4">
                                                                {!! $jobpost->Employer->summary !!}
                                                            </p>
                                                            @endif
                                                            @if($jobpost->Employer->EmployerAddress->count() > 0)
                                                            <h5 class="fw-bold text-dark">Address:</h5>
                                                            <span class="mb-4 btn border seeker_image_input_label">
                                                                
                                                                    @if($jobpost->Employer->EmployerAddress->first()->address_detail)
                                                                    <p>{{ $jobpost->Employer->EmployerAddress->first()->address_detail }}</p>
                                                                    @else
                                                                    <p>@if($jobpost->Employer->EmployerAddress->first()->country == 'Myanmar') {{ $jobpost->Employer->EmployerAddress->first()->State->name ?? '' }}, @if($jobpost->Employer->EmployerAddress->first()->township_id) {{ $jobpost->Employer->EmployerAddress->first()->Township->name }}, @endif {{ $jobpost->Employer->EmployerAddress->first()->country }} @endif</p>
                                                                    @endif
                                                                
                                                            </span>
                                                            @endif
                                                            @if($jobpost->Employer->website)
                                                            <h5 class="fw-bold text-dark">Company Website:</h5>
                                                            <p class="mb-4">
                                                                <a href="{{ $jobpost->Employer->website }}" target="_blank"><small><strong>{{ $jobpost->Employer->website }}</strong></small></a>
                                                            </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card job-post-detail-company-profile">
                                                <div class="px-2 px-md-5 py-3">
                                                    <h5 class="fw-bold text-dark">Company Details</h5>
                                                    <div class="row">
                                                        @if($jobpost->Employer->Industry->name)
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">Industry Type</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobpost->Employer->Industry->name }}
                                                            </p>
                                                        </div>
                                                        @endif
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">Company Size:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobpost->Employer->no_of_employees ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">No of Office:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobpost->Employer->no_of_offices ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <h5 class="fw-bold text-dark">Vision, Mission, Value</h5>
                                                        <p class="mb-4">
                                                            {!! $jobPost->Employer->value ?? '-' !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    @endif
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
        updateStatus();
    })

    $(".btn-reject").click(function(){
        $(this).removeClass('btn-outline-danger');
        $(this).addClass('btn-danger');
        $('.reject-icon').removeClass('d-none');
        $('.btn-approve').removeClass('btn-success');
        $('.btn-approve').addClass('btn-outline-success');
        $('.approve-icon').addClass('d-none');
        $('#job_post_status').val('Reject');
        updateStatus();
    })

    function updateStatus()
    {
        $("#update_submit").click();
    }
</script>
@endpush