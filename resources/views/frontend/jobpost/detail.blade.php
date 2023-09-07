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
                    <h3 class="text-dark">{{ $jobpost->job_title }}</h3>
                    <h5 class="d-block"><a class="h5 text-dark" href="{{ route('company-detail',$jobpost->Employer->slug ?? '') }}">{{ $jobpost->Employer->name }}</a></h5>
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
                <div class="col-12 mb-4">
                    <div class="company-name pt-3 px-0 pb-2">
                        <span>@if($jobpost->country == 'Myanmar') {{ $jobpost->State->name ?? '' }}, @if($jobpost->township_id) {{ $jobpost->Township->name }}, @endif {{ $jobpost->country }} @endif</span>
                        <h5 class="fw-bold text-dark">@if($jobpost->hide_salary == 1) Negotiate @else {{ $jobpost->salary_range }} {{ $jobpost->currency }} @endif - {{ $jobpost->job_type }}</h5>
                        
                    </div>
                </div>
                <hr class="w-100" style="height: 1px; background: #B7CEE5">
            </div>

            <div class="row">
                <div class="col-12 mb-4">
                    <div class="company-name py-3 px-0">
                        <h5 class="fw-bold text-dark">Additional Information</h5>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <h6 class="fw-bold m-0 text-dark">Career Level</h6>
                            <span>{{ $jobpost->career_level }}</span>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold m-0 text-dark">Qualification</h6>
                            <span>{{ $jobpost->degree }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <h6 class="fw-bold m-0 text-dark">Years of Experience</h6>
                            <span>{{ $jobpost->experience_level }}</span>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold m-0 text-dark">Job Type</h6>
                            <span>{{ $jobpost->job_type }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <h6 class="fw-bold m-0 text-dark">Job Specializations</h6>
                            <span>{{ $jobpost->MainFunctionalArea->name }} , {{ $jobpost->SubFunctionalArea->name }}</span>
                        </div>
                        
                    </div>
                </div>
                <hr class="w-100" style="height: 1px; background: #B7CEE5">
            </div>
            
            @if($jobpost->JobPostSkill->count() > 0)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="company-name py-3 px-0">
                        <h5 class="fw-bold text-dark">Job Skills</h5>
                    </div>
                    <div class="row mb-2">
                        @foreach($jobpost->JobPostSkill as $jobpostSkill)
                        <div class="col-6">
                            <i class="fa-solid fa-bookmark fa-rotate-by me-2" style="--fa-rotate-angle: 90deg; color: #0355D0"></i>
                            <span>{{ $jobpostSkill->Skill->name }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
                <hr class="w-100" style="height: 1px; background: #B7CEE5">
            </div>
            @endif

            @if($jobpost->job_description)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="company-name py-3 px-0">
                        <h5 class="fw-bold text-dark">Job Description</h5>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <p>
                                {!! $jobpost->job_description ?? '-' !!}
                            </p>
                        </div>
                        
                    </div>
                </div>
                <hr class="w-100" style="height: 1px; background: #B7CEE5">
            </div>
            @endif

            @if($jobpost->job_requirement)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="company-name py-3 px-0">
                        <h5 class="fw-bold text-dark">Job Requirements</h5>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <p>
                                {!! $jobpost->job_requirement ?? '-' !!}
                            </p>
                        </div>
                        
                    </div>
                </div>
                <hr class="w-100" style="height: 1px; background: #B7CEE5">
            </div>
            @endif

            @if($jobpost->benefit)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="company-name py-3 px-0">
                        <h5 class="fw-bold text-dark">Job Benefit:</h5>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <p>
                                {!! $jobpost->benefit ?? '-' !!}
                            </p>
                        </div>
                        
                    </div>
                </div>
                <hr class="w-100" style="height: 1px; background: #B7CEE5">
            </div>
            @endif

            @if($jobpost->job_highlight)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="company-name py-3 px-0">
                        <h5 class="fw-bold text-dark">Job Highlight:</h5>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <p>
                                {!! $jobpost->job_highlight ?? '-' !!}
                            </p>
                        </div>
                        
                    </div>
                </div>
                <hr class="w-100" style="height: 1px; background: #B7CEE5">
            </div>
            @endif

            @if($jobpost->Employer->no_of_employees || $jobpost->Employer->OwnerShipType || $jobpost->Employer->website || $jobpost->summary || $jobpost->Employer->EmployerMedia->where('type','Image')->count() > 0)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="company-name py-3 px-0">
                        <h5 class="fw-bold text-dark">Company Overview</h5>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
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
                        
                    </div>
                    <div class="row col-12 m-0 p-0 py-1">
                        
                        @if($jobpost->summary)
                        <div class="row col-12 m-0 p-0 py-1">
                            <p>
                                {{ $jobpost->Employer->summary ?? '-' }}
                            </p>
                        </div>
                        @endif
                        @if($jobpost->Employer->EmployerMedia->where('type','Image')->count() > 0)         
                        
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
                </div>
                <hr class="w-100" style="height: 1px; background: #B7CEE5">
            </div>
            @endif
        </div>
        <!-- Job Post Profile End -->
        
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