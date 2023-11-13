@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    @include('employer.profile.employer-sub-header')
    <div class="container-fluid mt-1 py-3" id="edit-profile-header">
        <form action="{{ route('employer-job-post.store') }}" method="post" enctype="multipart/form-data">
            <div class="px-0 px-sm-3 m-0 pb-0 pt-3">
            
                @csrf 
                <div class="row">
                    <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
                        <div class="step">
                            Step 1
                        </div>
                    </div>
                    <div class="col-8 col-sm-10 col-lg-10 col-xl-11 align-self-center">
                        <div class="py-2">
                            <h5>Job Details</h5>
                        </div>
                    </div>
                    <div class="col-11 col-sm-12">
                        <div class="py-2">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_title" class="seeker_label my-2">Job Title <span class="text-danger">*</span></label>
                                    <input type="text" name="job_title" id="job_title" class="form-control seeker_input @error('job_title') is-invalid @enderror" placeholder="Job Title" value="{{ old('job_title') }}">
                                    @error('job_title')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_post_industry" class="seeker_label my-2">Job Industry <span class="text-danger">*</span></label>
                                    <select name="job_post_industry" id="job_post_industry" class="select_2 form-control seeker_input @error('job_post_industry') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach($industries as $industry)
                                        <option value="{{ $industry->id }}" @if($industry->id == old('job_post_industry')) selected @endif >{{ $industry->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('job_post_industry')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="main_functional_area" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
                                    <select name="main_functional_area" id="main_functional_area" class="select_2 form-control seeker_input @error('main_functional_area') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach($functional_areas as $functional_area)
                                        <option value="{{ $functional_area->id }}" @if($functional_area->id == old('main_functional_area')) selected @endif>{{ $functional_area->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('main_functional_area')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="sub_functional_area" class="seeker_label my-2">Sub Functional Area <span class="text-danger">*</span></label>
                                    <select name="sub_functional_area" id="sub_functional_area" class="select_2 form-control seeker_input @error('sub_functional_area') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach($sub_functional_areas as $sub_functional_area)
                                        <option value="{{ $sub_functional_area->id }}" @if($sub_functional_area->id == old('sub_functional_area')) selected @endif>{{ $sub_functional_area->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_functional_area')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-12 col-md-6">
                                    <label for="career_level" class="seeker_label my-2">Job Level/ Career Level <span class="text-danger">*</span></label>
                                    <select name="career_level" id="career_level" class="select_2 form-control seeker_input @error('career_level') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach(config('careerlevel') as $careerlevel)
                                        <option value="{{ $careerlevel }}" @if($careerlevel == old('career_level')) selected @endif>{{ $careerlevel }}</option>
                                        @endforeach
                                    </select>
                                    @error('career_level')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_type" class="seeker_label my-2">Job Type <span class="text-danger">*</span></label>
                                    <select name="job_type" id="job_type" class="select_2 form-control seeker_input @error('job_type') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach(config('jobtype') as $jobtype)
                                        <option value="{{ $jobtype }}" @if($jobtype == old('job_type')) selected @endif>{{ $jobtype }}</option>
                                        @endforeach
                                    </select>
                                    @error('job_type')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="experience_level" class="seeker_label my-2">Experience Level <span class="text-danger">*</span></label>
                                    <select name="experience_level" id="experience_level" class="select_2 form-control seeker_input @error('experience_level') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        <option value="Less than 1 year" @if('Less than 1 year' == old('experience_level')) selected @endif>Less than 1 year</option>
                                        <option value="1 year" @if('1 year' == old('experience_level')) selected @endif>1 year</option>
                                        <option value="2 years" @if('2 years' == old('experience_level')) selected @endif>2 years</option>
                                        <option value="3 years" @if('3 years' == old('experience_level')) selected @endif>3 years</option>
                                        <option value="4 years" @if('4 years' == old('experience_level')) selected @endif>4 years</option>
                                        <option value="5 years" @if('5 years' == old('experience_level')) selected @endif>5 years</option>
                                        <option value="6 years" @if('6 years' == old('experience_level')) selected @endif>6 years</option>
                                        <option value="7 years" @if('7 years' == old('experience_level')) selected @endif>7 years</option>
                                        <option value="8 years" @if('8 years' == old('experience_level')) selected @endif>8 years</option>
                                        <option value="over 8 years" @if('over 8 years' == old('experience_level')) selected @endif>over 8 years</option>
                                    </select>
                                    @error('experience_level')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="degree" class="seeker_label my-2">Education/ Qualification <span class="text-danger">*</span></label><br>
                                    <select name="degree" id="degree" class="select_2 form-control seeker_input @error('degree') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach(config('seekerdegree') as $degree)
                                        <option value="{{ $degree }}" @if($degree == old('degree')) selected @endif>{{ $degree }}</option>
                                        @endforeach
                                    </select>
                                    @error('degree')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="no_of_candidate" class="seeker_label my-2">No. of Candidate <span class="text-danger">*</span></label><br>
                                    <input type="number" name="no_of_candidate" id="no_of_candidate" class="form-control seeker_input @error('no_of_candidate') is-invalid @enderror" placeholder="No. of Candidate" value="{{ old('no_of_candidate') }}">
                                    @error('no_of_candidate')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-12 col-md-6">
                                    <label for="currency" class="seeker_label my-2">Currency</label>
                                    <select name="currency" id="currency" class="select_2 form-control seeker_input" style="width: 100%" >
                                        <option value="">Choose...</option>
                                        <option value="USD" @if('USD' == old('currency')) selected @endif>USD</option>
                                        <option value="MMK" @if('MMK' == old('currency')) selected @endif>MMK</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-6 mmk_salary d-none">
                                    <label for="mmk_salary" class="seeker_label my-2">Salary Range</label>
                                    <select name="mmk_salary" id="mmk_salary" class="select_2 form-control seeker_input" style="width: 100%" >
                                        <option value="">Choose...</option>
                                        <option value="Less than 2 lakh" @if('Less than 2 lakh' == old('mmk_salary')) selected @endif>Less than 2 lakh</option>
                                        <option value="2 to 4 Lakh" @if('2 to 4 Lakh' == old('mmk_salary')) selected @endif>2 to 4 Lakh</option>
                                        <option value="4 to 6 Lakh" @if('4 to 6 Lakh' == old('mmk_salary')) selected @endif>4 to 6 Lakh</option>
                                        <option value="6 to 8 Lakh" @if('6 to 8 Lakh' == old('mmk_salary')) selected @endif>6 to 8 Lakh</option>
                                        <option value="8 to 10 Lakh" @if('8 to 10 Lakh' == old('mmk_salary')) selected @endif>8 to 10 Lakh</option>
                                        <option value="10 to 15 Lakh" @if('10 to 15 Lakh' == old('mmk_salary')) selected @endif>10 to 15 Lakh</option>
                                        <option value="15 to 20 Lakh" @if('15 to 20 Lakh' == old('mmk_salary')) selected @endif>15 to 20 Lakh</option>
                                        <option value="20 to 40 Lakh" @if('20 to 40 Lakh' == old('mmk_salary')) selected @endif>20 to 40 Lakh</option>
                                        <option value="Over 40 Lakh" @if('Over 40 Lakh' == old('mmk_salary')) selected @endif>Over 40 Lakh</option>
                                        <option value="Incentive/ comission only" @if('Incentive/ comission only' == old('mmk_salary')) selected @endif>Incentive/ comission only</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-6 usd_salary d-none">
                                    <label for="usd_salary" class="seeker_label my-2">Salary Range</label>
                                    <select name="usd_salary" id="usd_salary" class="select_2 form-control seeker_input" style="width: 100%" >
                                        <option value="">Choose...</option>
                                        <option value="Less Than 300" @if('Less Than 300' == old('usd_salary')) selected @endif>Less Than 300</option>
                                        <option value="300 to 500" @if('300 to 500' == old('usd_salary')) selected @endif>300 to 500</option>
                                        <option value="500 to 800" @if('500 to 800' == old('usd_salary')) selected @endif>500 to 800</option>
                                        <option value="800 to 1500" @if('800 to 1500' == old('usd_salary')) selected @endif>800 to 1500</option>
                                        <option value="1500 to 3000" @if('1500 to 3000' == old('usd_salary')) selected @endif>3000 to 1500</option>
                                        <option value="3000 to 5000" @if('3000 to 5000' == old('usd_salary')) selected @endif>3000 to 5000</option>
                                        <option value="Over 5000" @if('Over 5000' == old('usd_salary')) selected @endif>Over 5000</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3 col-12 col-md-6">
                                    <input type="checkbox" name="hide_salary" id="hide_salary" @if(old('hide_salary')) checked @endif>
                                    <label for="hide_salary">Hide Salary</label><br>
                                    @foreach($packageItems as $packageItem)
                                    @if($packageItem->name == 'Anonymous Posting')
                                    <input type="checkbox" name="hide_company_name" id="hide_company_name" @if(old('hide_company_name')) checked @endif>
                                    <label for="hide_company_name">Hide Company (Make confidential Job)</label>
                                    <input type="hidden" name="anonymous_posting_point" id="anonymous_posting_point" value="{{ $packageItem->point }}">
                                    <input type="hidden" name="anonymous_posting_package_item_id" id="anonymous_posting_package_item_id" value="{{ $packageItem->id }}">
                                    @endif
                                    @endforeach
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="gender" class="seeker_label my-2">Preferred Gender</label><br>
                                    <input type="checkbox" name="male" id="male" @if(old('male')) checked @endif>
                                    <label for="male">Male</label><br>
                                    <input type="checkbox" name="female" id="female" @if(old('female')) checked @endif>
                                    <label for="female">Female</label>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_post_country" class="seeker_label my-2">Country <span class="text-danger">*</span></label>
                                    <select name="job_post_country" id="job_post_country" class="seeker_input @error('job_post_country') is-invalid @enderror" style="width: 100%">
                                        <option value="Myanmar" @if('Myanmar' == old('job_post_country')) selected @endif>Myanmar</option>
                                        <option value="Other" @if('Other' == old('job_post_country')) selected @endif>Other</option>
                                    </select>
                                    @error('job_post_country')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6" id="job_post_state_id_field">
                                    <label for="job_post_state" class="seeker_label my-2">State or Region <span class="text-danger">*</span></label><br>
                                    <select name="job_post_state" id="job_post_state" class="select_2 form-control seeker_input @error('job_post_state') is-valid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}" @if($state->id == old('job_post_state')) selected @endif>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('job_post_state')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            
                                <div class="form-group col-12 col-md-6" id="job_post_township_id_field">
                                    <label for="job_post_township_id" class="seeker_label my-2">City/ Township </label><br>
                                    <select name="job_post_township_id" id="job_post_township_id" class="select_2 form-control seeker_input" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach($townships as $township)
                                        <option value="{{ $township->id }}" @if($township->id == old('job_post_township_id')) selected @endif>{{ $township->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
                        <div class="step">
                            Step 2
                        </div>
                    </div>
                    <div class="col-8 col-sm-10 col-lg-10 col-xl-11 align-self-center">
                        <div class="py-2">
                            <h5>Notify to the assigned recruiter</h5>
                        </div>
                    </div>
                    <div class="col-11 col-sm-12">
                        <div class="py-2">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="recruiter_name" class="seeker_label my-2">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="recruiter_name" id="recruiter_name" class="form-control seeker_input @error('recruiter_name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('recruiter_name') }}">
                                    @error('recruiter_name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="recruiter_email" class="seeker_label my-2">Email </label>
                                    <input type="email" name="recruiter_email" id="recruiter_email" class="form-control seeker_input"  placeholder="Enter Name" value="{{ old('recruiter_email') }}">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
                        <div class="step">
                            Step 3
                        </div>
                    </div>
                    <div class="col-8 col-sm-10 col-lg-10 col-xl-11 align-self-center">
                        <div class="py-2">
                            <h5>Job Description</h5>
                        </div>
                    </div>
                    <div class="col-11 col-sm-12">
                        <div class="py-2">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="skill_id" class="seeker_label my-2">Skill Name <span class="text-danger">*</span></label><br>
                                    <select name="skills[]" id="skill_id" class="form-control seeker_input select_2 @error('skills') is-invalid @enderror" style="width:100%" multiple>
                                        <option value="">Choose...</option>
                                        
                                    </select>
                                    @error('skills')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <br>
                                </div>
                                <div class="col-12 col-md-6"></div>
                                <div class="col-12 col-md-6 form-group">
                                    <label for="job_description" class="seeker_label">Job Description <span class="text-danger">*</span></label>
                                    <textarea name="job_description" class="summernote" id="job_description" cols="30" rows="5" class="seeker_input form-control @error('job_description') is-valid @enderror">{{ old('job_description') }}</textarea>
                                    @error('job_description')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                    <label for="job_requirement" class="seeker_label">Job Requirement <span class="text-danger">*</span></label>
                                    <textarea name="job_requirement" class="summernote" id="job_requirement" cols="30" rows="5" class="seeker_input form-control @error('job_requirement') @enderror">{{ old('job_requirement') }}</textarea>
                                    @error('job_requirement')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-8 form-group">
                                    <label for="benefit" class="seeker_label">Benefits</label>
                                    <textarea name="benefit" id="benefit" cols="30" rows="5"  class="seeker_input form-control">{{ old('benefit') }}</textarea>
                                </div>
                                <div class="col-12 col-md-4 mt-4 ms-2 ms-sm-0 py-3 align-self-center flex-column bd-highlight form-group text-center" style="background: #E8EFF7; border-radius: 8px">
                                    <div>Bonus + Commison </div>
                                    <div>Meal + Travel Allowance </div>
                                    <div>Overtime Payment </div>
                                    <div>Reward for Over Performance </div>
                                </div>
                                <div class="col-12 col-md-8 form-group">
                                    <label for="highlight" class="seeker_label">Highlight</label>
                                    <textarea name="highlight" id="highlight" cols="30" rows="5"  class="seeker_input form-control">{{ old('highlight') }}</textarea>
                                </div>
                                <div class="col-12 col-md-4 mt-4 ms-2 ms-sm-0 py-3 align-self-center flex-column bd-highlight form-group text-center" style="background: #E8EFF7; border-radius: 8px">
                                    <div>Fun Working Enviroment </div>
                                    <div>International Standards </div>
                                    <div>Make a Differnce </div>
                                    <div>Join an Experience Team </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach($packageItems as $packageItem)
                @if($packageItem->name == 'Pre-qualify questions')
                <div class="row">
                    <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
                        <div class="step">
                            Step 4
                        </div>
                    </div>
                    <div class="col-8 col-sm-10 col-lg-10 col-xl-11 align-self-center">
                        <div class="py-2">
                            <h5>Get to know your applicants</h5>
                        </div>
                    </div>
                    <div class="col-11 col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered job-post-question d-none">
                                <thead>
                                    <tr>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="py-2">
                            <div class="row">
                                <div class="col-12 col-md-6 form-group">
                                    <label for="job_post_question" class="seeker_label">Create Question</label>
                                    <input type="text" name="job_post_question" id="job_post_question" class="form-control seeker_input"  placeholder="Write Question" value="">
                                    <span class="text-danger job-post-question-error d-none">Please Fill the Question.</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_post_answer" class="seeker_label my-2">Selecter Answer Type</label><br>
                                    <select name="job_post_answer" id="job_post_answer" class="seeker_input" style="width: 100%" >
                                        <option value="Text Answer">Text Answer</option>
                                        <option value="Multiple Choice">Multiple Choice</option>
                                    </select>
                                    <span class="text-danger job-post-answer-error d-none">Need to Choose Answer Type.</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                <a class="btn btn-outline-primary rounded-3" onclick="createQuestion()"><i class="fa-solid fa-plus"></i> Create Question</a>
                                </div>
                                <input type="hidden" name="question_point" id="question_point" value="{{ $packageItem->point }}">
                                <input type="hidden" name="question_package_item_id" id="question_package_item_id" value="{{ $packageItem->id }}">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                <div class="row">
                    <div class="col-4 col-sm-2 col-lg-2 col-xl-1">
                        <div class="step">
                        @if($packageItems->where('name','Pre-qualify questions')->count() == 0)
                            Step 4
                        @else 
                            Step 5
                        @endif
                        </div>
                    </div>
                    <div class="col-8 col-sm-10 col-lg-10 col-xl-11 align-self-center">
                        <div class="py-2">
                            <h5>Elevate your posting</h5>
                        </div>
                    </div>
                    <div class="col-11 col-sm-12">
                        <div class="py-2">
                            <div class="row">
                                <div class="col-12 col-md-4 p-3">
                                    <div class="job_post_type_check_box w-100 p-3">
                                        <input type="radio" name="job_post_type" id="standard_job_post" value="standard" checked @if(old('job_post_type') == 'standard') checked @endif><br>
                                        <label for="standard_job_post" class="w-100">
                                            <h5>Standard Post</h5>
                                            <div class="standard_check_box w-100 d-flex align-items-center justify-content-center">
                                                <img src="{{ asset('frontend/img/logo/white_logo.svg') }}" alt="" width="200px">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @foreach($packageItems as $packageItem)
                                @if($packageItem->name == 'Feature Job Post')
                                <div class="col-12 col-md-4 p-3">
                                    <div class="job_post_type_check_box w-100 p-3">
                                        <input type="radio" name="job_post_type" id="feature_job_post" value="feature" @if(old('job_post_type') == 'feature') checked @endif><br>
                                        <label for="feature_job_post" class="w-100">
                                            <h5>Feature Job Post</h5>
                                            <div class="standard_check_box d-flex align-items-center justify-content-center">
                                                <img src="{{ asset('frontend/img/logo/white_logo.svg') }}" alt="" width="200px">
                                            </div>
                                        </label>
                                    </div>
                                    <input type="hidden" name="feature_job_point" id="feature_job_point" value="{{ $packageItem->point }}">
                                    <input type="hidden" name="feature_job_package_item_id" id="feature_job_package_item_id" value="{{ $packageItem->id }}">
                                </div>
                                @endif
                                @endforeach
                                @foreach($packageItems as $packageItem)
                                @if($packageItem->name == 'Trending Job Post')
                                <div class="col-12 col-md-4 p-3">
                                    <div class="job_post_type_check_box w-100 p-3">
                                        <input type="radio" name="job_post_type" id="trending_job_post" value="trending" @if(old('job_post_type') == 'trending') checked @endif><br>
                                        <label for="trending_job_post" class="w-100">
                                            <h5>Trending Job Post</h5>
                                            <div class="standard_check_box d-flex align-items-center justify-content-center">
                                                <img src="{{ asset('frontend/img/logo/white_logo.svg') }}" alt="" width="200px">
                                            </div>
                                        </label>
                                    </div>
                                    <input type="hidden" name="trending_job_point" id="trending_job_point" value="{{ $packageItem->point }}">
                                    <input type="hidden" name="trending_job_package_item_id" id="trending_job_package_item_id" value="{{ $packageItem->id }}">
                                </div>
                                @endif
                                @endforeach
                                @error('job_post_type')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row col-12 mb-2 py-3 text-center">
                <div class="col-12 col-sm-4">
                    <label for="total_point" class="seeker_label fw-bold">Total Point:</label>
                    <input type="text" name="total_point" id="total_point" class="border-0 bg-transparent w-25" readonly>
                </div>
                <div class="col-12 col-sm-8 d-flex justify-content-end">
                    
                    <div class="btn btn-outline-primary preview_card" data-toggle="modal" data-target="#exampleModalOut">
                        <span>Show preview</span><i class="fa-solid fa-eye px-2"></i>
                    </div>
                    <input type="hidden" name="status" id="job-post-status" value="Pending">
                    <button type="submit" class="btn btn-secondary ms-3" id="job-post-submit-draft">
                        <span>Save as Draft</span>
                    </button>
                    <button type="submit" class="btn profile-save-btn mx-3">
                        <span>Post Job</span><i class="fa-solid fa-arrow-right-long px-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalOut" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('frontend/img/logo/Logo Svg.svg') }}" class="img-fluid">
                        </div>
                        <div class="col-8">
                            <h5>This is a preview of what people may see</h5>
                            <span>Your job post may look slightly different when it goes live.</span>
                        </div>
                        <div class="col-1">
                            <div type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-body p-0">
                <div class="container-fluid">
                    <div class="row px-3" style="background-color: #ebf5ff">
                        <div class="col-lg-6 col-md-6 col-6">
                            <div class="company-name py-3">
                                <span>{{ $employer->name }}</span>
                                <h3 class="preview_job_title"></h3>
                                <span class="preview_address"></span>
                                <h3 class="preview_salary"></h3>
                            </div>
                        </div>
                
                        
                    </div>

                    <div class="row col-12 m-0 p-0 py-3">
                        <h5 class="fw-bolder fs-6">Job Description</h5>
                        <div class="preview_job_description">
                            
                        </div>
                    </div>
        
                    <div class="row col-12 m-0 p-0 py-3">
                        <h5 class="fw-bolder fs-6">Job Requirements</h5>          
                        <div class="preview_job_requirement">
                            
                        </div>
                    </div>
                
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <div type="button" class="btn btn-outline-primary text-blue" data-dismiss="modal">Close preview</div>
              </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pointBalance" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pointBalanceLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 50%; margin: auto">
      <div class="modal-header">
        <h5 class="modal-title" id="pointBalanceLabel">Point Balance</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      Your Balance Points are not enough to Post Job.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn profile-save-btn" id="buyYourPoint">Buy Your Points</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="buyPointForm">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 50%; margin: auto">
      <div class="modal-header">
        <h5 class="modal-title" id="buyPointFormLabel">Buy Point</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        
            <div class="col-12 m-auto">
                <div class="row">
                    <div class="form-group col-12">
                        
                        <input type="text" name="name" id="name" class="form-control seeker_input name-input" placeholder="Name *" value="{{ old('name') }}">
                        <small class="text-danger d-none name-error">Name is required</small>
                    </div>
                    <div class="form-group col-12">
                        
                        <input type="text" name="phone" id="phone" class="form-control seeker_input phone-input" placeholder="Phone *" value="{{ old('phone') }}">
                        <small class="text-danger d-none phone-error">Phone is required</small>
                    </div>
                    <div class="form-group col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                @foreach($pointPackages as $pointPackage)
                                <label class="card-radio-btn" for="pointPackage-{{ $pointPackage->id }}">
                                    <input type="radio" name="point_package_id" class="card-input-element d-none" id="pointPackage-{{ $pointPackage->id }}" @if($loop->first || (old('point_package_id') == $pointPackage->id)) checked @endif value="{{ $pointPackage->id }}">
                                    <div class="card card-body">
                                        <div class="content_head">{{ number_format($pointPackage->point) }} Points</div>
                                        <div class="content_sub">{{ number_format($pointPackage->price) }} MMK</div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="is_make_point_detect" id="is_make_point_detect">
                        <label for="is_make_point_detect">We'll detect <span id="point_detect"></span> point(s) for current Job Post.</label>
                        
                    </div>
                    <div class="col-12 text-center">
                        <button class="btn profile-save-btn btn-sm" id="point-order-confirm">Confirm</button>
                    </div>
                </div>
            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        
        var old_skills = @json(old('skills'));
        var main_functional_area = $('#main_functional_area').val();
        if(main_functional_area) {
            $.ajax({
                type: 'GET',
                url: '/employer/get-skill/'+main_functional_area,
            }).done(function(response){
                if(response.status == 'success') {
                    $("#skill_id").empty();
                    $("#skill_id").append('<option value="">Choose...</option>');
                    $.each(response.data, function(index, skill) {
                        $.each(old_skills, function(old_skill_index, old_skill) {
                            var selected = '';
                            if(old_skill == skill.id) {
                                selected = 'selected';
                            }
                            $("#skill_id").append('<option value="' + skill.id + '" '+ selected +'>' + skill.name +'</option>');
                        })
                    })
                }
            });
        }
        $('#total_point').val(0);
        $("#currency").change(function(){
            if($(this).val() == 'USD') {
                $(".mmk_salary").addClass('d-none');
                $("#mmk_salary").val('');
                $(".usd_salary").removeClass('d-none');
            }else {
                $(".usd_salary").addClass('d-none');
                $("#usd_salary").val('');
                $(".mmk_salary").removeClass('d-none');
            }
        })

        if($("#job_post_country").val() == "Myanmar") {
            $("#job_post_state_id_field").removeClass('d-none');
            $("#job_post_township_id_field").removeClass('d-none');
            // $("#job_post_state_id").prop('required',true);
            
        }else {
            $("#job_post_state_id_field").addClass('d-none');
            $("#job_post_township_id_field").addClass('d-none');
            $("#job_post_state_id_field").val('');
            $("#job_post_township_id_field").val('');
            // $("#job_post_state_id").prop('required',false);
            
        }

        $("#job_post_country").change(function() {
            if($(this).val() == "Myanmar") {
                $("#job_post_state_id_field").removeClass('d-none');
                $("#job_post_township_id_field").removeClass('d-none');
                // $("#job_post_state_id").prop('required',true);
                
            }else {
                $("#job_post_state_id_field").addClass('d-none');
                $("#job_post_township_id_field").addClass('d-none');
                $("#job_post_state_id_field").val('');
                $("#job_post_township_id_field").val('');
                // $("#job_post_state_id").prop('required',false);
                
            }
        })

        $("#job-post-submit-draft").click(function() {
            $("#job-post-status").val('Draft');
        })

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#job_post_state').change(function(e){
            e.preventDefault();
            if($(this).val() != "") {
                var job_post_state = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '/employer/get-township/'+job_post_state,
                }).done(function(response){
                    if(response.status == 'success') {
                        $("#job_post_township_id").empty();
                        $("#job_post_township_id").append('<option value="">Choose</option>')
                        $.each(response.data, function(index, township) {
                        
                        $("#job_post_township_id").append('<option value=' + township.id + '>' + township.name +'</option>');
                        })
                    }
                })
            }else {
                $("#job_post_township_id").empty();
            }
        });

        $('#main_functional_area').change(function(e){
            e.preventDefault();
            if($(this).val() != "") {
                var main_functional_area = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '/employer/get-sub-functional-area/'+main_functional_area,
                }).done(function(response){
                    if(response.status == 'success') {
                        $("#sub_functional_area").empty();
                        $("#sub_functional_area").append('<option value="">Choose</option>')
                        $.each(response.data, function(index, sub_functional_area) {
                        
                        $("#sub_functional_area").append('<option value=' + sub_functional_area.id + '>' + sub_functional_area.name +'</option>');
                        })
                    }
                })
                $.ajax({
                    type: 'GET',
                    url: '/employer/get-skill/'+main_functional_area,
                }).done(function(response){
                    if(response.status == 'success') {
                        

                        $("#skill_id").empty();
                        $("#skill_id").append('<option value="">Choose...</option>')
                        $.each(response.data, function(index, skill) {
                        
                        $("#skill_id").append('<option value=' + skill.id + '>' + skill.name +'</option>');
                        })
                    }
                })
            }else {
                $("#sub_functional_area").empty();
                $("#skill_id").empty();
            }
        });

        $("#buyYourPoint").click(function() {
            $("#pointBalance").modal('hide');
            $("#buyPointForm").modal('show')
        })

        $("#point-order-confirm").click(function() {
            var name = $("#name").val();
            var phone = $("#phone").val();
            var point_package_id = $('input[name="point_package_id"]').val();
            var is_make_point_detect = $("#is_make_point_detect").val();

            console.log(name, phone, point_package_id, is_make_point_detect)

            if(name == '') {
                $('.name-error').removeClass('d-none');
                $('.name-input').addClass('is-invalid');
            }else {
                $('.name-error').addClass('d-none');
                $('.name-input').removeClass('is-invalid');
            }

            if(phone == '') {
                $('.phone-error').removeClass('d-none');
                $('.phone-input').addClass('is-invalid');
            }else {
                $('.phone-error').addClass('d-none');
                $('.phone-input').removeClass('is-invalid');
            }

        })

        $("#phone").on('keyup change', function(e){
            e.preventDefault();
            $.ajax({
                type        : 'GET',
                url         : "{{ route('phone-check') }}",
                data        : {
                    'phone'     : $(this).val()
                },
                success: function(response) {
                    $('.phone-error').addClass('d-none');
                    $('.phone-input').removeClass('is-invalid');
                },
                error: function (data, response) {
                    var errors = $.parseJSON(data.responseText);
                    console.log(errors.errors['phone'])
                    if(errors.errors['phone'] !== undefined) {
                        
                        $('.phone-error').removeClass('d-none');
                        $('.phone-input').addClass('is-invalid');
                        $('.phone-error').text(errors.errors['phone']);
                    }
                }
            });
        });
    })
    var anonymous_posting_point = 0;
    $('#hide_company_name').change(function () {
        anonymous_posting_point = 0;
        if($(this).is(":checked")) {
            anonymous_posting_point = $("#anonymous_posting_point").val();
        }else {
            anonymous_posting_point = 0
        }
        calculatePoint();
    });
    var job_post_point = 0;
    $('input[name="job_post_type"]').change(function () {
        var feature = 0;
        var trending = 0;
        var standard = 0;
        job_post_point = 0;
        
        if($(this).val() == 'feature') {
            feature = $('#feature_job_point').val();
        }else {
            feature = 0;
        }
        if($(this).val() == 'trending') {
            trending = $('#trending_job_point').val();
        }else {
            trending = 0
        }
        job_post_point = Number(feature) + Number(trending) + Number(standard);
        calculatePoint();
    })

    var question_point = 0;
    function createQuestion()
    {
        var question = $("#job_post_question").val();
        var answer_type = $("#job_post_answer").val();

        if(question == '') {
            $('.job-post-question-error').removeClass('d-none');
        }else {
            $('.job-post-question-error').addClass('d-none');
        }
        if(answer_type == '') {
            $('.job-post-answer-error').removeClass('d-none');
        }else {
            $('.job-post-answer-error').addClass('d-none');
        }
        if(question != '' && answer_type != '') {
            $('.job-post-question').removeClass('d-none');
            $('.job-post-question').append('<tr><td><input type="text" name="questions[]" value="'+question+'" readonly class="border-0 bg-transparent"></td><td><input type="text" name="answer_types[]" value="'+answer_type+'" readonly class="border-0 bg-transparent"></td><td><a id="DeleteButton" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
            $("#job_post_question").val('');
            $("#job_post_answer").val('Text Answer');
            var rowCount = $('.job-post-question >tbody >tr').length;
            if(rowCount > 0) {
                question_point = 0;
                question_point = $("#question_point").val();
                calculatePoint()
            }
        }
    }

    function calculatePoint()
    {
        total_point = Number(job_post_point) + Number(anonymous_posting_point) + Number(question_point);
        var employer_point = checkPointBalance();

        if(total_point > employer_point) {
            $(".savejobpost").addClass('disabled');
            $("#pointBalance").modal('show');
        }else {
            $(".savejobpost").removeClass('disabled');
        }
        $("#total_point").val(total_point);
        $("#point_detect").text(total_point);
    }

    function checkPointBalance()
    {
        var employer_id = {{ Auth::guard('employer')->user()->id }};
        var point = 0;
        $.ajax({
            type: 'GET',
            url: '/employer/point-balance/'+employer_id,
        }).done(function(response){
            point = response.point;
        })
        return point;
    }

    $(".job-post-question").on("click", "#DeleteButton", function() {
        $(this).closest("tr").remove();
        var rowCount = $('.job-post-question >tbody >tr').length;
        if(rowCount == 0) {
            $('.job-post-question').addClass('d-none');
            question_point = 0;
            calculatePoint()
        }
    });

    $(".preview_card").click(function() {
        $(".preview_job_title").html($("#job_title").val());
        $(".preview_address").html($("#career_level").val()+' - '+$("#job_type").val());
        $(".preview_salary").html($("#mmk_salary").val()+''+ $("#usd_salary").val() +' '+ $("#currency").val());
        $(".preview_job_description").html($("#job_description").val());
        $(".preview_job_requirement").html($("#job_requirement").val());
    })
</script>
@endpush