@extends('frontend.layouts.app')
@section('content')

<!-- Search Start -->
<form action="{{ route('search-job') }}" method="get" autocomplete="off">
    @csrf
    <section class="find-jobs-search px-0 py-5 p-lg-5">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 p-0">
                        <div class="form-group has-search">
                            <span class="form-control-feedback"><i class="fa fa-search fa-md"></i></span>
                            <input type="text" class="form-control search-slt job-title" placeholder="{{ __('message.Job title or keyword') }}" name="job_title" @if(isset($_GET['job_title'])) value="{{ $_GET['job_title'] }}" @endif>
                            <ul class="autocomplete"></ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 p-0">
                        <div class="form-group has-search search-slt function-area">
                            <span class="form-control-feedback"><i class="fa fa-shopping-bag fa-md" aria-hidden="true"></i></span>
                            <select class="form-control d-none" id="function-area" multiple="multiple" name="function_area[]" size="10">
                                @foreach($main_functional_areas as $main_functional_area)
                                <optgroup label="{{ $main_functional_area->name }}">
                                    @foreach($sub_functional_areas as $sub_functional_area)
                                    @if($main_functional_area->id == $sub_functional_area->functional_area_id)
                                    <option value="{{ $sub_functional_area->id }}" @if(isset($_GET['function_area']) && in_array($sub_functional_area->id , $_GET['function_area'])) selected @endif>{{ $sub_functional_area->name }}</option>
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
                                <option value="" selected>{{ __('message.Location') }}</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}" @if(isset($_GET['location']) && $_GET['location'] == $state->id) selected @endif>{{ $state->name }}</option>
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

    <!-- Search End -->
    <div class="container row mx-auto my-3 m-0 p-0">
        <div class="row m-0 p-0">
            <div class="col-12 col-sm-3 col-md-4 col-lg">
                <div class="form-group">
                    <select name="industry" id="industry" class="find-job-select w-100" @if((isset($_GET['industry'])  && $_GET['industry'] != "") || isset($industry_id)) style="border: 2px solid #FB5404;" @endif>
                        <option value="">Job Industry</option>
                        @foreach($industries as $industry)
                        <option value="{{ $industry->id }}" @if(isset($_GET['industry']) && $_GET['industry'] == $industry->id) selected @endif @if(isset($industry_id) && $industry_id == $industry->id) selected @endif >{{ $industry->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-4 col-lg">
                <div class="form-group">
                    <select name="job_type" id="job_type" class="find-job-select w-100" @if(isset($_GET['job_type']) && $_GET['job_type'] != "") style="border: 2px solid #FB5404;" @endif>
                        <option value="">All Job Type</option>
                        @foreach(config('jobtype') as $jobtype)
                        <option value="{{ $jobtype }}" @if(isset($_GET['job_type']) && $_GET['job_type'] == $jobtype) selected @endif>{{ $jobtype }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-4 col-lg">
                <div class="form-group">
                    <select name="career_level" id="career_level" class="find-job-select w-100" @if(isset($_GET['career_level']) && $_GET['career_level'] != "") style="border: 2px solid #FB5404;" @endif>
                        <option value="">Career Level</option>
                        @foreach(config('careerlevel') as $careerlevel)
                        <option value="{{ $careerlevel }}" @if(isset($_GET['career_level']) && $_GET['career_level'] == $careerlevel) selected @endif>{{ $careerlevel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-4 col-lg">
                <div class="form-group">
                    <select name="qualification" id="qualification" class="find-job-select w-100" @if(isset($_GET['qualification']) && $_GET['qualification'] != "")style="border: 2px solid #FB5404;" @endif>
                        <option value="">Qualification</option>
                        @foreach(config('seekerdegree') as $degree)
                        <option value="{{ $degree }}" @if(isset($_GET['qualification']) && $_GET['qualification'] == $degree) selected @endif>{{ $degree }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-3 col-md-4 col-lg">
                <div class="form-group">
                    <select name="job_sorting" id="job_sorting" class="find-job-select w-100" @if(isset($_GET['job_sorting']) && $_GET['job_sorting'] != "") style="border: 2px solid #FB5404;" @endif>
                        <option value="">{{ __('message.Job Sort By') }}</option>
                        <option value="7" @if(isset($_GET['job_sorting']) && $_GET['job_sorting'] == "7") selected @endif >{{ __('message.Last 7 Days') }}</option>
                        <option value="30" @if(isset($_GET['job_sorting']) && $_GET['job_sorting'] == "30") selected @endif >{{ __('message.Last 30 Days') }}</option>
                    </select>
                </div>
            </div>
        </div>
        
    </div>
</form>
<div class="container my-3">
    <div class="row my-3">
        <div class="find-jobs-header py-3">
            <h3 class="find-jobs-title">{{ __('message.Explore your career journey via') }} {{ $jobPostsCount }} {{ __('message.Job(s)') }}</h3>
            {{--<span class="find-jobs-sub-title">Suggestions tailored to your profile, career preferences, and engagement history on our platform are provided to guide you towards the most relevant job opportunities.</span>--}}
        </div>
    </div>
    <div class="row">
        <!-- Left Sidebar Start -->
        @if($jobPosts->count() > 0)
        <div class="col-lg-8 m-0 p-lg-0 find-jobs-left-sidebar p-2">
            @foreach($jobPosts as $jobPost)
            @php 
            
            if($jobPost->Employer->MainEmployer) {
                $jobPostEmployer = $jobPost->Employer->MainEmployer;
            }else {
                $jobPostEmployer = $jobPost->Employer;
            }
            @endphp
            <div class="row job-content mb-2">
                <!-- Job List Start -->
                <div class="col-md-2 col-3 align-self-center text-center py-2">
                    <a data-bs-toggle="modal" class="jobpostModal" data-bs-target="#JobPostModal{{$jobPost->id}}">
                        @if(($jobPost->job_post_type == 'feature' || $jobPost->job_post_type == 'trending') && $jobPostEmployer->logo && $jobPost->hide_company == 0)
                        <img src="{{ getS3File('employer_logo',$jobPostEmployer->logo) }}" alt="Profile Image" class="pb-2" id="job-post-preview-company-logo">
                        @else 
                        <img src="{{ asset('img/icon/job-post.png') }}" alt="Profile Image" class="pb-2" id="job-post-preview-company-logo">
                        @endif
                        <div class="">
                        @if($jobPost->job_post_type == 'feature')<span class="badge badge-pill job-post-badge" style="background: #0355D0"> Featured @elseif($jobPost->job_post_type == 'trending') <span class="badge badge-pill job-post-badge" style="background: #FB5404"> Trending @endif</span>
                        </div>
                    </a>
                </div>
                <div class="col-md-8 col-9 align-self-center py-2">
                    <a data-bs-toggle="modal" class="jobpostModal" data-bs-target="#JobPostModal{{$jobPost->id}}">
                        <div class="mt-1 job-company text-black">@if($jobPost->hide_company == 0) {{ $jobPostEmployer->name }} @if($jobPostEmployer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif @endif @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$jobPost->id)->count() > 0) <span class="badge badge-info"> Applied </span> @endif @endauth</div>
                        <div class="mt-1">{{ $jobPost->job_title }}</div>
                        @if($jobPost->township_id)
                        <div class="mt-1 job-location">{{ $jobPost->Township->name }}</div>
                        @endif
                        @if($jobPost->job_post_type == 'trending')
                        <p class="job-post-preview text-black text-wrap">{!! \Illuminate\Support\Str::words(strip_tags($jobPost->job_requirement), 25, $end = '...') !!}</p>
                        @endif
                        <div class="row d-flex">
                            <a href="{{ route('search-main-function', $jobPost->main_functional_area_id) }}" class="job-post-area col-8 align-self-end"># {{ $jobPost->MainFunctionalArea->name }}</a>
                            <div class="d-md-none d-block col-4 text-end">
                                @auth('seeker')
                                <i style="cursor: pointer" onclick="saveJob({{ $jobPost->id }})" class="savejob-{{ $jobPost->id }} text-blue @if(Auth::guard('seeker')->user()->SaveJob->where('job_post_id', $jobPost->id)->count() > 0) fa-solid @else fa-regular @endif fa-heart"></i><br>
                                @endauth
                                <span>{{ $jobPost->updated_at->shortRelativeDiffForHumans() }}</span>
                            </div>
                            
                        </div>
                        
                    </a>
                </div>
                
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-sm-2 col-12 align-items-end flex-column bd-highlight py-2 d-md-flex d-none">
                    <div class="row col-12 m-0 p-0">
                        <div class="text-end p-0">
                            @auth('seeker')
                            <i style="cursor: pointer" onclick="saveJob({{ $jobPost->id }})" class="savejob-{{ $jobPost->id }} text-blue @if(Auth::guard('seeker')->user()->SaveJob->where('job_post_id', $jobPost->id)->count() > 0) fa-solid @else fa-regular @endif fa-heart"></i>
                            @endauth
                        </div>

                        <div class="text-end mt-auto p-1">
                            <span>{{ $jobPost->updated_at->shortRelativeDiffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <!-- Wishlist End -->
            </div>
            <!-- Modal -->
            @include('frontend.job-post-modal', ['jobPost' => $jobPost])
            
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
                        <span class="text-center">Unfortunately, No Jobs Match Your Search.</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Left Sidebar End -->

        <!-- Right Sidebar Start -->
        <div class="col-lg-4 col-12 px-0 px-sm-3 px-md-5 find-jobs-right-sidebar">
            <!-- Trending Jobs Start -->
            @if($trending_jobs->count() > 0)
            <div class="row mb-5 px-3 px-md-0">
                <div class="right-trending-title text-center">
                    <h5 class="text-white py-2">Trending Jobs</h5>
                </div>

                <div class="job-trending-scroll shadow rounded">
                    @foreach($trending_jobs as $trending_job)
                    @php 
                    if($trending_job->Employer->MainEmployer) {
                        $trending_job_Employer = $trending_job->Employer->MainEmployer;
                    }else {
                        $trending_job_Employer = $trending_job->Employer;
                    }
                    @endphp
                    <a data-bs-toggle="modal" class="jobpostModal" data-bs-target="#JobPostModal{{$trending_job->id}}">
                        <div class="col-lg-12 border-bottom p-0">
                            <div class="m-0 my-2 trending-job-list rounded">
                                <div class="row m-0">
                                    <div class="col-xl-3 col-lg-12 col-4 text-center h-100 align-self-center">
                                        @if($trending_job_Employer->logo && $trending_job->hide_company == 0)
                                        <img src="{{ getS3File('employer_logo',$trending_job_Employer->logo) }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 100%" id="ProfilePreview">
                                        @else 
                                        <img src="{{ asset('img/icon/job-post.png') }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 100%" id="ProfilePreview">
                                        @endif
                                    </div>
                                    <div class="col-xl-9 col-lg-12 col-8 p-0">
                                        <div>
                                            <h3 id="trending-job-title">{{ $trending_job->job_title }}</h3>
                                            <span id="trending-job-sub-title">@if($trending_job->hide_company == 0) {{ $trending_job_Employer->name }} @if($trending_job_Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i>@endif @endif @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$trending_job->id)->count() > 0) <span class="badge badge-info"> Applied </span> @endif @endauth</span>
                                        </div>

                                        <div class="fz13">
                                            <span class="me-2 d-block" style="margin: 0px 0 -15px 0"><i class="fa fa-briefcase me-2"></i></i>{{ $trending_job->MainFunctionalArea->name }}</span>
                                            @if($trending_job->township_id )<span style="margin: -15px 0"><i class="fa fa-map-marker me-1" aria-hidden="true"></i> {{ $trending_job->Township->name }}</span> @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- Modal -->
                    @include('frontend.job-post-modal', ['jobPost' => $trending_job])
                    
                    @endforeach
                </div>
            </div>
            @endif
            <!-- Trending Jobs End -->

            <!-- Featured Jobs Start -->
            @if($feature_jobs->count() > 0)
            <div class="row mb-5 px-3 px-md-0">
                <div class="right-trending-title text-center">
                    <h5 class="text-white py-2">Featured Jobs</h5>
                </div>

                <div class="job-trending-scroll shadow rounded">
                    @foreach($feature_jobs as $feature_job)
                    @php 
                    if($feature_job->Employer->MainEmployer) {
                        $feature_job_Employer = $feature_job->Employer->MainEmployer;
                    }else {
                        $feature_job_Employer = $feature_job->Employer;
                    }
                    @endphp
                    <a data-bs-toggle="modal" data-bs-target="#FeatureJobPostModal{{$feature_job->id}}">
                        <div class="col-lg-12 border-bottom p-0">
                            <div class="m-0 my-2 trending-job-list rounded">
                                <div class="row m-0">
                                    <div class="col-xl-3 col-lg-12 col-4 text-center h-100 align-self-center">
                                        @if($feature_job_Employer->logo && $feature_job->hide_company == 0)
                                        <img src="{{ getS3File('employer_logo',$feature_job_Employer->logo) }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 100%" id="ProfilePreview">
                                        @else 
                                        <img src="{{ asset('img/icon/job-post.png') }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 100%" id="ProfilePreview">
                                        @endif
                                    </div>
                                    <div class="col-xl-9 col-lg-12 col-8 p-0">
                                        <div>
                                            <h3 id="trending-job-title">{{ $feature_job->job_title }}</h3>
                                            <span id="trending-job-sub-title">@if($feature_job->hide_company == 0) {{ $feature_job_Employer->name }} @if($feature_job_Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i>@endif @endif @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$feature_job->id)->count() > 0) <span class="badge badge-info"> Applied </span> @endif @endauth</span>
                                        </div>

                                        <div class="fz13">
                                            <span class="me-2 d-block" style="margin: 0px 0 -15px 0"><i class="fa fa-briefcase me-2"></i></i>{{ $feature_job->MainFunctionalArea->name }}</span>
                                            @if($feature_job->township_id )<span style="margin: -15px 0"><i class="fa fa-map-marker me-1" aria-hidden="true"></i> {{ $feature_job->Township->name }}</span> @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- Modal -->
                    @include('frontend.job-post-modal', ['jobPost' => $feature_job])
                    
                    @endforeach
                </div>
            </div>
            @endif
            <!-- Featured Jobs End -->
            
        </div>
        <!-- Right Sidebar End -->
    </div>
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        var loggedIn = "{{ Auth::guard('seeker')->user() ? session(['returnUrl' => '']) : session(['returnUrl' => 'jobpost-detail', 'previous_url' => url()->current()]) }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#function-area').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            includeSelectAllOption: true,
            nonSelectedText: "{{ __('message.Select function area') }}",
            numberDisplayed: 1
        });

        $("#industry").change(function() {
            event.preventDefault();
            $(".search-job-btn").click();
        });

        $("#job_type").change(function() {
            event.preventDefault();
            $(".search-job-btn").click();
        });

        $("#career_level").change(function() {
            event.preventDefault();
            $(".search-job-btn").click();
        });
        
        $("#qualification").change(function() {
            event.preventDefault();
            $(".search-job-btn").click();
        });

        $("#job_sorting").change(function() {
            event.preventDefault();
            $(".search-job-btn").click();
        })

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

        var show_error_modal = "{{ Session::get('error') }}";
        if(show_error_modal != '') {
            MSalert.principal({
                icon:'error',
                title:'Error',
                description: show_error_modal,
            })
        }

        @if(count($errors) > 0) 
        MSalert.principal({
            icon:'error',
            title:'Error',
            description: "Need to answer all questions.",
        })
        @endif

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

    function saveJob(id) {
        $.ajax({
            type: 'GET',
            data: id,
            url: "seeker/save-job/"+id,
        }).done(function(response){
            if(response.status == 'create') {
                
                $('.savejob-'+id).removeClass('fa-regular');
                $('.savejob-'+id).addClass('fa-solid');
            }else if(response.status == 'remove') {
                
                $('.savejob-'+id).removeClass('fa-solid');
                $('.savejob-'+id).addClass('fa-regular');
            }
        })
    }

    function applyJob(id) {
        $(this).attr('disabled','true');
        
    }
</script>
@endpush