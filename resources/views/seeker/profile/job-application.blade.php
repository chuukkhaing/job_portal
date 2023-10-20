@extends('frontend.layouts.app')
@section('content')

<div class="col-xl-10 col-lg-12 m-auto">
    <div class="seeker-dashboard-header text-center py-5 mt-4 d-none d-lg-block">
        @if(Auth::guard('seeker')->user()->image)
        <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
        @else
        <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
        @endif
        <div class="seeker-name p-0" style="color: #fff">{{ Auth::guard('seeker')->user()->first_name }} {{ Auth::guard('seeker')->user()->last_name }}</div>
    </div>
    <div class="edit-profile-tab-border d-none d-lg-block">
        <ul class="nav d-flex justify-content-between py-3 px-xl-5 px-lg-3" id="seekerTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('profile.index') }}" class="seeker-single-tab" id="profile-dashboard-tab">Dashboard</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="seeker-single-tab" id="edit-profile-tab">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-applications') }}" class="seeker-single-tab active" id="job-application-tab">Applications</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-saved-jobs') }}" class="seeker-single-tab" id="fav-job-tab">Saved Jobs</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-job-alerts') }}" class="seeker-single-tab" id="job-alert-tab">Job Alerts</a>
            </li>
        </ul>
    </div>
    <div class="d-block d-lg-none p-4 my-4 seeker-dashboard-mobile">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Seeker Toggle Mobile" id="seeker-toggle-mobile">
                <i class="fa-solid fa-bars text-white"></i> <span class="text-white">Profile Dashboard</span>
                </button>
                <div class="collapse navbar-collapse" id="navbarToggler">

                <ul class="navbar-nav">
                    <li class="nav-item pt-3">
                        <a href="{{ route('profile.index') }}" class="text-white" id="">Dashboard</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="text-white" id="">Profile</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-applications') }}" class="text-white active" id="">Applications</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-saved-jobs') }}" class="text-white" id="">Saved Jobs</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-job-alerts') }}" class="text-white" id="">Job Alerts</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        
    </div>
    <div class="tab-content" id="seekerTabContent">
        <div class="tab-pane fade p-0 show active" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
            <div class="container-fluid px-xl-5 px-lg-3 py-3 edit-profile-header-border" id="edit-profile-header">
                <div class="">
                    <h5>My Applications ( {{ $jobsApplyBySeeker->count() }} )</h5>
                </div>
            </div>
            
            <div class="my-2 py-3 px-lg-5 px-md-3" id="edit-profile-body">
                @if($jobsApplyBySeeker->count() > 0)
                <div class="table-responsive" id="applicant-tracking-section">
                    <table class="table table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Job Function</th>
                                <th>Location</th>
                                <th>Applied Date</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($jobsApplyBySeeker as $key => $jobApplyBySeeker)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td class="fw-bold"><a data-bs-toggle="modal" data-bs-target="#JobPostModal{{$jobApplyBySeeker->JobPost->id}}" class="text-black">{{ $jobApplyBySeeker->JobPost->job_title }}</a></td>
                                <td class="text-blue">@if($jobApplyBySeeker->JobPost->hide_company == 0){{ $jobApplyBySeeker->JobPost->Employer->name }} @if($jobApplyBySeeker->JobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif @else - @endif</td>
                                <td>
                                    {{ $jobApplyBySeeker->JobPost->MainFunctionalArea->name }} , 
                                    {{ $jobApplyBySeeker->JobPost->SubFunctionalArea->name }}
                                </td>
                                <td>
                                    {{ $jobApplyBySeeker->JobPost->Township->name ?? '' }} {{ $jobApplyBySeeker->JobPost->Township->name ? ',' : '' }} 
                                    {{ $jobApplyBySeeker->JobPost->State->name ?? '' }}
                                </td>
                                <td class="fw-bold">{{ date('d M,Y', strtotime($jobApplyBySeeker->created_at)) }}</td>
                                
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="JobPostModal{{$jobApplyBySeeker->JobPost->id}}" tabindex="-1" aria-labelledby="JobPostModal{{$jobApplyBySeeker->JobPost->id}}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <div class="card shadow" id="edit-profile-body">
                                                <div class="card-header bg-transparent">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6 col-xl-5 mb-2 d-flex">
                                                            @if($jobApplyBySeeker->JobPost->Employer->logo && $jobApplyBySeeker->JobPost->hide_company == 0)
                                                            <img src="{{ asset('storage/employer_logo/'.$jobApplyBySeeker->JobPost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobApplyBySeeker->JobPost->Employer->name }}">
                                                            @else
                                                            <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="Employer Profile">
                                                            @endif
                                                            <div class="align-self-center">
                                                                <span class="h4 fw-bold">{{ $jobApplyBySeeker->JobPost->job_title }} @if($jobApplyBySeeker->JobPost->no_of_candidate) ( {{ $jobApplyBySeeker->JobPost->no_of_candidate }} - Posts ) @endif</span>
                                                                @if($jobApplyBySeeker->JobPost->hide_company == 0)
                                                                <div><a class="text-muted h6" href="{{ route('company-detail',$jobApplyBySeeker->JobPost->Employer->slug ?? '') }}">{{ $jobApplyBySeeker->JobPost->Employer->name }} @if($jobApplyBySeeker->JobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</a></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6 col-xl-5 mb-2 align-self-center">
                                                            <div>
                                                                <span>{{ $jobApplyBySeeker->JobPost->job_type }} @if($jobApplyBySeeker->JobPost->country == 'Myanmar') | {{ $jobApplyBySeeker->JobPost->State->name ?? '' }}, {{ $jobApplyBySeeker->JobPost->Township->name ?? '' }} @endif {{ $jobApplyBySeeker->JobPost->gender }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="text-muted">Salary Range:</span>
                                                                <span class="h5 fw-bold">@if($jobApplyBySeeker->JobPost->hide_salary == 1) Negotiate @else {{ $jobApplyBySeeker->JobPost->salary_range }} {{ $jobApplyBySeeker->JobPost->currency }} @endif</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-12 col-xl-2 mb-2 text-end">
                                                            @php
                                                                $disabled = '';
                                                                $btn_text = 'Apply Job';
                                                            @endphp
                                                            @auth('seeker')
                                                                @php
                                                                foreach(Auth::guard('seeker')->user()->JobApply as $seeker_job){
                                                                    if($seeker_job->job_post_id == $jobApplyBySeeker->JobPost->id){
                                                                        $disabled = 'disabled';
                                                                        $btn_text = 'Applied';
                                                                    }
                                                                }
                                                                @endphp
                                                            @endauth
                                                            @auth('seeker')
                                                                <a href="{{ route('jobpost-apply', $jobApplyBySeeker->JobPost->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                                                    <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                                                </a>
                                                            @elseauth('employer')
                                                            @else
                                                                <a href="{{ route('jobpost-apply', $jobApplyBySeeker->JobPost->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                                                    <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                                                </a>
                                                            @endguest
                                                                <div>
                                                                    <small>Posted {{ $jobApplyBySeeker->JobPost->updated_at->shortRelativeDiffForHumans() }}</small>
                                                                </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="card-body p-0">
                                                    <nav>
                                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                            <button class="p-md-3 p-2 job-post-detail nav-link active" id="nav-job-description-{{$jobApplyBySeeker->JobPost->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-job-description-{{$jobApplyBySeeker->JobPost->id}}" type="button" role="tab" aria-controls="nav-job-description-{{$jobApplyBySeeker->JobPost->id}}" aria-selected="true">Job Description</button>
                                                            @if($jobApplyBySeeker->JobPost->hide_company != 1)
                                                            <button class="p-md-3 p-2 job-post-detail nav-link" id="nav-company-profile-{{$jobApplyBySeeker->JobPost->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-company-profile-{{$jobApplyBySeeker->JobPost->id}}" type="button" role="tab" aria-controls="nav-company-profile-{{$jobApplyBySeeker->JobPost->id}}" aria-selected="false">Company Profile</button>
                                                            @endif
                                                        </div>
                                                    </nav>
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane p-3 fade show active" id="nav-job-description-{{$jobApplyBySeeker->JobPost->id}}" role="tabpanel" aria-labelledby="nav-job-description-{{$jobApplyBySeeker->JobPost->id}}-tab">
                                                            @if($jobApplyBySeeker->JobPost->JobPostSkill->count() > 0)
                                                            <h5 class="fw-bold text-black">Skills</h5>
                                                            <div class="badge-group mb-3">
                                                                @foreach($jobApplyBySeeker->JobPost->JobPostSkill as $jobApplyBySeeker->JobPostSkill)
                                                                <span class="my-1 badge text-white fz14 rounede-3 py-2 px-3" style="background: #0355d0">{{ $jobApplyBySeeker->JobPostSkill->Skill->name }}</span>
                                                                @endforeach
                                                            </div>
                                                            @endif
                                                            <h5 class="fw-bold text-black">Experience Level :</h5>
                                                            <div class="mb-4 fz14 fw-bold">{{ $jobApplyBySeeker->JobPost->experience_level }}</div>
                                                            <h5 class="fw-bold text-black">Qualification :</h5>
                                                            <div class="mb-4 fz14 fw-bold">{{ $jobApplyBySeeker->JobPost->degree }}</div>
                                                            <h5 class="fw-bold text-black">Job Specializations :</h5>
                                                            <div class="mb-4 fz14 fw-bold">{{ $jobApplyBySeeker->JobPost->MainFunctionalArea->name }} , {{ $jobApplyBySeeker->JobPost->SubFunctionalArea->name }}</div>
                                                            @if($jobApplyBySeeker->JobPost->job_description)
                                                            <h5 class="fw-bold text-black">Job Description</h5>
                                                            <div class="mb-4">
                                                                <p class="fz15">
                                                                    {!! $jobApplyBySeeker->JobPost->job_description ?? '-' !!}
                                                                </p>
                                                            </div>
                                                            @endif
                                                            @if($jobApplyBySeeker->JobPost->job_requirement)
                                                            <h5 class="fw-bold text-black">Job Requirement</h5>
                                                            <div class="mb-4">
                                                                <p class="fz15">
                                                                    {!! $jobApplyBySeeker->JobPost->job_requirement ?? '-' !!}
                                                                </p>
                                                            </div>
                                                            @endif
                                                            @if($jobApplyBySeeker->JobPost->benefit)
                                                            <h5 class="fw-bold text-black">Job Benefit</h5>
                                                            <div class="mb-4">
                                                                <p class="fz15">
                                                                    {!! $jobApplyBySeeker->JobPost->benefit ?? '-' !!}
                                                                </p>
                                                            </div>
                                                            @endif
                                                            @if($jobApplyBySeeker->JobPost->job_highlight)
                                                            <h5 class="fw-bold text-black">Job Highlight</h5>
                                                            <div class="mb-4">
                                                                <p class="fz15">
                                                                    {!! $jobApplyBySeeker->JobPost->job_highlight ?? '-' !!}
                                                                </p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-company-profile-{{$jobApplyBySeeker->JobPost->id}}" role="tabpanel" aria-labelledby="nav-company-profile-{{$jobApplyBySeeker->JobPost->id}}-tab">
                                                            <div class=" p-1 d-none d-lg-block">
                                                                <div class="row py-3">
                                                                    <div class="col-2">
                                                                        
                                                                    </div>
                                                                    @if($jobApplyBySeeker->JobPost->hide_company == 0)
                                                                    <div class="col-10">
                                                                        <h4 class="fw-bold text-black">{{ $jobApplyBySeeker->JobPost->Employer->name }} @if($jobApplyBySeeker->JobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                                <div class="card job-post-detail-company-profile mb-2">
                                                                    <div class="header">
                                                                        <div class="row">
                                                                            <div class="col-2 ">
                                                                                @if($jobApplyBySeeker->JobPost->Employer->logo && $jobApplyBySeeker->JobPost->hide_company == 0)
                                                                                <img src="{{ asset('storage/employer_logo/'.$jobApplyBySeeker->JobPost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $jobApplyBySeeker->JobPost->Employer->name }}">
                                                                                @else
                                                                                <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="Employer Profile">
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-10 py-4">
                                                                                <h5 class="fw-bold text-dark">Company Overview</h5>
                                                                                @if($jobApplyBySeeker->JobPost->Employer->summary)
                                                                                <p class="mb-4">
                                                                                    {!! $jobApplyBySeeker->JobPost->Employer->summary !!}
                                                                                </p>
                                                                                @endif
                                                                                <h5 class="fw-bold text-dark">Specialties:</h5>
                                                                                @if($jobApplyBySeeker->JobPost->Employer->Industry->name)
                                                                                <span class="mb-4 btn border seeker_image_input_label">
                                                                                    {{ $jobApplyBySeeker->JobPost->Employer->Industry->name }}
                                                                                </span>
                                                                                @endif
                                                                                @if($jobApplyBySeeker->JobPost->Employer->website)
                                                                                <h5 class="fw-bold text-dark">Company Website:</h5>
                                                                                <p class="mb-4">
                                                                                    <a href="{{ $jobApplyBySeeker->JobPost->Employer->website }}" target="_blank"><small><strong>{{ $jobApplyBySeeker->JobPost->Employer->website }}</strong></small></a>
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
                                                                            @if($jobApplyBySeeker->JobPost->Employer->Industry->name)
                                                                            <div class="col">
                                                                                <h6 class="fw-bold text-dark">Industry Type</h6>
                                                                                <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                                    {{ $jobApplyBySeeker->JobPost->Employer->Industry->name }}
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
                                                                                {!! $jobApplyBySeeker->JobPost->Employer->value ?? '-' !!}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class=" p-1  d-lg-none d-block company-detail-media">
                                                                
                                                                <div class="card job-post-detail-company-profile mb-2">
                                                                    <div class="header">
                                                                        <div class="row px-2 pt-4">
                                                                            
                                                                            <div class="col py-4" >
                                                                                <div class="col-6 mx-auto text-center">
                                                                                    @if($jobApplyBySeeker->JobPost->Employer->logo && $jobApplyBySeeker->JobPost->hide_company == 0)
                                                                                    <img src="{{ asset('storage/employer_logo/'.$jobApplyBySeeker->JobPost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $jobApplyBySeeker->JobPost->Employer->name }}">
                                                                                    @else
                                                                                    <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="Employer Profile">
                                                                                    @endif
                                                                                </div>
                                                                                @if($jobApplyBySeeker->JobPost->hide_company == 0)
                                                                                <h4 class="fw-bold text-black job-post-company-name">{{ $jobApplyBySeeker->JobPost->Employer->name }} @if($jobApplyBySeeker->JobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                                                @endif
                                                                                <h5 class="fw-bold text-dark">Company Overview</h5>
                                                                                @if($jobApplyBySeeker->JobPost->Employer->summary)
                                                                                <p class="mb-4">
                                                                                    {!! $jobApplyBySeeker->JobPost->Employer->summary !!}
                                                                                </p>
                                                                                @endif
                                                                                @if($jobApplyBySeeker->JobPost->Employer->EmployerAddress->count() > 0)
                                                                                <h5 class="fw-bold text-dark">Address:</h5>
                                                                                <span class="mb-4 btn border seeker_image_input_label">
                                                                                    
                                                                                        @if($jobApplyBySeeker->JobPost->Employer->EmployerAddress->first()->address_detail)
                                                                                        <p>{{ $jobApplyBySeeker->JobPost->Employer->EmployerAddress->first()->address_detail }}</p>
                                                                                        @else
                                                                                        <p>@if($jobApplyBySeeker->JobPost->Employer->EmployerAddress->first()->country == 'Myanmar') {{ $jobApplyBySeeker->JobPost->Employer->EmployerAddress->first()->State->name ?? '' }}, @if($jobApplyBySeeker->JobPost->Employer->EmployerAddress->first()->township_id) {{ $jobApplyBySeeker->JobPost->Employer->EmployerAddress->first()->Township->name }}, @endif {{ $jobApplyBySeeker->JobPost->Employer->EmployerAddress->first()->country }} @endif</p>
                                                                                        @endif
                                                                                    
                                                                                </span>
                                                                                @endif
                                                                                @if($jobApplyBySeeker->JobPost->Employer->website)
                                                                                <h5 class="fw-bold text-dark">Company Website:</h5>
                                                                                <p class="mb-4">
                                                                                    <a href="{{ $jobApplyBySeeker->JobPost->Employer->website }}" target="_blank"><small><strong>{{ $jobApplyBySeeker->JobPost->Employer->website }}</strong></small></a>
                                                                                </p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card job-post-detail-company-profile">
                                                                    <div class="px-2 px-md-3 px-lg-5 py-3">
                                                                        <h5 class="fw-bold text-dark">Company Details</h5>
                                                                        <div class="row">
                                                                            @if($jobApplyBySeeker->JobPost->Employer->Industry->name)
                                                                            <div class="col-12 col-lg-4">
                                                                                <h6 class="fw-bold text-dark">Industry Type</h6>
                                                                                <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                                    {{ $jobApplyBySeeker->JobPost->Employer->Industry->name }}
                                                                                </p>
                                                                            </div>
                                                                            @endif
                                                                            <div class="col-12 col-lg-4">
                                                                                <h6 class="fw-bold text-dark">Company Size:</h6>
                                                                                <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                                    {{ $jobApplyBySeeker->JobPost->Employer->no_of_employees ?? '-' }}
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-12 col-lg-4">
                                                                                <h6 class="fw-bold text-dark">No of Office:</h6>
                                                                                <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                                    {{ $jobApplyBySeeker->JobPost->Employer->no_of_offices ?? '-' }}
                                                                                </p>
                                                                            </div>
                                                                            <h5 class="fw-bold text-dark">Vision, Mission, Value</h5>
                                                                            <p class="mb-4">
                                                                                {!! $jobApplyBySeeker->JobPost->Employer->value ?? '-' !!}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($jobApplyBySeeker->JobPost->hide_company == 0)
                                                <div class="card-footer text-center">
                                                    <a href="{{ route('company-jobs', $jobApplyBySeeker->JobPost->Employer->id) }}" class="btn btn-sm text-white" style="background-color: #0355d0;">See more jobs from this company</a>
                                                </div>
                                                @endif
                                            </div>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success copyText" onclick="copyText('{{ route('jobpost-detail', $jobApplyBySeeker->JobPost->slug) }}')"  ><i class="fa-solid fa-copy"></i> Copy to Clipboard</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            @auth('seeker')
                                                <a href="{{ route('jobpost-apply', $jobApplyBySeeker->JobPost->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                                    <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                                </a>
                                            @elseauth('employer')
                                            @else
                                                <a href="{{ route('jobpost-apply', $jobApplyBySeeker->JobPost->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                                    <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                                </a>
                                            @endguest
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
    
</div>

@endsection
@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function saveJob(id) {
        $.ajax({
            type: 'GET',
            data: id,
            url: "/seeker/save-job/"+id,
        }).done(function(response){
            if(response.status == 'create') {
                
                $('#savejobapply-'+id).removeClass('fa-regular');
                $('#savejobapply-'+id).addClass('fa-solid');
            }else if(response.status == 'remove') {
                
                $('#savejobapply-'+id).removeClass('fa-solid');
                $('#savejobapply-'+id).addClass('fa-regular');
            }
        })
    }
</script>
@endpush