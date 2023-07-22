@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard m-auto">
    <div class="row employer-dashboard-header bg-light m-0">
        <div class="col-2 p-3">
            @if($employer->logo)
            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Company Logo" class="employer-header-logo">
            @else
            <img src="{{ asset('img/employer/Vertical Logo.svg') }}" alt="Company Logo" class="employer-header-logo">
            @endif
        </div>
        <div class="col-10 p-3">
            <div class="mb-4">
                <h4 class="fw-bold d-inline-block">Upgrade Your Package</h4>
                <div class="float-end">
                    <a href="http://" class="btn btn-outline-primary">Add-on Features</a>
                    <a href="http://" class="btn profile-save-btn">Package Details</a>
                </div>
            </div>
            <p>Our packing pricing design allows you to choose the right package that best fits your business needs. We offer a variety of options, each with different features, points, and pricing. Simply select the package that works best for you, and our team will take care of the rest.</p>
            <div class="row">
                <div class="col-4 p-1">
                    <div class="economy p-3">
                        Economy
                    </div>
                </div>
                <div class="col-4 p-1">
                    <div class="standard p-3">
                        Standard
                    </div>
                </div>
                <div class="col-4 p-1">
                    <div class="premium p-3">
                        Premium
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-light mt-1" id="edit-profile-header">
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
                                    <option value="MMK">MMk</option>
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
                                <input type="checkbox" name="hide_company_name" id="hide_company_name">
                                <label for="hide_company_name">Hide Company (Make confidential Job)</label>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="gender" class="seeker_label my-2">Preferred Gender</label><br>
                                <select name="gender" id="gender" class="form-control seeker_input" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="job_post_country" class="seeker_label my-2">Country <span class="text-danger">*</span></label>
                                <select name="job_post_country" id="job_post_country" class="form-control seeker_input" required>
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
                                <label for="job_post_township_id" class="seeker_label my-2">City <span class="text-danger">*</span></label><br>
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
                                <label for="reruiter_name" class="seeker_label my-2">Name <span class="text-danger">*</span></label>
                                <input type="text" name="reruiter_name" id="reruiter_name" class="form-control seeker_input" required placeholder="Enter Name" value="{{ old('reruiter_name') }}">
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="reruiter_phone" class="seeker_label my-2">Email <span class="text-danger">*</span></label>
                                <input type="email" name="reruiter_email" id="reruiter_email" class="form-control seeker_input" required placeholder="Enter Name" value="{{ old('reruiter_name') }}">
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="reruiter_phone" class="seeker_label my-2">Phone <span class="text-danger">*</span></label>
                                <input type="number" name="reruiter_phone" id="reruiter_phone" class="form-control seeker_input" required placeholder="Enter Name" value="{{ old('reruiter_name') }}">
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
                                <textarea name="benefit" id="benefit" cols="30" rows="5" required class="seeker_input form-control"></textarea>
                            </div>
                            <div class="col-4 mt-4 py-3 align-self-center flex-column bd-highlight form-group text-center" style="background: #E8EFF7; border-radius: 8px">
                                <div>Bonus + Commison </div>
                                <div>Meal + Travel Allowance </div>
                                <div>Overtime Payment </div>
                                <div>Reward for Over Performance </div>
                            </div>
                            <div class="col-8 form-group">
                                <label for="highlight" class="seeker_label">Highlight</label>
                                <textarea name="highlight" id="highlight" cols="30" rows="5" required class="seeker_input form-control"></textarea>
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
        </div>
        <div class="col-12 mb-2 text-center">
            <button type="submit" class="btn profile-save-btn">Post Job</button>
        </div>
    </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
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
            $("#job_post_township_id").prop('required',true);
        }else {
            $("#job_post_state_id_field").addClass('d-none');
            $("#job_post_township_id_field").addClass('d-none');
            $("#job_post_state_id_field").val('');
            $("#job_post_township_id_field").val('');
            $("#job_post_state_id").prop('required',false);
            $("#job_post_township_id").prop('required',false);
        }

        $("#job_post_country").change(function() {
            if($(this).val() == "Myanmar") {
                $("#job_post_state_id_field").removeClass('d-none');
                $("#job_post_township_id_field").removeClass('d-none');
                $("#job_post_state_id").prop('required',true);
                $("#job_post_township_id").prop('required',true);
            }else {
                $("#job_post_state_id_field").addClass('d-none');
                $("#job_post_township_id_field").addClass('d-none');
                $("#job_post_state_id_field").val('');
                $("#job_post_township_id_field").val('');
                $("#job_post_state_id").prop('required',false);
                $("#job_post_township_id").prop('required',false);
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
                    url: 'get-township/'+job_post_state_id,
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
                    url: 'get-sub-functional-area/'+main_functional_area_id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $("#sub_functional_area_id").empty();
                        $("#sub_functional_area_id").append('<option value="">Choose</option>')
                        $.each(response.data, function(index, sub_functional_area) {
                        
                        $("#sub_functional_area_id").append('<option value=' + sub_functional_area.id + '>' + sub_functional_area.name +'</option>');
                        })
                    }
                })
            }else {
                $("#sub_functional_area_id").empty();
            }
        });
    })
</script>
@endpush