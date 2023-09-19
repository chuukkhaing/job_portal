<div class="my-2 row @if($experiences->count() > 0 && $experiences->first()->is_experience == 0) d-none @endif" id="add_career_history">
    <button type="button" class="btn btn-sm profile-save-btn m-2 col-6" data-bs-toggle="modal" data-bs-target="#experienceModal">
        <i class="fa-solid fa-plus"></i> Add Career History
    </button>
</div>
<div class="my-2 row table-responsive">
    <table id="exp-table" class="table-bordered @if($experiences->count() == 0) d-none @endif table">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Company</th>
                <th>Main Functional Area</th>
                <th>Sub Functional Area</th>
                <th>Career Level</th>
                <th>Industry</th>
                <th>Country</th>
                <th>Job Responsibility</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="exp-tbody">
            @foreach($experiences as $experience)
            @if($experience->is_experience == 0)
            <tr class="exp-tr-{{ $experience->id }}">
                <td colspan="10" class="text-center">No Experience</td>
                <td>
                    <a onclick="editExp({{ $experience->id }})" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>
                    <a id="deleteExp-{{ $experience->id }}" class="deleteExp btn border-0 text-danger" value="{{ $experience->id }}"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
            @else
            <tr class="exp-tr-{{ $experience->id }}">
                <td class="exp-job_title-{{$experience->id}}">{{ $experience->job_title }}</td>
                <td class="exp-company-{{$experience->id}}">{{ $experience->company }}</td>
                <td class="exp-main_functional_area_id-{{$experience->id}}">{{ $experience->MainFunctionalArea->name }}</td>
                <td class="exp-sub_functional_area_id-{{$experience->id}}">{{ $experience->SubFunctionalArea->name }}</td>
                <td class="exp-career_lavel-{{$experience->id}}">{{ $experience->career_level }}</td>
                <td class="exp-industry_id-{{$experience->id}}">{{ $experience->Industry->name }}</td>
                <td class="exp-country-{{$experience->id}}">{{ $experience->country }}</td>
                <td class="exp-job-responsibility-{{$experience->id}}">{{ $experience->job_responsibility }}</td>
                <td class="exp-start_date-{{$experience->id}}">{{ date('Y-m', strtotime($experience->start_date)) }}</td>
                @if($experience->is_current_job == 1)
                <td class="exp-end_date-{{$experience->id}}">Present</td>
                @else
                <td class="exp-end_date-{{$experience->id}}">{{ date('Y-m', strtotime($experience->end_date)) }}</td>
                @endif
                <td>
                    <a onclick="editExp({{ $experience->id }})" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>
                    <a id="deleteExp-{{ $experience->id }}" class="deleteExp btn border-0 text-danger" value="{{ $experience->id }}"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="experienceModal" tabindex="-1" aria-labelledby="experienceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="experienceModalLabel">Add Career History Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="is_experienct" class="seeker_label my-2">Experience <span class="text-danger">*</span> </label><br>
                        <select name="is_experienct" id="is_experience" class="seeker_input" style="width: 100%">
                            <option value="1" selected>Experience</option>
                            <option value="0">No Experience</option>
                        </select>
                    </div>
                </div>
                <div class="row no-experience">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="exp_job_title" class="seeker_label my-2">Job Title <span class="text-danger">*</span></label>
                        <input type="text" name="exp_job_title" id="exp_job_title" class="form-control seeker_input" placeholder="Job Title" value="">
                        <span class="text-danger exp_job_title-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="exp_company" class="seeker_label my-2">Employment Company/Organization <span class="text-danger">*</span></label>
                        <input type="text" name="exp_company" id="exp_company" class="form-control seeker_input" placeholder="Employment Company/Organization" value="">
                        <span class="text-danger exp_company-error"></span>
                    </div>
                </div>
                <div class="row no-experience">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="exp_main_functional_area_id" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
                        <select name="exp_main_functional_area_id" id="exp_main_functional_area_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($functional_areas as $functional_area)
                            <option value="{{ $functional_area->id }}">{{ $functional_area->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger exp_main_functional_area_id-error"></span>
                    </div>
                
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="exp_sub_functional_area_id" class="seeker_label my-2">Sub Functional Area <span class="text-danger">*</span></label>
                        <select name="exp_sub_functional_area_id" id="exp_sub_functional_area_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($sub_functional_areas as $sub_functional_area)
                            <option value="{{ $sub_functional_area->id }}">{{ $sub_functional_area->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger exp_sub_functional_area_id-error"></span>
                    </div>
                </div>
                <div class="row no-experience">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="exp_career_level" class="seeker_label my-2">Career Level <span class="text-danger">*</span></label>
                        <select name="exp_career_level" id="exp_career_level" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach(config('careerlevel') as $careerlevel)
                            <option value="{{ $careerlevel }}">{{ $careerlevel }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger exp_career_level-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="exp_industry_id" class="seeker_label my-2">Industry <span class="text-danger">*</span></label>
                        <select name="exp_industry_id" id="exp_industry_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($industries as $industry)
                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger exp_industry_id-error"></span>
                    </div>
                </div>
                <div class="row no-experience">
                    
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="exp_country" class="seeker_label my-2">Country <span class="text-danger">*</span></label><br>
                        <select name="exp_country" id="exp_country" class="seeker_input" style="width: 100%">
                            <option value="Myanmar" selected>Myanmar</option>
                            <option value="Other" >Other</option>
                        </select>
                        <span class="text-danger exp_country-error"></span>
                    </div>
                    <div class="col-12 col-md-6"></div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="exp_job_responsibility" class="seeker_label my-2">Job Responsibility <span class="text-danger">*</span></label><br>
                        <textarea name="exp_job_responsibility" id="exp_job_responsibility" cols="30" rows="5" class="seeker_input" style="width: 100%"></textarea>
                        <span class="text-danger exp_job_responsibility-error"></span>
                    </div>
                    <div class="col-12 col-md-6"></div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <input type="checkbox" name="current_job" id="current_job" checked="1">
                        <label for="current_job" class="seeker_label my-2">Present </label>
                    </div>
                </div>
                <div class="row no-experience">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="exp_start_date" class="seeker_label my-2">Start Date <span class="text-danger">*</span></label>
                        <div class="datepicker date input-group exp-date">
                            <input type="text" name="exp_start_date" id="exp_start_date" class="form-control seeker_input" value="" placeholder="Start Date">
                            <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <span class="text-danger exp_start_date-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6 d-none" id="end_date_field">
                        <label for="exp_end_date" class="seeker_label my-2">End Date <span class="text-danger">*</span></label>
                        <div class="datepicker date input-group exp-date">
                            <input type="text" name="exp_end_date" id="exp_end_date" class="form-control seeker_input" value="" placeholder="End Date">
                            <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <span class="text-danger exp_end_date-error"></span>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                <span class="btn profile-save-btn text-light" id="save-exp">Save changes</span>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="experienceEditModal" tabindex="-1" aria-labelledby="experienceEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="experienceEditModalLabel">Edit Career History Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_is_experience" class="seeker_label my-2">Experience <span class="text-danger">*</span> </label><br>
                        <select name="edit_is_experience" id="edit_is_experience" class="seeker_input" style="width: 100%">
                            <option value="1">Experience</option>
                            <option value="0">No Experience</option>
                        </select>
                    </div>
                </div>
                <div class="row no-experience">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_exp_job_title" class="seeker_label my-2">Job Title <span class="text-danger">*</span></label>
                        <input type="text" name="edit_exp_job_title" id="edit_exp_job_title" class="form-control seeker_input" placeholder="Job Title" value="">
                        <span class="text-danger edit_exp_job_title-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_exp_company" class="seeker_label my-2">Employment Company/Organization <span class="text-danger">*</span></label>
                        <input type="text" name="edit_exp_company" id="edit_exp_company" class="form-control seeker_input" placeholder="Employment Company/Organization" value="">
                        <span class="text-danger edit_exp_company-error"></span>
                    </div>
                </div>
                <div class="row no-experience">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_exp_main_functional_area_id" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
                        <select name="edit_exp_main_functional_area_id" id="edit_exp_main_functional_area_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($functional_areas as $functional_area)
                            <option value="{{ $functional_area->id }}">{{ $functional_area->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger edit_exp_main_functional_area_id-error"></span>
                    </div>
                
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_exp_sub_functional_area_id" class="seeker_label my-2">Sub Functional Area <span class="text-danger">*</span></label>
                        <select name="edit_exp_sub_functional_area_id" id="edit_exp_sub_functional_area_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($sub_functional_areas as $sub_functional_area)
                            <option value="{{ $sub_functional_area->id }}">{{ $sub_functional_area->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger edit_exp_sub_functional_area_id-error"></span>
                    </div>
                </div>
                <div class="row no-experience">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_exp_career_level" class="seeker_label my-2">Career Level <span class="text-danger">*</span></label>
                        <select name="edit_exp_career_level" id="edit_exp_career_level" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach(config('careerlevel') as $careerlevel)
                            <option value="{{ $careerlevel }}">{{ $careerlevel }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger edit_exp_career_level-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_exp_industry_id" class="seeker_label my-2">Industry <span class="text-danger">*</span></label>
                        <select name="edit_exp_industry_id" id="edit_exp_industry_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($industries as $industry)
                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger edit_exp_industry_id-error"></span>
                    </div>
                </div>
                <div class="row no-experience">
                    
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_exp_country" class="seeker_label my-2">Country <span class="text-danger">*</span></label><br>
                        <select name="edit_exp_country" id="edit_exp_country" class="seeker_input" style="width: 100%">
                            <option value="Myanmar" >Myanmar</option>
                            <option value="Other" >Other</option>
                        </select>
                        <span class="text-danger edit_exp_country-error"></span>
                    </div>
                    <div class="col-12 col-md-6"></div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_exp_job_responsibility" class="seeker_label my-2">Job Responsibility <span class="text-danger">*</span></label><br>
                        <textarea name="edit_exp_job_responsibility" id="edit_exp_job_responsibility" cols="30" rows="5" class="seeker_input" style="width: 100%"></textarea>
                        <span class="text-danger edit_exp_job_responsibility-error"></span>
                    </div>
                    <div class="col-12 col-md-6"></div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <input type="checkbox" name="edit_current_job" id="edit_current_job" checked="1">
                        <label for="edit_current_job" class="seeker_label my-2">Present </label>
                    </div>
                </div>
                <div class="row no-experience">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_exp_start_date" class="seeker_label my-2">Start Date <span class="text-danger">*</span></label>
                        <div class="datepicker date input-group exp-date">
                            <input type="text" name="edit_exp_start_date" id="edit_exp_start_date" class="form-control seeker_input" value="" placeholder="Start Date">
                            <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <span class="text-danger edit_exp_start_date-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6 d-none" id="edit_end_date_field">
                        <label for="edit_exp_end_date" class="seeker_label my-2">End Date <span class="text-danger">*</span></label>
                        <div class="datepicker date input-group exp-date">
                            <input type="text" name="edit_exp_end_date" id="edit_exp_end_date" class="form-control seeker_input" value="" placeholder="End Date">
                            <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <span class="text-danger edit_exp_end_date-error"></span>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                <span class="btn profile-save-btn text-light" id="update-exp">Update changes</span>
            </div>
            
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> 
<script>
    $(document).ready(function() {
        $('.exp-date').datepicker({
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months",
            autoclose: true
        });
        $('#is_experience').change(function() {
            if($(this).val() == 0) {
                $(".no-experience").addClass('d-none');
            }else {
                $(".no-experience").removeClass('d-none');
            }
        })
        
        $("#current_job").change(function() {
            if($(this).is(":checked")){
                $("#end_date_field").addClass('d-none');
                $("#exp_end_date").val('')
            }else{
                $("#end_date_field").removeClass('d-none');
            }
        })

        $('#edit_is_experience').change(function() {
            if($(this).val() == 0) {
                $(".no-experience").addClass('d-none');
            }else {
                $("#edit_exp_start_date").val('');
                $(".no-experience").removeClass('d-none');
            }
        })
        
        $("#edit_current_job").change(function() {
            if($(this).is(":checked")){
                $("#edit_end_date_field").addClass('d-none');
                $("#edit_exp_end_date").val('');
            }else{
                $("#edit_end_date_field").removeClass('d-none');
                $("#edit_exp_end_date").val('');
            }
        })
    })
    $('#exp_main_functional_area_id').change(function(e){
        e.preventDefault();
        if($(this).val() != "") {
            var exp_main_functional_area_id = $(this).val();
            $.ajax({
                type: 'GET',
                url: 'get-sub-functional-area/'+exp_main_functional_area_id,
            }).done(function(response){
                if(response.status == 'success') {
                    $("#exp_sub_functional_area_id").empty();
                    $("#exp_sub_functional_area_id").append('<option value="">Choose...</option>')
                    $.each(response.data, function(index, sub_functional_area) {
                    
                    $("#exp_sub_functional_area_id").append('<option value=' + sub_functional_area.id + '>' + sub_functional_area.name +'</option>');
                    })
                }
            })
        }else {
            $("#exp_sub_functional_area_id").empty();
        }
    });

    $('#edit_exp_main_functional_area_id').change(function(e){
        e.preventDefault();
        if($(this).val() != "") {
            var exp_main_functional_area_id = $(this).val();
            $.ajax({
                type: 'GET',
                url: 'get-sub-functional-area/'+exp_main_functional_area_id,
            }).done(function(response){
                if(response.status == 'success') {
                    $("#edit_exp_sub_functional_area_id").empty();
                    $("#edit_exp_sub_functional_area_id").append('<option value="">Choose...</option>')
                    $.each(response.data, function(index, sub_functional_area) {
                    
                    $("#edit_exp_sub_functional_area_id").append('<option value=' + sub_functional_area.id + '>' + sub_functional_area.name +'</option>');
                    })
                }
            })
        }else {
            $("#edit_exp_sub_functional_area_id").empty();
        }
    });

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var seeker_id = {{ Auth::guard("seeker")->user()->id }};

    $('#save-exp').click(function() {
        if($("#is_experience").val() == 0) {
            $('.btn-close').click();
            $.ajax({
                type: 'POST',
                data: {
                    'seeker_id' : seeker_id,
                    'is_experience' : $("#is_experience").val(),
                    'is_current_job' : 0
                },
                url: '{{ route("experience.store") }}',
            }).done(function(response){
                if(response.status == 'success') {
                    $("#exp-table").removeClass('d-none');
                    $(".experience_label").removeClass('d-none');

                    $("#exp-tbody").html('');
                    $(".experience_label").html('');

                    $("#exp-table").append('<tr class="exp-tr-'+response.experience.id+'"><td colspan="10" class="text-center">No Experience</td><td><a onclick="editExp('+response.experience.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a><a id="deleteExp-'+response.experience.id+'" class="deleteExp btn border-0 text-danger" value="'+response.experience.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');

                    $(".experience_label").append('<h5 class="text-white resume-header py-2">Career History</h5><div class="row py-2 exp-resume-'+response.experience.id+'"><p>No Experience</p></div>');

                    $("#add_career_history").addClass('d-none');
                    MSalert.principal({
                        icon:'success',
                        title:'',
                        description:response.msg,
                    });
                    $("#is_experience").val(1);
                    $("#exp_job_title").val('');
                    $("#exp_company").val('');
                    $("#exp_main_functional_area_id").val('');
                    $("#exp_sub_functional_area_id").val('');
                    $("#exp_career_level").val('');
                    $("#exp_industry_id").val('');
                    $("#exp_start_date").val('');
                    $("#exp_end_date").val('');
                    $("#exp_country").val('Myanmar');
                    $("#exp_job_responsibility").val('');
                }
            })
        }else {
            $(".no-experience").removeClass('d-none');
            var exp_job_title = $("#exp_job_title").val();
            var exp_company = $("#exp_company").val();
            var exp_main_functional_area_id = $("#exp_main_functional_area_id").val();
            var exp_sub_functional_area_id = $("#exp_sub_functional_area_id").val();
            var exp_career_level = $("#exp_career_level").val();
            var exp_industry_id = $("#exp_industry_id").val();
            var exp_start_date = $("#exp_start_date").val();
            var exp_end_date = $("#exp_end_date").val();
            var exp_country = $("#exp_country").val();
            var exp_job_responsibility = $("#exp_job_responsibility").val();

            if(exp_job_title == '') {
                $(".exp_job_title-error").html("Job Title need to fill.")
            }else{
                $(".exp_job_title-error").html("")
            }
            if(exp_company == '') {
                $(".exp_company-error").html("Employment Company/Organization need to fill.")
            }else{
                $(".exp_company-error").html("")
            }
            if(exp_main_functional_area_id == '') {
                $(".exp_main_functional_area_id-error").html("Main Functional Area need to choose.")
            }else{
                $(".exp_main_functional_area_id-error").html("")
            }
            if(exp_sub_functional_area_id == '') {
                $(".exp_sub_functional_area_id-error").html("Sub Functional Area need to choose.")
            }else{
                $(".exp_sub_functional_area_id-error").html("")
            }
            if(exp_career_level == '') {
                $(".exp_career_level-error").html("Career Level need to fill.")
            }else{
                $(".exp_career_level-error").html("")
            }
            if(exp_job_responsibility == '') {
                $(".exp_job_responsibility-error").html("Job Responsibility need to fill.")
            }else{
                $(".exp_job_responsibility-error").html("")
            }
            if(exp_industry_id == '') {
                $(".exp_industry_id-error").html("Industry need to fill.")
            }else{
                $(".exp_industry_id-error").html("")
            }
            
            if(exp_start_date == '') {
                $(".exp_start_date-error").html("Start Date need to choose.")
            }else{
                $(".exp_start_date-error").html("")
            }
            if($("#current_job").is(":checked")){
                if(exp_job_title != '' && exp_company != '' && exp_main_functional_area_id != '' && exp_sub_functional_area_id != '' && exp_career_level != '' && exp_industry_id != '' && exp_start_date != '' && exp_job_responsibility != '')
                {
                    $('.btn-close').click();
                    $.ajax({
                        type: 'POST',
                        data: {
                            'exp_job_title' : exp_job_title,
                            'exp_company' : exp_company,
                            'exp_main_functional_area_id' : exp_main_functional_area_id,
                            'exp_sub_functional_area_id' : exp_sub_functional_area_id,
                            'exp_career_level' : exp_career_level,
                            'exp_industry_id' : exp_industry_id,
                            'exp_start_date' : exp_start_date,
                            'exp_end_date' : '',
                            'seeker_id' : seeker_id,
                            'is_experience' : $("#is_experience").val(),
                            'is_current_job' : 1,
                            'exp_country' : exp_country,
                            'exp_job_responsibility' : exp_job_responsibility
                        },
                        url: '{{ route("experience.store") }}',
                    }).done(function(response){
                        if(response.status == 'success') {
                            $("#exp-table").removeClass('d-none');
                            $(".experience_label").removeClass('d-none');
                            var exp_main_function = '';
                            var exp_sub_function_name = '';
                            var exp_industry_name = '';
                            $(response.exp_functions).each(function(index, exp_function) {
                                if(exp_function.id == response.experience.main_functional_area_id) {
                                    exp_main_function = exp_function.name
                                }
                            })
                            $(response.sub_exp_functions).each(function(index, exp_sub_function) {
                                if(exp_sub_function.id == response.experience.sub_functional_area_id) {
                                    exp_sub_function_name = exp_sub_function.name
                                }
                            })
                            $(response.exp_industries).each(function(index, exp_industry) {
                                if(exp_industry.id == response.experience.industry_id) {
                                    exp_industry_name = exp_industry.name
                                }
                            })

                            $("#exp-table").append('<tr class="exp-tr-'+response.experience.id+'"><td class="exp-job_title-'+response.experience.id+'">'+response.experience.job_title+'</td><td class="exp-company-'+response.experience.id+'">'+response.experience.company+'</td><td class="exp-main_functional_area_id-'+response.experience.id+'">'+exp_main_function+'</td><td class="exp-sub_functional_area_id-'+response.experience.id+'">'+exp_sub_function_name+'</td><td class="exp-career_lavel-'+response.experience.id+'">'+response.experience.career_level+'</td><td class="exp-industry_id-'+response.experience.id+'">'+exp_industry_name+'</td><td class="exp-country-'+response.experience.id+'">'+response.experience.country+'</td><td class="exp-job_responsibility-'+response.experience.id+'">'+response.experience.job_responsibility+'</td><td class="exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+'</td><td class="exp-end_date-'+response.experience.id+'">Present</td><td>    <a onclick="editExp('+response.experience.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>    <a id="deleteExp-'+response.experience.id+'" class="deleteExp btn border-0 text-danger" value="'+response.experience.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');

                            $(".experience_label").append('<div class="row py-2 exp-resume-'+response.experience.id+'"><div class="col-4 fw-bold"><span class="exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+'</span> - <span class="exp-end_date-'+response.experience.id+'">Present</span></div><div class="col-8"><span class="exp-job_title-'+response.experience.id+' fw-bold">'+response.experience.job_title+'</span><br><span class="exp-company-'+response.experience.id+' text-blue">'+response.experience.company+'</span><br><span class="exp-job-responsibility-'+response.experience.id+'">'+response.experience.job_responsibility+'</span></div></div>');

                            MSalert.principal({
                                icon:'success',
                                title:'',
                                description:response.msg,
                            });
                            $("#is_experience").val(1);
                            $("#exp_job_title").val('');
                            $("#exp_company").val('');
                            $("#exp_main_functional_area_id").val('');
                            $("#exp_sub_functional_area_id").val('');
                            $("#exp_career_level").val('');
                            $("#exp_industry_id").val('');
                            $("#exp_start_date").val('');
                            $("#exp_end_date").val('');
                            $("#exp_country").val('Myanmar');
                            $("#exp_job_responsibility").val('');
                        }
                    })
                }
            }else{
                if(exp_end_date == '') {
                    $(".exp_end_date-error").html("End Date need to choose.")
                }else{
                    $(".exp_end_date-error").html("")
                }
                if(exp_start_date != '' && exp_end_date != '' && exp_start_date > exp_end_date) {
                    $(".exp_end_date-error").html('End Date must be greater than Start Date.');
                }
                if(exp_job_title != '' && exp_company != '' && exp_main_functional_area_id != '' && exp_sub_functional_area_id != '' && exp_career_level != '' && exp_industry_id != '' && exp_start_date != '' && exp_end_date != '' && exp_job_responsibility != '')
                {
                    $('.btn-close').click();
                    $.ajax({
                        type: 'POST',
                        data: {
                            'exp_job_title' : exp_job_title,
                            'exp_company' : exp_company,
                            'exp_main_functional_area_id' : exp_main_functional_area_id,
                            'exp_sub_functional_area_id' : exp_sub_functional_area_id,
                            'exp_career_level' : exp_career_level,
                            'exp_industry_id' : exp_industry_id,
                            'exp_start_date' : exp_start_date,
                            'exp_end_date' : exp_end_date,
                            'seeker_id' : seeker_id,
                            'is_experience' : $("#is_experience").val(),
                            'is_current_job' : 0,
                            'exp_country' : exp_country,
                            'exp_job_responsibility' : exp_job_responsibility
                        },
                        url: '{{ route("experience.store") }}',
                    }).done(function(response){
                        if(response.status == 'success') {
                            $("#exp-table").removeClass('d-none');
                            var exp_main_function = '';
                            var exp_sub_function_name = '';
                            var exp_industry_name = '';
                            $(response.exp_functions).each(function(index, exp_function) {
                                if(exp_function.id == response.experience.main_functional_area_id) {
                                    exp_main_function = exp_function.name
                                }
                            })
                            $(response.sub_exp_functions).each(function(index, exp_sub_function) {
                                if(exp_sub_function.id == response.experience.sub_functional_area_id) {
                                    exp_sub_function_name = exp_sub_function.name
                                }
                            })
                            $(response.exp_industries).each(function(index, exp_industry) {
                                if(exp_industry.id == response.experience.industry_id) {
                                    exp_industry_name = exp_industry.name
                                }
                            })
                            $("#exp-table").append('<tr class="exp-tr-'+response.experience.id+'"><td class="exp-job_title-'+response.experience.id+'">'+response.experience.job_title+'</td><td class="exp-company-'+response.experience.id+'">'+response.experience.company+'</td><td class="exp-main_functional_area_id-'+response.experience.id+'">'+exp_main_function+'</td><td class="exp-sub_functional_area_id-'+response.experience.id+'">'+exp_sub_function_name+'</td><td class="exp-career_lavel-'+response.experience.id+'">'+response.experience.career_level+'</td><td class="exp-industry_id-'+response.experience.id+'">'+exp_industry_name+'</td><td class="exp-country-'+response.experience.id+'">'+response.experience.country+'</td><td class="exp-job_responsibility-'+response.experience.id+'">'+response.experience.job_responsibility+'</td><td class="exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+'</td><td class="exp-end_date-'+response.experience.id+'">'+moment(response.experience.end_date).format("MMM-YYYY")+'</td><td>    <a onclick="editExp('+response.experience.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>    <a id="deleteExp-'+response.experience.id+'" class="deleteExp btn border-0 text-danger" value="'+response.experience.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');

                            $(".experience_label").append('<div class="row py-2 exp-resume-'+response.experience.id+'"><div class="col-4 fw-bold"><span class="exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+'</span> - <span class="exp-end_date-'+response.experience.id+'">'+moment(response.experience.end_date).format("MMM-YYYY")+'</span></div><div class="col-8"><span class="exp-job_title-'+response.experience.id+' fw-bold">'+response.experience.job_title+'</span><br><span class="exp-company-'+response.experience.id+' text-blue">'+response.experience.company+'</span><br><span class="exp-job-responsibility-'+response.experience.id+'">'+response.experience.job_responsibility+'</span></div></div>');

                            MSalert.principal({
                                icon:'success',
                                title:'',
                                description:response.msg,
                            });
                            $("#is_experience").val(1);
                            $("#exp_job_title").val('');
                            $("#exp_company").val('');
                            $("#exp_main_functional_area_id").val('');
                            $("#exp_sub_functional_area_id").val('');
                            $("#exp_career_level").val('');
                            $("#exp_industry_id").val('');
                            $("#exp_start_date").val('');
                            $("#exp_end_date").val('');
                            $("#exp_country").val('Myanmar');
                            $("#exp_job_responsibility").val('');
                        }
                    })
                }
            }
        }
    })

    function editExp(id)
    {
        $("#experienceEditModal").modal('show');
        $.ajax({
            type: 'GET',
            url: 'experience/edit/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                $("#edit_is_experience").val(response.experience.is_experience);
                $("#edit_exp_job_title").val(response.experience.job_title);
                $("#edit_exp_company").val(response.experience.company);
                $("#edit_exp_main_functional_area_id").val(response.experience.main_functional_area_id);
                $("#edit_exp_sub_functional_area_id").val(response.experience.sub_functional_area_id);
                $("#edit_exp_career_level").val(response.experience.career_level);
                $("#edit_exp_industry_id").val(response.experience.industry_id);
                $("#edit_exp_country").val(response.experience.country);
                $("#edit_exp_job_responsibility").val(response.experience.job_responsibility);
                $("#edit_exp_start_date").val(moment(response.experience.start_date).format("MMM-YYYY"));
                $("#edit_exp_end_date").val(moment(response.experience.end_date).format("MMM-YYYY"));
                if(response.experience.is_current_job) {
                    $("#edit_current_job").prop('checked',true);
                }else {
                    $("#edit_current_job").prop('checked',false);
                    $("#edit_end_date_field").removeClass('d-none');
                }
                if(response.experience.is_experience == 0) {
                    $(".no-experience").addClass('d-none');
                }else {
                    $(".no-experience").removeClass('d-none');
                }
            }
        })

        $("#update-exp").one('click', function(e) {
            e.preventDefault();
            if($("#edit_is_experience").val() == 0) {
                $('.btn-close').click();
                $.ajax({
                    type: 'POST',
                    data: {
                        'seeker_id' : seeker_id,
                        'is_experience' : $("#edit_is_experience").val(),
                        'is_current_job' : 0
                    },
                    url: 'experience/update/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $("#exp-table").removeClass('d-none');
                        $("#exp-tbody").html('');
                        $("#exp-table").append('<tr data-id="'+response.experience.id+'"><td colspan="9" class="text-center">No Experience</td><td><a onclick="editExp('+response.experience.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i> </a> <a id="deleteExp-'+response.experience.id+'" class="deleteExp btn border-0 text-danger" value="'+response.experience.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                        $("#add_career_history").addClass('d-none');
                        MSalert.principal({
                            icon:'success',
                            title:'',
                            description:response.msg,
                        })
                    }
                })
            }else {
                $(".no-experience").removeClass('d-none');
                var edit_exp_job_title = $("#edit_exp_job_title").val();
                var edit_exp_company = $("#edit_exp_company").val();
                var edit_exp_main_functional_area_id = $("#edit_exp_main_functional_area_id").val();
                var edit_exp_sub_functional_area_id = $("#edit_exp_sub_functional_area_id").val();
                var edit_exp_career_level = $("#edit_exp_career_level").val();
                var edit_exp_industry_id = $("#edit_exp_industry_id").val();
                var edit_exp_start_date = $("#edit_exp_start_date").val();
                var edit_exp_end_date = $("#edit_exp_end_date").val();
                var edit_exp_country = $("#edit_exp_country").val();
                var edit_exp_job_responsibility = $("#edit_exp_job_responsibility").val();

                if(edit_exp_job_title == '') {
                    $(".edit_exp_job_title-error").html("Job Title need to fill.")
                }else{
                    $(".edit_exp_job_title-error").html("")
                }
                if(edit_exp_company == '') {
                    $(".edit_exp_company-error").html("Employment Company/Organization need to fill.")
                }else{
                    $(".edit_exp_company-error").html("")
                }
                if(edit_exp_main_functional_area_id == '') {
                    $(".edit_exp_main_functional_area_id-error").html("Main Functional Area need to choose.")
                }else{
                    $(".edit_exp_main_functional_area_id-error").html("")
                }
                if(edit_exp_sub_functional_area_id == '') {
                    $(".edit_exp_sub_functional_area_id-error").html("Sub Functional Area need to choose.")
                }else{
                    $(".edit_exp_sub_functional_area_id-error").html("")
                }
                if(edit_exp_career_level == '') {
                    $(".edit_exp_career_level-error").html("Career Level need to fill.")
                }else{
                    $(".edit_exp_career_level-error").html("")
                }
                if(edit_exp_job_responsibility == '') {
                    $(".edit_exp_job_responsibility-error").html("Job Responsibility need to fill.")
                }else{
                    $(".edit_exp_job_responsibility-error").html("")
                }
                if(edit_exp_industry_id == '') {
                    $(".edit_exp_industry_id-error").html("Industry need to fill.")
                }else{
                    $(".edit_exp_industry_id-error").html("")
                }
                
                if(edit_exp_start_date == '') {
                    $(".edit_exp_start_date-error").html("Start Date need to choose.")
                }else{
                    $(".edit_exp_start_date-error").html("")
                }
                if($("#edit_current_job").is(":checked")){
                    if(edit_exp_job_title != '' && edit_exp_company != '' && edit_exp_main_functional_area_id != '' && edit_exp_sub_functional_area_id != '' && edit_exp_career_level != '' && edit_exp_industry_id != '' && edit_exp_start_date != '' && edit_exp_job_responsibility != '')
                    {
                        $('.btn-close').click();
                        $.ajax({
                            type: 'POST',
                            data: {
                                'exp_job_title' : edit_exp_job_title,
                                'exp_company' : edit_exp_company,
                                'exp_main_functional_area_id' : edit_exp_main_functional_area_id,
                                'exp_sub_functional_area_id' : edit_exp_sub_functional_area_id,
                                'exp_career_level' : edit_exp_career_level,
                                'exp_industry_id' : edit_exp_industry_id,
                                'exp_start_date' : edit_exp_start_date,
                                'exp_end_date' : '',
                                'seeker_id' : seeker_id,
                                'is_experience' : $("#edit_is_experience").val(),
                                'is_current_job' : 1,
                                'exp_country' : edit_exp_country,
                                'exp_job_responsibility' : edit_exp_job_responsibility
                            },
                            url: 'experience/update/'+id,
                        }).done(function(response){
                            if(response.status == 'success') {
                                $(".exp-tr-"+id).html('');
                                var exp_main_function = '';
                                var exp_sub_function_name = '';
                                var exp_industry_name = '';
                                $(response.exp_functions).each(function(index, exp_function) {
                                    if(exp_function.id == response.experience.main_functional_area_id) {
                                        exp_main_function = exp_function.name
                                    }
                                })
                                $(response.sub_exp_functions).each(function(index, exp_sub_function) {
                                    if(exp_sub_function.id == response.experience.sub_functional_area_id) {
                                        exp_sub_function_name = exp_sub_function.name
                                    }
                                })
                                $(response.exp_industries).each(function(index, exp_industry) {
                                    if(exp_industry.id == response.experience.industry_id) {
                                        exp_industry_name = exp_industry.name
                                    }
                                })
                                $("#exp-table").append('<tr class="exp-tr-'+id+'"><td class="exp-job_title-'+id+'">'+response.experience.job_title+'</td><td class="exp-company-'+id+'">'+response.experience.company+'</td><td class="exp-main_functional_area_id-'+id+'">'+exp_main_function+'</td><td class="exp-sub_functional_area_id-'+id+'">'+exp_sub_function_name+'</td><td class="exp-career_lavel-'+id+'">'+response.experience.career_level+'</td><td class="exp-industry_id-'+id+'">'+exp_industry_name+'</td><td class="exp-country-'+id+'">'+response.experience.country+'</td><td class="exp-job_responsibility-'+id+'">'+response.experience.job_responsibility+'</td><td class="exp-start_date-'+id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+'</td><td class="exp-end_date-'+id+'">Present</td><td>    <a onclick="editExp('+id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>    <a id="deleteExp-'+id+'" class="deleteExp btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>')
                                $("#add_career_history").removeClass('d-none');
                                MSalert.principal({
                                    icon:'success',
                                    title:'',
                                    description:response.msg,
                                })
                            }
                        })
                    }
                }else{
                    if(edit_exp_end_date == '') {
                        $(".edit_exp_end_date-error").html("End Date need to choose.")
                    }else{
                        $(".edit_exp_end_date-error").html("")
                    }
                    if(edit_exp_start_date != '' && exp_end_date != '' && exp_start_date > exp_end_date) {
                        $(".edit_exp_end_date-error").html('End Date must be greater than Start Date.');
                    }
                    if(edit_exp_job_title != '' && edit_exp_company != '' && edit_exp_main_functional_area_id != '' && edit_exp_sub_functional_area_id != '' && edit_exp_career_level != '' && edit_exp_industry_id != '' && edit_exp_start_date != '' && edit_exp_end_date != '' && edit_exp_job_responsibility != '')
                    {
                        $('.btn-close').click();
                        $.ajax({
                            type: 'POST',
                            data: {
                                'exp_job_title' : edit_exp_job_title,
                                'exp_company' : edit_exp_company,
                                'exp_main_functional_area_id' : edit_exp_main_functional_area_id,
                                'exp_sub_functional_area_id' : edit_exp_sub_functional_area_id,
                                'exp_career_level' : edit_exp_career_level,
                                'exp_industry_id' : edit_exp_industry_id,
                                'exp_start_date' : edit_exp_start_date,
                                'exp_end_date' : edit_exp_end_date,
                                'seeker_id' : seeker_id,
                                'is_experience' : $("#edit_is_experience").val(),
                                'is_current_job' : 0,
                                'exp_country' : edit_exp_country,
                                'exp_job_responsibility' : edit_exp_job_responsibility
                            },
                            url: 'experience/update/'+id,
                        }).done(function(response){
                            if(response.status == 'success') {
                                $(".exp-tr-"+id).html('');
                                var exp_main_function = '';
                                var exp_sub_function_name = '';
                                var exp_industry_name = '';
                                $(response.exp_functions).each(function(index, exp_function) {
                                    if(exp_function.id == response.experience.main_functional_area_id) {
                                        exp_main_function = exp_function.name
                                    }
                                })
                                $(response.sub_exp_functions).each(function(index, exp_sub_function) {
                                    if(exp_sub_function.id == response.experience.sub_functional_area_id) {
                                        exp_sub_function_name = exp_sub_function.name
                                    }
                                })
                                $(response.exp_industries).each(function(index, exp_industry) {
                                    if(exp_industry.id == response.experience.industry_id) {
                                        exp_industry_name = exp_industry.name
                                    }
                                })
                                $("#exp-table").append('<tr class="exp-tr-'+response.experience.id+'"><td class="exp-job_title-'+response.experience.id+'">'+response.experience.job_title+'</td><td class="exp-company-'+response.experience.id+'">'+response.experience.company+'</td><td class="exp-main_functional_area_id-'+response.experience.id+'">'+exp_main_function+'</td><td class="exp-sub_functional_area_id-'+response.experience.id+'">'+exp_sub_function_name+'</td><td class="exp-career_lavel-'+response.experience.id+'">'+response.experience.career_level+'</td><td class="exp-industry_id-'+response.experience.id+'">'+exp_industry_name+'</td><td class="exp-country-'+response.experience.id+'">'+response.experience.country+'</td><td class="exp-job_responsibility-'+response.experience.id+'">'+response.experience.job_responsibility+'</td><td class="exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+'</td><td class="exp-end_date-'+response.experience.id+'">'+moment(response.experience.end_date).format("MMM-YYYY")+'</td><td>    <a onclick="editExp('+response.experience.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>    <a id="deleteExp-'+response.experience.id+'" class="deleteExp btn border-0 text-danger" value="'+response.experience.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>')
                                MSalert.principal({
                                    icon:'success',
                                    title:'',
                                    description:response.msg,
                                })
                                $("#add_career_history").removeClass('d-none');
                            }
                        })
                    }
                }
            }
        })
    }

    $(document).on('click', '.deleteExp', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    data: {
                        "seeker_id": seeker_id
                    },
                    url: 'experience/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".exp-tr-"+id).empty();
                        $(".exp-resume-"+id).empty();
                        $("#add_career_history").removeClass('d-none');
                        if(response.seeker_experiences_count == 0) {
                            $("#exp-table").addClass('d-none');
                            $(".experience_label").addClass('d-none');
                        }
                        MSalert.principal({
                            icon:'success',
                            title:'',
                            description:response.msg,
                        })
                    }
                })
            }            
        })
    });
</script>
@endpush