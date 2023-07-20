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
<section class="search-sec">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 p-0">
                    <div class="form-group has-search">
                        <span class="form-control-feedback"><i class="fa fa-search fa-md"></i></span>
                        <input type="text" class="form-control search-slt job-title" placeholder="Job title or keyword">
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 p-0">
                    <div class="form-group has-search search-slt function-area">
                        <span class="form-control-feedback"><i class="fa fa-shopping-bag fa-md" aria-hidden="true"></i></span>
                        <select class="form-control" id="function-area" multiple="multiple">
                            <optgroup label="Group 1">
                                <option value="1-1">Option 1.1</option>
                                <option value="1-2">Option 1.2</option>
                                <option value="1-3">Option 1.3</option>
                            </optgroup>
                            <optgroup label="Group 2">
                                <option value="2-1">Option 2.1</option>
                                <option value="2-2">Option 2.2</option>
                                <option value="2-3">Option 2.3</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 p-0">
                    <div class="form-group has-search">
                        <span class="form-control-feedback"><i class="fa fa-map-marker fa-md"></i></span>
                        <input type="text" class="form-control search-slt location" placeholder="location">
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 p-0">
                    <button type="button" class="btn wrn-btn pull-right">Search Jobs</button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Search End -->

<!-- Popular Job Category Start  -->
@if($jobPosts->count() > 0)
<div class="container">
    <div class="popular-job-category">
        <div id="header-popular-job-category" class="text-center py-5">
            <h3 id="popular-job-category-title">Popular Job Categories</h3>
            <span id="popular-job-category-sub-title">{{ $live_job }} jobs live - {{ $today_job }} added today</span>
        </div>
        <div id="body-popular-job-category" class="row">
            @foreach($jobPosts as $jobPost)
            <div class="col-lg-3 col-md-4 col-sm-2 p-2">
                <div id="job-category-box" class="text-center">
                    <div id="job-category-icon">
                    <i class="{{ $jobPost->Industry->icon }}"></i>
                    </div>
                    <div id="job-category-name">
                    <span id="job-category-name-title" class="d-block">{{ $jobPost->Industry->name }}</span>
                    <span id="job-category-name-position">{{ $jobPost->total }} open positions</span>
                    </div>
                </div>
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
<div class="container">
    <div class="popular-job-category">
        <div id="header-popular-job-category" class="text-center py-5">
            <h3 id="popular-job-category-title">Top Employers</h3>
        </div>
        <div id="body-popular-job-category" class="row col-12 pb-5">
            @foreach($employers as $employer)
            <div class="col-md-2 col-4 text-center">
                <img src="{{ asset('/storage/employer_logo'.'/'.$employer->logo) }}" class="" width="100" alt="{{ $employer->name }}">
                <div id="job-category-name">
                <span id="job-category-name-position">{{ $employer->name }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
<!-- Top Employer End  -->

<!-- Trending Jobs Start  -->
<div class="container pb-4 my-2" id="edit-profile-body">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="trending-image">
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

        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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

        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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

        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                    </div>
                    <div class="col-9 p-0">
                        <div class="fz13">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
        <div class="col-12 col-md-4">
            <div class="m-0 mb-2 pb-0 p-2 trending-job-list rounded">
                <div class="row">
                    <div class="col-3 text-center">
                        <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
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
<!-- Trending Jobs End  -->

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