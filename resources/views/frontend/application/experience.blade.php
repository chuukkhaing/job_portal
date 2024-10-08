<div class="my-2 row">
    <button type="button" class="btn btn-sm profile-save-btn m-2 col-6 d-none" data-bs-toggle="modal" data-bs-target="#experienceModal" id="add_career_history">
        <i class="fa-solid fa-plus"></i> Add Career History
    </button>
    <div class="form-group col-12 col-md-6 my-0 experience_status">
        <label for="is_experience" class="seeker_label">Do you have experience?</label><br>
        <input type="radio" name="is_experience" id="yes" class="seeker_input ps-2"> <label for="yes" class="seeker_label pe-4"> Yes</label>
        <input type="radio" name="is_experience" id="no" class="seeker_input ps-2"> <label for="no" class="seeker_label"> No</label>
    </div>
</div>
<div class="my-2 row">
    <div id="exp-table" class="d-none">
        
    </div>
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
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="exp_job_title" class="seeker_label my-2">Job Title <span class="text-danger">*</span></label>
                        <input type="text" name="exp_job_title" id="exp_job_title" class="form-control seeker_input" placeholder="Job Title" value="">
                        <span class="text-danger exp_job_title-error"></span>
                    </div>
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="exp_company" class="seeker_label my-2">Employment Company/Organization <span class="text-danger">*</span></label>
                        <input type="text" name="exp_company" id="exp_company" class="form-control seeker_input" placeholder="Employment Company/Organization" value="">
                        <span class="text-danger exp_company-error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="exp_main_functional_area_id" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
                        <select name="exp_main_functional_area_id" id="exp_main_functional_area_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($functional_areas as $functional_area)
                            <option value="{{ $functional_area->id }}">{{ $functional_area->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger exp_main_functional_area_id-error"></span>
                    </div>
                
                    <div class="form-group col-12 col-md-6 my-0">
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
                <div class="row">
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="exp_career_level" class="seeker_label my-2">Career Level <span class="text-danger">*</span></label>
                        <select name="exp_career_level" id="exp_career_level" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach(config('careerlevel') as $careerlevel)
                            <option value="{{ $careerlevel }}">{{ $careerlevel }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger exp_career_level-error"></span>
                    </div>
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="exp_industry_id" class="seeker_label my-2">{{ __('message.Industry') }} <span class="text-danger">*</span></label>
                        <select name="exp_industry_id" id="exp_industry_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($industries as $industry)
                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger exp_industry_id-error"></span>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="exp_country" class="seeker_label my-2">Country <span class="text-danger">*</span></label><br>
                        <select name="exp_country" id="exp_country" class="seeker_input" style="width: 100%">
                            <option value="Myanmar" selected>Myanmar</option>
                            <option value="Other" >Other</option>
                        </select>
                        <span class="text-danger exp_country-error"></span>
                    </div>
                    <div class="col-12 col-md-6 my-0"></div>
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="exp_job_responsibility" class="seeker_label my-2">Job Responsibility <span class="text-danger">*</span></label><br>
                        <textarea name="exp_job_responsibility" id="exp_job_responsibility" cols="30" rows="5" class="seeker_input edit_summernote_exp" style="width: 100%"></textarea>
                        <span class="text-danger exp_job_responsibility-error"></span>
                    </div>
                    <div class="col-12 col-md-6 my-0"></div>
                    <div class="form-group col-12 col-md-6 my-0">
                        <input type="checkbox" name="current_job" id="current_job" checked="1">
                        <label for="current_job" class="seeker_label my-2">Present </label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="exp_start_date" class="seeker_label my-2">Start Date <span class="text-danger">*</span></label>
                        <div class="datepicker date input-group exp-date">
                            <input type="text" name="exp_start_date" id="exp_start_date" class="form-control seeker_input" value="" placeholder="Start Date">
                            <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <span class="text-danger exp_start_date-error"></span>
                    </div>
                    <div class="form-group col-12 col-md-6 my-0 d-none" id="end_date_field">
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
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="edit_exp_job_title" class="seeker_label my-2">Job Title <span class="text-danger">*</span></label>
                        <input type="text" name="edit_exp_job_title" id="edit_exp_job_title" class="form-control seeker_input" placeholder="Job Title" value="">
                        <span class="text-danger edit_exp_job_title-error"></span>
                    </div>
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="edit_exp_company" class="seeker_label my-2">Employment Company/Organization <span class="text-danger">*</span></label>
                        <input type="text" name="edit_exp_company" id="edit_exp_company" class="form-control seeker_input" placeholder="Employment Company/Organization" value="">
                        <span class="text-danger edit_exp_company-error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="edit_exp_main_functional_area_id" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
                        <select name="edit_exp_main_functional_area_id" id="edit_exp_main_functional_area_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($functional_areas as $functional_area)
                            <option value="{{ $functional_area->id }}">{{ $functional_area->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger edit_exp_main_functional_area_id-error"></span>
                    </div>
                
                    <div class="form-group col-12 col-md-6 my-0">
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
                <div class="row">
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="edit_exp_career_level" class="seeker_label my-2">Career Level <span class="text-danger">*</span></label>
                        <select name="edit_exp_career_level" id="edit_exp_career_level" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach(config('careerlevel') as $careerlevel)
                            <option value="{{ $careerlevel }}">{{ $careerlevel }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger edit_exp_career_level-error"></span>
                    </div>
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="edit_exp_industry_id" class="seeker_label my-2">{{ __('message.Industry') }} <span class="text-danger">*</span></label>
                        <select name="edit_exp_industry_id" id="edit_exp_industry_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($industries as $industry)
                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger edit_exp_industry_id-error"></span>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="edit_exp_country" class="seeker_label my-2">Country <span class="text-danger">*</span></label><br>
                        <select name="edit_exp_country" id="edit_exp_country" class="seeker_input" style="width: 100%">
                            <option value="Myanmar" >Myanmar</option>
                            <option value="Other" >Other</option>
                        </select>
                        <span class="text-danger edit_exp_country-error"></span>
                    </div>
                    <div class="col-12 col-md-6 my-0"></div>
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="edit_exp_job_responsibility" class="seeker_label my-2">Job Responsibility <span class="text-danger">*</span></label><br>
                        <textarea name="edit_exp_job_responsibility" id="edit_exp_job_responsibility" cols="30" rows="5" class="seeker_input summernote_exp" style="width: 100%"></textarea>
                        <span class="text-danger edit_exp_job_responsibility-error"></span>
                    </div>
                    <div class="col-12 col-md-6 my-0"></div>
                    <div class="form-group col-12 col-md-6 my-0">
                        <input type="checkbox" name="edit_current_job" id="edit_current_job" checked="1">
                        <label for="edit_current_job" class="seeker_label my-2">Present </label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12 col-md-6 my-0">
                        <label for="edit_exp_start_date" class="seeker_label my-2">Start Date <span class="text-danger">*</span></label>
                        <div class="datepicker date input-group exp-date">
                            <input type="text" name="edit_exp_start_date" id="edit_exp_start_date" class="form-control seeker_input" value="" placeholder="Start Date">
                            <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <span class="text-danger edit_exp_start_date-error"></span>
                    </div>
                    <div class="form-group col-12 col-md-6 my-0 d-none" id="edit_end_date_field">
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
        $('.summernote_exp').summernote({
            toolbar: [
                ['font', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']]
            ],
            callbacks: {
                
                onPaste: function (e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('text/html');
                    e.preventDefault();
                    var div = $('<div />');
                    div.append(bufferText);
                    div.find('*').removeAttr('style');
                    setTimeout(function () {
                        document.execCommand('insertHtml', false, div.html());
                    }, 10);
                }
            }
        });

        $('.edit_summernote_exp').summernote({
            toolbar: [
                ['font', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']]
            ],
            callbacks: {
                
                onPaste: function (e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('text/html');
                    e.preventDefault();
                    var div = $('<div />');
                    div.append(bufferText);
                    div.find('*').removeAttr('style');
                    setTimeout(function () {
                        document.execCommand('insertHtml', false, div.html());
                    }, 10);
                }
            }
        });

        $('.exp-date').datepicker({
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months",
            autoclose: true
        });

        $('input[name="is_experience"]').change(function() {
            
            if($("#yes").is(":checked")){ 
                $(this).val(1);
                $(".experience_status").addClass('d-none');
                $("#add_career_history").removeClass('d-none');
            }else {
                $(this).val(0);
                $.ajax({
                    type: 'POST',
                    data: {
                        'seeker_id' : seeker_id,
                        'is_experience' : 0,
                        'is_current_job' : 0
                    },
                    url: '{{ route("experience.store") }}',
                }).done(function(response){
                    if(response.status == 'success') {
                        $("#exp-table").removeClass('d-none');
                        $(".experience_label").removeClass('d-none')
                        $(".exp-job_title-").removeClass('d-none');

                        $("#exp-table").html('');
                        $(".experience_label").html('');

                        $("#exp-table").append('<div class="row exp-tr-'+response.experience.id+'"><span class="fw-bold col text-center">No Experience</span><span class="col"><a id="deleteExp-'+response.experience.id+'" class="deleteExp border-0 text-danger" value="'+response.experience.id+'"><i class="fa-solid fa-trash-can"></i></a></span></div>');

                        $(".experience_label").append('<h5 class="resume-header">Experience</h5><div class="row py-2 exp-resume-'+response.experience.id+' job-responsibility"><p>No Experience</p></div>');

                        $("#add_career_history").addClass('d-none');
                        MSalert.principal({
                            icon:'success',
                            title:'Success',
                            description:response.msg,
                        });
                        $("#is_experience").val();
                        $(".experience_status").addClass('d-none');
                    }
                })
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
                url: '/seeker/get-sub-functional-area/'+exp_main_functional_area_id,
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
                url: '/seeker/get-sub-functional-area/'+exp_main_functional_area_id,
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
    
    
    $('#save-exp').click(function() {
        var seeker_id =$("#seeker_id").val();
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
                $("#experienceModal").modal('toggle');
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
                        'is_experience' : 1,
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

                        $("#exp-table").append('<div class="row exp-tr-'+response.experience.id+'"><div class="col"><span class="fw-bold exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+' -</span><span class="fw-bold exp-end_date-'+response.experience.id+'">Present</span><div class="exp-job_title-'+response.experience.id+'">'+response.experience.job_title+'</div><div class="exp-company-'+response.experience.id+'">'+response.experience.company+'</div><div class="exp-career_lavel-'+response.experience.id+'">'+response.experience.career_level+'</div></div><div class="col"><a onclick="editExp('+response.experience.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a><a id="deleteExp-'+response.experience.id+'" class="deleteExp border-0 text-danger" value="'+response.experience.id+'"><i class="fa-solid fa-trash-can"></i></a></div></div>');

                        $(".experience_label").append('<div class="row py-2 exp-resume-'+response.experience.id+'"><div class="col-4 exp-date-range"><span class="exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+'</span> - <span class="exp-end_date-'+response.experience.id+'">Present</span></div><div class="col-8" style="border-left: 2px solid #0563C1;"><span class="exp-job_title-'+response.experience.id+' exp-job-title text-break text-uppercase">'+response.experience.job_title+'</span> | <span class="exp-company-'+response.experience.id+' text-uppercase text-break exp-company">'+response.experience.company+'</span><br><span class="exp-job-responsibility-'+response.experience.id+' job-responsibility">'+response.experience.job_responsibility+'</span></div></div>');

                        MSalert.principal({
                            icon:'success',
                            title:'Success',
                            description:response.msg,
                        });
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
                        $('.summernote_exp').summernote('code','');
                    }
                })
            }
        }else{
            if(exp_end_date == '') {
                $(".exp_end_date-error").html("End Date need to choose.")
            }else{
                $(".exp_end_date-error").html("")
            }
            if(exp_start_date != '' && exp_end_date != '' && exp_start_date < exp_end_date) {
                $(".exp_end_date-error").html('End Date must be greater than Start Date.');
            }
            if(exp_job_title != '' && exp_company != '' && exp_main_functional_area_id != '' && exp_sub_functional_area_id != '' && exp_career_level != '' && exp_industry_id != '' && exp_start_date != '' && exp_end_date != '' && exp_job_responsibility != '' && exp_end_date > exp_start_date)
            {
                $("#experienceModal").modal('toggle');
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
                        'is_experience' : 1,
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
                        $("#exp-table").append('<div class="row exp-tr-'+response.experience.id+'"><div class="col"><span class="fw-bold exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+' -</span><span class="fw-bold exp-end_date-'+response.experience.id+'">'+moment(response.experience.end_date).format("MMM-YYYY")+'</span><div class="exp-job_title-'+response.experience.id+'">'+response.experience.job_title+'</div><div class="exp-company-'+response.experience.id+'">'+response.experience.company+'</div><div class="exp-career_lavel-'+response.experience.id+'">'+response.experience.career_level+'</div></div><div class="col"><a onclick="editExp('+response.experience.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a><a id="deleteExp-'+response.experience.id+'" class="deleteExp border-0 text-danger" value="'+response.experience.id+'"><i class="fa-solid fa-trash-can"></i></a></div></div>');

                        $(".experience_label").append('<div class="row py-2 exp-resume-'+response.experience.id+'"><div class="col-4 exp-date-range"><span class="exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+'</span> - <span class="exp-end_date-'+response.experience.id+'">'+moment(response.experience.end_date).format("MMM-YYYY")+'</span></div><div class="col-8" style="border-left: 2px solid #0563C1;"><span class="exp-job_title-'+response.experience.id+' exp-job-title text-break text-uppercase">'+response.experience.job_title+'</span> | <span class="exp-company-'+response.experience.id+' text-uppercase text-break exp-company">'+response.experience.company+'</span><br><span class="exp-job-responsibility-'+response.experience.id+' job-responsibility">'+response.experience.job_responsibility+'</span></div></div>');

                        MSalert.principal({
                            icon:'success',
                            title:'Success',
                            description:response.msg,
                        });
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
                        $('.summernote_exp').summernote('code','');
                        $(".exp_end_date-error").html('');
                        $(".exp_start_date-error").html('');
                    }
                })
            }
        }
    })

    function editExp(id)
    {
        $("#experienceEditModal").modal('show');
        $.ajax({
            type: 'GET',
            url: '/seeker/experience/edit/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                $("#edit_exp_job_title").val(response.experience.job_title);
                $("#edit_exp_company").val(response.experience.company);
                $("#edit_exp_main_functional_area_id").val(response.experience.main_functional_area_id);
                $("#edit_exp_sub_functional_area_id").val(response.experience.sub_functional_area_id);
                $("#edit_exp_career_level").val(response.experience.career_level);
                $("#edit_exp_industry_id").val(response.experience.industry_id);
                $("#edit_exp_country").val(response.experience.country);
                $("#edit_exp_job_responsibility").val(response.experience.job_responsibility);
                $('#edit_exp_job_responsibility').summernote('code',response.experience.job_responsibility);
                $("#edit_exp_start_date").val(moment(response.experience.start_date).format("YYYY-MM"));
                $("#edit_exp_end_date").val(moment(response.experience.end_date).format("YYYY-MM"));
                if(response.experience.is_current_job) {
                    $("#edit_current_job").prop('checked',true);
                }else {
                    $("#edit_current_job").prop('checked',false);
                    $("#edit_end_date_field").removeClass('d-none');
                }
            }
        })

        $("#update-exp").one('click', function(e) {
            
            e.preventDefault();
            var seeker_id =$("#seeker_id").val();
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
                    $("#experienceEditModal").modal('toggle');
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
                            'is_experience' : 1,
                            'is_current_job' : 1,
                            'exp_country' : edit_exp_country,
                            'exp_job_responsibility' : edit_exp_job_responsibility
                        },
                        url: '/seeker/experience/update/'+id,
                    }).done(function(response){
                        if(response.status == 'success') {
                            $(".exp-tr-"+id).html('');
                            $(".exp-resume-"+id).hide('');
                            
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
                            $("#exp-table").append('<div class="row exp-tr-'+response.experience.id+'"><div class="col"><span class="fw-bold exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+' -</span><span class="fw-bold exp-end_date-'+response.experience.id+'">Present</span><div class="exp-job_title-'+response.experience.id+'">'+response.experience.job_title+'</div><div class="exp-company-'+response.experience.id+'">'+response.experience.company+'</div><div class="exp-career_lavel-'+response.experience.id+'">'+response.experience.career_level+'</div></div><div class="col"><a onclick="editExp('+response.experience.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a><a id="deleteExp-'+response.experience.id+'" class="deleteExp border-0 text-danger" value="'+response.experience.id+'"><i class="fa-solid fa-trash-can"></i></a></div></div>')
                            $("#add_career_history").removeClass('d-none');

                            $(".experience_label").append('<div class="row py-2 exp-resume-'+response.experience.id+'"><div class="col-4 exp-date-range"><span class="exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+'</span> - <span class="exp-end_date-'+response.experience.id+'">Present</span></div><div class="col-8" style="border-left: 2px solid #0563C1;"><span class="exp-job_title-'+response.experience.id+' exp-job-title text-break text-uppercase">'+response.experience.job_title+'</span> | <span class="exp-company-'+response.experience.id+' text-uppercase text-break exp-company">'+response.experience.company+'</span><br><span class="exp-job-responsibility-'+response.experience.id+' job-responsibility">'+response.experience.job_responsibility+'</span></div></div>');

                            $("#edit_exp_job_title").val('');
                    $("#edit_exp_company").val('');
                    $("#edit_exp_main_functional_area_id").val('');
                    $("#edit_exp_sub_functional_area_id").val('');
                    $("#edit_exp_career_level").val('');
                    $("#edit_exp_industry_id").val('');
                    $("#edit_exp_start_date").val('');
                    $("#edit_exp_end_date").val('');
                    $("#edit_exp_country").val('Myanmar');
                    $("#edit_exp_job_responsibility").val('');
                    $('.edit_summernote_exp').summernote('code','');
                    $(".edit_exp_end_date-error").html('');
                    $(".edit_exp_start_date-error").html('');
                            MSalert.principal({
                                icon:'success',
                                title:'Success',
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
                if(edit_exp_start_date != '' && edit_exp_end_date != '' && edit_exp_start_date > edit_exp_end_date) {
                    $(".edit_exp_end_date-error").html('End Date must be greater than Start Date.');
                }else {
                    $(".edit_exp_end_date-error").html("")
                }
                
                if(edit_exp_job_title != '' && edit_exp_company != '' && edit_exp_main_functional_area_id != '' && edit_exp_sub_functional_area_id != '' && edit_exp_career_level != '' && edit_exp_industry_id != '' && edit_exp_start_date != '' && edit_exp_end_date != '' && edit_exp_job_responsibility != '' && edit_exp_end_date > edit_exp_start_date)
                {
                    $("#experienceEditModal").modal('toggle');
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
                            'is_experience' : 1,
                            'is_current_job' : 0,
                            'exp_country' : edit_exp_country,
                            'exp_job_responsibility' : edit_exp_job_responsibility
                        },
                        url: '/seeker/experience/update/'+id,
                    }).done(function(response){
                        if(response.status == 'success') {
                            $(".exp-tr-"+id).html('');
                            $(".exp-resume-"+id).hide('');
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
                            $("#exp-table").append('<div class="row exp-tr-'+response.experience.id+'"><div class="col"><span class="fw-bold exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+' -</span><span class="fw-bold exp-end_date-'+response.experience.id+'">'+moment(response.experience.end_date).format("MMM-YYYY")+'</span><div class="exp-job_title-'+response.experience.id+'">'+response.experience.job_title+'</div><div class="exp-company-'+response.experience.id+'">'+response.experience.company+'</div><div class="exp-career_lavel-'+response.experience.id+'">'+response.experience.career_level+'</div></div><div class="col"><a onclick="editExp('+response.experience.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a><a id="deleteExp-'+response.experience.id+'" class="deleteExp border-0 text-danger" value="'+response.experience.id+'"><i class="fa-solid fa-trash-can"></i></a></div></div>');

                            $(".experience_label").append('<div class="row py-2 exp-resume-'+response.experience.id+'"><div class="col-4 exp-date-range"><span class="exp-start_date-'+response.experience.id+'">'+moment(response.experience.start_date).format("MMM-YYYY")+'</span> - <span class="exp-end_date-'+response.experience.id+'">'+moment(response.experience.end_date).format("MMM-YYYY")+'</span></div><div class="col-8" style="border-left: 2px solid #0563C1;"><span class="exp-job_title-'+response.experience.id+' exp-job-title text-break text-uppercase">'+response.experience.job_title+'</span> | <span class="exp-company-'+response.experience.id+' text-uppercase text-break exp-company">'+response.experience.company+'</span><br><span class="exp-job-responsibility-'+response.experience.id+' job-responsibility">'+response.experience.job_responsibility+'</span></div></div>');
                            $("#edit_exp_job_title").val('');
                            $("#edit_exp_company").val('');
                            $("#edit_exp_main_functional_area_id").val('');
                            $("#edit_exp_sub_functional_area_id").val('');
                            $("#edit_exp_career_level").val('');
                            $("#edit_exp_industry_id").val('');
                            $("#edit_exp_start_date").val('');
                            $("#edit_exp_end_date").val('');
                            $("#edit_exp_country").val('Myanmar');
                            $("#edit_exp_job_responsibility").val('');
                            $('.edit_summernote_exp').summernote('code','');
                            $(".edit_exp_end_date-error").html('');
                            $(".edit_exp_start_date-error").html('');
                            MSalert.principal({
                                icon:'success',
                                title:'Success',
                                description:response.msg,
                            })
                            $("#add_career_history").removeClass('d-none');
                            $(".edit_exp_start_date-error").html("");
                            $(".edit_exp_end_date-error").html("")
                        }
                    })
                }
            }
        })
    }

    $(document).on('click', '.deleteExp', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'Warning',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    data: {
                        "seeker_id": seeker_id
                    },
                    url: '/seeker/experience/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".exp-tr-"+id).empty();
                        $(".exp-resume-"+id).empty();
                        $("#add_career_history").removeClass('d-none');
                        if(response.seeker_experiences_count == 0) {
                            $("#exp-table").addClass('d-none');
                            $(".experience_label").addClass('d-none');
                            $(".experience_status").removeClass('d-none');
                            $("#add_career_history").addClass('d-none');
                            $('input[name="is_experience"]').prop('checked', false);
                            $('.summernote_exp').summernote('code','');
                            $('.edit_summernote_exp').summernote('code','');
                        }
                        MSalert.principal({
                            icon:'success',
                            title:'Success',
                            description:response.msg,
                        })
                    }
                })
            }            
        })
    });
</script>
@endpush