@extends('frontend.layouts.app')
@section('content')

<!-- Search Start -->
<form action="{{ route('search-job') }}" method="post">
    @csrf
    <section class="find-jobs-search p-5">
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

<div class="container my-5">
    <div class="row my-5">
        <div class="find-jobs-header py-3">
            <h3 class="find-jobs-title">Explore Job Near for you</h3>
            <span class="find-jobs-sub-title">Suggestions tailored to your profile, career preferences, and engagement history on our platform are provided to guide you towards the most relevant job opportunities.</span>
        </div>
    </div>
    <div class="row my-5">
        <!-- Left Sidebar Start -->
        @if($jobPosts->count() > 0)
        <div class="col-md-8 find-jobs-left-sidebar">
            @foreach($jobPosts as $jobPost)
            <div class="row job-content mb-3">
                <!-- Job List Start -->
                <div class="col-md-11 py-4">
                    <div class="row">
                        <div class="col-md-1 job-image">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="">
                        </div>    
                        <div class="col-md-11">
                            <div class="job-company">{{ $jobPost->Employer->name }}</div>
                            <div class="job-title">{{ $jobPost->job_title }}</div>
                            @if($jobPost->country == 'Myanmar')
                            <div class="job-location">{{ $jobPost->State->name }}</div>
                            @endif
                            <div class="job-salary my-3">@if($jobPost->hide_salary == 1) Negotiate @else {{ $jobPost->salary_range }} @endif</div>
                            <div class="">
                                <a href="" class="btn job-btn">{{ $jobPost->Industry->name }}</a>
                                @if($jobPost->job_highlight)
                                <a href="" class="btn job-btn">{{ $jobPost->job_highlight }}</a>
                                @endif
                                @if($jobPost->benefit)
                                <a href="" class="btn job-btn">{{ $jobPost->benefit }}</a>
                                @endif
                            </div>
                        </div>
                    </div>                    
                </div>
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-md-1 py-4">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <!-- Wishlist End -->
            </div>
            @endforeach
        </div>
        @endif
        <!-- Left Sidebar End -->

        <!-- Right Sidebar Start -->
        <div class="col-md-4 px-5 find-jobs-right-sidebar">
            <!-- Trending Jobs Start -->
            <div class="mb-5">
                <div class="row right-trending-title" style="background: #0355d0">
                    <h5 class="text-white py-2">Trending Jobs</h5>
                </div>
                <div class="row pt-4 pb-4 job-trending-scroll">
                    <div class="col-lg-12">
                        <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Trending Job Image" class="trending-image">
                                </div>
                                <div class="col-md-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>
            
                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-lg-12">
                        <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Trending Job Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                </div>
                                <div class="col-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>
            
                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-12">
                        <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Trending Job Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                </div>
                                <div class="col-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>
            
                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-12">
                        <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Trending Job Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                </div>
                                <div class="col-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>
            
                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Trending Job Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                </div>
                                <div class="col-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>
            
                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Trending Jobs End -->

             <!-- Featured Jobs Start -->
             <div>
                <div class="row right-trending-title" style="background: #0355d0">
                    <h5 class="text-white py-2">Features Jobs</h5>
                </div>
                <div class="row pt-4 pb-4 job-trending-scroll">
                    <div class="col-12">
                        <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Trending Job Image" class="trending-image">
                                </div>
                                <div class="col-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>
            
                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-12">
                        <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Trending Job Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                </div>
                                <div class="col-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>
            
                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-12">
                        <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Trending Job Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                </div>
                                <div class="col-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>
            
                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-12">
                        <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Trending Job Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                </div>
                                <div class="col-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>
            
                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Trending Job Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                </div>
                                <div class="col-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>
            
                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Featured Jobs End -->
            
        </div>
        <!-- Right Sidebar End -->
    </div>
</div>

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
    });
</script>
@endpush