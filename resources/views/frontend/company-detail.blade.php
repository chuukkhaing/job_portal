@extends('frontend.layouts.app')
@section('content')

<!-- Banner Start -->
@if($employer->background)
<div class="container-fluid p-0">
    <div class="company-detail-banner">
        <img src="{{ asset('storage/employer_background/'. $employer->background) }}" style="width: 100%; max-height: 510px" alt="{{ $employer->name }}">
    </div>
</div>
@endif
<!-- Banner End -->

<!-- Company Profile Start -->
<div class="container company-profile my-5">
    <div class="row pt-3 px-3">
        <div class="col-lg-6 col-md-6 col-6">
            @if($employer->logo)
            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" class="company-detail-logo" style="background: #ffffff; width: 100px; height: 100px; border-radius: 8px" alt="{{ $employer->name }}">
            @else
            <img src="{{ asset('img/icon/company.png') }}" class="company-detail-logo" style="background: #ffffff; width: 100px; height: 100px; border-radius: 8px" alt="{{ $employer->name }}">
            @endif
        </div>

        {{--<div class="col-lg-6 col-md-6 col-6">
            @if($employer->qr)
            <img src="{{ asset('storage/employer_qr/'.$employer->qr) }}" class="profile-qr pull-right mt-2" alt="{{ $employer->name }}">
            @else
            <img src="{{ asset('frontend/img/company/qr-image.png') }}" class="profile-qr pull-right mt-2" alt="{{ $employer->name }}">
            @endif
        </div>--}}
    </div>

    <div class="row px-3">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="company-name pt-4 pb-2">
                <h3>{{ $employer->name }} @if($employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h3>
            </div>

            <div class="company-address">
                @if($employer->EmployerAddress->count() > 0)
                @foreach($employer->EmployerAddress as $address)
                @if($address->address_detail)
                <p>{{ $address->address_detail }}</p>
                @else
                <p>@if($address->country == 'Myanmar') {{ $address->State->name ?? '' }}, @if($address->township_id) {{ $address->Township->name }}, @endif {{ $address->country ?? '' }} @endif</p>
                @endif
                @endforeach
                @endif
            </div>
        </div>

        {{--<div class="col-lg-6 col-md-6 col-12">
            <div class="float-end mt-4">
                <a href="http://" class="btn btn-outline-primary mt-2">
                    <i class="fa fa-heart-o p-1"></i><span class="p-1">Add to Favourite</span>
                </a>
                <a href="http://" class="btn see-all-btn mt-2">
                    <i class="fa-regular fa-envelope"></i> <span class="p-1">Send Message</span>
                </a>
            </div>
        </div>--}}
    </div>

    <div class="row pb-3 pt-4">
        <div class="col-lg-4 col-md-6 py-3 bdr2 company-profile-deatil">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-3 p-0">
                    <img src="{{ asset('frontend/img/company/industry.png') }}" class="pull-right" alt="">
                </div>    
                <div class="col-lg-9 col-md-9 col-9">
                    <h3>Industry</h3>
                    <p>{{ $employer->Industry->name ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 py-3 bdr2 company-profile-deatil">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-3 p-0">
                    <img src="{{ asset('frontend/img/company/employee.png') }}" class="pull-right" alt="">
                </div>    
                <div class="col-lg-9 col-md-9 col-9">
                    <h3>No Employees</h3>
                    <p>{{ $employer->no_of_employees ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 py-3 company-profile-deatil">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-3 p-0">
                    <img src="{{ asset('frontend/img/company/apartment.png') }}" class="pull-right" alt="">
                </div>    
                <div class="col-lg-9 col-md-9 col-9">
                    <h3>No Offices</h3>
                    <p>{{ $employer->no_of_offices ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Company Profile End -->

<!-- Vision, Mission and Value Start -->
@if($employer->value)
<div class="container my-3">
    <div class="row py-3">
        <div class="about-company-header py-3">
            <h3 class="about-company-title mt-3">Vision, Mission, Value</h3>
        </div>
    </div>

    <div class="row py-3">
        <div class="col-lg-12 about-company">
            <p>
                {!! $employer->value !!}
            </p>
        </div>
    </div>
</div>
@endif

    {{--<div class="row py-2">
        <div class="col-lg-12 company-vision">
            <h3 class="vision-title">
                Mission
            </h3>
            
            <p>
                In its bid to constantly improve its operational efficiency and ability to deliver value to its clients and stakeholders, Riverbank Group has made strategic investments to expand its infrastructure. This enables them to deliver storage solution to its clients as well as providing a wide-range of services such as drumming, blending and contract manufacturing.
            </p>
        </div>
    </div>

    <div class="row py-2">
        <div class="col-lg-12 company-vision">
            <h3 class="vision-title">
                Value
            </h3>
            
            <p>
                {{ $employer->value ?? '-' }}
            </p>
        </div>
    </div>--}}

    {{--<div class="row py-3">
        <div class="col-lg-12">
            <div class="pull-right">
                <div class="bg-light d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/twitter.png') }}" alt="" width='32px' height='32px'></a>
                </div>
                <div class="bg-light d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/facebook.png') }}" alt="" width='32px' height='32px'></a>
                </div>
                <div class="bg-light d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/icon_Linkedin.png') }}" alt="" width='32px' height='32px'></a>
                </div>
                <div class="bg-light d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/icon_Google.png') }}" alt="" width='32px' height='32px'></a>
                </div>
            </div>
        </div>
    </div>--}}
<!-- Vision, Mission and Value End -->

<!-- About Company Start -->
@if($employer->summary)
<div class="container my-3">
    <div class="row py-3">
        <div class="about-company-header py-3">
            <h3 class="about-company-title mt-3">About Company</h3>
        </div>
    </div>

    <div class="row py-3">
        <div class="col-lg-12 about-company">
            <p>
                {!! $employer->summary !!}
            </p>
        </div>
    </div>
</div>
@endif
<!-- About Company End -->

<div class="container my-3">
    <div class="row">
        <!-- Company Video Start -->
        @if($employer->EmployerMedia->where('type','Video Link')->count() > 0)
        <div class="col-6 pe-5">
            <div class="row py-3">
                <div class="about-company-header py-3">
                    <h3 class="about-company-title mt-3">Company Video</h3>
                </div>
            </div>

            <div class="row pb-3">
                {{--<iframe width="420" height="315"
                    src="{{ $employer->EmployerMedia->where('type','Video Link')->first()->name }}">
                </iframe>--}}
                <iframe id="myIframe" width="560" height="315" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        @endif
        <!-- Company Video End -->

        <!-- Company Photo Start -->
        @if($employer->EmployerMedia->where('type','Image')->count() > 0)
        <div class="col-6 ps-5">
            <div class="row py-3">
                <div class="about-company-header py-3">
                    <h3 class="about-company-title mt-3">Company Photos</h3>
                </div>
            </div>

            <div class="row pb-3">
                {{--@foreach($employer->EmployerMedia->where('type','Image') as $image)
                <div class="col-lg-3 col-md-3 p-0 company-photo">
                    <img src="{{ asset('storage/employer_media/'.$image->name) }}" class="w-100 py-1 pe-2" height="200px" alt="">
                </div>
                @endforeach--}}
                <div class="container py-5">
                    <div class="row">
                        <!--Ik gebruik hieronder alleen het middiv omdat dat de enige info is die ik wil vervangen-->
                        <div class="col-md-12" id="middiv" style="background-color: rgba(255, 255, 255, 0.1)">
                            <div id="companyCarousel" class="carousel slide" data-ride="carousel" align="center">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    @foreach($employer->EmployerMedia->where('type','Image') as $image)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ asset('storage/employer_media/'.$image->name) }}" alt="{{ $employer->name }}" style="width:80%;">
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Left and right controls -->
                                <a class="carousel-control-prev" href="#companyCarousel" data-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </a>
                                <a class="carousel-control-next" href="#companyCarousel" data-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </a>

                                <!-- Indicators -->
                                <ol class="carousel-indicators list-inline">
                                    @foreach($employer->EmployerMedia->where('type','Image') as $key => $image)
                                    <li class="list-inline-item {{ $loop->first ? 'active' : '' }}">
                                        <a id="carousel-selector-0" class="selected" data-slide-to="{{ $key }}" data-target="#companyCarousel">
                                            <img src="{{ asset('storage/employer_media/'.$image->name) }}" class="img-fluid">
                                        </a>
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Company Photo End -->
    </div>
</div>

<!-- Job Openings Start -->
@if($jobPosts->count() > 0)
<div class="container my-3">
    <div class="row py-3">
        <div class="about-company-header py-3">
            <h3 class="about-company-title mt-3">Job Openings</h3>
        </div>
    </div>

    <div class="row" style="">
        @foreach($jobPosts as $jobPost)
        <!-- Button trigger modal -->
        <div  data-bs-toggle="modal" class="jobpostModal" data-bs-target="#JobPostModal{{$jobPost->id}}">
            <div class="col-lg-12 col-12 pb-2">
                <div class="row job-opening me-1 p-2 h-100">
                    <div class="col-lg-9 col-md-9 p-0">
                        <div class="row col-12 m-0 p-0">
                            <div class="col-lg-2 col-md-3 col-4 align-self-center">
                                @if(($jobPost->job_post_type == 'feature' || $jobPost->job_post_type == 'trending') && $employer->logo && $jobPost->hide_company == 0)
                                <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Profile Image" class="mb-2 img-responsive center-block d-block mx-auto" style="" id="ProfilePreview">
                                @else 
                                <img src="{{ asset('img/icon/job-post.png') }}" alt="Profile Image" class="mb-2 img-responsive center-block d-block mx-auto" style="" id="ProfilePreview">
                                @endif
                                <div class="text-center">
                                @if($jobPost->job_post_type == 'feature')<span class="badge badge-pill job-post-badge" style="background: #0355D0"> Featured @elseif($jobPost->job_post_type == 'trending') <span class="badge badge-pill job-post-badge" style="background: #FB5404"> Trending @endif</span>
                                </div>
                                
                            </div>

                            <div class="col-lg-10 col-md-9 col-8 align-self-center">
                                <div class="mt-1 job-company">@if($jobPost->hide_company == 0) {{ $employer->name }} @if($employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif @endif @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$jobPost->id)->count() > 0) <span class="badge badge-info"> Applied </span> @endif @endauth</div>
                                <div class="mt-1">{{ $jobPost->job_title }}</div>
                                @if($jobPost->township_id)
                                <div class="mt-1 job-location">{{ $jobPost->Township->name }}</div>
                                @endif
                                @if($jobPost->job_post_type == 'trending')
                                <p class="job-post-preview">{!! \Illuminate\Support\Str::limit(strip_tags($jobPost->job_requirement), $limit = 100, $end = '...') !!}</p>
                                @endif
                                <div class="mt-1 ">
                                    <a href="{{ route('search-main-function', $jobPost->main_functional_area_id) }}" class="mt-1 job-post-area"># {{ $jobPost->MainFunctionalArea->name }}</a>
                                    <div class="mt-auto p-1 d-md-none d-flex justify-content-between">
                                        
                                        <div>{{ $jobPost->updated_at->shortRelativeDiffForHumans() }}</div>
                                        <div class="text-end"><a href="{{ route('jobpost-detail', $jobPost->slug) }}" class="text-decoration-none fw-bold">View...</a></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-3 d-md-flex d-none align-items-end flex-column bd-highlight p-0">
                        <div class="row col-12 m-0 p-0">
                            {{--<div class="text-end p-0">
                                <a href="{{ route('jobpost-detail', $jobPost->slug) }}" class="btn view-detail-btn p-0">View Details</a>
                            </div>--}}

                            <div class="text-end mt-auto p-1 ">
                                <span>{{ $jobPost->updated_at->shortRelativeDiffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="JobPostModal{{$jobPost->id}}" tabindex="-1" aria-labelledby="JobPostModal{{$jobPost->id}}Label" aria-hidden="true">
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
                                        @if($jobPost->Employer->logo && $jobPost->hide_comopany == 0)
                                        <img src="{{ asset('storage/employer_logo/'.$jobPost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobPost->Employer->name }}">
                                        @else
                                        <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="Employer Profile">
                                        @endif
                                        <div class="align-self-center">
                                            <span class="h4 fw-bold">{{ $jobPost->job_title }} @if($jobPost->no_of_candidate) ( {{ $jobPost->no_of_candidate }} - Posts ) @endif</span>
                                            @if($jobPost->hide_comopany == 0)
                                            <div><a class="text-muted h6" href="{{ route('company-detail',$jobPost->Employer->slug ?? '') }}">{{ $jobPost->Employer->name }} @if($jobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</a></div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 col-xl-5 mb-2 align-self-center">
                                        <div>
                                            <span>{{ $jobPost->job_type }} @if($jobPost->country == 'Myanmar') | {{ $jobPost->State->name ?? '' }}, {{ $jobPost->Township->name ?? '' }} @endif {{ $jobPost->gender }}</span>
                                        </div>
                                        <div>
                                            <span class="text-muted">Salary Range:</span>
                                            <span class="h5 fw-bold">@if($jobPost->hide_salary == 1) Negotiate @else {{ $jobPost->salary_range }} {{ $jobPost->currency }} @endif</span>
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
                                                if($seeker_job->job_post_id == $jobPost->id){
                                                    $disabled = 'disabled';
                                                    $btn_text = 'Applied';
                                                }
                                            }
                                            @endphp
                                        @endauth
                                        @auth('seeker')
                                            <a href="{{ route('jobpost-apply', $jobPost->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3" onclick="applyJob({{ $jobPost->id }})">
                                                <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                            </a>
                                        @elseauth('employer')
                                        @else
                                            <a href="{{ route('jobpost-apply', $jobPost->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3" onclick="applyJob({{ $jobPost->id }})">
                                                <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                            </a>
                                        @endguest
                                            <div>
                                                <small>Posted {{ $jobPost->updated_at->shortRelativeDiffForHumans() }}</small>
                                            </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="card-body p-0">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="p-md-3 p-2 job-post-detail nav-link active" id="nav-job-description-{{$jobPost->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-job-description-{{$jobPost->id}}" type="button" role="tab" aria-controls="nav-job-description-{{$jobPost->id}}" aria-selected="true">Job Description</button>
                                        @if($jobPost->hide_company != 1)
                                        <button class="p-md-3 p-2 job-post-detail nav-link" id="nav-company-profile-{{$jobPost->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-company-profile-{{$jobPost->id}}" type="button" role="tab" aria-controls="nav-company-profile-{{$jobPost->id}}" aria-selected="false">Company Profile</button>
                                        @endif
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane p-3 fade show active" id="nav-job-description-{{$jobPost->id}}" role="tabpanel" aria-labelledby="nav-job-description-{{$jobPost->id}}-tab">
                                        @if($jobPost->JobPostSkill->count() > 0)
                                        <h5 class="fw-bold text-black">Skills</h5>
                                        <div class="badge-group mb-3">
                                            @foreach($jobPost->JobPostSkill as $jobPostSkill)
                                            <span class="my-1 badge text-white fz14 rounede-3 py-2 px-3 text-wrap" style="background: #0355d0">{{ $jobPostSkill->Skill->name }}</span>
                                            @endforeach
                                        </div>
                                        @endif
                                        <h5 class="fw-bold text-black">Experience Level :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $jobPost->experience_level }}</div>
                                        <h5 class="fw-bold text-black">Qualification :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $jobPost->degree }}</div>
                                        <h5 class="fw-bold text-black">Job Specializations :</h5>
                                        <div class="mb-4 fz14 fw-bold">{{ $jobPost->MainFunctionalArea->name }} , {{ $jobPost->SubFunctionalArea->name }}</div>
                                        @if($jobPost->job_description)
                                        <h5 class="fw-bold text-black">Job Description</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobPost->job_description ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($jobPost->job_requirement)
                                        <h5 class="fw-bold text-black">Job Requirement</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobPost->job_requirement ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($jobPost->benefit)
                                        <h5 class="fw-bold text-black">Job Benefit</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobPost->benefit ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                        @if($jobPost->job_highlight)
                                        <h5 class="fw-bold text-black">Job Highlight</h5>
                                        <div class="mb-4">
                                            <p class="fz15">
                                                {!! $jobPost->job_highlight ?? '-' !!}
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="nav-company-profile-{{$jobPost->id}}" role="tabpanel" aria-labelledby="nav-company-profile-{{$jobPost->id}}-tab">
                                        <div class=" p-1 d-none d-lg-block">
                                            <div class="row py-3">
                                                <div class="col-2">
                                                    
                                                </div>
                                                @if($jobPost->hide_comopany == 0)
                                                <div class="col-10">
                                                    <h4 class="fw-bold text-black">{{ $jobPost->Employer->name }} @if($jobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="card job-post-detail-company-profile mb-2">
                                                <div class="header">
                                                    <div class="row">
                                                        <div class="col-2 ">
                                                            @if($jobPost->Employer->logo && $jobPost->hide_comopany == 0)
                                                            <img src="{{ asset('storage/employer_logo/'.$jobPost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $jobPost->Employer->name }}">
                                                            @else
                                                            <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="Employer Profile">
                                                            @endif
                                                        </div>
                                                        <div class="col-10 py-4">
                                                            <h5 class="fw-bold text-dark">Company Overview</h5>
                                                            @if($jobPost->Employer->summary)
                                                            <p class="mb-4">
                                                                {!! $jobPost->Employer->summary !!}
                                                            </p>
                                                            @endif
                                                            <h5 class="fw-bold text-dark">Specialties:</h5>
                                                            @if($jobPost->Employer->Industry->name)
                                                            <span class="mb-4 btn border seeker_image_input_label">
                                                                {{ $jobPost->Employer->Industry->name }}
                                                            </span>
                                                            @endif
                                                            @if($jobPost->Employer->website)
                                                            <h5 class="fw-bold text-dark">Company Website:</h5>
                                                            <p class="mb-4">
                                                                <a href="{{ $jobPost->Employer->website }}" target="_blank"><small><strong>{{ $jobPost->Employer->website }}</strong></small></a>
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
                                                        @if($jobPost->Employer->Industry->name)
                                                        <div class="col">
                                                            <h6 class="fw-bold text-dark">Industry Type</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobPost->Employer->Industry->name }}
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
                                        <div class=" p-1  d-lg-none d-block company-detail-media">
                                            
                                            <div class="card job-post-detail-company-profile mb-2">
                                                <div class="header">
                                                    <div class="row px-2 pt-4">
                                                        
                                                        <div class="col py-4" >
                                                            <div class="col-6 mx-auto text-center">
                                                                @if($jobPost->Employer->logo && $jobPost->hide_company == 0)
                                                                <img src="{{ asset('storage/employer_logo/'.$jobPost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $jobPost->Employer->name }}">
                                                                @else
                                                                <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="Employer Profile">
                                                                @endif
                                                            </div>
                                                            @if($jobPost->hide_company == 0)
                                                            <h4 class="fw-bold text-black job-post-company-name">{{ $jobPost->Employer->name }} @if($jobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                            @endif
                                                            <h5 class="fw-bold text-dark">Company Overview</h5>
                                                            @if($jobPost->Employer->summary)
                                                            <p class="mb-4">
                                                                {!! $jobPost->Employer->summary !!}
                                                            </p>
                                                            @endif
                                                            @if($jobPost->Employer->EmployerAddress->count() > 0)
                                                            <h5 class="fw-bold text-dark">Address:</h5>
                                                            <span class="mb-4 btn border seeker_image_input_label">
                                                                
                                                                    @if($jobPost->Employer->EmployerAddress->first()->address_detail)
                                                                    <p>{{ $jobPost->Employer->EmployerAddress->first()->address_detail }}</p>
                                                                    @else
                                                                    <p>@if($jobPost->Employer->EmployerAddress->first()->country == 'Myanmar') {{ $jobPost->Employer->EmployerAddress->first()->State->name ?? '' }}, @if($jobPost->Employer->EmployerAddress->first()->township_id) {{ $jobPost->Employer->EmployerAddress->first()->Township->name }}, @endif {{ $jobPost->Employer->EmployerAddress->first()->country }} @endif</p>
                                                                    @endif
                                                                
                                                            </span>
                                                            @endif
                                                            @if($jobPost->Employer->website)
                                                            <h5 class="fw-bold text-dark">Company Website:</h5>
                                                            <p class="mb-4">
                                                                <a href="{{ $jobPost->Employer->website }}" target="_blank"><small><strong>{{ $jobPost->Employer->website }}</strong></small></a>
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
                                                        @if($jobPost->Employer->Industry->name)
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">Industry Type</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobPost->Employer->Industry->name }}
                                                            </p>
                                                        </div>
                                                        @endif
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">Company Size:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobPost->Employer->no_of_employees ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-12 col-lg-4">
                                                            <h6 class="fw-bold text-dark">No of Office:</h6>
                                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                {{ $jobPost->Employer->no_of_offices ?? '-' }}
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
                            @if($jobPost->hide_comopany == 0)
                            <div class="card-footer text-center">
                                <a href="{{ route('company-jobs', $jobPost->Employer->id) }}" class="btn btn-sm text-white" style="background-color: #0355d0;">See more jobs from this company</a>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success copyText" onclick="copyText('{{ route('jobpost-detail', $jobPost->slug) }}')"  ><i class="fa-solid fa-copy"></i> Copy to Clipboard</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @auth('seeker')
                            <a href="{{ route('jobpost-apply', $jobPost->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                            </a>
                        @elseauth('employer')
                        @else
                            <a href="{{ route('jobpost-apply', $jobPost->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
        
        @endforeach
    </div>

    <div class="row py-3">
        <div>
            <a href="{{ route('company-jobs', $employer->id) }}" class="btn see-all-btn pull-right">See All Jobs</a>
        </div>
    </div>
</div>
@endif
<!-- Job Openings End -->
@endsection

@push('scripts')
<script>
    function applyJob(id) {
        $(this).on('submit', function(){
            $(this).attr('disabled','true');
        })
    }

    $(document).ready(function() {
        var url = @json($videourl);
        
        var id = url.split("?v=")[1]; //sGbxmsDFVnE

        var embedlink = "http://www.youtube.com/embed/" + id;

        $("#myIframe").attr('src',embedlink );
        
    })
</script>
@endpush