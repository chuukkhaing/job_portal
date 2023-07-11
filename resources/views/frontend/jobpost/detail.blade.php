@extends('frontend.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-4 my-5">
            <div class="ex3">
                <a href="{{ route('jobpost-detail', $jobpost->slug) }}">
                    <div class="m-0 mb-2 pb-0 seeker-job-list active rounded">
                        <div class="row m-0">
                            <div class="col-2">
                                @if($jobpost->Employer->logo)
                                <img src="{{ asset('storage/employer_logo/'.$jobpost->Employer->logo) }}" alt="Profile Image" class="seeker-profile rounded-circle" style="width: 55px" id="ProfilePreview">
                                @else 
                                <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" style="width: 55px" id="ProfilePreview">
                                @endif
                            </div>
                            <div class="col-6">
                                <span class="jobpost-attr">{{ $jobpost->Employer->name }}</span>
                                <h5>{{ $jobpost->job_title }}</h5>
                                @if($jobpost->state_id)
                                <span class="jobpost-attr">{{ $jobpost->State->name }} ,</span>
                                @endif
                                @if($jobpost->township_id)
                                <span class="jobpost-attr">{{ $jobpost->Township->name }}</span>
                                @endif
                                @if($jobpost->country == 'Other') 
                                <span class="jobpost-attr">Other Country</span>
                                @endif
                                @if($jobpost->salary_status == 'Negotiable')
                                <p style="color: #181722">Negotiate</p>
                                @endif
                                @if($jobpost->salary_status != 'Hide' && $jobpost->salary_status != 'Negotiable')
                                @if($jobpost->salary_range)
                                <p style="color: #181722">{{ $jobpost->salary_range }} {{ $jobpost->currency }}</p>
                                @endif
                                @endif
                            </div>
                            <div class="col-4 d-flex align-items-end flex-column bd-highlight mb-3">
                                <div class="text-end py-2 bd-highlight job-post-fav"><i class="fa-regular fa-heart"></i></div>
                                <div class="mt-auto bd-highlight">
                                <span>{{ $jobpost->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @if($jobposts->count() >0)
                @foreach($jobposts as $jobPost_detail)
                <a href="{{ route('jobpost-detail', $jobPost_detail->slug) }}">
                    <div class="m-0 mb-2 pb-0 seeker-job-list rounded">
                        <div class="row m-0">
                            <div class="col-2">
                                @if($jobPost_detail->Employer->logo)
                                <img src="{{ asset('storage/employer_logo/'.$jobPost_detail->Employer->logo) }}" alt="Profile Image" class="seeker-profile rounded-circle" style="width: 55px" id="ProfilePreview">
                                @else 
                                <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" style="width: 55px" id="ProfilePreview">
                                @endif
                            </div>
                            <div class="col-6">
                                <span class="jobpost-attr">{{ $jobPost_detail->Employer->name }}</span>
                                <h5>{{ $jobPost_detail->job_title }}</h5>
                                @if($jobPost_detail->state_id)
                                <span class="jobpost-attr">{{ $jobPost_detail->State->name }} ,</span>
                                @endif
                                @if($jobPost_detail->township_id)
                                <span class="jobpost-attr">{{ $jobPost_detail->Township->name }}</span>
                                @endif
                                @if($jobPost_detail->country == 'Other') 
                                <span class="jobpost-attr">Other Country</span>
                                @endif
                                @if($jobPost_detail->salary_status == 'Negotiable')
                                <p style="color: #181722">Negotiate</p>
                                @endif
                                @if($jobPost_detail->salary_status != 'Hide' && $jobPost_detail->salary_status != 'Negotiable')
                                @if($jobPost_detail->salary_range)
                                <p style="color: #181722">{{ $jobPost_detail->salary_range }} {{ $jobPost_detail->currency }}</p>
                                @endif
                                @endif
                            </div>
                            <div class="col-4 d-flex align-items-end flex-column bd-highlight mb-3">
                                <div class="text-end py-2 bd-highlight job-post-fav"><i class="fa-regular fa-heart"></i></div>
                                <div class="mt-auto bd-highlight">
                                <span>{{ $jobPost_detail->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                @endif
            </div>
        </div>
        <div class="col-12 col-md-8 my-5 ex3">
            <div class="jobpost-header p-0 m-0">
                <div class="p-3">
                    <div class="row">
                        <div class="col-7">
                            <span class="jobpost-attr">{{ $jobpost->Employer->name }}</span>
                            <h5>{{ $jobpost->job_title }}</h5>
                            @if($jobpost->state_id)
                            <span class="jobpost-attr">{{ $jobpost->State->name }} ,</span>
                            @endif
                            @if($jobpost->township_id)
                            <span class="jobpost-attr">{{ $jobpost->Township->name }}</span>
                            @endif
                            @if($jobpost->country == 'Other') 
                            <span class="jobpost-attr">Other Country</span>
                            @endif
                            @if($jobpost->salary_status == 'Negotiable')
                            <p style="color: #181722">Negotiate</p>
                            @endif
                            @if($jobpost->salary_status != 'Hide' && $jobpost->salary_status != 'Negotiable')
                            @if($jobpost->salary_range)
                            <p style="color: #181722">{{ $jobpost->salary_range }} {{ $jobpost->currency }}</p>
                            @endif
                            @endif
                        </div>
                        <div class="col-5 text-end">
                            <a href="{{ route('jobpost-apply', $jobpost->id) }}" class="btn vertical-tab profile-save-btn apply-btn mb-2"><i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> Apply Job</a>
                            <a href="" class="btn btn-save-job mb-2"><i class="fa-regular fa-heart"></i> Save Job</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jobpost-body">
                <div class="job-description">
                    <div class="p-3">
                    @if($jobpost->job_description)
                    <h5>Job Description</h5>
                    <p>{!! $jobpost->job_description !!}</p>
                    @endif
                    </div>
                </div>
                <div class="job-requirement">
                    <div class="p-3">
                    @if($jobpost->requirement_and_skill)
                    <h5>Job Requirement</h5>
                    <p>{!! $jobpost->requirement_and_skill !!}</p>
                    @endif
                    </div>
                </div>
                <div class="job-higlight">
                    <div class="p-3">
                    @if($jobpost->job_higlight)
                    <h5>We expect you to have:</h5>
                    <p>{!! $jobpost->job_higlight !!}</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection