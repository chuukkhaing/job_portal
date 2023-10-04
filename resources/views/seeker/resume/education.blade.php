<div class="my-2">
    <button type="button" class="btn btn-sm profile-save-btn" onclick="createEduForm()">
        <i class="fa-solid fa-plus"></i> Add Education
    </button>
</div>
<div class="my-2 row">
    <div id="edu-table" class="@if($educations->count() == 0) d-none @endif">
        @foreach($educations as $education)
        <div class="row edu-tr-{{ $education->id }} py-2">
            <div class="col-4 fw-bold">
                <span class="edu-from-{{ $education->id }}">{{ $education->from }}</span> - <span class="edu-to-{{ $education->id }}">@if($education->is_current == 1) Present @else {{ $education->to }} @endif</span>
            </div>
            <div class="col-4">
                <span class="edu-degree-{{ $education->id }} fw-bold">{{ $education->degree }} (<span class="edu-major_subject-{{ $education->id }}">{{ $education->major_subject }}</span>)</span><br>
                <span class="edu-location-{{ $education->id }} text-blue">{{ $education->location }}</span>
            </div>
            <div class="col-4">
                <a onclick="editEdu({{ $education->id }})" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>
                <a id="deleteEdu-{{ $education->id }}" class="deleteEdu btn border-0 text-danger" value="{{ $education->id }}"><i class="fa-solid fa-trash-can"></i></a>
            </div>
        </div>
        @endforeach
    </div>
</div>
<form action="" class="resume-edu-form d-none border rounded-3 p-4">
    <div class="row">
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="degree" class="">Degree <span class="text-danger">*</span></label><br>
            <select name="degree" id="degree" class="form-control">
                <option value="">Choose...</option>
                @foreach(config('seekerdegree') as $degree)
                <option value="{{ $degree }}" >{{ $degree }}</option>
                @endforeach
            </select>
            <span class="text-danger" id="degree-error"></span>
        </div>
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="school" class="">School/University <span class="text-danger">*</span></label>
            <input type="text" name="school" id="school" class="form-control" placeholder="School/University" value="">
            <span class="text-danger" id="school-error"></span>
        </div>
        
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="major_subject" class="">Major Subject/Area of Study <span class="text-danger">*</span></label>
            <input type="text" name="major_subject" id="major_subject" class="form-control" placeholder="Major Subject" value="">
            <span class="text-danger" id="major_subject-error"></span>
        </div>        
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="location" class="">Location <span class="text-danger">*</span></label>
            <input type="text" name="location" id="location" class="form-control" placeholder="Location" value="">
            <span class="text-danger" id="location-error"></span>
        </div>
        <div class="form-group mt-1 col-12 col-md-6">
            <br>
            <input type="checkbox" name="current_school" id="current_school" checked="1">
            <label for="current_school" class="seeker_label my-2">Present </label>
        </div>
        <div class="form-group mt-1 px-1 col-6 col-md-3">
            <label for="from" class="">Start Year <span class="text-danger">*</span></label>
            <div class="datepicker date input-group year">
                <input type="text" name="from" id="from" class="form-control" value="" placeholder="Start Year">
                <div class="input-group-append">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <span class="text-danger" id="from-error"></span>
        </div>
        <div class="form-group mt-1 px-1 col-6 col-md-3 d-none" id="end-date-school">
            <label for="to" class="">End Year <span class="text-danger">*</span></label>
            <div class="datepicker date input-group year">
                <input type="text" name="to" id="to" class="form-control" value="" placeholder="End Year">
                <div class="input-group-append">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <span class="text-danger" id="to-error"></span>
        </div>
    </div>
    <button type="reset" class="btn btn-sm border seeker_image_input_label" onclick="resetEduResume()">Cancel</button>
    <span class="btn btn-sm profile-save-btn" id="save-edu" onclick="createEduResume()">Save changes</span>
</form>
<form action="" class="resume-edu-edit-form d-none border rounded-3 p-4">
    <div class="row">
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="degree" class="seeker_label my-2">Degree <span class="text-danger">*</span></label><br>
            <select name="degree" id="edit-degree" class="form-control seeker_input">
                <option value="">Choose...</option>
                @foreach(config('seekerdegree') as $degree)
                <option value="{{ $degree }}" >{{ $degree }}</option>
                @endforeach
            </select>
            <span class="text-danger" id="edit-degree-error"></span>
        </div>
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="school" class="seeker_label my-2">School or University <span class="text-danger">*</span></label>
            <input type="text" name="school" id="edit-school" class="form-control seeker_input" placeholder="Major Subject" value="">
            <span class="text-danger" id="edit-school-error"></span>
        </div>  
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="major_subject" class="seeker_label my-2">Major Subject/Area of Study <span class="text-danger">*</span></label>
            <input type="text" name="major_subject" id="edit-major_subject" class="form-control seeker_input" placeholder="Major Subject" value="">
            <span class="text-danger" id="edit-major_subject-error"></span>
        </div>        
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="location" class="seeker_label my-2">Location <span class="text-danger">*</span></label>
            <input type="text" name="location" id="edit-location" class="form-control seeker_input" placeholder="Location" value="">
            <span class="text-danger" id="edit-location-error"></span>
        </div>
        <div class="form-group mt-1 col-12 col-md-6">
            <br>
            <input type="checkbox" name="edit-current_school" id="edit-current_school" checked="1">
            <label for="edit-current_school" class="seeker_label my-2">Present </label>
        </div>
        <div class="form-group mt-1 col-6 col-md-3">
            <label for="edit-from" class="seeker_label my-2">Start Year <span class="text-danger">*</span></label>
            <div class="datepicker date input-group year">
                <input type="text" name="edit-from" id="edit-from" class="form-control seeker_input" value="" placeholder="Start Year">
                <div class="input-group-append">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <span class="text-danger" id="edit-from-error"></span>
        </div>
        <div class="form-group mt-1 col-6 col-md-3 " id="edit-end-date-school">
            <label for="edit-to" class="seeker_label my-2">End Year <span class="text-danger">*</span></label>
            <div class="datepicker date input-group year">
                <input type="text" name="edit-to" id="edit-to" class="form-control seeker_input" value="" placeholder="Start Year">
                <div class="input-group-append">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
            <span class="text-danger" id="edit-to-error"></span>
        </div>
    </div>
    <button type="reset" class="btn btn-sm border seeker_image_input_label" onclick="resetEduEditResume()">Cancel</button>
    <span class="btn btn-sm profile-save-btn" id="update-edu">Update changes</span>
</form>
@push('scripts')
<script>
    var seeker_id = {{ Auth::guard("seeker")->user()->id }};

    $(document).ready(function() {
        $('.year').datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            autoclose: true
        });

        $("#current_school").change(function() {
            if($(this).is(":checked")){
                $("#end-date-school").addClass('d-none');
                $("#to").val('')
            }else{
                $("#end-date-school").removeClass('d-none');
            }
        })

        $("#edit-current_school").change(function() {
            if($(this).is(":checked")){
                $("#edit-end-date-school").addClass('d-none');
                $("#edit-to").val('')
            }else{
                $("#edit-end-date-school").removeClass('d-none');
            }
        })
    })

    function createEduForm()
    {
        $(".resume-edu-form").removeClass('d-none');
    }

    function resetEduResume()
    {
        $(".resume-edu-form").addClass('d-none');
    }

    function resetEduEditResume()
    {
        $(".resume-edu-edit-form").addClass('d-none');
    }

    function createEduResume()
    {
        var degree = $("#degree").val();
        var major_subject = $("#major_subject").val();
        var location = $("#location").val();
        var from = $("#from").val();
        var to = $("#to").val();
        var school = $("#school").val();
        var current_school = $('#current_school').val();

        if(degree == '') {
            $("#degree-error").html('Degree need to select.');
        }else {
            $("#degree-error").html('');
        }
        if(major_subject == '') {
            $("#major_subject-error").html('Major Subject need to fill.');
        }else {
            $("#major_subject-error").html('');
        }
        if(school == '') {
            $("#school-error").html('School need to fill.');
        }else {
            $("#school-error").html('');
        }
        if(location == '') {
            $("#location-error").html('Location need to fill.');
        }else {
            $("#location-error").html('');
        }
        if(from == '') {
            $("#from-error").html('Start Year need to select.');
        }else {
            $("#from-error").html('');
        }
        if(to == '') {
            $("#to-error").html('End Year need to select.');
        }else {
            $("#to-error").html('');
        }
        if(from != '' && to != '' && from > to) {
            $("#to-error").html('End Year must be greater than Start Year.');
        }
        if(from != '' && to != '' && from == to) {
            $("#to-error").html('Start Year and End Year should not the same.');
        }
        var condition = '';
        if($("#current_school").is(":checked") == true) {
            current_school = 1;
            condition = degree != '' && school != '' && major_subject != '' && location != '' && from != '';
        }else {
            current_school = 0;
            condition = degree != '' && school != '' && major_subject != '' && location != '' && from != '' && to != '' && to > from && to != from;
        }
        if(condition)
        {
            console.log(degree);
            $.ajax({
                type: 'POST',
                data: {
                    'degree' : degree,
                    'major_subject' : major_subject,
                    'location' : location,
                    'from' : from,
                    'to' : to,
                    'seeker_id' : seeker_id,
                    'school' : school,
                    'current_school' : current_school
                },
                url: '{{ route("education.store") }}',
            }).done(function(response){
                if(response.status == 'success') {
                    $("#edu-table").removeClass('d-none');
                    $(".education_label").removeClass('d-none');
                    var responseTo = '';
                    console.log(response.education)
                    if(response.education.is_current == 1) {
                        responseTo = 'Present';
                    }else {
                        responseTo = response.education.to;
                    }

                    $("#edu-table").append('<div class="row edu-tr-'+response.education.id+'" py-2><div class="col-4 fw-bold"><span class="edu-from-'+response.education.id+'">'+response.education.from+'</span> - <span class="edu-to-'+response.education.id+'">'+responseTo+'</span></div><div class="col-4"><span class="edu-degree-'+response.education.id+' fw-bold">'+response.education.degree+' (<span class="edu-major_subject-'+response.education.id+'">'+response.education.major_subject+'</span>)</span><br><span class="edu-location-'+response.education.id+' text-blue">'+response.education.location+'</span></div><div class="col-4"><a onclick="editEdu('+response.education.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a><a id="deleteEdu-'+response.education.id+'" class="deleteEdu btn border-0 text-danger" value="'+response.education.id+'"><i class="fa-solid fa-trash-can"></i></a></div></div>');

                    $(".resume-edu-form").addClass('d-none');

                    $(".education_label").append('<div class="row py-2 edu-resume-'+response.education.id+'"><div class="col-4 fw-bold"><span class="edu-from-'+response.education.id+'">'+response.education.from+'</span> - <span class="edu-to-'+response.education.id+'">'+responseTo+'</span></div><div class="col-8"><span class="edu-degree-'+response.education.id+' fw-bold">'+response.education.degree+' (<span class="edu-major_subject-'+response.education.id+'">'+response.education.major_subject+'</span>)</span><br><span class="edu-location-'+response.education.id+' text-blue">'+response.education.location+'</span></div></div>');

                    MSalert.principal({
                        icon:'success',
                        title:'',
                        description:response.msg,
                    })
                    $("#degree").val('');
                    $("#major_subject").val('');
                    $("#location").val('');
                    $("#from").val('');
                    $("#to").val('');
                }
            })
        }
    }

    $(document).on('click', '.deleteEdu', function (e) {
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
                    url: 'education/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".edu-tr-"+id).empty();
                        $(".edu-resume-"+id).hide();
                        if(response.seeker_educations_count == 0) {
                            $("#edu-table").addClass('d-none');
                            $(".education_label").addClass('d-none');
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

    function editEdu(id)
    {
        $(".resume-edu-edit-form").removeClass('d-none');
        $.ajax({
            type: 'GET',
            url: 'education/edit/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                if(response.education.is_current == 1) {
                    $("#edit-current_school").prop("checked", true);
                    $("#edit-end-date-school").addClass('d-none');
                }else {
                    $("#edit-current_school").prop("checked", false);
                    $("#edit-end-date-school").removeClass('d-none');
                }
                
                $("#edit-degree").val(response.education.degree);
                $("#edit-major_subject").val(response.education.major_subject);
                $("#edit-location").val(response.education.location);
                $("#edit-from").val(response.education.from);
                $("#edit-to").val(response.education.to);
                $("#edit-school").val(response.education.school);
                $("#update-edu").attr("onclick",'updateEdu('+id+')');
            }
        })
    }

    function updateEdu(id)
    {
        var edit_degree = $("#edit-degree").val();
        var edit_major_subject = $("#edit-major_subject").val();
        var edit_location = $("#edit-location").val();
        var edit_from = $("#edit-from").val();
        var edit_to = $("#edit-to").val();
        var edit_school = $("#edit-school").val();
        var edit_current_school = $("#edit-current_school").val();
        
        if(edit_degree == '') {
            $("#edit-degree-error").html('Degree need to select.');
        }else {
            $("#edit-degree-error").html('');
        }
        if(edit_major_subject == '') {
            $("#edit-major_subject-error").html('Major Subject need to fill.');
        }else {
            $("#edit-major_subject-error").html('');
        }
        if(edit_location == '') {
            $("#edit-location-error").html('Location need to fill.');
        }else {
            $("#edit-location-error").html('');
        }
        if(edit_school == '') {
            $("#edit-school-error").html('School need to fill.');
        }else {
            $("#edit-school-error").html('');
        }
        if(edit_from == '') {
            $("#edit-from-error").html('Start Year need to select.');
        }else {
            $("#edit-from-error").html('');
        }
        if(edit_to == '') {
            $("#edit-to-error").html('End Year need to select.');
        }else {
            $("#edit-to-error").html('');
        }
        if(edit_from != '' && edit_to != '' && edit_from > edit_to) {
            $("#edit-to-error").html('End Year need to greater than Start Year.');
        }
        
        var edit_condition = '';
        if($("#edit-current_school").is(":checked") == true) {
            edit_current_school = 1;
            edit_condition = edit_degree != '' && edit_school != '' && edit_major_subject != '' && edit_location != '' && edit_from != '';
        }else {
            edit_current_school = 0;
            edit_condition = edit_degree != '' && edit_school != '' && edit_major_subject != '' && edit_location != '' && edit_from != '' && edit_to != '' && edit_to > edit_from && edit_to != edit_from;
        }

        if(edit_condition) {
            $('.btn-close').click();
            $.ajax({
                type: 'POST',
                data: {
                    'degree' : edit_degree,
                    'major_subject' : edit_major_subject,
                    'location' : edit_location,
                    'from' : edit_from,
                    'to' : edit_to,
                    'seeker_id' : seeker_id,
                    'school' : edit_school,
                    'is_current' : edit_current_school,
                },
                url: 'education/update/'+id,
                cache: false,
            }).done(function(response){
                if(response.status == 'success') {
                    var edit_responseTo = '';
                    console.log(response.education)
                    if(response.education.is_current == 1) {
                        edit_responseTo = 'Present';
                    }else {
                        edit_responseTo = response.education.to;
                    }

                    $('.edu-degree-'+id).html(response.education.degree);
                    $('.edu-major_subject-'+id).html(response.education.major_subject);
                    $('.edu-location-'+id).html(response.education.location);
                    $('.edu-from-'+id).html(response.education.from);
                    $('.edu-to-'+id).html(edit_responseTo);
                    $(".resume-edu-edit-form").addClass('d-none');
                    MSalert.principal({
                        icon:'success',
                        title:'',
                        description:response.msg,
                    })
                }
            })
        }
    }
</script>
@endpush