@extends('frontend.layouts.app')
@section('content')
<!-- Banner Start -->
<div class="container-fluid p-3">
    <div class="row company-detail-banner">
        @if($jobpost->Employer->background)
        <img src="{{ asset('storage/employer_background/'. $jobpost->Employer->background) }}" class="w-100" style="max-height : 400px" alt="{{ $jobpost->Employer->name }}">
        @else
        <img src="{{ asset('/frontend/img/company/company-banner-image.png') }}" class="w-100" alt="{{ $jobpost->Employer->name }}">
        @endif
    </div>
</div>
<!-- Banner End -->

<!-- Job Post Profile Start -->
<div class="container">
    <div class="row pt-3 px-3">
        <div class="col-lg-6 col-md-6 col-6">
            @if($jobpost->Employer->logo)
            <img src="{{ asset('storage/employer_logo/'.$jobpost->Employer->logo) }}" class="" style="width: 120px; height: 120px" alt="{{ $jobpost->Employer->name }}">
            @else
            <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="" style="width: 120px; height: 120px" alt="{{ $jobpost->Employer->name }}">
            @endif
            <div class="company-name pt-4 pb-2">
                <h3>{{ $jobpost->job_title }}</h3>
                <span>{{ $jobpost->Employer->name }}</span>
                <h3>{{ $jobpost->gender }} @if($jobpost->no_of_candidate) ( {{ $jobpost->no_of_candidate }} - Posts ) @endif</h3>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-6 align-self-end">
            <div class="float-end pb-2">
                @php
                    $disabled = '';
                    $btn_text = 'Apply Job';
                @endphp
                @auth('seeker')
                    @php
                    foreach(Auth::guard('seeker')->user()->JobApply as $seeker_job){
                        if($seeker_job->job_post_id == $jobpost->id){
                            $disabled = 'disabled';
                            $btn_text = 'Applied';
                        }
                    }
                    @endphp
                @endauth
                @auth('seeker')
                <a href="{{ route('jobpost-apply', $jobpost->id) }}" class="{{ $disabled }} btn apply-company-btn py-2">
                    <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="p-1">Apply Job</span>
                </a>
                <a href="http://" class="btn btn-outline-primary py-2">
                    <i class="fa fa-heart-o p-1 fw-bold"></i><span class="p-1">Save Job</span>
                </a>
                @elseauth('employer')
                @else
                    <a href="{{ route('jobpost-apply', $jobpost->id) }}" class="{{ $disabled }} btn apply-company-btn py-2">
                        <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="p-1">Apply Job</span>
                    </a>
                    <a href="http://" class="btn btn-outline-primary py-2">
                        <i class="fa fa-heart-o p-1 fw-bold"></i><span class="p-1">Save Job</span>
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <div class="row pt-3 px-3">
        <div class="col-12">
            <div class="company-name pt-4 pb-2">
                <span>@if($jobpost->country == 'Myanmar' && $jobpost->township_id) {{ $jobpost->State->name }}, {{ $jobpost->country }} @elseif($jobpost->country == 'Other') {{ $jobpost->country }} @endif</span>
                <h3>@if($jobpost->hide_salary == 1) Negotiate @else {{ $jobpost->salary_range }} {{ $jobpost->currency }} @endif - {{ $jobpost->job_type }}</h3>
                @if($jobpost->JobPostSkill->count() > 0)
                <div class="col-12 pt-3">
                    <h6 class="fw-bold">Skill</h6>
                    @foreach($jobpost->JobPostSkill as $jobpostSkill)
                    <span class="badge text-light bg-success">{{ $jobpostSkill->Skill->name }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row pt-3 px-3">
        <div class="col-lg-2 col-md-3 col-6">
            <div class="company-name pt-4 pb-2">
                <h3>Career Level</h3>
                <span>{{ $jobpost->career_level }}</span>
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-6">
            <div class="company-name pt-4 pb-2">
                <h3>Years of Experience</h3>
                <span>{{ $jobpost->experience_level }}</span>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-6">
            <div class="company-name pt-4 pb-2">
                <h3>Job Specializations</h3>
                <span>{{ $jobpost->MainFunctionalArea->name }} , {{ $jobpost->SubFunctionalArea->name }}</span>
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-6">
            <div class="company-name pt-4 pb-2">
                <h3>Qualification</h3>
                <span>{{ $jobpost->degree }}</span>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-6">
            <div class="company-name pt-4 pb-2">
                <h3>Job Type</h3>
                <span>{{ $jobpost->job_type }}</span>
            </div>
        </div>
    </div>
</div>
<!-- Job Post Profile End -->

<div class="container">
    <div class="row col-12 m-0 p-0 mt-5">
        <!-- Job Post Detail Start-->
        <div class="col-lg-7 col-12">
            <div class="row col-12 m-0 p-0 py-3">
                <h5 class="fw-bolder fs-6">Job Description</h5>
                <p>
                    {!! $jobpost->job_description ?? '-' !!}
                </p>
            </div>

            <div class="row col-12 m-0 p-0 py-3">
                <h5 class="fw-bolder fs-6">Job Requirements</h5>          
                <p>
                    {!! $jobpost->job_requirement ?? '-' !!}
                </p>
            </div>

            <div class="row col-12 m-0 p-0 py-3">
                <h5 class="fw-bolder fs-6">Job Benefits</h5>          
                <p>
                    {{ $jobpost->benefit ?? '-' }}
                </p>
            </div>
            <div class="row col-12 m-0 p-0 py-3">
                <h5 class="fw-bolder fs-6">Job Highlight</h5>          
                <p>
                    {{ $jobpost->job_highlight ?? '-' }}
                </p>
            </div>
            <div class="row col-12 m-0 p-0 py-3">
                <h5 class="fw-bolder fs-6">Company Overview</h5> 
                <div>
                    <ul>
                        @if($jobpost->Employer->no_of_employees)
                        <li><div class="row"><div class="col-1">Size</div><div class="col-11"><strong>{{ $jobpost->Employer->no_of_employees }} Employee</strong></div></div></li>
                        @endif
                        @if($jobpost->Employer->OwnerShipType->name)
                        <li><div class="row"><div class="col-1">Type</div><div class="col-11"><strong>{{ $jobpost->Employer->OwnerShipType->name ?? '' }}</strong></div></div></li>
                        @endif
                        @if($jobpost->Employer->website)
                        <li><div class="row"><div class="col-1">Website</div><div class="col-11"><a href="{{ $jobpost->Employer->website }}"><strong>{{ $jobpost->Employer->website }}</strong></a></div></div></li>
                        @endif
                    </ul>
                </div>
                @if($jobpost->summary)
                <div class="row col-12 m-0 p-0 py-3">
                    <p>
                        {{ $jobpost->Employer->summary ?? '-' }}
                    </p>
                </div>
                @endif
                @if($jobpost->Employer->EmployerMedia->where('type','Image')->count() > 0)         
                <p>
                    @foreach($jobpost->Employer->EmployerMedia->where('type','Image') as $image)
                    <div class="col-lg-3 col-md-3 p-0 company-photo">
                        <img src="{{ asset('storage/employer_media/'.$image->name) }}" class="w-100 py-1 pe-2" height="200px" alt="">
                    </div>
                    @endforeach
                </p>
                @endif
            </div>
            
        </div>
        <!-- Job Post Detail End-->

        <!-- Similar Jobs Start-->
        <div class="col-lg-5 col-12">
            <div class="px-3 m-0 pb-0 pt-3">
                <h5 class="text-blue fw-bolder">More Similar Jobs</h5>
            </div>
            
            <div class="row m-0 pb-0">
                @if($similar_jobs->count() > 0)
                @foreach($similar_jobs as $similar_job)
                <a href="{{ route('jobpost-detail', $similar_job->slug) }}">
                <div class="col-12">
                    <div class="m-0 pb-0 border-bottom">
                        <div class="row p-0 m-0">
                            <div class="col-lg-10 col-md-10 py-4 px-1">
                                <div class="row m-0">
                                    <div class="col-lg-2 col-12 job-image p-0 px-1">
                                        @if($similar_job->Employer->logo)
                                        <img src="{{ asset('storage/employer_logo/'.$similar_job->Employer->logo) }}" alt="{{ $similar_job->Employer->name }}" class="seeker-profile rounded-circle" alt="{{ $similar_job->Employer->name }}">
                                        @else 
                                        <img src="{{ asset('img/profile.svg') }}" alt="{{ $similar_job->Employer->name }}" class="seeker-profile rounded-circle" alt="{{ $similar_job->Employer->name }}">
                                        @endif
                                    </div>
        
                                    <div class="col-lg-10 col-12">
                                        <div class="job-company">{{ $similar_job->Employer->name }}</div>
                                        <div class="job-title">{{ $similar_job->job_title }}</div>
                                        <div class="job-location">@if($jobpost->country == 'Myanmar' && $jobpost->township_id) {{ $jobpost->State->name }}, {{ $jobpost->country }} @elseif($jobpost->country == 'Other') {{ $jobpost->country }} @endif</div>
                                        <div class="job-salary my-3">@if($jobpost->hide_salary == 1) Negotiate @else {{ $jobpost->salary_range }} {{ $jobpost->currency }} @endif</div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4 px-1">
                                <div class="row col-12 m-0 p-0">
                                    <div class="text-end px-0">
                                        <i class="fa fa-heart-o text-blue"></i>
                                    </div>
            
                                    <div class="text-end mt-auto  px-0">
                                        <span>{{ $jobpost->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
                @endforeach
                @else 
                @endif
            </div>
        </div>
        <!-- Similar Jobs End-->
    </div>
</div>

@endsection