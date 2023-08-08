@extends('frontend.layouts.app')
@section('content')

<!-- Search Start -->
<section class="company-banner p-5">
    <div class="container p-0">
        <form action="{{ route('search-company') }}" method="get">
            <div class="row company-banner-search py-1">
                @csrf
                <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                    <div class="form-group has-search">
                        <span class="form-control-feedback company-icon"><i class="fa fa-search fa-md"></i></span>
                        <input type="text" name="company_name" class="form-control search-slt company-search" placeholder="Search Companies" @if(isset($_GET['company_name'])) value="{{ $_GET['company_name'] }}" @endif>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3 col-12 pe-1">
                    <button type="submit" class="btn company-search-btn pull-right">Search Jobs</button>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Search End -->

<!-- Show Data Start -->
<div class="container my-5">
    <div class="row my-5">
        <div class="company-header py-3 text-center">
            <h3 class="company-header-title text-center">Discover Your Dream Job with Top Companies</h3>
            <span class="company-header-sub-title justify-content-center">Find endless career opportunities with our customizable search filters and user-friendly interface</span>
        </div>
    </div>

    <div class="row">
        @foreach($employers as $employer)
        <div class="col-lg-4 col-md-6 col-12 pb-3">
            <a href="{{ route('company-detail',$employer->slug ?? '') }}">
                <div class="company-content p-4 h-100">
                    <div class="company-image">
                        @if($employer->background)
                        <img src="{{ asset('storage/employer_background/'. $employer->background) }}" class="w-100" alt="{{ $employer->name }}">
                        @else
                        <img src="{{ asset('/frontend/img/company/image.jpg') }}" class="w-100" alt="{{ $employer->name }}">
                        @endif
                    </div>
        
                    <div class="company-name pt-4 pb-2">
                        <h3>{{ $employer->name }}</h3>
                    </div>
        
                    <div class="company-address">
                        @if($employer->EmployerAddress->count() > 0)
                        @foreach($employer->EmployerAddress as $address)
                        @if($address->address_detail)
                        <p>{{ $address->address_detail }}</p>
                        @else
                        <p>@if($address->country == 'Myanmar') {{ $address->State->name ?? '' }}, @if($address->township_id) {{ $address->Township->name }}, @endif {{ $address->country }} @endif</p>
                        @endif
                        @endforeach
                        @endif
                    </div>
        
                    <div class="company-job-count mt-4 py-2">
                        Opening Jobs - {{ $employer->JobPost->where('is_active',1)->where('status','Online')->count() }}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        <div class="row">
            <div class="col pt-2">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                {{ $employers->appends(request()->all())->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
            </div>
        </div>
    </div>
</div>
<!-- Show Data End -->

<!-- Join Our Community Start -->
<div class="container my-5">
    <div class="row my-5">
        <div class="community-header py-3">
            <h3 class="community-header-title text-center">Join Our Community</h3>
        </div>

        <div class="community-text">
            <p>
                By joining our community, you will have access to a pool of qualified and motivated job seekers who are eager to contribute their skills and expertise to your company.
                Our job seeker website is dedicated to connecting employers with top talent, making the hiring process easier and more efficient than ever before.
                Whether you're looking for entry-level candidates or seasoned professionals, our platform has something to offer for everyone.
            </p>

            <p>
                As a member of our community, you will have the opportunity to showcase your company and job openings to a wide audience of job seekers.
                Our platform is user-friendly and easy to navigate, allowing you to quickly and easily post job listings and browse through resumes to find the perfect fit for your company.
                Join our job seeker community today and take the first step towards improving your company and finding the right talent to help your business grow and thrive!
            </p>
        </div>
    </div>

    <div class="row py-5">
        <div class="col-lg-5 col-md-8 community-form p-0">
            <div class="row col-12 m-0 p-0">
                <div class="col-lg-9 col-md-8 p-2">
                    <input type="text" class="form-control search-slt community-search" placeholder="Enter your mail address">
                </div>

                <div class="col-lg-3 col-md-4 p-2">
                    <button type="button" class="btn community-form-btn pull-right">Join Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Join Our Community End -->

@endsection