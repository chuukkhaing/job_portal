@extends('frontend.layouts.app')
@section('content')



<!-- Carousel Start -->
@if($sliders->count() > 0)
<div class="container-fluid p-0">
    <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($sliders as $slider)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img class="w-100 img-fluid" src="{{ asset('storage/slider/'.$slider->image) }}" alt="{{ $slider->Employer->name }}">
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
@endif
<!-- Carousel End -->

<!-- Search Start -->
<form action="{{ route('search-job') }}" method="post" class="form-height-0">
    @csrf
    <section class="search-sec">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 p-0">
                        <div class="form-group has-search">
                            <span class="form-control-feedback"><i class="fa fa-search fa-md"></i></span>
                            <input type="text" class="form-control search-slt job-title" placeholder="Job title or keyword" name="job_title">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-3 p-0">
                        <div class="form-group has-search search-slt function-area">
                            <span class="form-control-feedback"><i class="fa fa-shopping-bag fa-md" aria-hidden="true"></i></span>
                            <select class="form-control" id="function-area" multiple="multiple" name="function_area[]" size="10">
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

                    <div class="col-lg-3 col-md-3 p-0">
                        <div class="form-group has-search">
                            <span class="form-control-feedback"><i class="fa fa-map-marker fa-md"></i></span>
                            <select name="location" id="location" class="form-control search-slt location" placeholder="location" name="location">
                                <option value="" disabled selected>location</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 p-0">
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
<div class="container bg-light">
    <div class="popular-job-category">
        <div id="header-popular-job-category" class="text-center py-5">
            <h3 id="popular-job-category-title">Popular Job Categories</h3>
            <span id="popular-job-category-sub-title">{{ $live_job }} jobs live - {{ $today_job }} added today</span>
        </div>
        <div id="body-popular-job-category" class="row">
            @foreach($industries as $industry)
            <div class="col-lg-3 col-md-4 col-sm-2 p-2">
                <a href="{{ route('industry-job',$industry->Industry->id) }}">
                    <div id="job-category-box" class="text-center">
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
            <div class="text-center py-5">
                <a href="{{ route('job-categories') }}" class="btn btn-browse-category">Browse All Categories <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Popular Job Category End  -->

<!-- Top Employer Start  -->
@if($employers->count() > 0)
<div class="container bg-light">
    <div class="popular-job-category">
        <div id="header-popular-job-category" class="text-center py-5">
            <h3 id="popular-job-category-title">Top Employers</h3>
        </div>
        <div id="body-popular-job-category" class="row col-12 pb-5">
            @foreach($employers as $employer)
            <div class="col-md-2 col-4 text-center">
                <a href="{{ route('company-detail',$employer->slug) }}">
                    @if($employer->logo)
                    <img src="{{ asset('/storage/employer_logo'.'/'.$employer->logo) }}" class="" width="100" alt="{{ $employer->name }}">
                    @else
                    <img src="{{ asset('/img/logo/ICLogo.png') }}" class="" width="100" alt="{{ $employer->name }}">
                    @endif
                    <div class="mt-2" id="job-category-name">
                    <span id="job-category-name-position">{{ $employer->name }}</span>
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
<div class="container pb-4 my-2 bg-light" id="edit-profile-body">
    <div class="row">
        <div id="header-popular-job-category" class="text-center py-4" style="border-bottom: 1px solid #95B6D8;">
            <h3 id="popular-job-category-title">
                <span class="text-orange">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </span>
                <span class="px-3">Trending Jobs</span>
                <span class="text-orange">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </span>
            </h3>
        </div>
    </div>  

    <div class="row pt-4 pb-4 trending-scroll">
        @foreach($trending_jobs as $trending_job)
        <div class="col-lg-4 col-sm-6 col-12">
            <a href="{{ route('jobpost-detail', $trending_job->slug) }}">
                <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                    <div class="row">
                        <div class="col-3 text-center">
                            @if($trending_job->Employer->logo)
                            <img src="{{ asset('storage/employer_logo/'.$trending_job->Employer->logo) }}" alt="{{ $trending_job->Employer->name }}" class="seeker-profile rounded-circle">
                            @else 
                            <img src="{{ asset('img/profile.svg') }}" alt="{{ $trending_job->Employer->name }}" class="seeker-profile rounded-circle">
                            @endif
                        </div>
                        <div class="col-9 p-0">
                            <div>
                                <h3 id="trending-job-title">{{ $trending_job->job_title }}</h3>
                                <span id="trending-job-sub-title">{{ $trending_job->Employer->name }}</span>
                            </div>

                            <div class="fz13">
                                <span class="me-2 d-block" style="margin: 0px 0 -15px 0"><i class="fa fa-briefcase me-2"></i></i>{{ $trending_job->MainFunctionalArea->name }}</span>
                                @if($trending_job->country == 'Myanmar' && $trending_job->township_id )<span style="margin: -15px 0"><i class="fa fa-map-marker me-1" aria-hidden="true"></i> {{ $trending_job->Township->name }}</span> @elseif($trending_job->country == 'Other') <span style="margin: -15px 0"><i class="fa fa-map-marker me-1" aria-hidden="true"></i>{{ $trending_job->country }} </span>@endif
                            </div>
                        </div>
                    </div>
                </div>
            </a>
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
        <div id="header-popular-job-category" class="text-center pt-5">
            <h3 id="popular-job-category-title">Featured Jobs</h3>
        </div>

        <div class="row bg-light">
            <div class="col-12 p-0">
                <div class="owl-slider py-5">
                    <div class="row col-12 m-0">
                    <div id="multiple-carousel" class="owl-carousel">
                        @foreach($feature_jobs as $feature_job)
                        <a href="{{ route('jobpost-detail', $feature_job->slug) }}">
                            <div class="item d-flex justify-content-center">
                                <div class="row px-3 align-items-center">
                                    <div class="col-3">
                                        @if($feature_job->Employer->logo)
                                        <img src="{{ asset('storage/employer_logo/'.$feature_job->Employer->logo) }}" alt="{{ $feature_job->Employer->name }}" class="d-block pt-3 pb-3 trending-image" >
                                        @else 
                                        <img src="{{ asset('img/profile.svg') }}" alt="{{ $feature_job->Employer->name }}" class="d-block pt-3 pb-3 trending-image" >
                                        @endif
                                    </div>
                                    <div class="col-9 p-0 pt-3">
                                        <h3 class="fz15 text-truncate" id="trending-job-title">{{ $feature_job->job_title }}</h3>
                                        <span id="trending-job-sub-title">{{ $feature_job->Employer->name }}</span>
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
@endif
{{-- <div class="container bg-light">
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
<div class="container-fluid mt-5 p-0">
    <div class="row" id="job-interview">
        <div class="offset-lg-1 col-lg-6 p-5">

            <h3 class="job-interview-title pt-4">Are You Looking For Job!</h3>

            <p class="job-interview-content pt-3 pb-5">Looking for a job can be a daunting task, but with a little focus and effort, you can increase your chances of success. Define your job search goals, tailor your resume and cover letter, network with others in your industry, use job search engines to find opportunities, and prepare for interviews. With these tips, you can streamline your search and find the job that's right for you.</p>
            
            <a href="#" class="interview-btn">Get Started Today </a>
        </div>
    </div>
</div>
<!-- Job Interview End -->

<!-- Additional Services Start  -->
<div class="container bg-light">
    <div class="additional-service">
        <div id="header-additional-service" class="text-center pt-5 pb-3">
            <h3 id="additional-service-title">Additional Services</h3>
        </div>
        <div id="body-additional-service" class="row">
            <div class="col-lg-4 col-md-4 p-2">
                <div id="additional-service-box" class="text-center">
                    <div id="additional-service-icon">
                        <i class="fa-solid fa-puzzle-piece"></i>
                    </div>

                    <div id="additional-service-name">
                        <h4>{{ 'Solve Problems Real Time' }}</h4>
                    </div>

                    <div id="additional-service-content">
                        <p class="px-5">Lorem ipsum dolor sit amet, consectetur adipis elit. Sit enim nec, proin faucibus nibh et sagittis a. Lacinia purus ac amet.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 p-2">
                <div id="additional-service-box" class="text-center">
                    <div id="additional-service-icon">
                        <i class='fa fa-lock'></i>
                    </div>

                    <div id="additional-service-name">
                        <h4>{{ 'Secured & Safe Payments' }}</h4>
                    </div>

                    <div id="additional-service-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipis elit. Sit enim nec, proin faucibus nibh et sagittis a. Lacinia purus ac amet.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 p-2">
                <div id="additional-service-box" class="text-center">
                    <div id="additional-service-icon">
                        <i class="fa-solid fa-message"></i>
                    </div>

                    <div id="additional-service-name">
                        <h4>{{ '24//7 Customer Support' }}</h4>
                    </div>

                    <div id="additional-service-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipis elit. Sit enim nec, proin faucibus nibh et sagittis a. Lacinia purus ac amet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Additional Services End  -->

<!-- Explore the Marketplace Start  -->
<div class="container bg-light">
    <div class="explore-marketplace">
        <div id="header-explore-marketplace" class="text-center py-5">
            <h3 id="explore-marketplace-title">Explore the Marketplace Today!</h3>
        </div>

        <div id="body-explore-marketplace" class="row py-3">
            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <div id="explore-marketplace-box" class="text-center">
                    <div class="explore-marketplace-icon pt-4">
                        <i class="fa-solid fa-building-columns bg-white rounded-circle p-3"></i>
                    </div>

                    <div class="explore-marketplace-title pt-1">
                        <span class="text-white">Banking</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <div id="explore-marketplace-box" class="text-center">
                    <div class="explore-marketplace-icon pt-4">
                        <i class="fa-solid fa-display bg-white rounded-circle p-3"></i>
                    </div>

                    <div class="explore-marketplace-title pt-1">
                        <span class="text-white">Computer</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <div id="explore-marketplace-box" class="text-center">
                    <div class="explore-marketplace-icon pt-4">
                        <i class="fa-solid fa-graduation-cap bg-white rounded-circle p-3"></i>
                    </div>

                    <div class="explore-marketplace-title pt-1">
                        <span class="text-white">Education</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <div id="explore-marketplace-box" class="text-center">
                    <div class="explore-marketplace-icon pt-4">
                        <i class="fa-solid fa-martini-glass-citrus bg-white rounded-circle p-3"></i>
                    </div>

                    <div class="explore-marketplace-title pt-1">
                        <span class="text-white">Food</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <div id="explore-marketplace-box" class="text-center">
                    <div class="explore-marketplace-icon pt-4">
                        <i class="fa-solid fa-pen-to-square bg-white rounded-circle p-3"></i>
                    </div>

                    <div class="explore-marketplace-title pt-1">
                        <span class="text-white">Writing</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 px-5 pb-3">
                <div id="explore-marketplace-box" class="text-center">
                    <div class="explore-marketplace-icon pt-4">
                        <i class="fa-solid fa-wifi bg-white rounded-circle p-3"></i>
                    </div>

                    <div class="explore-marketplace-title pt-1">
                        <span class="text-white">Wifi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Explore the Marketplace End  -->

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#function-area').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            includeSelectAllOption: true,
            nonSelectedText: "Select function area",
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
                items: 5
                }
            }
        });
    });
</script>
@endpush