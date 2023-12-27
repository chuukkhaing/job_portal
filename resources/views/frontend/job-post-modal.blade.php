<div class="modal fade" id="JobPostModal{{$jobPost->id}}" tabindex="-1" aria-labelledby="JobPostModal{{$jobPost->id}}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('jobpost-apply', $jobPost->id) }}" method="post">
            @csrf
                <div class="modal-body">
                    
                    <div class="card shadow" id="edit-profile-body">
                        <div class="card-header bg-transparent">
                            <div class="row">
                                <div class="col-12 col-lg-6 col-xl-5 mb-2 d-flex">
                                    @if($jobPost->Employer->logo && $jobPost->hide_comopany == 0)
                                    <img src="{{ getS3File('employer_logo',$jobPost->Employer->logo) }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="{{ $jobPost->Employer->name }}">
                                    @else
                                    <img src="{{ asset('img/icon/company.png') }}" class="rounded-circle shadow align-self-center me-3" style="width: 50px; height: 50px" alt="Employer Profile">
                                    @endif
                                    <div class="align-self-center">
                                        <span class="h4 fw-bold">{{ $jobPost->job_title }} @if($jobPost->no_of_candidate) ( {{ $jobPost->no_of_candidate }} - Posts ) @endif</span>
                                        @if($jobPost->hide_comopany == 0)
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
                                        <button type="submit" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3" onclick="applyJob({{ $jobPost->id }})">
                                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                        </button>
                                    @elseauth('employer')
                                    @else
                                        <button type="submit" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3" onclick="applyJob({{ $jobPost->id }})">
                                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                                        </button>
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
                                    <div class="row">
                                        <div class="col-md-7 col-12 @if($jobPost->JobPostQuestion->count() > 0) border-right @endif">
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
                                        @if($jobPost->JobPostQuestion->count() > 0)
                                        <div class="col-12 col-md-5">
                                            @error('answers.*.*')
                                            <h5 class="text-danger">{{ $message }}</h5>
                                            @enderror
                                            @foreach($jobPost->JobPostQuestion as $question)
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
                                <div class="tab-pane fade" id="nav-company-profile-{{$jobPost->id}}" role="tabpanel" aria-labelledby="nav-company-profile-{{$jobPost->id}}-tab">
                                    <div class=" p-1 d-none d-lg-block">
                                        <div class="row py-3">
                                            <div class="col-2">
                                                
                                            </div>
                                            @if($jobPost->hide_comopany == 0)
                                            <div class="col-10">
                                                <h4 class="fw-bold text-black">{{ $jobPost->Employer->name }} @if($jobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</h4>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="card job-post-detail-company-profile mb-2">
                                            <div class="header">
                                                <div class="row">
                                                    <div class="col-2 ">
                                                        @if($jobPost->Employer->logo && $jobPost->hide_comopany == 0)
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
                        @if($jobPost->hide_comopany == 0)
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
                        <button type="submit" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                        </button>
                    @elseauth('employer')
                    @else
                        <button type="submit" class="{{ $disabled }} btn-sm btn apply-company-btn py-2 px-3">
                            <i class="fa-solid fa-arrow-right-long fa-rotate-by" style="--fa-rotate-angle: -45deg;"></i> <span class="">{{ $btn_text }}</span>
                        </button>
                    @endguest
                </div>
            </form>
        </div>
    </div>
</div>