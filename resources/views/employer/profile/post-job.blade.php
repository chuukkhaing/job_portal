<div class="container-fluid" id="edit-profile-header">
    <form action="{{ route('employer-job-post.store') }}" method="post" enctype="multipart/form-data">
        <div class="px-5 m-0 pb-0 pt-5">
        
            @csrf 
            
            <h5>Create a Job Ad That Attracts Top Jobseekers</h5>
            <span>Discover expert tips to optimize your job ad's visibility and appeal, attracting high-caliber candidates</span>
            <div class="row">
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="job_title" class="seeker_label my-2">Job Title <span class="text-danger">*</span></label>
                    <input type="text" name="job_title" id="job_title" class="form-control seeker_input" required placeholder="Job Title" value="">
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="main_functional_area_id" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
                    <select name="main_functional_area_id" id="main_functional_area_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                        <option value="">Choose...</option>
                        @foreach($functional_areas as $functional_area)
                        <option value="{{ $functional_area->id }}" >{{ $functional_area->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="sub_functional_area_id" class="seeker_label my-2">Sub Functional Area <span class="text-danger">*</span></label>
                    <select name="sub_functional_area_id" id="sub_functional_area_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                        <option value="">Choose...</option>
                        @foreach($sub_functional_areas as $sub_functional_area)
                        <option value="{{ $sub_functional_area->id }}" >{{ $sub_functional_area->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="job_post_industry_id" class="seeker_label my-2">Job Industry <span class="text-danger">*</span></label>
                    <select name="job_post_industry_id" id="job_post_industry_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                        <option value="">Choose...</option>
                        @foreach($industries as $industry)
                        <option value="{{ $industry->id }}" >{{ $industry->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="career_level" class="seeker_label my-2">Career Level <span class="text-danger">*</span></label>
                    <select name="career_level" id="career_level" class="select_2 form-control seeker_input" style="width: 100%" required>
                        <option value="">Choose...</option>
                        @foreach(config('careerlevel') as $careerlevel)
                        <option value="{{ $careerlevel }}" >{{ $careerlevel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="job_type" class="seeker_label my-2">Job Type <span class="text-danger">*</span></label>
                    <select name="job_type" id="job_type" class="select_2 form-control seeker_input" style="width: 100%" required>
                        <option value="">Choose...</option>
                        @foreach(config('jobtype') as $jobtype)
                        <option value="{{ $jobtype }}" >{{ $jobtype }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
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
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="degree" class="seeker_label my-2">Degree <span class="text-danger">*</span></label><br>
                    <select name="degree" id="degree" class="select_2 form-control seeker_input" style="width: 100%">
                        <option value="">Choose...</option>
                        @foreach(config('seekerdegree') as $degree)
                        <option value="{{ $degree }}" >{{ $degree }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="degree-error"></span>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="gender" class="seeker_label my-2">Preferred Gender</label><br>
                    <input type="checkbox" name="male" id="male">
                    <label for="male">Male</label>
                    <input type="checkbox" name="female" id="female">
                    <label for="female">Female</label>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="currency" class="seeker_label my-2">Currency</label>
                    <select name="currency" id="currency" class="select_2 form-control seeker_input" style="width: 100%" >
                        <option value="">Choose...</option>
                        <option value="USD">USD</option>
                        <option value="MMK">MMk</option>
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6 mmk_salary d-none">
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
                <div class="form-group mt-1 col-12 col-md-6 usd_salary d-none">
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
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="salary_status" class="seeker_label my-2">Salary Status</label>
                    <select name="salary_status" id="salary_status" class="select_2 form-control seeker_input" style="width: 100%">
                        <option value="">Choose...</option>
                        <option value="Hide">Hide</option>
                        <option value="Negotiable">Negotiable</option>
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="job_post_country" class="seeker_label my-2">Country <span class="text-danger">*</span></label>
                    <select name="job_post_country" id="job_post_country" class="form-control seeker_input" required>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6" id="job_post_state_id_field">
                    <label for="job_post_state_id" class="seeker_label my-2">State or Region <span class="text-danger">*</span></label><br>
                    <select name="job_post_state_id" id="job_post_state_id" class="select_2 form-control seeker_input" style="width: 100%">
                        <option value="">Choose...</option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group mt-1 col-12 col-md-6" id="job_post_township_id_field">
                    <label for="job_post_township_id" class="seeker_label my-2">City <span class="text-danger">*</span></label><br>
                    <select name="job_post_township_id" id="job_post_township_id" class="select_2 form-control seeker_input" style="width: 100%">
                        <option value="">Choose...</option>
                        @foreach($townships as $township)
                        <option value="{{ $township->id }}">{{ $township->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-1 col-12">
                    <label for="job_description" class="seeker_label my-2">Job Description</label>
                    <textarea name="job_description" id="job_description" class="form-control seeker_input summernote" cols="30" rows="2"></textarea>
                </div>
                <div class="form-group mt-1 col-12">
                    <label for="benefit" class="seeker_label my-2">Job Benefitss</label>
                    <textarea name="benefit" id="benefit" class="form-control seeker_input summernote" cols="30" rows="2"></textarea>
                </div>
                <div class="form-group mt-1 col-12">
                    <label for="job_higlight" class="seeker_label my-2">Job Higlighted</label>
                    <textarea name="job_higlight" id="job_higlight" class="form-control seeker_input summernote" cols="30" rows="2"></textarea>
                </div>
                <div class="form-group mt-1 col-12">
                    <label for="requirement_and_skill" class="seeker_label my-2">Requirement and Skills</label>
                    <textarea name="requirement_and_skill" id="requirement_and_skill" class="form-control seeker_input summernote" cols="30" rows="2"></textarea>
                </div>
                <div class="col-12 mb-2 text-center">
                    <button type="submit" class="btn profile-save-btn">Post Job</button>
                </div>
            </div>
        </div>
    </form>
</div>
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