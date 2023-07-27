@extends('frontend.layouts.app')
@section('content')

<!-- Banner Start -->
<div class="container-fluid p-3">
    <div class="row company-detail-banner">
        @if($employer->background)
        <img src="{{ asset('storage/employer_background/'. $employer->background) }}" class="w-100" style="max-height : 400px" alt="{{ $employer->name }}">
        @else
        <img src="{{ asset('/frontend/img/company/company-banner-image.png') }}" class="w-100" alt="{{ $employer->name }}">
        @endif
    </div>
</div>
<!-- Banner End -->

<!-- Company Profile Start -->
<div class="container company-profile my-5">
    <div class="row pt-3 px-3">
        <div class="col-lg-6 col-md-6 col-6">
            @if($employer->logo)
            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" class="" style="width: 120px; height: 120px" alt="{{ $employer->name }}">
            @else
            <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="" style="width: 120px; height: 120px" alt="{{ $employer->name }}">
            @endif
        </div>

        <div class="col-lg-6 col-md-6 col-6">
            @if($employer->qr)
            <img src="{{ asset('storage/employer_qr/'.$employer->qr) }}" class="profile-qr pull-right mt-2" alt="{{ $employer->name }}">
            @else
            <img src="{{ asset('frontend/img/company/qr-image.png') }}" class="profile-qr pull-right mt-2" alt="{{ $employer->name }}">
            @endif
        </div>
    </div>

    <div class="row px-3">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="company-name pt-4 pb-2">
                <h3>{{ $employer->name }}</h3>
            </div>

            <div class="company-address">
                @if($employer->EmployerAddress->count() > 0)
                @foreach($employer->EmployerAddress as $address)
                @if($address->address_detail)
                <p>{{ $address->address_detail }}</p>
                @else
                <p>@if($address->country == 'Myanmar') {{ $address->State->name }}, {{ $address->Township->name }}, @endif {{ $address->country }}</p>
                @endif
                @endforeach
                @endif
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12">
            <div class="float-end mt-4">
                <a href="http://" class="btn btn-outline-primary mt-2">
                    <i class="fa fa-heart-o p-1"></i><span class="p-1">Add to Favourite</span>
                </a>
                <a href="http://" class="btn see-all-btn mt-2">
                    <i class="fa-regular fa-envelope"></i> <span class="p-1">Send Message</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row pb-3 pt-4">
        <div class="col-lg-4 col-md-4 py-3 bdr2 company-profile-deatil">
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

        <div class="col-lg-4 col-md-4 py-3 bdr2 company-profile-deatil">
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

        <div class="col-lg-4 col-md-4 py-3 company-profile-deatil">
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
<div class="container my-5">
    @if($employer->value)
    <div class="row py-2">
        <div class="col-lg-12 company-vision">
            <h3 class="vision-title">
                Vision, Mission, Value
            </h3>
            
            <p>
                {{ $employer->value ?? '-' }}
            </p>
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
</div>
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
                {{ $employer->summary }}
            </p>
        </div>
    </div>
</div>
@endif
<!-- About Company End -->

<!-- Company Photo Start -->
@if($employer->EmployerMedia->where('type','Image')->count() > 0)
<div class="container my-3">
    <div class="row py-3">
        <div class="about-company-header py-3">
            <h3 class="about-company-title mt-3">Company Photos</h3>
        </div>
    </div>

    <div class="row pb-3">
        @foreach($employer->EmployerMedia->where('type','Image') as $image)
        <div class="col-lg-3 col-md-3 p-0 company-photo">
            <img src="{{ asset('storage/employer_media/'.$image->name) }}" class="w-100 py-1 pe-2" height="200px" alt="">
        </div>
        @endforeach
        
    </div>
</div>
@endif
<!-- Company Photo End -->

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
        <div class="col-lg-6 col-12 pb-2">
            <div class="row job-opening me-1 p-2">
                <div class="col-lg-9 col-md-9 p-0">
                    <div class="row col-12 m-0 p-0">
                        <div class="col-lg-2 col-md-2">
                            @if($employer->logo)
                            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Profile Image" class="seeker-profile rounded-circle" style="width: 55px" id="ProfilePreview">
                            @else 
                            <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" style="width: 55px" id="ProfilePreview">
                            @endif
                        </div>

                        <div class="col-lg-10 col-md-10">
                            <div class="job-company">{{ $employer->name ?? '-' }}</div>
                            <div class="job-title">{{ $jobPost->job_title }}</div>
                            <div class="job-location">@if($jobPost->country == 'Myanmar') {{ $jobPost->State->name ?? '-' }} @else {{ $jobPost->country }} @endif</div>
                            <div class="job-salary my-3">@if($jobPost->hide_salary == 1) Negotiate @else {{ $jobPost->salary_range }} @endif</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 d-flex align-items-end flex-column bd-highlight p-0">
                    <div class="row col-12 m-0 p-0">
                        <div class="text-end p-0">
                            <button type="button" class="btn view-detail-btn p-0">View Details</button>
                        </div>

                        <div class="text-end mt-auto p-1">
                            <span>{{ $jobPost->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row py-3">
        <div>
            <a href="#" class="btn see-all-btn pull-right">See All Jobs</a>
        </div>
    </div>
</div>
@endif
<!-- Job Openings End -->



@endsection