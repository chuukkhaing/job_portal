@extends('frontend.layouts.app')
@section('content')
<div class="container my-2" id="">
    <div class="card shadow" id="edit-profile-body">
        <div class="card-header bg-transparent">
            <div class="row">
                <div class="col d-flex">
                    @if($jobpost->Employer->logo)
                    <img src="{{ asset('storage/employer_logo/'.$jobpost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobpost->Employer->name }}">
                    @else
                    <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobpost->Employer->name }}">
                    @endif
                    <div class="align-self-center">
                        <span class="h4 fw-bold">{{ $jobpost->job_title }} @if($jobpost->no_of_candidate) ( {{ $jobpost->no_of_candidate }} - Posts ) @endif</span>
                        <div><a class="text-muted h6" href="{{ route('company-detail',$jobpost->Employer->slug ?? '') }}">{{ $jobpost->Employer->name }}</a></div>
                    </div>
                </div>
                <div class="col align-self-center">
                    <div>
                        <span>{{ $jobpost->job_type }} @if($jobpost->country == 'Myanmar') | {{ $jobpost->State->name ?? '' }}, {{ $jobpost->Township->name ?? '' }} @endif {{ $jobpost->gender }}</span>
                    </div>
                    <div>
                        <span class="text-muted">Salary Range:</span>
                        <span class="h5 fw-bold">@if($jobpost->hide_salary == 1) Negotiate @else {{ $jobpost->salary_range }} {{ $jobpost->currency }} @endif</span>
                    </div>
                </div>
                <div class="col text-end">
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
                        <a href="{{ route('jobpost-apply', $jobpost->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                        </a>
                    @elseauth('employer')
                    @else
                        <a href="{{ route('jobpost-apply', $jobpost->id) }}" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                        </a>
                    @endguest
                        <div>
                            <small>Posted {{ $jobpost->updated_at->diffForHumans() }}</small>
                        </div>
                </div>
            </div>  
        </div>
        <div class="card-body p-0">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="p-3 job-post-detail nav-link active" id="nav-job-description-tab" data-bs-toggle="tab" data-bs-target="#nav-job-description" type="button" role="tab" aria-controls="nav-job-description" aria-selected="true">Job Description</button>
                    <button class="p-3 job-post-detail nav-link" id="nav-company-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-company-profile" type="button" role="tab" aria-controls="nav-company-profile" aria-selected="false">Company Profile</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane p-3 fade show active" id="nav-job-description" role="tabpanel" aria-labelledby="nav-job-description-tab">
                    @if($jobpost->JobPostSkill->count() > 0)
                    <h5 class="fw-bold text-black">Skills</h5>
                    <div class="badge-group mb-3">
                        @foreach($jobpost->JobPostSkill as $jobpostSkill)
                        <span class="badge text-white fz14 rounede-3 py-2 px-3" style="background: #0355d0">{{ $jobpostSkill->Skill->name }}</span>
                        @endforeach
                    </div>
                    @endif
                    <h5 class="fw-bold text-black">Experience Level :</h5>
                    <div class="mb-4 fz14 fw-bold">{{ $jobpost->experience_level }}</div>
                    <h5 class="fw-bold text-black">Qualification :</h5>
                    <div class="mb-4 fz14 fw-bold">{{ $jobpost->degree }}</div>
                    <h5 class="fw-bold text-black">Job Specializations :</h5>
                    <div class="mb-4 fz14 fw-bold">{{ $jobpost->MainFunctionalArea->name }} , {{ $jobpost->SubFunctionalArea->name }}</div>
                    @if($jobpost->job_description)
                    <h5 class="fw-bold text-black">Job Description</h5>
                    <div class="mb-4">
                        <p class="fz15">
                            {!! $jobpost->job_description ?? '-' !!}
                        </p>
                    </div>
                    @endif
                    @if($jobpost->job_requirement)
                    <h5 class="fw-bold text-black">Job Requirement</h5>
                    <div class="mb-4">
                        <p class="fz15">
                            {!! $jobpost->job_requirement ?? '-' !!}
                        </p>
                    </div>
                    @endif
                    @if($jobpost->benefit)
                    <h5 class="fw-bold text-black">Job Benefit</h5>
                    <div class="mb-4">
                        <p class="fz15">
                            {!! $jobpost->benefit ?? '-' !!}
                        </p>
                    </div>
                    @endif
                    @if($jobpost->job_highlight)
                    <h5 class="fw-bold text-black">Job Highlight</h5>
                    <div class="mb-4">
                        <p class="fz15">
                            {!! $jobpost->job_highlight ?? '-' !!}
                        </p>
                    </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="nav-company-profile" role="tabpanel" aria-labelledby="nav-company-profile-tab">
                    <div class="p-5">
                        <div class="row py-3">
                            <div class="col-2">
                                
                            </div>
                            <div class="col-10">
                                <h4 class="fw-bold text-black">{{ $jobpost->Employer->name }}</h4>
                            </div>
                        </div>
                        <div class="card job-post-detail-company-profile mb-2">
                            <div class="header">
                                <div class="row">
                                    <div class="col-2 px-5">
                                        @if($jobpost->Employer->logo)
                                        <img src="{{ asset('storage/employer_logo/'.$jobpost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $jobpost->Employer->name }}">
                                        @else
                                        <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $jobpost->Employer->name }}">
                                        @endif
                                    </div>
                                    <div class="col-10 py-4">
                                        <h5 class="fw-bold text-dark">Company Overview</h5>
                                        @if($jobpost->Employer->summary)
                                        <p class="mb-4">
                                            {{ $jobpost->Employer->summary }}
                                        </p>
                                        @endif
                                        <h5 class="fw-bold text-dark">Specialties:</h5>
                                        @if($jobpost->Employer->Industry->name)
                                        <span class="mb-4 btn border seeker_image_input_label">
                                            {{ $jobpost->Employer->Industry->name }}
                                        </span>
                                        @endif
                                        @if($jobpost->Employer->website)
                                        <h5 class="fw-bold text-dark">Company Website:</h5>
                                        <p class="mb-4">
                                            <a href="{{ $jobpost->Employer->website }}" target="_blank"><small><strong>{{ $jobpost->Employer->website }}</strong></small></a>
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
                                    @if($jobpost->Employer->Industry->name)
                                    <div class="col">
                                        <h6 class="fw-bold text-dark">Industry Type</h6>
                                        <p class="mb-4 btn border seeker_image_input_label w-100">
                                            {{ $jobpost->Employer->Industry->name }}
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
                                        {{ $jobpost->Employer->value ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('company-jobs', $jobpost->Employer->id) }}" class="btn btn-sm text-white" style="background-color: #0355d0;">See more jobs from this company</a>
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