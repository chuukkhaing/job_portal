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
                            <input type="text" class="form-control search-slt job-title" placeholder="Job title or keyword" name="job_title" @if(isset($_GET['job_title'])) value="{{ $_GET['job_title'] }}" @endif>
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
                            <select name="location" id="location" class="form-control search-slt location" placeholder="location" name="location">
                                <option value="" selected>Location</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}" @if(isset($_GET['location']) && $_GET['location'] == $state->id) selected @endif>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 p-0 mt-lg-0 mt-md-3">
                        <button type="submit" class="btn pull-right search-job-btn">Search Jobs</button>
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
                        <option value="">Job Sort By</option>
                        <option value="7" @if(isset($_GET['job_sorting']) && $_GET['job_sorting'] == "7") selected @endif >Last 7 Days</option>
                        <option value="30" @if(isset($_GET['job_sorting']) && $_GET['job_sorting'] == "30") selected @endif >Last 30 Days</option>
                    </select>
                </div>
            </div>
        </div>
        
    </div>
</form>
<div class="container my-3">
    <div class="row my-3">
        <div class="find-jobs-header py-3">
            <h3 class="find-jobs-title">Explore your career journey via {{ $jobPostsCount }} @if($jobPostsCount > 1) Jobs @else Job @endif</h3>
            {{--<span class="find-jobs-sub-title">Suggestions tailored to your profile, career preferences, and engagement history on our platform are provided to guide you towards the most relevant job opportunities.</span>--}}
        </div>
    </div>
    <div class="row">
        <!-- Left Sidebar Start -->
        @if($jobPosts->count() > 0)
        <div class="col-lg-8 m-0 p-lg-0 find-jobs-left-sidebar p-2">
            @foreach($jobPosts as $jobPost)
            <div class="row job-content mb-2">
                <!-- Job List Start -->
                <div class="col-md-2 col-3 align-self-center text-center py-2">
                    <a data-bs-toggle="modal" class="jobpostModal" data-bs-target="#JobPostModal{{$jobPost->id}}">
                        @if(($jobPost->job_post_type == 'feature' || $jobPost->job_post_type == 'trending') && $jobPost->Employer->logo && $jobPost->hide_company == 0)
                        <img src="{{ getS3File('employer_logo',$jobPost->Employer->logo) }}" alt="Profile Image" class="pb-2" id="job-post-preview-company-logo">
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
                        <div class="mt-1 job-company text-black">@if($jobPost->hide_company == 0) {{ $jobPost->Employer->name }} @if($jobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif @endif @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$jobPost->id)->count() > 0) <span class="badge badge-info"> Applied </span> @endif @endauth</div>
                        <div class="mt-1">{{ $jobPost->job_title }}</div>
                        @if($jobPost->township_id)
                        <div class="mt-1 job-location">{{ $jobPost->Township->name }}</div>
                        @endif
                        @if($jobPost->job_post_type == 'trending')
                        <p class="job-post-preview text-black text-wrap">{!! \Illuminate\Support\Str::limit(strip_tags($jobPost->job_requirement), $limit = 150, $end = '...') !!}</p>
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
                                            @if($jobPost->Employer->logo && $jobPost->hide_company == 0)
                                            <img src="{{ getS3File('employer_logo',$jobPost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobPost->Employer->name }}">
                                            @else
                                            <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="Employer Profile">
                                            @endif
                                            <div class="align-self-center">
                                                <span class="h4 fw-bold">{{ $jobPost->job_title }} @if($jobPost->no_of_candidate) ( {{ $jobPost->no_of_candidate }} - Posts ) @endif</span>
                                                @if($jobPost->hide_company == 0)
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
                                                    @if($jobPost->hide_company == 0)
                                                    <div class="col-10">
                                                        <h4 class="fw-bold text-black">{{ $jobPost->Employer->name }} @if($jobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="card job-post-detail-company-profile mb-2">
                                                    <div class="header">
                                                        <div class="row">
                                                            <div class="col-2 ">
                                                                @if($jobPost->Employer->logo && $jobPost->hide_company == 0)
                                                                <img src="{{ getS3File('employer_logo',$jobPost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $jobPost->Employer->name }}">
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
                                                                    <img src="{{ getS3File('employer_logo',$jobPost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $jobPost->Employer->name }}">
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
                                @if($jobPost->hide_company == 0)
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
                    <a data-bs-toggle="modal" class="jobpostModal" data-bs-target="#JobPostModal{{$trending_job->id}}">
                        <div class="col-lg-12 border-bottom p-0">
                            <div class="m-0 my-2 trending-job-list rounded">
                                <div class="row m-0">
                                    <div class="col-xl-3 col-lg-12 col-4 text-center h-100 align-self-center">
                                        @if($trending_job->Employer->logo && $trending_job->hide_company == 0)
                                        <img src="{{ getS3File('employer_logo',$trending_job->Employer->logo) }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 100%" id="ProfilePreview">
                                        @else 
                                        <img src="{{ asset('img/icon/job-post.png') }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 100%" id="ProfilePreview">
                                        @endif
                                    </div>
                                    <div class="col-xl-9 col-lg-12 col-8 p-0">
                                        <div>
                                            <h3 id="trending-job-title">{{ $trending_job->job_title }}</h3>
                                            <span id="trending-job-sub-title">@if($trending_job->hide_company == 0) {{ $trending_job->Employer->name }} @if($trending_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i>@endif @endif @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$trending_job->id)->count() > 0) <span class="badge badge-info"> Applied </span> @endif @endauth</span>
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
                    <div class="modal fade" id="JobPostModal{{$trending_job->id}}" tabindex="-1" aria-labelledby="JobPostModal{{$trending_job->id}}Label" aria-hidden="true">
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
                                                    @if($trending_job->Employer->logo && $trending_job->hide_company == 0)
                                                    <img src="{{ getS3File('employer_logo',$trending_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $trending_job->Employer->name }}">
                                                    @else
                                                    <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $trending_job->Employer->name }}">
                                                    @endif
                                                    <div class="align-self-center">
                                                        <span class="h4 fw-bold">{{ $trending_job->job_title }} @if($trending_job->no_of_candidate) ( {{ $trending_job->no_of_candidate }} - Posts ) @endif</span>
                                                        @if($trending_job->hide_company == 0)
                                                        <div><a class="text-muted h6" href="{{ route('company-detail',$trending_job->Employer->slug ?? '') }}">{{ $trending_job->Employer->name }} @if($trending_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</a></div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 col-xl-5 mb-2 align-self-center">
                                                    <div>
                                                        <span>{{ $trending_job->job_type }} @if($trending_job->country == 'Myanmar') | {{ $trending_job->State->name ?? '' }}, {{ $trending_job->Township->name ?? '' }} @endif {{ $trending_job->gender }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-muted">Salary Range:</span>
                                                        <span class="h5 fw-bold">@if($trending_job->hide_salary == 1) Negotiate @else {{ $trending_job->salary_range }} {{ $trending_job->currency }} @endif</span>
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
                                                            if($seeker_job->job_post_id == $trending_job->id){
                                                                $disabled = 'disabled';
                                                                $btn_text = 'Applied';
                                                            }
                                                        }
                                                        @endphp
                                                    @endauth
                                                    @auth('seeker')
                                                        <a href="{{ route('jobpost-apply', $trending_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3" onclick="applyJob({{ $trending_job->id }})">
                                                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                                        </a>
                                                    @elseauth('employer')
                                                    @else
                                                        <a href="{{ route('jobpost-apply', $trending_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3" onclick="applyJob({{ $trending_job->id }})">
                                                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                                        </a>
                                                    @endguest
                                                        <div>
                                                            <small>Posted {{ $trending_job->updated_at->shortRelativeDiffForHumans() }}</small>
                                                        </div>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="card-body p-0">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <button class="p-md-3 p-2 job-post-detail nav-link active" id="nav-job-description-{{$trending_job->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-job-description-{{$trending_job->id}}" type="button" role="tab" aria-controls="nav-job-description-{{$trending_job->id}}" aria-selected="true">Job Description</button>
                                                    @if($trending_job->hide_company != 1)
                                                    <button class="p-md-3 p-2 job-post-detail nav-link" id="nav-company-profile-{{$trending_job->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-company-profile-{{$trending_job->id}}" type="button" role="tab" aria-controls="nav-company-profile-{{$trending_job->id}}" aria-selected="false">Company Profile</button>
                                                    @endif
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane p-3 fade show active" id="nav-job-description-{{$trending_job->id}}" role="tabpanel" aria-labelledby="nav-job-description-{{$trending_job->id}}-tab">
                                                    @if($trending_job->JobPostSkill->count() > 0)
                                                    <h5 class="fw-bold text-black">Skills</h5>
                                                    <div class="badge-group mb-3">
                                                        @foreach($trending_job->JobPostSkill as $trending_jobSkill)
                                                        <span class="my-1 badge text-white fz14 rounede-3 py-2 px-3 text-wrap" style="background: #0355d0">{{ $trending_jobSkill->Skill->name }}</span>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                    <h5 class="fw-bold text-black">Experience Level :</h5>
                                                    <div class="mb-4 fz14 fw-bold">{{ $trending_job->experience_level }}</div>
                                                    <h5 class="fw-bold text-black">Qualification :</h5>
                                                    <div class="mb-4 fz14 fw-bold">{{ $trending_job->degree }}</div>
                                                    <h5 class="fw-bold text-black">Job Specializations :</h5>
                                                    <div class="mb-4 fz14 fw-bold">{{ $trending_job->MainFunctionalArea->name }} , {{ $trending_job->SubFunctionalArea->name }}</div>
                                                    @if($trending_job->job_description)
                                                    <h5 class="fw-bold text-black">Job Description</h5>
                                                    <div class="mb-4">
                                                        <p class="fz15">
                                                            {!! $trending_job->job_description ?? '-' !!}
                                                        </p>
                                                    </div>
                                                    @endif
                                                    @if($trending_job->job_requirement)
                                                    <h5 class="fw-bold text-black">Job Requirement</h5>
                                                    <div class="mb-4">
                                                        <p class="fz15">
                                                            {!! $trending_job->job_requirement ?? '-' !!}
                                                        </p>
                                                    </div>
                                                    @endif
                                                    @if($trending_job->benefit)
                                                    <h5 class="fw-bold text-black">Job Benefit</h5>
                                                    <div class="mb-4">
                                                        <p class="fz15">
                                                            {!! $trending_job->benefit ?? '-' !!}
                                                        </p>
                                                    </div>
                                                    @endif
                                                    @if($trending_job->job_highlight)
                                                    <h5 class="fw-bold text-black">Job Highlight</h5>
                                                    <div class="mb-4">
                                                        <p class="fz15">
                                                            {!! $trending_job->job_highlight ?? '-' !!}
                                                        </p>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="tab-pane fade" id="nav-company-profile-{{$trending_job->id}}" role="tabpanel" aria-labelledby="nav-company-profile-{{$trending_job->id}}-tab">
                                                    <div class=" p-1 d-none d-lg-block">
                                                        <div class="row py-3">
                                                            <div class="col-2">
                                                                
                                                            </div>
                                                            @if($trending_job->hide_company == 0)
                                                            <div class="col-10">
                                                                <h4 class="fw-bold text-black">{{ $trending_job->Employer->name }} @if($trending_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="card job-post-detail-company-profile mb-2">
                                                            <div class="header">
                                                                <div class="row">
                                                                    <div class="col-2 ">
                                                                        @if($trending_job->Employer->logo && $trending_job->hide_company == 0)
                                                                        <img src="{{ getS3File('employer_logo',$trending_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $trending_job->Employer->name }}">
                                                                        @else
                                                                        <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="Employer Profile">
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-10 py-4">
                                                                        <h5 class="fw-bold text-dark">Company Overview</h5>
                                                                        @if($trending_job->Employer->summary)
                                                                        <p class="mb-4">
                                                                            {!! $trending_job->Employer->summary !!}
                                                                        </p>
                                                                        @endif
                                                                        <h5 class="fw-bold text-dark">Specialties:</h5>
                                                                        @if($trending_job->Employer->Industry->name)
                                                                        <span class="mb-4 btn border seeker_image_input_label">
                                                                            {{ $trending_job->Employer->Industry->name }}
                                                                        </span>
                                                                        @endif
                                                                        @if($trending_job->Employer->website)
                                                                        <h5 class="fw-bold text-dark">Company Website:</h5>
                                                                        <p class="mb-4">
                                                                            <a href="{{ $trending_job->Employer->website }}" target="_blank"><small><strong>{{ $trending_job->Employer->website }}</strong></small></a>
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
                                                                    @if($trending_job->Employer->Industry->name)
                                                                    <div class="col">
                                                                        <h6 class="fw-bold text-dark">Industry Type</h6>
                                                                        <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                            {{ $trending_job->Employer->Industry->name }}
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
                                                                        {!! $trending_job->Employer->value ?? '-' !!}
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
                                                                            @if($trending_job->Employer->logo && $trending_job->hide_company == 0)
                                                                            <img src="{{ getS3File('employer_logo',$trending_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $trending_job->Employer->name }}">
                                                                            @else
                                                                            <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="Employer Profile">
                                                                            @endif
                                                                        </div>
                                                                        @if($trending_job->hide_company == 0)
                                                                        <h4 class="fw-bold text-black job-post-company-name">{{ $trending_job->Employer->name }} @if($trending_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                                        @endif
                                                                        <h5 class="fw-bold text-dark">Company Overview</h5>
                                                                        @if($trending_job->Employer->summary)
                                                                        <p class="mb-4">
                                                                            {!! $trending_job->Employer->summary !!}
                                                                        </p>
                                                                        @endif
                                                                        @if($trending_job->Employer->EmployerAddress->count() > 0)
                                                                        <h5 class="fw-bold text-dark">Address:</h5>
                                                                        <span class="mb-4 btn border seeker_image_input_label">
                                                                            
                                                                                @if($trending_job->Employer->EmployerAddress->first()->address_detail)
                                                                                <p>{{ $trending_job->Employer->EmployerAddress->first()->address_detail }}</p>
                                                                                @else
                                                                                <p>@if($trending_job->Employer->EmployerAddress->first()->country == 'Myanmar') {{ $trending_job->Employer->EmployerAddress->first()->State->name ?? '' }}, @if($trending_job->Employer->EmployerAddress->first()->township_id) {{ $trending_job->Employer->EmployerAddress->first()->Township->name }}, @endif {{ $trending_job->Employer->EmployerAddress->first()->country }} @endif</p>
                                                                                @endif
                                                                            
                                                                        </span>
                                                                        @endif
                                                                        @if($trending_job->Employer->website)
                                                                        <h5 class="fw-bold text-dark">Company Website:</h5>
                                                                        <p class="mb-4">
                                                                            <a href="{{ $trending_job->Employer->website }}" target="_blank"><small><strong>{{ $trending_job->Employer->website }}</strong></small></a>
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
                                                                    @if($trending_job->Employer->Industry->name)
                                                                    <div class="col-12 col-lg-4">
                                                                        <h6 class="fw-bold text-dark">Industry Type</h6>
                                                                        <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                            {{ $trending_job->Employer->Industry->name }}
                                                                        </p>
                                                                    </div>
                                                                    @endif
                                                                    <div class="col-12 col-lg-4">
                                                                        <h6 class="fw-bold text-dark">Company Size:</h6>
                                                                        <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                            {{ $trending_job->Employer->no_of_employees ?? '-' }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-12 col-lg-4">
                                                                        <h6 class="fw-bold text-dark">No of Office:</h6>
                                                                        <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                            {{ $trending_job->Employer->no_of_offices ?? '-' }}
                                                                        </p>
                                                                    </div>
                                                                    <h5 class="fw-bold text-dark">Vision, Mission, Value</h5>
                                                                    <p class="mb-4">
                                                                        {!! $trending_job->Employer->value ?? '-' !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($trending_job->hide_company == 0)
                                        <div class="card-footer text-center">
                                            <a href="{{ route('company-jobs', $trending_job->Employer->id) }}" class="btn btn-sm text-white" style="background-color: #0355d0;">See more jobs from this company</a>
                                        </div>
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success copyText" onclick="copyText('{{ route('jobpost-detail', $trending_job->slug) }}')"  ><i class="fa-solid fa-copy"></i> Copy to Clipboard</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    @auth('seeker')
                                        <a href="{{ route('jobpost-apply', $trending_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                        </a>
                                    @elseauth('employer')
                                    @else
                                        <a href="{{ route('jobpost-apply', $trending_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                        </a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <a data-bs-toggle="modal" data-bs-target="#FeatureJobPostModal{{$feature_job->id}}">
                        <div class="col-lg-12 border-bottom p-0">
                            <div class="m-0 my-2 trending-job-list rounded">
                                <div class="row m-0">
                                    <div class="col-xl-3 col-lg-12 col-4 text-center h-100 align-self-center">
                                        @if($feature_job->Employer->logo && $feature_job->hide_company == 0)
                                        <img src="{{ getS3File('employer_logo',$feature_job->Employer->logo) }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 100%" id="ProfilePreview">
                                        @else 
                                        <img src="{{ asset('img/icon/job-post.png') }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 100%" id="ProfilePreview">
                                        @endif
                                    </div>
                                    <div class="col-xl-9 col-lg-12 col-8 p-0">
                                        <div>
                                            <h3 id="trending-job-title">{{ $feature_job->job_title }}</h3>
                                            <span id="trending-job-sub-title">@if($feature_job->hide_company == 0) {{ $feature_job->Employer->name }} @if($feature_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i>@endif @endif @auth('seeker') @if(Auth::guard('seeker')->user()->JobApply->where('job_post_id',$feature_job->id)->count() > 0) <span class="badge badge-info"> Applied </span> @endif @endauth</span>
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
                    <div class="modal fade" id="FeatureJobPostModal{{$feature_job->id}}" tabindex="-1" aria-labelledby="FeatureJobPostModal{{$feature_job->id}}Label" aria-hidden="true">
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
                                                    @if($feature_job->Employer->logo && $feature_job->hide_company == 0)
                                                    <img src="{{ getS3File('employer_logo',$feature_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $feature_job->Employer->name }}">
                                                    @else
                                                    <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="Employer Profile">
                                                    @endif
                                                    <div class="align-self-center">
                                                        <span class="h4 fw-bold">{{ $feature_job->job_title }} @if($feature_job->no_of_candidate) ( {{ $feature_job->no_of_candidate }} - Posts ) @endif</span>
                                                        @if($feature_job->hide_company == 0)
                                                        <div><a class="text-muted h6" href="{{ route('company-detail',$feature_job->Employer->slug ?? '') }}">{{ $feature_job->Employer->name }} @if($feature_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</a></div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6 col-xl-5 mb-2 align-self-center">
                                                    <div>
                                                        <span>{{ $feature_job->job_type }} @if($feature_job->country == 'Myanmar') | {{ $feature_job->State->name ?? '' }}, {{ $feature_job->Township->name ?? '' }} @endif {{ $feature_job->gender }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-muted">Salary Range:</span>
                                                        <span class="h5 fw-bold">@if($feature_job->hide_salary == 1) Negotiate @else {{ $feature_job->salary_range }} {{ $feature_job->currency }} @endif</span>
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
                                                            if($seeker_job->job_post_id == $feature_job->id){
                                                                $disabled = 'disabled';
                                                                $btn_text = 'Applied';
                                                            }
                                                        }
                                                        @endphp
                                                    @endauth
                                                    @auth('seeker')
                                                        <a href="{{ route('jobpost-apply', $feature_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3" onclick="applyJob({{ $feature_job->id }})" >
                                                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                                        </a>
                                                    @elseauth('employer')
                                                    @else
                                                        <a href="{{ route('jobpost-apply', $feature_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3" onclick="applyJob({{ $feature_job->id }})" >
                                                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                                        </a>
                                                    @endguest
                                                        <div>
                                                            <small>Posted {{ $feature_job->updated_at->shortRelativeDiffForHumans() }}</small>
                                                        </div>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="card-body p-0">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <button class="p-md-3 p-2 job-post-detail nav-link active" id="nav-job-description-{{$feature_job->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-job-description-{{$feature_job->id}}" type="button" role="tab" aria-controls="nav-job-description-{{$feature_job->id}}" aria-selected="true">Job Description</button>
                                                    @if($feature_job->hide_company != 1)
                                                    <button class="p-md-3 p-2 job-post-detail nav-link" id="nav-company-profile-{{$feature_job->id}}-tab" data-bs-toggle="tab" data-bs-target="#nav-company-profile-{{$feature_job->id}}" type="button" role="tab" aria-controls="nav-company-profile-{{$feature_job->id}}" aria-selected="false">Company Profile</button>
                                                    @endif
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane p-3 fade show active" id="nav-job-description-{{$feature_job->id}}" role="tabpanel" aria-labelledby="nav-job-description-{{$feature_job->id}}-tab">
                                                    @if($feature_job->JobPostSkill->count() > 0)
                                                    <h5 class="fw-bold text-black">Skills</h5>
                                                    <div class="badge-group mb-3">
                                                        @foreach($feature_job->JobPostSkill as $feature_jobSkill)
                                                        <span class="my-1 badge text-white fz14 rounede-3 py-2 px-3 text-wrap" style="background: #0355d0">{{ $feature_jobSkill->Skill->name }}</span>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                    <h5 class="fw-bold text-black">Experience Level :</h5>
                                                    <div class="mb-4 fz14 fw-bold">{{ $feature_job->experience_level }}</div>
                                                    <h5 class="fw-bold text-black">Qualification :</h5>
                                                    <div class="mb-4 fz14 fw-bold">{{ $feature_job->degree }}</div>
                                                    <h5 class="fw-bold text-black">Job Specializations :</h5>
                                                    <div class="mb-4 fz14 fw-bold">{{ $feature_job->MainFunctionalArea->name }} , {{ $feature_job->SubFunctionalArea->name }}</div>
                                                    @if($feature_job->job_description)
                                                    <h5 class="fw-bold text-black">Job Description</h5>
                                                    <div class="mb-4">
                                                        <p class="fz15">
                                                            {!! $feature_job->job_description ?? '-' !!}
                                                        </p>
                                                    </div>
                                                    @endif
                                                    @if($feature_job->job_requirement)
                                                    <h5 class="fw-bold text-black">Job Requirement</h5>
                                                    <div class="mb-4">
                                                        <p class="fz15">
                                                            {!! $feature_job->job_requirement ?? '-' !!}
                                                        </p>
                                                    </div>
                                                    @endif
                                                    @if($feature_job->benefit)
                                                    <h5 class="fw-bold text-black">Job Benefit</h5>
                                                    <div class="mb-4">
                                                        <p class="fz15">
                                                            {!! $feature_job->benefit ?? '-' !!}
                                                        </p>
                                                    </div>
                                                    @endif
                                                    @if($feature_job->job_highlight)
                                                    <h5 class="fw-bold text-black">Job Highlight</h5>
                                                    <div class="mb-4">
                                                        <p class="fz15">
                                                            {!! $feature_job->job_highlight ?? '-' !!}
                                                        </p>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="tab-pane fade" id="nav-company-profile-{{$feature_job->id}}" role="tabpanel" aria-labelledby="nav-company-profile-{{$feature_job->id}}-tab">
                                                    <div class=" p-1 d-none d-lg-block">
                                                        <div class="row py-3">
                                                            <div class="col-2">
                                                                
                                                            </div>
                                                            @if($feature_job->hide_company == 0)
                                                            <div class="col-10">
                                                                <h4 class="fw-bold text-black">{{ $feature_job->Employer->name }} @if($feature_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="card job-post-detail-company-profile mb-2">
                                                            <div class="header">
                                                                <div class="row">
                                                                    <div class="col-2 ">
                                                                        @if($feature_job->Employer->logo && $feature_job->hide_company == 0)
                                                                        <img src="{{ getS3File('employer_logo',$feature_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $feature_job->Employer->name }}">
                                                                        @else
                                                                        <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="Employer Profile">
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-10 py-4">
                                                                        <h5 class="fw-bold text-dark">Company Overview</h5>
                                                                        @if($feature_job->Employer->summary)
                                                                        <p class="mb-4">
                                                                            {!! $feature_job->Employer->summary !!}
                                                                        </p>
                                                                        @endif
                                                                        <h5 class="fw-bold text-dark">Specialties:</h5>
                                                                        @if($feature_job->Employer->Industry->name)
                                                                        <span class="mb-4 btn border seeker_image_input_label">
                                                                            {{ $feature_job->Employer->Industry->name }}
                                                                        </span>
                                                                        @endif
                                                                        @if($feature_job->Employer->website)
                                                                        <h5 class="fw-bold text-dark">Company Website:</h5>
                                                                        <p class="mb-4">
                                                                            <a href="{{ $feature_job->Employer->website }}" target="_blank"><small><strong>{{ $feature_job->Employer->website }}</strong></small></a>
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
                                                                    @if($feature_job->Employer->Industry->name)
                                                                    <div class="col">
                                                                        <h6 class="fw-bold text-dark">Industry Type</h6>
                                                                        <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                            {{ $feature_job->Employer->Industry->name }}
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
                                                                        {!! $feature_job->Employer->value ?? '-' !!}
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
                                                                            @if($feature_job->Employer->logo && $feature_job->hide_company == 0)
                                                                            <img src="{{ getS3File('employer_logo',$feature_job->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $feature_job->Employer->name }}">
                                                                            @else
                                                                            <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="Employer Profile">
                                                                            @endif
                                                                        </div>
                                                                        @if($feature_job->hide_company == 0)
                                                                        <h4 class="fw-bold text-black job-post-company-name">{{ $feature_job->Employer->name }} @if($feature_job->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                                                        @endif
                                                                        <h5 class="fw-bold text-dark">Company Overview</h5>
                                                                        @if($feature_job->Employer->summary)
                                                                        <p class="mb-4">
                                                                            {!! $feature_job->Employer->summary !!}
                                                                        </p>
                                                                        @endif
                                                                        @if($feature_job->Employer->EmployerAddress->count() > 0)
                                                                        <h5 class="fw-bold text-dark">Address:</h5>
                                                                        <span class="mb-4 btn border seeker_image_input_label">
                                                                            
                                                                                @if($feature_job->Employer->EmployerAddress->first()->address_detail)
                                                                                <p>{{ $feature_job->Employer->EmployerAddress->first()->address_detail }}</p>
                                                                                @else
                                                                                <p>@if($feature_job->Employer->EmployerAddress->first()->country == 'Myanmar') {{ $feature_job->Employer->EmployerAddress->first()->State->name ?? '' }}, @if($feature_job->Employer->EmployerAddress->first()->township_id) {{ $feature_job->Employer->EmployerAddress->first()->Township->name }}, @endif {{ $feature_job->Employer->EmployerAddress->first()->country }} @endif</p>
                                                                                @endif
                                                                            
                                                                        </span>
                                                                        @endif
                                                                        @if($feature_job->Employer->website)
                                                                        <h5 class="fw-bold text-dark">Company Website:</h5>
                                                                        <p class="mb-4">
                                                                            <a href="{{ $feature_job->Employer->website }}" target="_blank"><small><strong>{{ $feature_job->Employer->website }}</strong></small></a>
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
                                                                    @if($feature_job->Employer->Industry->name)
                                                                    <div class="col-12 col-lg-4">
                                                                        <h6 class="fw-bold text-dark">Industry Type</h6>
                                                                        <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                            {{ $feature_job->Employer->Industry->name }}
                                                                        </p>
                                                                    </div>
                                                                    @endif
                                                                    <div class="col-12 col-lg-4">
                                                                        <h6 class="fw-bold text-dark">Company Size:</h6>
                                                                        <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                            {{ $feature_job->Employer->no_of_employees ?? '-' }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-12 col-lg-4">
                                                                        <h6 class="fw-bold text-dark">No of Office:</h6>
                                                                        <p class="mb-4 btn border seeker_image_input_label w-100">
                                                                            {{ $feature_job->Employer->no_of_offices ?? '-' }}
                                                                        </p>
                                                                    </div>
                                                                    <h5 class="fw-bold text-dark">Vision, Mission, Value</h5>
                                                                    <p class="mb-4">
                                                                        {!! $feature_job->Employer->value ?? '-' !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($feature_job->hide_company == 0)
                                        <div class="card-footer text-center">
                                            <a href="{{ route('company-jobs', $feature_job->Employer->id) }}" class="btn btn-sm text-white" style="background-color: #0355d0;">See more jobs from this company</a>
                                        </div>
                                        @endif
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success copyText" onclick="copyText('{{ route('jobpost-detail', $feature_job->slug) }}')"  ><i class="fa-solid fa-copy"></i> Copy to Clipboard</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    @auth('seeker')
                                        <a href="{{ route('jobpost-apply', $feature_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                        </a>
                                    @elseauth('employer')
                                    @else
                                        <a href="{{ route('jobpost-apply', $feature_job->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                        </a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
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
            nonSelectedText: "Select function area",
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
        $(this).on('submit', function(){
            $(this).attr('disabled','true');
        })
    }
</script>
@endpush