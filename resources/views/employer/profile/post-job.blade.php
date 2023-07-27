@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    <div class="row employer-dashboard-header bg-light m-0">
        <div class="col-2 p-3">
            <a href="{{ route('employer-profile.index') }}">
            @if($employer->logo)
            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Company Logo" class="employer-header-logo">
            @else
            <img src="{{ asset('img/employer/Vertical Logo.svg') }}" alt="Company Logo" class="employer-header-logo">
            @endif
            </a>
        </div>
        <div class="col-10 p-3">
            <div class="mb-4">
                <h4 class="fw-bold d-inline-block">Upgrade Your Package</h4>
                <div class="float-end">
                    {{--<a href="http://" class="btn btn-outline-primary">Add-on Features</a>--}}
                    <a data-bs-toggle="modal" data-bs-target="#cardModal" class="btn profile-save-btn text-light">Package Details</a>
                </div>
            </div>
            <p>Our packing pricing design allows you to choose the right package that best fits your business needs. We offer a variety of options, each with different features, points, and pricing. Simply select the package that works best for you, and our team will take care of the rest.</p>
            <div class="row">
                <div class="col-4 p-1">
                    <div class="economy p-3" @if($employer->Package && $employer->Package->name == "Economy Package") style="border: 1px solid #0565FF" @endif>
                        Economy
                        @if($employer->Package && $employer->Package->name == "Economy Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
                <div class="col-4 p-1">
                    <div class="standard p-3" @if($employer->Package && $employer->Package->name == "Standard Package") style="border: 1px solid #C72C91" @endif>
                        Standard
                        @if($employer->Package && $employer->Package->name == "Standard Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
                <div class="col-4 p-1">
                    <div class="premium p-3" @if($employer->Package && $employer->Package->name == "Premium Package") style="border: 1px solid #F58220" @endif>
                        Premium
                        @if($employer->Package && $employer->Package->name == "Premium Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-light mt-1 py-5" id="edit-profile-header">
    <form action="{{ route('employer-job-post.store') }}" method="post" enctype="multipart/form-data">
        <div class="px-5 m-0 pb-0 pt-5">
        
            @csrf 
            <div class="row">
                <div class="col-1">
                    <div class="step">
                        Step 1
                    </div>
                </div>
                <div class="col-11">
                    <div class="py-2">
                        <h5>Create a Job Ad That Attracts Top Jobseekers</h5>
                        <span>Discover expert tips to optimize your job ad's visibility and appeal, attracting high-caliber candidates</span>
                    </div>
                    <div class="py-2">
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label for="job_title" class="seeker_label my-2">Job Title <span class="text-danger">*</span></label>
                                <input type="text" name="job_title" id="job_title" class="form-control seeker_input" required placeholder="Job Title" value="{{ old('job_title') }}">
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="job_post_industry_id" class="seeker_label my-2">Job Industry <span class="text-danger">*</span></label>
                                <select name="job_post_industry_id" id="job_post_industry_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                                    <option value="">Choose...</option>
                                    @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}" >{{ $industry->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="main_functional_area_id" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
                                <select name="main_functional_area_id" id="main_functional_area_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                                    <option value="">Choose...</option>
                                    @foreach($functional_areas as $functional_area)
                                    <option value="{{ $functional_area->id }}" >{{ $functional_area->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="sub_functional_area_id" class="seeker_label my-2">Sub Functional Area <span class="text-danger">*</span></label>
                                <select name="sub_functional_area_id" id="sub_functional_area_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                                    <option value="">Choose...</option>
                                    @foreach($sub_functional_areas as $sub_functional_area)
                                    <option value="{{ $sub_functional_area->id }}" >{{ $sub_functional_area->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group col-12 col-md-6">
                                <label for="career_level" class="seeker_label my-2">Job Level/ Career Level <span class="text-danger">*</span></label>
                                <select name="career_level" id="career_level" class="select_2 form-control seeker_input" style="width: 100%" required>
                                    <option value="">Choose...</option>
                                    @foreach(config('careerlevel') as $careerlevel)
                                    <option value="{{ $careerlevel }}" >{{ $careerlevel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="job_type" class="seeker_label my-2">Job Type <span class="text-danger">*</span></label>
                                <select name="job_type" id="job_type" class="select_2 form-control seeker_input" style="width: 100%" required>
                                    <option value="">Choose...</option>
                                    @foreach(config('jobtype') as $jobtype)
                                    <option value="{{ $jobtype }}" >{{ $jobtype }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="experience_level" class="seeker_label my-2">Experience Level <span class="text-danger">*</span></label>
                                <select name="experience_level" id="experience_level" class="select_2 form-control seeker_input" style="width: 100%" required>
                                    <option value="">Choose...</option>
                                    <option value="Less than 1 year">Less than 1 year</option>
                                    <option value="1 year">1 year</option>
                                    <option value="2 years">2 years</option>
                                    <option value="3 years">3 years</option>
                                    <option value="4 years">4 years</option>
                                    <option value="5 years">5 years</option>
                                    <option value="6 years">6 years</option>
                                    <option value="7 years">7 years</option>
                                    <option value="8 years">8 years</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="degree" class="seeker_label my-2">Education/ Qualification <span class="text-danger">*</span></label><br>
                                <select name="degree" id="degree" class="select_2 form-control seeker_input" style="width: 100%" required>
                                    <option value="">Choose...</option>
                                    @foreach(config('seekerdegree') as $degree)
                                    <option value="{{ $degree }}" >{{ $degree }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="no_of_candidate" class="seeker_label my-2">No. of Candidate <span class="text-danger">*</span></label><br>
                                <input type="number" name="no_of_candidate" id="no_of_candidate" class="form-control seeker_input" required placeholder="No. of Candidate" value="{{ old('no_of_candidate') }}">
                            </div>
                            
                            <div class="form-group col-12 col-md-6">
                                <label for="currency" class="seeker_label my-2">Currency</label>
                                <select name="currency" id="currency" class="select_2 form-control seeker_input" style="width: 100%" >
                                    <option value="">Choose...</option>
                                    <option value="USD">USD</option>
                                    <option value="MMK">MMK</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6 mmk_salary d-none">
                                <label for="mmk_salary" class="seeker_label my-2">Salary Range</label>
                                <select name="mmk_salary" id="mmk_salary" class="select_2 form-control seeker_input" style="width: 100%" >
                                    <option value="">Choose...</option>
                                    <option value="Less than 2 lakh">Less than 2 lakh</option>
                                    <option value="2 to 4 Lakh">2 to 4 Lakh</option>
                                    <option value="4 to 6 Lakh">4 to 6 Lakh</option>
                                    <option value="6 to 8 Lakh">6 to 8 Lakh</option>
                                    <option value="8 to 10 Lakh">8 to 10 Lakh</option>
                                    <option value="10 to 15 Lakh">10 to 15 Lakh</option>
                                    <option value="15 to 20 Lakh">15 to 20 Lakh</option>
                                    <option value="20 to 40 Lakh">20 to 40 Lakh</option>
                                    <option value="Over 40 Lakh">Over 40 Lakh</option>
                                    <option value="Incentive/ comission only">Incentive/ comission only</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6 usd_salary d-none">
                                <label for="usd_salary" class="seeker_label my-2">Salary Range</label>
                                <select name="usd_salary" id="usd_salary" class="select_2 form-control seeker_input" style="width: 100%" >
                                    <option value="">Choose...</option>
                                    <option value="Less Than 300">Less Than 300</option>
                                    <option value="300 to 500">300 to 500</option>
                                    <option value="500 to 800">500 to 800</option>
                                    <option value="800 to 1500">800 to 1500</option>
                                    <option value="1500 to 3000">3000 to 1500</option>
                                    <option value="3000 to 5000">3000 to 5000</option>
                                    <option value="Over 5000">Over 5000</option>
                                </select>
                            </div>
                            <div class="form-group mt-3 col-12 col-md-6">
                                <input type="checkbox" name="hide_salary" id="hide_salary">
                                <label for="hide_salary">Hide Salary</label><br>
                                @foreach($packageItems as $packageItem)
                                @if($packageItem->name == 'Anonymous Posting')
                                <input type="checkbox" name="hide_company_name" id="hide_company_name">
                                <label for="hide_company_name">Hide Company (Make confidential Job)</label>
                                <input type="hidden" name="anonymous_posting_point" id="anonymous_posting_point" value="{{ $packageItem->point }}">
                                <input type="hidden" name="anonymous_posting_package_item_id" id="anonymous_posting_package_item_id" value="{{ $packageItem->id }}">
                                @endif
                                @endforeach
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="gender" class="seeker_label my-2">Preferred Gender</label><br>
                                <input type="checkbox" name="male" id="male">
                                <label for="male">Male</label><br>
                                <input type="checkbox" name="female" id="female">
                                <label for="female">Female</label>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="job_post_country" class="seeker_label my-2">Country <span class="text-danger">*</span></label>
                                <select name="job_post_country" id="job_post_country" class="seeker_input" required style="width: 100%">
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6" id="job_post_state_id_field">
                                <label for="job_post_state_id" class="seeker_label my-2">State or Region <span class="text-danger">*</span></label><br>
                                <select name="job_post_state_id" id="job_post_state_id" class="select_2 form-control seeker_input" style="width: 100%">
                                    <option value="">Choose...</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="form-group col-12 col-md-6" id="job_post_township_id_field">
                                <label for="job_post_township_id" class="seeker_label my-2">City/ Township </label><br>
                                <select name="job_post_township_id" id="job_post_township_id" class="select_2 form-control seeker_input" style="width: 100%">
                                    <option value="">Choose...</option>
                                    @foreach($townships as $township)
                                    <option value="{{ $township->id }}">{{ $township->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <div class="step">
                        Step 2
                    </div>
                </div>
                <div class="col-11">
                    <div class="py-2">
                        <h5>Streamline Recruitment with Email or Assigned Recruiters</h5>
                        <span>Discover effective strategies to optimize your hiring process by leveraging email communication or dedicated recruiters.</span>
                    </div>
                    <div class="py-2">
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label for="recruiter_name" class="seeker_label my-2">Name <span class="text-danger">*</span></label>
                                <input type="text" name="recruiter_name" id="recruiter_name" class="form-control seeker_input" required placeholder="Enter Name" value="{{ old('recruiter_name') }}">
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
                <div class="col-1">
                    <div class="step">
                        Step 3
                    </div>
                </div>
                <div class="col-11">
                    <div class="py-2">
                        <h5>Open Job Description</h5>
                        <span>Discover effective strategies to optimize your hiring process by leveraging email communication or dedicated recruiters.</span>
                    </div>
                    <div class="py-2">
                        <div class="row">
                            
                            <div class="form-group col-12 col-md-6">
                                <label for="skill_id" class="seeker_label my-2">Skill Name <span class="text-danger">*</span></label><br>
                                <select name="skills[]" id="skill_id" class="form-control seeker_input select_2" style="width:100%" multiple>
                                    <option value="">Choose...</option>
                                    
                                </select><br>
                            </div>
                            <div class="col-6"></div>
                            <div class="col-6 form-group">
                                <label for="job_description" class="seeker_label">Job Description</label>
                                <textarea name="job_description" id="job_description" cols="30" rows="5" required class="seeker_input form-control"></textarea>
                            </div>
                            <div class="col-6 form-group">
                                <label for="job_requirement" class="seeker_label">Job Requirement</label>
                                <textarea name="job_requirement" id="job_requirement" cols="30" rows="5" required class="seeker_input form-control"></textarea>
                            </div>
                            <div class="col-8 form-group">
                                <label for="benefit" class="seeker_label">Benefits</label>
                                <textarea name="benefit" id="benefit" cols="30" rows="5"  class="seeker_input form-control"></textarea>
                            </div>
                            <div class="col-4 mt-4 py-3 align-self-center flex-column bd-highlight form-group text-center" style="background: #E8EFF7; border-radius: 8px">
                                <div>Bonus + Commison </div>
                                <div>Meal + Travel Allowance </div>
                                <div>Overtime Payment </div>
                                <div>Reward for Over Performance </div>
                            </div>
                            <div class="col-8 form-group">
                                <label for="highlight" class="seeker_label">Highlight</label>
                                <textarea name="highlight" id="highlight" cols="30" rows="5"  class="seeker_input form-control"></textarea>
                            </div>
                            <div class="col-4 mt-4 py-3 align-self-center flex-column bd-highlight form-group text-center" style="background: #E8EFF7; border-radius: 8px">
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
                <div class="col-1">
                    <div class="step">
                        Step 4
                    </div>
                </div>
                <div class="col-11">
                    <div class="py-2">
                        <h5>Open Job Question</h5>
                        <span>Explore a set of thought-provoking interview questions that help evaluate candidates' skills, qualifications, and alignment with our company's values</span>
                    </div>
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
                            <div class="col-6 form-group">
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
                            <div class="col-6">
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
                <div class="col-1">
                    <div class="step">
                    @foreach($packageItems as $packageItem)
                    @if($packageItem->name == 'Pre-qualify questions')
                        Step 5
                    @else 
                        Step 4
                    @endif
                    @endforeach
                    </div>
                </div>
                <div class="col-11">
                    <div class="py-2">
                        <h5>Job Post Ranking Made Easy</h5>
                        <span>Discover effective techniques to rank and prioritize job posts, ensuring you attract the most qualified candidates</span>
                    </div>
                    <div class="py-2">
                        <div class="row">
                            <div class="col-4">
                                <div class="job_post_type_check_box w-100 p-3">
                                    <input type="radio" name="job_post_type" required id="standard_job_post" vlaue="standard"><br>
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
                            <div class="col-4">
                                <div class="job_post_type_check_box w-100 p-3">
                                    <input type="radio" name="job_post_type" required id="feature_job_post" value="feature"><br>
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
                            <div class="col-4">
                                <div class="job_post_type_check_box w-100 p-3">
                                    <input type="radio" name="job_post_type" required id="trending_job_post" value="trending"><br>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2 text-center">
            <div class="col-6">
                <label for="total_point" class="seeker_label fw-bold">Total Point:</label>
                <input type="text" name="total_point" id="total_point" class="border-0 bg-transparent" readonly>
            </div>
            <div class="col-6">
            <button type="submit" class="btn profile-save-btn">Post Job</button>
            </div>
        </div>
    </form>
    </div>
</div>
@endsection
@push('css')
    <style>
        .modal-dialog {
            max-width: 80%;
        }
    </style>
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
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
            $("#job_post_state_id").prop('required',true);
            
        }else {
            $("#job_post_state_id_field").addClass('d-none');
            $("#job_post_township_id_field").addClass('d-none');
            $("#job_post_state_id_field").val('');
            $("#job_post_township_id_field").val('');
            $("#job_post_state_id").prop('required',false);
            
        }

        $("#job_post_country").change(function() {
            if($(this).val() == "Myanmar") {
                $("#job_post_state_id_field").removeClass('d-none');
                $("#job_post_township_id_field").removeClass('d-none');
                $("#job_post_state_id").prop('required',true);
                
            }else {
                $("#job_post_state_id_field").addClass('d-none');
                $("#job_post_township_id_field").addClass('d-none');
                $("#job_post_state_id_field").val('');
                $("#job_post_township_id_field").val('');
                $("#job_post_state_id").prop('required',false);
                
            }
        })

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#job_post_state_id').change(function(e){
            e.preventDefault();
            if($(this).val() != "") {
                var job_post_state_id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '/employer/get-township/'+job_post_state_id,
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

        $('#main_functional_area_id').change(function(e){
            e.preventDefault();
            if($(this).val() != "") {
                var main_functional_area_id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '/employer/get-sub-functional-area/'+main_functional_area_id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $("#sub_functional_area_id").empty();
                        $("#sub_functional_area_id").append('<option value="">Choose</option>')
                        $.each(response.data, function(index, sub_functional_area) {
                        
                        $("#sub_functional_area_id").append('<option value=' + sub_functional_area.id + '>' + sub_functional_area.name +'</option>');
                        })
                    }
                })
                $.ajax({
                    type: 'GET',
                    url: '/employer/get-skill/'+main_functional_area_id,
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
                $("#sub_functional_area_id").empty();
                $("#skill_id").empty();
            }
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
        $("#total_point").val(total_point)
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
</script>
@endpush