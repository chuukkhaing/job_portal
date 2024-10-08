@extends('frontend.layouts.app')
@section('content')
<form action="{{ route('jobpost-apply', $jobpost->id) }}" method="get">
    @csrf
    <div class="container my-5" id="">
        <div class="card shadow" id="edit-profile-body">
            <div class="card-header bg-transparent">
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl-5 mb-2 d-flex">
                        @if($jobpost->Employer->logo && $jobpost->hide_company == 0)
                        <img src="{{ getS3File('employer_logo',$jobpost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobpost->Employer->name }}">
                        @else
                        <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="Employer Profile">
                        @endif
                        <div class="align-self-center">
                            <span class="h4 fw-bold">{{ $jobpost->job_title }} @if($jobpost->no_of_candidate) ( {{ $jobpost->no_of_candidate }} - Posts ) @endif</span>
                            @if($jobpost->hide_company == 0)
                            <div><a class="text-muted h6" href="{{ route('company-detail',$jobpost->Employer->slug ?? '') }}">{{ $jobpost->Employer->name }} @if($jobpost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</a></div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-5 mb-2 align-self-center">
                        <div>
                            <span>{{ $jobpost->job_type }} @if($jobpost->country == 'Myanmar') | {{ $jobpost->State->name ?? '' }}, {{ $jobpost->Township->name ?? '' }} @endif {{ $jobpost->gender }}</span>
                        </div>
                        <div>
                            <span class="text-muted">Salary Range:</span>
                            <span class="h5 fw-bold">@if($jobpost->hide_salary == 1) Negotiate @else {{ $jobpost->salary_range }} {{ $jobpost->currency }} @endif</span>
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
                                if($seeker_job->job_post_id == $jobpost->id){
                                    $disabled = 'disabled';
                                    $btn_text = 'Applied';
                                }
                            }
                            @endphp
                        @endauth
                        @auth('seeker')
                            <button type="submit" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3" onclick="applyJob({{ $jobpost->id }})">
                                <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                            </button>
                        @elseauth('employer')
                        @else
                            <button type="submit" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3" onclick="applyJob({{ $jobpost->id }})">
                                <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                            </button>
                        @endguest
                            <div>
                                <small>Posted {{ $jobpost->updated_at->shortRelativeDiffForHumans() }}</small>
                            </div>
                    </div>
                </div>  
            </div>
            <div class="card-body p-0">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="p-md-3 p-2 job-post-detail nav-link active" id="nav-job-description-tab" data-bs-toggle="tab" data-bs-target="#nav-job-description" type="button" role="tab" aria-controls="nav-job-description" aria-selected="true">Job Description</button>
                        @if($jobpost->hide_company != 1)
                        <button class="p-md-3 p-2 job-post-detail nav-link" id="nav-company-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-company-profile" type="button" role="tab" aria-controls="nav-company-profile" aria-selected="false">Company Profile</button>
                        @endif
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane p-3 fade show active" id="nav-job-description" role="tabpanel" aria-labelledby="nav-job-description-tab">
                        @if($jobpost->JobPostSkill->count() > 0)
                        <h5 class="fw-bold text-black">Skills</h5>
                        <div class="badge-group mb-3">
                            @foreach($jobpost->JobPostSkill as $jobpostSkill)
                            <span class="my-1 badge text-white fz14 rounede-3 py-2 px-3 text-wrap" style="background: #0355d0">{{ $jobpostSkill->Skill->name }}</span>
                            @endforeach
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-7 col-12 @if($jobpost->JobPostQuestion->count() > 0) border-right @endif">
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
                            @if($jobpost->JobPostQuestion->count() > 0)
                            <div class="col-12 col-md-5">
                                @error('answers.*.*')
                                <h5 class="text-danger">{{ $message }}</h5>
                                @enderror
                                @foreach($jobpost->JobPostQuestion as $question)
                                <h5>Q: {{ $question->question }}</h5>
                                @if($question->answer == 'Multiple Choice')
                                <div class="py-2">
                                    <input type="radio" id="yes_{{ $question->id }}" name="answers[{{ $question->id }}][]" class="cb-radio @error('answers.*.*') is-invalid @enderror" value="Yes">
                                    <label for="yes_{{ $question->id }}"> &nbsp;	Yes &nbsp;	&nbsp;	&nbsp;	&nbsp;	</label>
                                    <input type="radio" id="no_{{ $question->id }}" name="answers[{{ $question->id }}][]" class="cb-radio @error('answers.*.*') is-invalid @enderror" value="No">
                                    <label for="no_{{ $question->id }}"> &nbsp;	 No</label>
                                </div>
                                @else
                                <div class="py-2">
                                    <input type="text" name="answers[{{ $question->id }}][]" id="text_{{ $question->id }}" value="" class="form-control seeker_input @error('answers.*.*') is-invalid @enderror" placeholder="Enter Answer">
                                </div>
                                @endif
                                @endforeach
                                
                            </div>
                            @endif
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="nav-company-profile" role="tabpanel" aria-labelledby="nav-company-profile-tab">
                        <div class="p-md-5 p-1 pt-5 d-none d-lg-block">
                            <div class="row py-3">
                                <div class="col-2">
                                    
                                </div>
                                @if($jobpost->hide_company == 0)
                                <div class="col-10">
                                    <h4 class="fw-bold text-black">{{ $jobpost->Employer->name }} @if($jobpost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                </div>
                                @endif
                            </div>
                            <div class="card job-post-detail-company-profile mb-2">
                                <div class="header">
                                    <div class="row">
                                        <div class="col-2 px-xl-5 p-0">
                                            @if($jobpost->Employer->logo && $jobpost->hide_company == 0)
                                            <img src="{{ getS3File('employer_logo',$jobpost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="{{ $jobpost->Employer->name }}">
                                            @else
                                            <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-100" style="" alt="Employer Profile">
                                            @endif
                                        </div>
                                        <div class="col-10 py-4">
                                            <h5 class="fw-bold text-dark">Company Overview</h5>
                                            @if($jobpost->Employer->summary)
                                            <p class="mb-4">
                                                {!! $jobpost->Employer->summary !!}
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
                                            {!! $jobpost->Employer->value ?? '-' !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-md-5 p-1 pt-5 d-lg-none d-block company-detail-media">
                            
                            <div class="card job-post-detail-company-profile mb-2">
                                <div class="header">
                                    <div class="row px-2 pt-4">
                                        
                                        <div class="col py-4" >
                                            <div class="col-6 mx-auto text-center">
                                                @if($jobpost->Employer->logo && $jobpost->hide_company == 0)
                                                <img src="{{ getS3File('employer_logo',$jobpost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="{{ $jobpost->Employer->name }}">
                                                @else
                                                <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3 w-50" style="" alt="Employer Profile">
                                                @endif
                                            </div>
                                            @if($jobpost->hide_company == 0)
                                            <h4 class="fw-bold text-black job-post-company-name">{{ $jobpost->Employer->name }} @if($jobpost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                            @endif
                                            <h5 class="fw-bold text-dark">Company Overview</h5>
                                            @if($jobpost->Employer->summary)
                                            <p class="mb-4">
                                                {!! $jobpost->Employer->summary !!}
                                            </p>
                                            @endif
                                            @if($jobpost->Employer->EmployerAddress->count() > 0)
                                            <h5 class="fw-bold text-dark">Address:</h5>
                                            <span class="mb-4 btn border seeker_image_input_label">
                                                
                                                    @if($jobpost->Employer->EmployerAddress->first()->address_detail)
                                                    <p>{{ $jobpost->Employer->EmployerAddress->first()->address_detail }}</p>
                                                    @else
                                                    <p>@if($jobpost->Employer->EmployerAddress->first()->country == 'Myanmar') {{ $jobpost->Employer->EmployerAddress->first()->State->name ?? '' }}, @if($jobpost->Employer->EmployerAddress->first()->township_id) {{ $jobpost->Employer->EmployerAddress->first()->Township->name }}, @endif {{ $jobpost->Employer->EmployerAddress->first()->country }} @endif</p>
                                                    @endif
                                                
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
                                <div class="px-2 px-md-3 px-lg-5 py-3">
                                    <h5 class="fw-bold text-dark">Company Details</h5>
                                    <div class="row">
                                        @if($jobpost->Employer->Industry->name)
                                        <div class="col-12 col-lg-4">
                                            <h6 class="fw-bold text-dark">Industry Type</h6>
                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                {{ $jobpost->Employer->Industry->name }}
                                            </p>
                                        </div>
                                        @endif
                                        <div class="col-12 col-lg-4">
                                            <h6 class="fw-bold text-dark">Company Size:</h6>
                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                {{ $jobpost->Employer->no_of_employees ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <h6 class="fw-bold text-dark">No of Office:</h6>
                                            <p class="mb-4 btn border seeker_image_input_label w-100">
                                                {{ $jobpost->Employer->no_of_offices ?? '-' }}
                                            </p>
                                        </div>
                                        <h5 class="fw-bold text-dark">Vision, Mission, Value</h5>
                                        <p class="mb-4">
                                            {!! $jobpost->Employer->value ?? '-' !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($jobpost->hide_company == 0)
            <div class="card-footer text-center">
                <a href="{{ route('company-jobs', $jobpost->Employer->id) }}" class="btn btn-sm text-white" style="background-color: #0355d0;">See more jobs from this company</a>
            </div>
            @endif
        </div>
    </div>
</form>
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
                
                $('#savejob-'+id).removeClass('fa-regular');
                $('#savejob-'+id).addClass('fa-solid');
            }else if(response.status == 'remove') {
                
                $('#savejob-'+id).removeClass('fa-solid');
                $('#savejob-'+id).addClass('fa-regular');
            }
        })
    }

    function applyJob(id) {
        $(this).attr('disabled','true');
        
    }

    $(document).ready(function() {
        var loggedIn = "{{ Auth::guard('seeker')->user() ? session(['returnUrl' => '']) : session(['returnUrl' => 'jobpost-detail', 'previous_url' => url()->current()]) }}";

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
    })
</script>
@endpush