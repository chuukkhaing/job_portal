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
        <div class="col-lg-8 col-12 find-jobs-left-sidebar">
            @foreach($jobPosts as $jobPost)
            <div class="row job-content mb-3">
                <!-- Job List Start -->
                <div class="col-lg-10 col-md-10 py-4">
                    <a href="{{ route('jobpost-detail', $jobPost->slug) }}">
                        <div class="row">
                            <div class="col-md-2 job-image">
                                @if($jobPost->Employer->logo)
                                <img src="{{ asset('storage/employer_logo/'.$jobPost->Employer->logo) }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 55px" id="ProfilePreview">
                                @else 
                                <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 55px" id="ProfilePreview">
                                @endif
                            </div>    
                            <div class="col-md-10">
                                <div class="job-company">{{ $jobPost->Employer->name }}</div>
                                <div class="job-title">{{ $jobPost->job_title }}</div>
                                @if($jobPost->country == 'Myanmar')
                                <div class="job-location">{{ $jobPost->State->name }}</div>
                                @endif
                                <div class="job-salary my-3">@if($jobPost->hide_salary == 1) Negotiate @else {{ $jobPost->salary_range }} @endif</div>
                                <div class="">
                                    <a href="" class="btn job-btn">{{ $jobPost->Industry->name }}</a>
                                    {{--@if($jobPost->job_highlight)
                                    <a href="" class="btn job-btn">{{ $jobPost->job_highlight }}</a>
                                    @endif
                                    @if($jobPost->benefit)
                                    <a href="" class="btn job-btn">{{ $jobPost->benefit }}</a>
                                    @endif--}}
                                </div>
                            </div>
                        </div>    
                    </a>                
                </div>
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4">
                    <div class="row col-12 m-0 p-0">
                        <div class="text-end p-0">
                            <i class="fa-regular fa-heart"></i>
                        </div>

                        <div class="text-end mt-auto p-1">
                            <span>1 d</span>
                        </div>
                    </div>
                </div>
                <!-- Wishlist End -->
            </div>
            @endforeach
            <div class="row">
                <div class="col pt-2">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                    {{ $jobPosts->appends(request()->all())->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
                </div>
            </div>
        </div>
        @else
        <div class="col-lg-8 col-12 find-jobs-left-sidebar">
            <div class="row job-content mb-3">
                <!-- Job List Start -->
                <div class="col-lg-10 col-md-10 py-4">
                    <div class="row text-center">
                        <p class="text-center">There is no Job.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Left Sidebar End -->

        <!-- Right Sidebar Start -->
        <div class="col-lg-4 col-12 px-5 find-jobs-right-sidebar">
            <!-- Trending Jobs Start -->
            <div class="row mb-5">
                <div class="right-trending-title">
                    <h5 class="text-white py-2">Trending Jobs</h5>
                </div>

                <div class="job-trending-scroll p-2">
                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
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
            <div class="row mb-5">
                <div class="right-trending-title">
                    <h5 class="text-white py-2">Features Jobs</h5>
                </div>

                <div class="job-trending-scroll p-2">
                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
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