@extends('frontend.layouts.app')
@section('content')
<!-- Carousel Start -->
@if($sliders->count() > 0)
<div class="container-fluid p-0">
    <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($sliders as $key => $slider)
            <button type="button" data-bs-target="#header-carousel" data-bs-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($sliders as $slider)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img class="" src="{{ asset('storage/slider/'.$slider->image) }}" alt="{{ $slider->Employer->name }}">
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev d-sm-none d-md-none d-none d-lg-block" type="button" data-bs-target="#header-carousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d-sm-none d-md-none d-none d-lg-block" type="button" data-bs-target="#header-carousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
@endif
<!-- Carousel End -->

<!-- Search Start -->
<form action="{{ route('search-job') }}" method="get" class="form-height-0" autocomplete="off">
    @csrf
    <section class="search-sec">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 p-0">
                        <div class="form-group has-search">
                            <span class="form-control-feedback"><i class="fa fa-search fa-md"></i></span>
                            <input type="text" class="form-control search-slt job-title" placeholder="Job title or keyword" name="job_title">
                            <ul class="autocomplete"></ul>
                        </div>
                    </div>
                    <div class="ol-lg-4 col-md-4 p-0">
                        <div class="form-group has-search search-slt function-area">
                            <span class="form-control-feedback"><i class="fa fa-shopping-bag fa-md" aria-hidden="true"></i></span>
                            <select class="form-control d-none" id="function-area" multiple="multiple" name="function_area[]" size="10">
                                @foreach($main_functional_areas as $main_functional_area)
                                <optgroup label="{{ $main_functional_area->name }}">
                                    @foreach($sub_functional_areas as $sub_functional_area)
                                    @if($main_functional_area->id == $sub_functional_area->functional_area_id)
                                    <option value="{{ $sub_functional_area->id }}">{{ $sub_functional_area->name }}</option>
                                    @endif
                                    @endforeach
                                </optgroup>
                                @endforeach
                                
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 p-0">
                        <div class="form-group has-search">
                            <span class="form-control-feedback"><i class="fa fa-map-marker fa-md"></i></span>
                            <select name="location" id="location" class="form-control search-slt location" placeholder="location" name="location">
                                <option value="" selected disabled>Location</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 p-0 mt-lg-0 mt-md-3">
                        <button type="submit" class="btn pull-right search-job-btn">Search Jobs</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<!-- Search End -->

<!-- Popular Job Category Start  -->
@if($industries->count() > 0)
<div class="container">
    <div class="popular-job-category">
        <div id="header-popular-job-category" class="text-center py-3">
            <h3 id="popular-job-category-title">Popular Job Categories</h3>
            <span id="popular-job-category-sub-title">{{ $live_job }} jobs live - {{ $today_job }} added today</span>
        </div>
        <div id="body-popular-job-category" class="row">
            @foreach($industries as $industry)
            <div class="col-lg-3 col-md-4 col-sm-2 p-2">
                <a href="{{ route('industry-job',$industry->Industry->id) }}">
                    <div id="job-category-box" class="text-center px-0 px-sm-3 h-100 shadow">
                        <div id="job-category-icon">
                            <i class="{{ $industry->Industry->icon }}"></i>
                        </div>
                        <div id="job-category-name">
                            <span id="job-category-name-title" class="d-block">{{ $industry->Industry->name }}</span>
                            <span id="job-category-name-position">{{ $industry->total }} open positions</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            <div class="text-end py-3">
                <a href="{{ route('job-categories') }}" class="btn-browse-category">Browse All Categories <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Popular Job Category End  -->

<!-- Top Employer Start  -->
@if($employers->count() > 0)
<div class="container">
    <div class="popular-job-category">
        <div id="header-popular-job-category" class="text-center py-3">
            <h3 id="popular-job-category-title">Top Employers</h3>
        </div>
        <div id="body-popular-job-category" class="row col-12 pb-5">
            @foreach($employers as $employer)
            <div class="col-lg-2 col-md-3 col-sm-4 col-12 text-center h-100 align-self-center">
                <a href="{{ route('company-detail',$employer->slug) }}">
                    @if($employer->logo)
                    <img src="{{ asset('/storage/employer_logo'.'/'.$employer->logo) }}" class="" width="100" alt="{{ $employer->name }}">
                    @else
                    <img src="{{ asset('/img/logo/ICLogo.png') }}" class="" width="100" alt="{{ $employer->name }}">
                    @endif
                    <div class="mt-2" id="job-category-name">
                    <span id="job-category-name-position">{{ $employer->name }} @if($employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
<!-- Top Employer End  -->

<!-- Trending Jobs Start  -->
@if($trending_jobs->count() > 0)
<div class="container pb-4 my-2 shadow" id="edit-profile-body">
    <div class="row">
        <div id="header-popular-job-category" class="text-center py-4" style="border-bottom: 1px solid #95B6D8;">
            <h3 id="popular-job-category-title">
                <span class="text-orange d-none d-sm-inline-block">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </span>
                <span class="px-3">Trending Jobs</span>
                <span class="text-orange d-none d-sm-inline-block">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </span>
            </h3>
        </div>
    </div>  

    <div class="row pt-4 pb-4 trending-scroll">
        @foreach($trending_jobs as $trending_job)
        <div class="col-lg-4 col-sm-6 col-12 align-self-center">
            <div data-bs-toggle="modal" data-bs-target="#JobPostModal{{$trending_job->id}}">
                <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                    <div class="row h-100 p-2">
                        <div class="col-3 text-center h-100 align-self-center">
                            @if($trending_job->Employer->logo)
                            <img src="{{ asset('storage/employer_logo/'.$trending_job->Employer->logo) }}" alt="{{ $trending_job->Employer->name }}" class="w-75 border rounded-circle">
                            @else 
                            <img src="{{ asset('img/profile.svg') }}" alt="{{ $trending_job->Employer->name }}" class="w-75 border rounded-circle">
                            @endif
                        </div>
                        <div class="col-9 p-0">
                            <div>
                                <h3 id="trending-job-title">{{ $trending_job->job_title }}</h3>
                                <span id="trending-job-sub-title">{{ $trending_job->Employer->name }} @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$trending_job->id)->count() > 0)<span class="badge badge-info"> Applied </span> @endif @endauth</span>
                            </div>

                            <div class="">
                                <span class="me-2 d-block" style="margin: 0px 0 -15px 0"><i class="fa fa-briefcase me-2"></i></i>{{ $trending_job->MainFunctionalArea->name }}</span>
                                @if($trending_job->township_id )<span style="margin: -15px 0"><i class="fa fa-map-marker me-1" aria-hidden="true"></i> {{ $trending_job->Township->name }}</span> @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="JobPostModal{{$trending_job->id}}" tabindex="-1" aria-labelledby="JobPostModal{{$trending_job->id}}Label" aria-hidden="true">
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
                                        @if($trending_job->Employer->logo)
                                        <img src="{{ asset('storage/employer_logo/'.$trending_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $trending_job->Employer->name }}">
                                        @else
                                        <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $trending_job->Employer->name }}">
                                        @endif
                                        <div class="align-self-center">
                                            <span class="h4 fw-bold">{{ $trending_job->job_title }} @if($trending_job->no_of_candidate) ( {{ $trending_job->no_of_candidate }} - Posts ) @endif</span>
                                            <div><a class="text-muted h6" href="{{ route('company-detail',$trending_job->Employer->slug ?? '') }}">{{ $trending_job->Employer->name }} @if($trending_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</a></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-5 mb-2 align-self-center">
                                        <div>
                                            <span>{{ $trending_job->job_type }} @if($trending_job->country == 'Myanmar') | {{ $trending_job->State->name ?? '' }}, {{ $trending_job->Township->name ?? '' }} @endif {{ $trending_job->gender }}</span>
                                        </div>
                                        <div>
                                            <span class="text-muted">Salary Range:</span>
                                            <span class="h5 fw-bold">@if($trending_job->hide_salary == 1) Negotiate @else {{ $trending_job->salary_range }} {{ $trending_job->currency }} @endif</span>
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
                                                if($seeker_job->job_post_id == $trending_job->id){
                                                    $disabled = 'disabled';
                                                    $btn_text = 'Applied';
                                                }
                                            }
                                            @endphp
                                        @endauth
                                        @auth('seeker')
                                            <a href="{{ route('jobpost-apply', $trending_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                                <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                            </a>
                                        @elseauth('employer')
                                        @else
                                            <a href="{{ route('jobpost-apply', $trending_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                                <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                            </a>
                                        @endguest
                                            <div>
                                                <small>Posted {{ $trending_job->updated_at->shortRelativeDiffForHumans() }}</small>
                                            </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="card-body p-0">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="p-md-3 p-2 job-post-detail nav-link active" id="nav-job-description-{{$trending_job->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-job-description-{{$trending_job->id}}" type="button" role="tab" aria-controls="nav-job-description-{{$trending_job->id}}" aria-selected="true">Job Description</button>
                                        @if($trending_job->hide_company != 1)
                                        <button class="p-md-3 p-2 job-post-detail nav-link" id="nav-company-profile-{{$trending_job->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-company-profile-{{$trending_job->id}}" type="button" role="tab" aria-controls="nav-company-profile-{{$trending_job->id}}" aria-selected="false">Company Profile</button>
                                        @endif
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane p-3 fade show active" id="nav-job-description-{{$trending_job->id}}" role="tabpanel" aria-labelledby="nav-job-description-{{$trending_job->id}}-tab">
                                        @if($trending_job->JobPostSkill->count() > 0)
                                        <h5 class="fw-bold text-black">Skills</h5>
                                        <div class="badge-group mb-3">
                                            @foreach($trending_job->JobPostSkill as $trending_jobSkill)
                                            <span class="my-1 badge text-white fz14 rounede-3 py-2 px-3" style="background: #0355d0">{{ $trending_jobSkill->Skill->name }}</span>
                                            @endforeach
                                        </div>
                                        @endif
                                        <h5 class="fw-bold text-black">Experience Level :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $trending_job->experience_level }}</div>
                                        <h5 class="fw-bold text-black">Qualification :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $trending_job->degree }}</div>
                                        <h5 class="fw-bold text-black">Job Specializations :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $trending_job->MainFunctionalArea->name }} , {{ $trending_job->SubFunctionalArea->name }}</div>
                                        @if($trending_job->job_description)
                                        <h5 class="fw-bold text-black">Job Description</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $trending_job->job_description ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($trending_job->job_requirement)
                                        <h5 class="fw-bold text-black">Job Requirement</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $trending_job->job_requirement ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($trending_job->benefit)
                                        <h5 class="fw-bold text-black">Job Benefit</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $trending_job->benefit ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($trending_job->job_highlight)
                                        <h5 class="fw-bold text-black">Job Highlight</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $trending_job->job_highlight ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="nav-company-profile-{{$trending_job->id}}" role="tabpanel" aria-labelledby="nav-company-profile-{{$trending_job->id}}-tab">
                                        <div class=" p-1 d-none d-lg-block">
                                            <div class="row py-3">
                                                <div class="col-2">
                                                    
                                                </div>
                                                <div class="col-10">
                                                    <h4 class="fw-bold text-black">{{ $trending_job->Employer->name }} @if($trending_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                </div>
                                            </div>
                                            <div class="card job-post-detail-company-profile mb-2">
                                                <div class="header">
                                                    <div class="row">
                                                        <div class="col-2 ">
                                                            @if($trending_job->Employer->logo)
                                                            <img src="{{ asset('storage/employer_logo/'.$trending_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $trending_job->Employer->name }}">
                                                            @else
                                                            <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $trending_job->Employer->name }}">
                                                            @endif
                                                        </div>
                                                        <div class="col-10 py-4">
                                                            <h5 class="fw-bold text-dark">Company Overview</h5>
                                                            @if($trending_job->Employer->summary)
                                                            <p class="mb-4">
                                                                {!! $trending_job->Employer->summary !!}
                                                            </p>
                                                            @endif
                                                            <h5 class="fw-bold text-dark">Specialties:</h5>
                                                            @if($trending_job->Employer->Industry->name)
                                                            <span class="mb-4 btn border seeker_image_input_label">
                                                                {{ $trending_job->Employer->Industry->name }}
                                                            </span>
                                                            @endif
                                                            @if($trending_job->Employer->website)
                                                            <h5 class="fw-bold text-dark">Company Website:</h5>
                                                            <p class="mb-4">
                                                                <a href="{{ $trending_job->Employer->website }}" target="_blank"><small><strong>{{ $trending_job->Employer->website }}</strong></small></a>
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
                                                        @if($trending_job->Employer->Industry->name)
                                                        <div class="col">
                                                            <h6 class="fw-bold text-dark">Industry Type</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $trending_job->Employer->Industry->name }}
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
                                                            {!! $trending_job->Employer->value ?? '-' !!}
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
                                                                @if($trending_job->Employer->logo)
                                                                <img src="{{ asset('storage/employer_logo/'.$trending_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $trending_job->Employer->name }}">
                                                                @else
                                                                <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $trending_job->Employer->name }}">
                                                                @endif
                                                            </div>
                                                            <h4 class="fw-bold text-black job-post-company-name">{{ $trending_job->Employer->name }} @if($trending_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                            <h5 class="fw-bold text-dark">Company Overview</h5>
                                                            @if($trending_job->Employer->summary)
                                                            <p class="mb-4">
                                                                {!! $trending_job->Employer->summary !!}
                                                            </p>
                                                            @endif
                                                            @if($trending_job->Employer->EmployerAddress->count() > 0)
                                                            <h5 class="fw-bold text-dark">Address:</h5>
                                                            <span class="mb-4 btn border seeker_image_input_label">
                                                                
                                                                    @if($trending_job->Employer->EmployerAddress->first()->address_detail)
                                                                    <p>{{ $trending_job->Employer->EmployerAddress->first()->address_detail }}</p>
                                                                    @else
                                                                    <p>@if($trending_job->Employer->EmployerAddress->first()->country == 'Myanmar') {{ $trending_job->Employer->EmployerAddress->first()->State->name ?? '' }}, @if($trending_job->Employer->EmployerAddress->first()->township_id) {{ $trending_job->Employer->EmployerAddress->first()->Township->name }}, @endif {{ $trending_job->Employer->EmployerAddress->first()->country }} @endif</p>
                                                                    @endif
                                                                
                                                            </span>
                                                            @endif
                                                            @if($trending_job->Employer->website)
                                                            <h5 class="fw-bold text-dark">Company Website:</h5>
                                                            <p class="mb-4">
                                                                <a href="{{ $trending_job->Employer->website }}" target="_blank"><small><strong>{{ $trending_job->Employer->website }}</strong></small></a>
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
                                                        @if($trending_job->Employer->Industry->name)
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">Industry Type</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $trending_job->Employer->Industry->name }}
                                                            </p>
                                                        </div>
                                                        @endif
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">Company Size:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $trending_job->Employer->no_of_employees ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">No of Office:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $trending_job->Employer->no_of_offices ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <h5 class="fw-bold text-dark">Vision, Mission, Value</h5>
                                                        <p class="mb-4">
                                                            {!! $trending_job->Employer->value ?? '-' !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('company-jobs', $trending_job->Employer->id) }}" class="btn btn-sm text-white" style="background-color: #0355d0;">See more jobs from this company</a>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success copyText" onclick="copyText('{{ route('jobpost-detail', $trending_job->slug) }}')" data-bs-toggle="tooltip" title="Copied"><i class="fa-solid fa-copy"></i> Copy to Clipboard</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @auth('seeker')
                            <a href="{{ route('jobpost-apply', $trending_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                            </a>
                        @elseauth('employer')
                        @else
                            <a href="{{ route('jobpost-apply', $trending_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
<!-- Trending Jobs End  -->

<!-- Featured Jobs Start  -->
@if($feature_jobs->count() > 0)
<div class="container bg-white">
    <div class="popular-job-category">
        <div id="header-popular-job-category" class="text-center pt-3">
            <h3 id="popular-job-category-title">Featured Jobs</h3>
        </div>

        <div class="row bg-white">
            <div class="col-12 p-0 bg-white">
                <div class="owl-slider py-3">
                    <div class="row col-12 m-0">
                        <div id="multiple-carousel" class="owl-carousel">
                            @foreach($feature_jobs as $feature_job)
                            <a data-bs-toggle="modal" data-bs-target="#FeatureJobPostModal{{$feature_job->id}}">
                                <div class="item d-flex justify-content-center">
                                    <div class="row px-3 align-items-center h-100">
                                        <div class="col-3">
                                            @if($feature_job->Employer->logo)
                                            <img src="{{ asset('storage/employer_logo/'.$feature_job->Employer->logo) }}" alt="{{ $feature_job->Employer->name }}" class="w-100 rounded-circle border" >
                                            @else 
                                            <img src="{{ asset('img/profile.svg') }}" alt="{{ $feature_job->Employer->name }}" class="w-100 rounded-circle border" >
                                            @endif
                                        </div>
                                        <div class="col-9 p-0 pt-3">
                                            <h3 class="fz15 text-truncate" id="trending-job-title">{{ $feature_job->job_title }}</h3>
                                            <span id="trending-job-sub-title">{{ $feature_job->Employer->name }} @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$feature_job->id)->count() > 0) <span class="badge badge-info"> Applied </span>@endif @endauth</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($feature_jobs as $feature_job)
<!-- Modal -->
<div class="modal fade" id="FeatureJobPostModal{{$feature_job->id}}" tabindex="-1" aria-labelledby="FeatureJobPostModal{{$feature_job->id}}Label" aria-hidden="true">
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
                                @if($feature_job->Employer->logo)
                                <img src="{{ asset('storage/employer_logo/'.$feature_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $feature_job->Employer->name }}">
                                @else
                                <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $feature_job->Employer->name }}">
                                @endif
                                <div class="align-self-center">
                                    <span class="h4 fw-bold">{{ $feature_job->job_title }} @if($feature_job->no_of_candidate) ( {{ $feature_job->no_of_candidate }} - Posts ) @endif</span>
                                    <div><a class="text-muted h6" href="{{ route('company-detail',$feature_job->Employer->slug ?? '') }}">{{ $feature_job->Employer->name }} @if($feature_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</a></div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-xl-5 mb-2 align-self-center">
                                <div>
                                    <span>{{ $feature_job->job_type }} @if($feature_job->country == 'Myanmar') | {{ $feature_job->State->name ?? '' }}, {{ $feature_job->Township->name ?? '' }} @endif {{ $feature_job->gender }}</span>
                                </div>
                                <div>
                                    <span class="text-muted">Salary Range:</span>
                                    <span class="h5 fw-bold">@if($feature_job->hide_salary == 1) Negotiate @else {{ $feature_job->salary_range }} {{ $feature_job->currency }} @endif</span>
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
                                        if($seeker_job->job_post_id == $feature_job->id){
                                            $disabled = 'disabled';
                                            $btn_text = 'Applied';
                                        }
                                    }
                                    @endphp
                                @endauth
                                @auth('seeker')
                                    <a href="{{ route('jobpost-apply', $feature_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                        <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                    </a>
                                @elseauth('employer')
                                @else
                                    <a href="{{ route('jobpost-apply', $feature_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                        <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                    </a>
                                @endguest
                                    <div>
                                        <small>Posted {{ $feature_job->updated_at->shortRelativeDiffForHumans() }}</small>
                                    </div>
                            </div>
                        </div>  
                    </div>
                    <div class="card-body p-0">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="p-md-3 p-2 job-post-detail nav-link active" id="nav-job-description-{{$feature_job->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-job-description-{{$feature_job->id}}" type="button" role="tab" aria-controls="nav-job-description-{{$feature_job->id}}" aria-selected="true">Job Description</button>
                                @if($feature_job->hide_company != 1)
                                <button class="p-md-3 p-2 job-post-detail nav-link" id="nav-company-profile-{{$feature_job->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-company-profile-{{$feature_job->id}}" type="button" role="tab" aria-controls="nav-company-profile-{{$feature_job->id}}" aria-selected="false">Company Profile</button>
                                @endif
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane p-3 fade show active" id="nav-job-description-{{$feature_job->id}}" role="tabpanel" aria-labelledby="nav-job-description-{{$feature_job->id}}-tab">
                                @if($feature_job->JobPostSkill->count() > 0)
                                <h5 class="fw-bold text-black">Skills</h5>
                                <div class="badge-group mb-3">
                                    @foreach($feature_job->JobPostSkill as $feature_jobSkill)
                                    <span class="my-1 badge text-white fz14 rounede-3 py-2 px-3" style="background: #0355d0">{{ $feature_jobSkill->Skill->name }}</span>
                                    @endforeach
                                </div>
                                @endif
                                <h5 class="fw-bold text-black">Experience Level :</h5>
                                <div class="mb-4 fz14 fw-bold">{{ $feature_job->experience_level }}</div>
                                <h5 class="fw-bold text-black">Qualification :</h5>
                                <div class="mb-4 fz14 fw-bold">{{ $feature_job->degree }}</div>
                                <h5 class="fw-bold text-black">Job Specializations :</h5>
                                <div class="mb-4 fz14 fw-bold">{{ $feature_job->MainFunctionalArea->name }} , {{ $feature_job->SubFunctionalArea->name }}</div>
                                @if($feature_job->job_description)
                                <h5 class="fw-bold text-black">Job Description</h5>
                                <div class="mb-4">
                                    <p class="fz15">
                                        {!! $feature_job->job_description ?? '-' !!}
                                    </p>
                                </div>
                                @endif
                                @if($feature_job->job_requirement)
                                <h5 class="fw-bold text-black">Job Requirement</h5>
                                <div class="mb-4">
                                    <p class="fz15">
                                        {!! $feature_job->job_requirement ?? '-' !!}
                                    </p>
                                </div>
                                @endif
                                @if($feature_job->benefit)
                                <h5 class="fw-bold text-black">Job Benefit</h5>
                                <div class="mb-4">
                                    <p class="fz15">
                                        {!! $feature_job->benefit ?? '-' !!}
                                    </p>
                                </div>
                                @endif
                                @if($feature_job->job_highlight)
                                <h5 class="fw-bold text-black">Job Highlight</h5>
                                <div class="mb-4">
                                    <p class="fz15">
                                        {!! $feature_job->job_highlight ?? '-' !!}
                                    </p>
                                </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="nav-company-profile-{{$feature_job->id}}" role="tabpanel" aria-labelledby="nav-company-profile-{{$feature_job->id}}-tab">
                                <div class=" p-1 d-none d-lg-block">
                                    <div class="row py-3">
                                        <div class="col-2">
                                            
                                        </div>
                                        <div class="col-10">
                                            <h4 class="fw-bold text-black">{{ $feature_job->Employer->name }} @if($feature_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                        </div>
                                    </div>
                                    <div class="card job-post-detail-company-profile mb-2">
                                        <div class="header">
                                            <div class="row">
                                                <div class="col-2 ">
                                                    @if($feature_job->Employer->logo)
                                                    <img src="{{ asset('storage/employer_logo/'.$feature_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $feature_job->Employer->name }}">
                                                    @else
                                                    <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $feature_job->Employer->name }}">
                                                    @endif
                                                </div>
                                                <div class="col-10 py-4">
                                                    <h5 class="fw-bold text-dark">Company Overview</h5>
                                                    @if($feature_job->Employer->summary)
                                                    <p class="mb-4">
                                                        {!! $feature_job->Employer->summary !!}
                                                    </p>
                                                    @endif
                                                    <h5 class="fw-bold text-dark">Specialties:</h5>
                                                    @if($feature_job->Employer->Industry->name)
                                                    <span class="mb-4 btn border seeker_image_input_label">
                                                        {{ $feature_job->Employer->Industry->name }}
                                                    </span>
                                                    @endif
                                                    @if($feature_job->Employer->website)
                                                    <h5 class="fw-bold text-dark">Company Website:</h5>
                                                    <p class="mb-4">
                                                        <a href="{{ $feature_job->Employer->website }}" target="_blank"><small><strong>{{ $feature_job->Employer->website }}</strong></small></a>
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
                                                @if($feature_job->Employer->Industry->name)
                                                <div class="col">
                                                    <h6 class="fw-bold text-dark">Industry Type</h6>
                                                    <p class="mb-4 btn border seeker_image_input_label w-100">
                                                        {{ $feature_job->Employer->Industry->name }}
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
                                                    {!! $feature_job->Employer->value ?? '-' !!}
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
                                                        @if($feature_job->Employer->logo)
                                                        <img src="{{ asset('storage/employer_logo/'.$feature_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $feature_job->Employer->name }}">
                                                        @else
                                                        <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $feature_job->Employer->name }}">
                                                        @endif
                                                    </div>
                                                    <h4 class="fw-bold text-black job-post-company-name">{{ $feature_job->Employer->name }} @if($feature_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                    <h5 class="fw-bold text-dark">Company Overview</h5>
                                                    @if($feature_job->Employer->summary)
                                                    <p class="mb-4">
                                                        {!! $feature_job->Employer->summary !!}
                                                    </p>
                                                    @endif
                                                    @if($feature_job->Employer->EmployerAddress->count() > 0)
                                                    <h5 class="fw-bold text-dark">Address:</h5>
                                                    <span class="mb-4 btn border seeker_image_input_label">
                                                        
                                                            @if($feature_job->Employer->EmployerAddress->first()->address_detail)
                                                            <p>{{ $feature_job->Employer->EmployerAddress->first()->address_detail }}</p>
                                                            @else
                                                            <p>@if($feature_job->Employer->EmployerAddress->first()->country == 'Myanmar') {{ $feature_job->Employer->EmployerAddress->first()->State->name ?? '' }}, @if($feature_job->Employer->EmployerAddress->first()->township_id) {{ $feature_job->Employer->EmployerAddress->first()->Township->name }}, @endif {{ $feature_job->Employer->EmployerAddress->first()->country }} @endif</p>
                                                            @endif
                                                        
                                                    </span>
                                                    @endif
                                                    @if($feature_job->Employer->website)
                                                    <h5 class="fw-bold text-dark">Company Website:</h5>
                                                    <p class="mb-4">
                                                        <a href="{{ $feature_job->Employer->website }}" target="_blank"><small><strong>{{ $feature_job->Employer->website }}</strong></small></a>
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
                                                @if($feature_job->Employer->Industry->name)
                                                <div class="col-12 col-lg-4">
                                                    <h6 class="fw-bold text-dark">Industry Type</h6>
                                                    <p class="mb-4 btn border seeker_image_input_label w-100">
                                                        {{ $feature_job->Employer->Industry->name }}
                                                    </p>
                                                </div>
                                                @endif
                                                <div class="col-12 col-lg-4">
                                                    <h6 class="fw-bold text-dark">Company Size:</h6>
                                                    <p class="mb-4 btn border seeker_image_input_label w-100">
                                                        {{ $feature_job->Employer->no_of_employees ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <h6 class="fw-bold text-dark">No of Office:</h6>
                                                    <p class="mb-4 btn border seeker_image_input_label w-100">
                                                        {{ $feature_job->Employer->no_of_offices ?? '-' }}
                                                    </p>
                                                </div>
                                                <h5 class="fw-bold text-dark">Vision, Mission, Value</h5>
                                                <p class="mb-4">
                                                    {!! $feature_job->Employer->value ?? '-' !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('company-jobs', $feature_job->Employer->id) }}" class="btn btn-sm text-white" style="background-color: #0355d0;">See more jobs from this company</a>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @auth('seeker')
                    <a href="{{ route('jobpost-apply', $feature_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                        <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                    </a>
                @elseauth('employer')
                @else
                    <a href="{{ route('jobpost-apply', $feature_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                        <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
{{-- <div class="container">
    <div class="row">
        <div class="col-md-3 ps-0 pe-3 pb-3">          
            <div class="gradient-img">
                <img src="{{ asset('frontend/img/featured/bg-image.jpg') }}" class="img-responsive w-100">
            </div>
            <div class="gradient-text">
                <span class="ps-3 pt-3">For Employers</span>
            </div>      
        </div>

        <div class="col-md-3 ps-0 pe-3 pb-3">          
            <div class="gradient-img">
                <img src="{{ asset('frontend/img/featured/bg-image.jpg') }}" class="img-responsive w-100">
            </div>
            <div class="gradient-text">
                <span class="ps-3 pt-3">For Jobseekers</span>
            </div>      
        </div>

        <div class="col-md-3 ps-0 pe-3 pb-3">          
            <div class="gradient-img">
                <img src="{{ asset('frontend/img/featured/bg-image.jpg') }}" class="img-responsive w-100">
            </div>
            <div class="gradient-text">
                <span class="ps-3 pt-3">For Jobseekers</span>
            </div>      
        </div>

        <div class="col-md-3 ps-0 pe-3 pb-3">          
            <div class="gradient-img">
                <img src="{{ asset('frontend/img/featured/bg-image.jpg') }}" class="img-responsive w-100">
            </div>
            <div class="gradient-text">
                <span class="ps-3 pt-3">For Jobseekers</span>
            </div>      
        </div>
 </div>
</div> --}}
<!-- Featured Jobs End  -->

<!-- Job Interview Start -->
<div class="container mt-5 p-0">
    <div class="row d-flex align-items-end" id="">
        <div class="col-md-6 col-12 p-5 text-center border-end">
            <h1 style="color: #FB5404">Jobseeker</h1>
            <h5>Ready to apply? It is easy now!</h5>
            <img src="{{ asset('img/background/jobseeker_signup.png') }}" class="img-fluid my-3" alt="">
            <div>
            <a href="{{ route('register-form') }}" class="btn text-white" style="background: #FB5404">Sign up here</a>
            </div>
        </div>
        <div class="col-md-6 col-12 p-5 text-center">
            <h1>Employer</h1>
            <h5>Ready to hire? It is easy now!</h5>
            <img src="{{ asset('img/background/employer_signup.png') }}" class="img-fluid my-3" alt="">
            <div>
            <a href="{{ route('employer-register-form') }}" class="btn text-white" style="background: #091E3E">Sign up here</a>
            </div>
        </div>
    </div>
</div>
<!-- Job Interview End -->

<!-- Additional Services Start  -->
<div class="container">
    <div class="additional-service">
        <div id="header-additional-service" class="text-center pt-5 pb-3">
            <h3 id="additional-service-title">Additional Services</h3>
        </div>
        <div id="body-additional-service" class="row mb-5">
            <div class="col-lg-4 col-md-4 px-2 py-0">
                <div id="additional-service-box" class="text-center p-0">
                    <div id="additional-service-icon" class="p-0">
                        <i class="fa-solid fa-people-line"></i>
                    </div>

                    <div id="additional-service-name">
                        <h4>{{ 'Executive Search End-to-End Service' }}</h4>
                    </div>

                    <div id="additional-service-content">
                        <p class="">Our main goal is to consistently improve the way we provide services, making sure we offer exceptional service to our valued clients</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 px-2 py-0">
                <div id="additional-service-box" class="text-center p-0">
                    <div id="additional-service-icon" class="p-0">
                        <i class="fa-solid fa-people-roof"></i>
                    </div>

                    <div id="additional-service-name">
                        <h4>{{ 'HRMS' }}</h4>
                    </div>

                    <div id="additional-service-content">
                        <p>A human resources management system is a form of human resources software that combines a number of systems and processes to ensure the easy management of human resources, business processes and data.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 px-2 py-0">
                <div id="additional-service-box" class="text-center p-0">
                    <div id="additional-service-icon" class="p-0">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>

                    <div id="additional-service-name">
                        <h4>{{ 'ERP SYSTEM' }}</h4>
                    </div>

                    <div id="additional-service-content">
                        <p>Enterprise resource planning (ERP) is the integrated management of core business processes, often in real-time and mediated by software and technology.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Additional Services End  -->

<!-- Explore the Marketplace Start  -->
{{--<div class="container">
    <div class="explore-marketplace">
        <div id="header-explore-marketplace" class="text-center py-5">
            <h3 id="explore-marketplace-title">Explore the Marketplace Today!</h3>
        </div>

        <div id="body-explore-marketplace" class="row py-3">
            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <a href="{{ route('job-categories') }}">
                    <div id="explore-marketplace-box" class="text-center">
                        <div class="explore-marketplace-icon pt-4">
                            <i class="fa-solid fa-building-columns bg-white rounded-circle p-3"></i>
                        </div>

                        <div class="explore-marketplace-title pt-1">
                            <span class="text-white">Banking</span>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <a href="{{ route('job-categories') }}">
                    <div id="explore-marketplace-box" class="text-center">
                        <div class="explore-marketplace-icon pt-4">
                            <i class="fa-solid fa-display bg-white rounded-circle p-3"></i>
                        </div>

                        <div class="explore-marketplace-title pt-1">
                            <span class="text-white">Computer</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <a href="{{ route('job-categories') }}">
                    <div id="explore-marketplace-box" class="text-center">
                        <div class="explore-marketplace-icon pt-4">
                            <i class="fa-solid fa-graduation-cap bg-white rounded-circle p-3"></i>
                        </div>

                        <div class="explore-marketplace-title pt-1">
                            <span class="text-white">Education</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <a href="{{ route('job-categories') }}">
                    <div id="explore-marketplace-box" class="text-center">
                        <div class="explore-marketplace-icon pt-4">
                            <i class="fa-solid fa-martini-glass-citrus bg-white rounded-circle p-3"></i>
                        </div>

                        <div class="explore-marketplace-title pt-1">
                            <span class="text-white">Food</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <a href="{{ route('job-categories') }}">
                    <div id="explore-marketplace-box" class="text-center">
                        <div class="explore-marketplace-icon pt-4">
                            <i class="fa-solid fa-pen-to-square bg-white rounded-circle p-3"></i>
                        </div>

                        <div class="explore-marketplace-title pt-1">
                            <span class="text-white">Writing</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <a href="{{ route('job-categories') }}">
                    <div id="explore-marketplace-box" class="text-center">
                        <div class="explore-marketplace-icon pt-4">
                            <i class="fa-solid fa-wifi bg-white rounded-circle p-3"></i>
                        </div>

                        <div class="explore-marketplace-title pt-1">
                            <span class="text-white">Wifi</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>--}}
<!-- Explore the Marketplace End  -->

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.copyText').tooltip('hide');
        $('#function-area').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            includeSelectAllOption: true,
            nonSelectedText: "Select function area",
            numberDisplayed: 1
        });

        $('#multiple-carousel').owlCarousel({
            margin: 20,
            dots:false,
            loop: true,
            autoplay: false,
            autoplayTimeout:700,
            slideSpeed : 200,
            nav : true,
            responsiveClass:true,
            autoHeight: true,
            smartSpeed: 800,
            responsive: {
                0: {
                items: 1
                },

                600: {
                items: 2
                },

                1024: {
                items: 3
                },

                1366: {
                items: 4
                }
            }
        });

        const suggestionList = @json($jobPostName);
        const inputField = document.querySelector(".job-title");
        const autocompleteBox = document.querySelector('.autocomplete');
        inputField.addEventListener('keyup', () => {
            autocompleteBox.classList.add('shown');
        });
        inputField.addEventListener('focusout', () => {
            autocompleteBox.classList.remove('shown');
        });

        const optionClick = (event) => {
            inputField.value = event.target.innerText;
        }
        inputField.addEventListener('keyup', () => {

            const available = suggestionList.filter((suggest) => (suggest.toLowerCase().indexOf(inputField.value) !== -1));

            autocompleteBox.innerHTML = ''
            if(available.length > 0) {
                available.forEach((item) => {
                    const li = document.createElement('li');
                    
                    li.classList.add('autocomplete-suggestion');
                    
                    li.onclick = optionClick;
                    li.innerText = item;
                    autocompleteBox.appendChild(li);
                })
            }else {
                autocompleteBox.classList.remove('shown');
            }
        })
    });
    function copyText(link)
    {
        navigator.clipboard.writeText(link);
        $('.copyText').tooltip('show');
    }
</script>
@endpush