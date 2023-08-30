@extends('frontend.layouts.app')
@section('content')
<!-- Banner Start -->
<div class="container-fluid p-0">
    <div class="company-detail-banner">
        @if($jobpost->Employer->background)
        <img src="{{ asset('storage/employer_background/'. $jobpost->Employer->background) }}" style="width: 100%; max-height: 510px" alt="{{ $jobpost->Employer->name }}">
        @else
        <img src="{{ asset('/frontend/img/company/company-banner-image.png') }}" style="width: 100%; max-height: 510px" alt="{{ $jobpost->Employer->name }}">
        @endif
    </div>
</div>
<!-- Banner End -->

<!-- Job Post Profile Start -->
<div class="">
    <div class="container" id="">
        <div class="row pt-3 px-3" >
            <div class="col-lg-8 col-md-8 col-8">
                @if($jobpost->Employer->logo)
                <img src="{{ asset('storage/employer_logo/'.$jobpost->Employer->logo) }}" class="" style="width: 120px; height: 120px" alt="{{ $jobpost->Employer->name }}">
                @else
                <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="" style="width: 120px; height: 120px" alt="{{ $jobpost->Employer->name }}">
                @endif
                <div class=" pt-3 pb-2">
                    <h3>{{ $jobpost->job_title }}</h3>
                    <span class="d-block"><a href="{{ route('company-detail',$jobpost->Employer->slug ?? '') }}">{{ $jobpost->Employer->name }}</a></span>
                    <span class="fw-bold">{{ $jobpost->gender }} @if($jobpost->no_of_candidate) ( {{ $jobpost->no_of_candidate }} - Posts ) @endif</span>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-4 align-self-end">
                <div class=" pb-2">
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
                        <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="p-1">{{ $btn_text }}</span>
                    </a>
                    <div onclick="saveJob({{ $jobpost->id }})" class="btn btn-outline-primary py-2">
                        <i id="savejob-{{ $jobpost->id }}" class="text-blue @if(Auth::guard('seeker')->user()->SaveJob->where('job_post_id', $jobpost->id)->count() > 0) fa-solid @else fa-regular @endif fa-heart"></i>
                        <span class="p-1">Save Job</span>
                    </div>
                    @elseauth('employer')
                    @else
                        <a href="{{ route('jobpost-apply', $jobpost->id) }}" class="{{ $disabled }} btn apply-company-btn py-2">
                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="p-1">{{ $btn_text }}</span>
                        </a>
                        
                    @endguest
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="company-name pt-3 px-0 pb-2">
                        <span>@if($jobpost->country == 'Myanmar') {{ $jobpost->State->name ?? '' }}, @if($jobpost->township_id) {{ $jobpost->Township->name }}, @endif {{ $jobpost->country }} @endif</span>
                        <h3>@if($jobpost->hide_salary == 1) Negotiate @else {{ $jobpost->salary_range }} {{ $jobpost->currency }} @endif - {{ $jobpost->job_type }}</h3>
                        @if($jobpost->JobPostSkill->count() > 0)
                        <div class="col-12 pt-3 px-0">
                            <h6 class="fw-bold">Skill</h6>
                            @foreach($jobpost->JobPostSkill as $jobpostSkill)
                            <span class="badge text-light bg-success">{{ $jobpostSkill->Skill->name }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row pt-3">
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="pt-3 pb-2">
                        <h4>Career Level</h4>
                        <span>{{ $jobpost->career_level }}</span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <div class="pt-3 pb-2">
                        <h4>Years of Experience</h4>
                        <span>{{ $jobpost->experience_level }}</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-6">
                    <div class="pt-3 pb-2">
                        <h4>Job Specializations</h4>
                        <span>{{ $jobpost->MainFunctionalArea->name }} , {{ $jobpost->SubFunctionalArea->name }}</span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <div class="pt-3 pb-2">
                        <h4>Qualification</h4>
                        <span>{{ $jobpost->degree }}</span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-6">
                    <div class="pt-3 pb-2">
                        <h4>Job Type</h4>
                        <span>{{ $jobpost->job_type }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Job Post Profile End -->

        <div class="container-fluid px-0">
            <div class="row col-12 m-0 px-0 mt-3">
                <!-- Job Post Detail Start-->
                <div class="col-lg-8 col-12 px-0 border-right-profile">
                    @if($jobpost->job_description)
                    <div class="row col-12 m-0 px-0 py-1">
                        <h4 class="fw-bold">Job Description</h4>
                        <p>
                            {!! $jobpost->job_description ?? '-' !!}
                        </p>
                        <hr class="w-75">
                    </div>
                    @endif 
                    @if($jobpost->job_requirement)
                    <div class="row col-12 m-0 p-0 py-1">
                        <h4 class="fw-bold">Job Requirements</h4>          
                        <p>
                            {!! $jobpost->job_requirement ?? '-' !!}
                        </p>
                        <hr class="w-75">
                    </div>
                    @endif
                    @if($jobpost->benefit)
                    <div class="row col-12 m-0 p-0 py-1">
                        <h4 class="fw-bold">Job Benefits</h4>          
                        <p>
                            {{ $jobpost->benefit ?? '-' }}
                        </p>
                        <hr class="w-75">
                    </div>
                    @endif 
                    @if($jobpost->job_highlight)
                    <div class="row col-12 m-0 p-0 py-1">
                        <h4 class="fw-bold">Job Highlight</h4>          
                        <p>
                            {{ $jobpost->job_highlight ?? '-' }}
                        </p>
                        <hr class="w-75">
                    </div>
                    @endif
                    @if($jobpost->Employer->no_of_employees || $jobpost->Employer->OwnerShipType || $jobpost->Employer->website || $jobpost->summary || $jobpost->Employer->EmployerMedia->where('type','Image')->count() > 0)
                    <div class="row col-12 m-0 p-0 py-1">
                        <h4 class="fw-bold">Company Overview</h4> 
                        <div>
                            <ul>
                                @if($jobpost->Employer->no_of_employees)
                                <li><div class="row"><div class="col-2">Size</div><div class="col-10"><strong>{{ $jobpost->Employer->no_of_employees }} Employee</strong></div></div></li>
                                @endif
                                @if($jobpost->Employer->OwnerShipType)
                                <li><div class="row"><div class="col-2">Type</div><div class="col-10"><strong>{{ $jobpost->Employer->OwnerShipType->name ?? '' }}</strong></div></div></li>
                                @endif
                                @if($jobpost->Employer->website)
                                <li><div class="row"><div class="col-2">Website</div><div class="col-10"><a href="{{ $jobpost->Employer->website }}" target="_blank"><strong>{{ $jobpost->Employer->website }}</strong></a></div></div></li>
                                @endif
                            </ul>
                        </div>
                        @if($jobpost->summary)
                        <div class="row col-12 m-0 p-0 py-1">
                            <p>
                                {{ $jobpost->Employer->summary ?? '-' }}
                            </p>
                        </div>
                        @endif
                        @if($jobpost->Employer->EmployerMedia->where('type','Image')->count() > 0)         
                        {{--<p>
                            @foreach($jobpost->Employer->EmployerMedia->where('type','Image') as $image)
                            <div class="col-lg-3 col-md-3 p-0 company-photo">
                                <img src="{{ asset('storage/employer_media/'.$image->name) }}" class="w-100 py-1 pe-2" height="200px" alt="">
                            </div>
                            @endforeach
                        </p>--}}
                        <div class="container-fluid py-1">
                            <div class="row pb-5 mb-5">
                                <!--Ik gebruik hieronder alleen het middiv omdat dat de enige info is die ik wil vervangen-->
                                <div class="col-md-12" id="middiv" style="background-color: rgba(255, 255, 255, 0.1)">
                                    <div id="companyCarousel" class="carousel slide" data-ride="carousel" align="center">
                                        <!-- Wrapper for slides -->
                                        <div class="carousel-inner">
                                            @foreach($jobpost->Employer->EmployerMedia->where('type','Image') as $image)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                <img src="{{ asset('storage/employer_media/'.$image->name) }}" alt="{{ $jobpost->Employer->name }}" style="width:80%;">
                                            </div>
                                            @endforeach
                                        </div>

                                        <!-- Left and right controls -->
                                        <a class="carousel-control-prev" href="#companyCarousel" data-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </a>
                                        <a class="carousel-control-next" href="#companyCarousel" data-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </a>

                                        <!-- Indicators -->
                                        <ol class="carousel-indicators list-inline">
                                            @foreach($jobpost->Employer->EmployerMedia->where('type','Image') as $key => $image)
                                            <li class="list-inline-item {{ $loop->first ? 'active' : '' }}">
                                                <a id="carousel-selector-0" class="selected" data-slide-to="{{ $key }}" data-target="#companyCarousel">
                                                    <img src="{{ asset('storage/employer_media/'.$image->name) }}" class="img-fluid">
                                                </a>
                                            </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                    @endif
                </div>
                <!-- Job Post Detail End-->

                <!-- Similar Jobs Start-->
                @if($similar_jobs->count() > 0)
                <div class="col-lg-4 col-md-4 col-4 mt-4 px-5">
                    <div class="p-1 right-trending-title text-center">
                        <h5 class="text-white py-2">More Similar Jobs</h5>
                    </div>

                    <div class="job-similar-scroll shadow rounded p-2">
                        @foreach($similar_jobs as $similar_job)
                        <a href="{{ route('jobpost-detail', $similar_job->slug) }}">
                            <div class="col-lg-12 border-bottom p-0">
                                <div class="m-0 my-2 p-2 trending-job-list rounded">
                                    <div class="row m-0 p-2">
                                        <div class="col-lg-3 col-12 text-center h-100 align-self-center">
                                            @if($similar_job->Employer->logo)
                                            <img src="{{ asset('storage/employer_logo/'.$similar_job->Employer->logo) }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 100%" id="ProfilePreview">
                                            @else 
                                            <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 100%" id="ProfilePreview">
                                            @endif
                                        </div>
                                        <div class="col-lg-9 col-12 p-0">
                                            <div>
                                                <h3 id="trending-job-title">{{ $similar_job->job_title }}</h3>
                                                <span id="trending-job-sub-title">{{ $similar_job->Employer->name }}</span>
                                            </div>

                                            <div class="fz13">
                                                <span class="me-2 d-block" style="margin: 0px 0 -15px 0"><i class="fa fa-briefcase me-2"></i></i>{{ $similar_job->MainFunctionalArea->name }}</span>
                                                @if($similar_job->country == 'Myanmar' && $similar_job->township_id )<span style="margin: -15px 0"><i class="fa fa-map-marker me-1" aria-hidden="true"></i> {{ $similar_job->Township->name }}</span> @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                <!-- Similar Jobs End-->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function saveJob(id) {
        $.ajax({
            type: 'GET',
            data: id,
            url: "/seeker/save-job/"+id,
        }).done(function(response){
            if(response.status == 'create') {
                MSalert.principal({
                    icon:'success',
                    title:'',
                    description:response.msg,
                });
                $('#savejob-'+id).removeClass('fa-regular');
                $('#savejob-'+id).addClass('fa-solid');
            }else if(response.status == 'remove') {
                MSalert.principal({
                    icon:'success',
                    title:'',
                    description:response.msg,
                });
                $('#savejob-'+id).removeClass('fa-solid');
                $('#savejob-'+id).addClass('fa-regular');
            }
        })
    }
</script>
@endpush