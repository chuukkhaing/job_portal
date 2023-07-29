@extends('frontend.layouts.app')
@section('content')
{{-- <div class="container">
    <div class="row">
        <div class="col-12 col-md-5 my-5">
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
                                <p class="p-0 m-0" style="color: #181722">Negotiate</p>
                                @endif
                                @if($jobpost->salary_status != 'Hide' && $jobpost->salary_status != 'Negotiable')
                                @if($jobpost->salary_range)
                                <p class="p-0 m-0" style="color: #181722">{{ $jobpost->salary_range }} {{ $jobpost->currency }}</p>
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
                                <p class="p-0 m-0" style="color: #181722">Negotiate</p>
                                @endif
                                @if($jobPost_detail->salary_status != 'Hide' && $jobPost_detail->salary_status != 'Negotiable')
                                @if($jobPost_detail->salary_range)
                                <p class="p-0 m-0" style="color: #181722">{{ $jobPost_detail->salary_range }} {{ $jobPost_detail->currency }}</p>
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
        <div class="col-12 col-md-7 my-5 ex3">
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
                            <p class="p-0 m-0" style="color: #181722">Negotiate</p>
                            @endif
                            @if($jobpost->salary_status != 'Hide' && $jobpost->salary_status != 'Negotiable')
                            @if($jobpost->salary_range)
                            <p class="p-0 m-0" style="color: #181722">{{ $jobpost->salary_range }} {{ $jobpost->currency }}</p>
                            @endif
                            @endif
                        </div>
                        <div class="col-5 text-end">
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
                            <a href="{{ route('jobpost-apply', $jobpost->id) }}" class="{{ $disabled }} btn vertical-tab profile-save-btn apply-btn mb-2"><i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> {{ $btn_text }}</a>
                            <a href="" class="btn btn-save-job mb-2"><i class="fa-regular fa-heart"></i> Save Job</a>
                            @elseauth('employer')
                            @else
                            <a href="{{ route('jobpost-apply', $jobpost->id) }}" class="{{ $disabled }} btn vertical-tab profile-save-btn apply-btn mb-2"><i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> {{ $btn_text }}</a>
                            <a href="" class="btn btn-save-job mb-2"><i class="fa-regular fa-heart"></i> Save Job</a>
                            @endguest
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
</div> --}}

<!-- Banner Start -->
<div class="container-fluid p-3">
    <div class="row company-detail-banner">
        <img src="{{ asset('/frontend/img/company/company-banner-image.png') }}" class="w-100" alt=" }}">
    </div>
</div>
<!-- Banner End -->

<!-- Job Post Profile Start -->
<div class="container">
    <div class="row pt-3 px-3">
        <div class="col-lg-6 col-md-6 col-6">
            <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="" style="width: 120px; height: 120px" alt="">

            <div class="company-name pt-4 pb-2">
                <h3>Senior Java Lead Developer</h3>
                <span>Spring Company</span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-6 align-self-end">
            <div class="float-end pb-2">
                <a href="http://" class="btn apply-company-btn py-2">
                    <i class="fa-solid fa-arrow-right rotate45"></i> <span class="p-1">Apply on company site</span>
                </a>
                <a href="http://" class="btn btn-outline-primary py-2">
                    <i class="fa fa-heart-o p-1 fw-bold"></i><span class="p-1">Save Job</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row pt-3 px-3">
        <div class="col-12">
            <div class="company-name pt-4 pb-2">
                <span>Yangon , Myanmar</span>
                <h3>1 Lakhs - 10 Lakhs  - Full-time</h3>
            </div>
        </div>
    </div>

    <div class="row pt-3 px-3">
        <div class="col-lg-2 col-md-3 col-6">
            <div class="company-name pt-4 pb-2">
                <h3>Career Level</h3>
                <span>Senior Manager</span>
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-6">
            <div class="company-name pt-4 pb-2">
                <h3>Years of Experience</h3>
                <span>12 years</span>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-6">
            <div class="company-name pt-4 pb-2">
                <h3>Job Specializations</h3>
                <span>Computer/Information Technology, IT-Network</span>
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-6">
            <div class="company-name pt-4 pb-2">
                <h3>Qualification</h3>
                <span>Not Specified</span>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-6">
            <div class="company-name pt-4 pb-2">
                <h3>Job Type</h3>
                <span>Full-Time/Part-Time/Project-Base</span>
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
                <div>
                    We are seeking a self-motivated and innovative Merchant Engagement Specialist to join our Sale & Merchant Engagement Business Unit and help us build strong relationships with our Payroll Customer /KBZPay merchants. You will be part of a team that specializes in merchant engagement and merchant care.  In addition, experiences in customer service will be essential.
                    <ol>
                        <li>Be part of a team to engage merchants for both Payroll customers and KBZPay merchants.</li>
                        <li>Provide product knowledge of Payroll for Customers awareness.</li>
                        <li>Provide required product (KBZPay partner app, portal) trainings to merchants and respective users at outlets.</li>
                        <li>Ensure after sale activities to address any gaps left in both pre-sales and sales activities.</li>
                        <li>Execute merchants’ segmentation and engagement strategies to create win-win outcomes for our customers, the bank and the merchants.</li>
                        <li>Provide Level 1 support to address merchant issues related to the use of Payroll product or KBZPay partner app.</li>
                        <li>Be a focal point of contact for merchants and payroll customers to resolve issues.</li>
                        <li>Actively collaborate with cross-functional departments to ensure merchants and payroll customers issues and requirements are resolved within the SLA.</li>
                    </ol>
                </div>
            </div>

            <div class="row col-12 m-0 p-0 py-3">
                <h5 class="fw-bolder fs-6">Job Requirements</h5>          
                <div>
                    <ul>
                        <li>Possess a bachelor degree (Degree in Banking/Business Administration)</li>
                        <li>Proficient in English language</li>
                        <li>Excellent customer service skill and communication skill</li>
                        <li>Strong organizational and influential skills</li>
                        <li>Strong Teamwork and excellent interpersonal skills</li>
                        <li>Skilled in oratory and presentation</li>
                        <li>Willing to work overtime, when needed, to complete the jobs in time and for good results</li>
                    </ul>
                </div>
            </div>

            <div class="row col-12 m-0 p-0 py-3">
                <h5 class="fw-bolder fs-6">We expect you to have:</h5>          
                <div>
                    <ul>
                        <li>Possess a bachelor degree (Degree in Banking/Business Administration)</li>
                        <li>Proficient in English language</li>
                        <li>Excellent customer service skill and communication skill</li>
                        <li>Strong organizational and influential skills</li>
                        <li>Strong Teamwork and excellent interpersonal skills</li>
                        <li>Skilled in oratory and presentation</li>
                        <li>Willing to work overtime, when needed, to complete the jobs in time and for good results</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Job Post Detail End-->

        <!-- Similar Jobs Start-->
        <div class="col-lg-5 col-12">
            <div class="px-3 m-0 pb-0 pt-3">
                <h5 class="text-blue fw-bolder">More Similar Jobs</h5>
            </div>
        
            <div class="row m-0 pb-0">
                <div class="col-12">
                    <div class="m-0 pb-0 border-bottom">
                        <div class="row p-0 m-0">
                            <div class="col-lg-10 col-md-10 py-4 px-1">
                                <div class="row m-0">
                                    <div class="col-lg-2 col-12 job-image p-0 px-1">
                                        <img src="http://localhost:93/frontend/img/trending/aya.png" class="img-responsive center-block d-block mx-auto" alt="Job Profile">
                                    </div>
        
                                    <div class="col-lg-10 col-12">
                                        <div class="job-company">Blackzim</div>
                                        <div class="job-title">Senior Java Developer</div>
                                        <div class="job-location">Yangon , Myanmar</div>
                                        <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4 px-1">
                                <div class="row col-12 m-0 p-0">
                                    <div class="text-end px-0">
                                        <i class="fa fa-heart-o text-blue"></i>
                                    </div>
            
                                    <div class="text-end mt-auto  px-0">
                                        <span>1 d</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="m-0 pb-0 border-bottom">
                        <div class="row p-0 m-0">
                            <div class="col-lg-10 col-md-10 py-4 px-1">
                                <div class="row m-0">
                                    <div class="col-lg-2 col-12 job-image p-0 px-1">
                                        <img src="http://localhost:93/frontend/img/trending/aya.png" class="img-responsive center-block d-block mx-auto" alt="Job Profile">
                                    </div>
        
                                    <div class="col-lg-10 col-12">
                                        <div class="job-company">Blackzim</div>
                                        <div class="job-title">Senior Java Developer</div>
                                        <div class="job-location">Yangon , Myanmar</div>
                                        <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4 px-1">
                                <div class="row col-12 m-0 p-0">
                                    <div class="text-end px-0">
                                        <i class="fa fa-heart-o text-blue"></i>
                                    </div>
            
                                    <div class="text-end mt-auto px-0">
                                        <span>1 d</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Similar Jobs End-->
    </div>
</div>

@endsection