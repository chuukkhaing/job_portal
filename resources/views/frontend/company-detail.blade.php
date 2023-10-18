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
            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" class="company-detail-logo" style="background: #0355D0; width: 100px; height: 100px; border-radius: 8px" alt="{{ $employer->name }}">
            @else
            <img src="{{ asset('img/employer/Vertical Logo.svg') }}" class="company-detail-logo" style="background: #0355D0; width: 100px; height: 100px; border-radius: 8px" alt="{{ $employer->name }}">
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
                {!! $employer->EmployerMedia->where('type','Video Link')->first()->name !!}
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
        <div class="col-lg-12 col-12 pb-2">
            <div class="row job-opening me-1 p-2 h-100">
                <div class="col-lg-9 col-md-9 p-0">
                    <div class="row col-12 m-0 p-0">
                        <div class="col-lg-2 col-md-3 col-4 align-self-center">
                            @if($jobPost->job_post_type == 'feature' || $jobPost->job_post_type == 'trending')
                            @if($employer->logo)
                            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Profile Image" class="mb-2 img-responsive center-block d-block mx-auto" style="" id="ProfilePreview">
                            @else 
                            <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="mb-2 img-responsive center-block d-block mx-auto" style="" id="ProfilePreview">
                            @endif
                            <div class="text-center">
                            @if($jobPost->job_post_type == 'feature')<span class="badge badge-pill job-post-badge" style="background: #0355D0"> Featured @elseif($jobPost->job_post_type == 'trending') <span class="badge badge-pill job-post-badge" style="background: #FB5404"> Trending @endif</span>
                            </div>
                            @endif
                        </div>

                        <div class="col-lg-10 col-md-9 col-8 align-self-center">
                            <div class="mt-1 job-company">{{ $employer->name }} @if($employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$jobPost->id)->count() > 0) <span class="badge badge-info"> Applied </span> @endif @endauth</div>
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
                        <div class="text-end p-0">
                            <a href="{{ route('jobpost-detail', $jobPost->slug) }}" class="btn view-detail-btn p-0">View Details</a>
                        </div>

                        <div class="text-end mt-auto p-1 ">
                            <span>{{ $jobPost->updated_at->shortRelativeDiffForHumans() }}</span>
                        </div>
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