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
                <img class="" src="{{ getS3File('slider' ,$slider->image) }}" alt="{{ $slider->Employer->name }}">
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
                            <input type="text" class="form-control search-slt job-title" placeholder="{{ __('message.Job title or keyword') }}" name="job_title">
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
                            <select name="location" id="location" class="form-control search-slt location" placeholder="{{ __('message.Location') }}" name="location">
                                <option value="" selected disabled>{{ __('message.Location') }}</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 p-0 mt-lg-0 mt-md-3">
                        <button type="submit" class="btn pull-right search-job-btn">{{ __('message.Search Jobs') }}</button>
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
            <h3 id="popular-job-category-title">{{ __('message.Popular Job Categories') }}</h3>
            <span id="popular-job-category-sub-title">{{ $live_job }} {{ __('message.Jobs live') }} - {{ $today_job }} added today</span>
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
                            <span id="job-category-name-position">{{ $industry->total }} {{ __('message.open positions') }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            <div class="text-end py-3">
                <a href="{{ route('job-categories') }}" class="btn-browse-category">{{ __('message.Browse All Categories') }} <i class="fas fa-arrow-right"></i></a>
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
            <h3 id="popular-job-category-title">{{ __('message.Top Employers') }}</h3>
        </div>
        <div id="body-popular-job-category" class="row col-12 pb-5">
            @foreach($employers as $employer)
            <div class="col-lg-2 col-md-3 col-sm-4 col-12 text-center h-100 align-self-center mt-3">
                <a href="{{ route('company-detail',$employer->slug) }}">
                    @if($employer->logo)
                    <img src="{{ getS3File('employer_logo',$employer->logo) }}" class="" width="100" alt="{{ $employer->name }}">
                    @else
                    <img src="{{ asset('/img/icon/company.png') }}" class="" width="100" alt="Employer Profile">
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
            <div data-bs-toggle="modal" class="jobpostModal" data-bs-target="#JobPostModal{{$trending_job->id}}">
                <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                    <div class="row h-100 p-2">
                        <div class="col-3 text-center h-100 align-self-center">
                            @if($trending_job->Employer->logo && $trending_job->hide_company == 0)
                            <img src="{{ getS3File('employer_logo',$trending_job->Employer->logo) }}" alt="{{ $trending_job->Employer->name }}" class="w-75 border rounded-circle">
                            @else 
                            <img src="{{ asset('img/icon/job-post.png') }}" alt="Employer Profile" class="w-75 border rounded-circle">
                            @endif
                        </div>
                        <div class="col-9 p-0">
                            <div>
                                <h3 id="trending-job-title">{{ $trending_job->job_title }}</h3>
                                <span id="trending-job-sub-title">@if($trending_job->hide_company == 0){{ $trending_job->Employer->name }} @endif @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$trending_job->id)->count() > 0)<span class="badge badge-info"> Applied </span> @endif @endauth</span>
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
        @include('frontend.job-post-modal', ['jobPost' => $trending_job])
        
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
                                            @if($feature_job->Employer->logo && $feature_job->hide_company == 0)
                                            <img src="{{ getS3File('employer_logo',$feature_job->Employer->logo) }}" alt="{{ $feature_job->Employer->name }}" class="w-100 rounded-circle border" >
                                            @else 
                                            <img src="{{ asset('img/icon/job-post.png') }}" alt="Employer Profile" class="w-100 rounded-circle border" >
                                            @endif
                                        </div>
                                        <div class="col-9 p-0 pt-3">
                                            <h3 class="fz15 text-truncate" id="trending-job-title">{{ $feature_job->job_title }}</h3>
                                            <span id="trending-job-sub-title">@if($feature_job->hide_company == 0) {{ $feature_job->Employer->name }} @endif @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$feature_job->id)->count() > 0) <span class="badge badge-info"> Applied </span>@endif @endauth</span>
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
@include('frontend.job-post-modal', ['jobPost' => $feature_job])

@endforeach
@endif
{{-- <div class="container">
    <div class="row">
        <div class="col-md-3 ps-0 pe-3 pb-3">          
            <div class="gradient-img">
                <img src="{{ asset('frontend/img/featured/bg-image.jpg') }}" class="img-responsive w-100">
            </div>
            <div class="gradient-text">
                <span class="ps-3 pt-3">{{ __('message.For Employers') }}</span>
            </div>      
        </div>

        <div class="col-md-3 ps-0 pe-3 pb-3">          
            <div class="gradient-img">
                <img src="{{ asset('frontend/img/featured/bg-image.jpg') }}" class="img-responsive w-100">
            </div>
            <div class="gradient-text">
                <span class="ps-3 pt-3">{{ __('message.For Jobseekers') }}</span>
            </div>      
        </div>

        <div class="col-md-3 ps-0 pe-3 pb-3">          
            <div class="gradient-img">
                <img src="{{ asset('frontend/img/featured/bg-image.jpg') }}" class="img-responsive w-100">
            </div>
            <div class="gradient-text">
                <span class="ps-3 pt-3">{{ __('message.For Jobseekers') }}</span>
            </div>      
        </div>

        <div class="col-md-3 ps-0 pe-3 pb-3">          
            <div class="gradient-img">
                <img src="{{ asset('frontend/img/featured/bg-image.jpg') }}" class="img-responsive w-100">
            </div>
            <div class="gradient-text">
                <span class="ps-3 pt-3">{{ __('message.For Jobseekers') }}</span>
            </div>      
        </div>
 </div>
</div> --}}
<!-- Featured Jobs End  -->

<!-- Job Interview Start -->
<div class="container mt-5 p-0">
    <div class="row d-flex align-items-end" id="">
        <div class="col-md-6 col-12 p-5 text-center border-end">
            <h1 style="color: #FB5404">{{ __('message.Jobseeker') }}</h1>
            <h5>Ready to apply? It is easy now!</h5>
            <img src="{{ asset('img/background/jobseeker_signup.png') }}" class="img-fluid my-3" alt="">
            <div>
            <a href="{{ route('register-form') }}" class="btn text-white" style="background: #FB5404">{{ __('message.Sign up here') }}</a>
            </div>
        </div>
        <div class="col-md-6 col-12 p-5 text-center">
            <h1>{{ __('message.Employers') }}</h1>
            <h5>Ready to hire? It is easy now!</h5>
            <img src="{{ asset('img/background/employer_signup.png') }}" class="img-fluid my-3" alt="">
            <div>
            <a href="{{ route('employer-register-form') }}" class="btn text-white" style="background: #091E3E">{{ __('message.Sign up here') }}</a>
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
        
        var loggedIn = "{{ Auth::guard('seeker')->user() ? session(['returnUrl' => '']) : session(['returnUrl' => 'jobpost-detail', 'previous_url' => url()->current()]) }}";

        $('#function-area').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            includeSelectAllOption: true,
            nonSelectedText: "{{ __('message.Select function area') }}",
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

        var show_success_modal = "{{ Session::get('success') }}";
        if(show_success_modal != '') {
            MSalert.principal({
                icon:'success',
                title:'Success',
                description: show_success_modal,
            })
        }

        @if(count($errors) > 0) 
        MSalert.principal({
            icon:'error',
            title:'Error',
            description: "Need to answer all questions.",
        })
        @endif

        var show_error_modal = "{{ Session::get('error') }}";
        if(show_error_modal != '') {
            MSalert.principal({
                icon:'error',
                title:'Error',
                description: show_error_modal,
            })
        }

        var show_info_modal = "{{ Session::get('info') }}";
        if(show_info_modal != '') {
            MSalert.principal({
                icon:'info',
                title:'Info',
                description: show_info_modal,
            })
        }

        var show_warning_modal = "{{ Session::get('warning') }}";
        if(show_warning_modal != '') {
            MSalert.principal({
                icon:'warning',
                title:'Warning',
                description: show_warning_modal,
            })
        }
    });

    function applyJob(id) {
        $(this).attr('disabled','true');
        
    }
    
</script>
@endpush