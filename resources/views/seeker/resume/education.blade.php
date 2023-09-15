<div class="my-2">
    <button type="button" class="btn btn-sm profile-save-btn" onclick="createEduForm()">
        <i class="fa-solid fa-plus"></i> Add Education
    </button>
</div>
<div class="my-2 row table-responsive">
    <table id="edu-table" class="table-bordered @if($educations->count() == 0) d-none @endif table">
        <thead>
            <tr>
                <th>Degree</th>
                <th>Major Subject/Area of Study</th>
                <th>Location</th>
                <th>Start Year</th>
                <th>End Year</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($educations as $education)
            <tr class="edu-tr-{{ $education->id }}">
                <td class="edu-degree-{{$education->id}}">{{ $education->degree }}</td>
                <td class="edu-major_subject-{{$education->id}}">{{ $education->major_subject }}</td>
                <td class="edu-location-{{$education->id}}">{{ $education->location }}</td>
                <td class="edu-from-{{$education->id}}">{{ $education->from }}</td>
                <td class="edu-to-{{$education->id}}">{{ $education->to }}</td>
                <td>
                    <a onclick="editEdu({{ $education->id }})" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>
                    <a id="deleteEdu-{{ $education->id }}" class="deleteEdu btn border-0 text-danger" value="{{ $education->id }}"><i class="fa-solid fa-trash-can"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
            <label for="major_subject" class="">Major Subject/Area of Study <span class="text-danger">*</span></label>
            <input type="text" name="major_subject" id="major_subject" class="form-control" placeholder="Major Subject" value="">
            <span class="text-danger" id="major_subject-error"></span>
        </div>        
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="location" class="">Location <span class="text-danger">*</span></label>
            <input type="text" name="location" id="location" class="form-control" placeholder="Location" value="">
            <span class="text-danger" id="location-error"></span>
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
        <div class="form-group mt-1 px-1 col-6 col-md-3">
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
            <label for="major_subject" class="seeker_label my-2">Major Subject/Area of Study <span class="text-danger">*</span></label>
            <input type="text" name="major_subject" id="edit-major_subject" class="form-control seeker_input" placeholder="Major Subject" value="">
            <span class="text-danger" id="edit-major_subject-error"></span>
        </div>        
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="location" class="seeker_label my-2">Location <span class="text-danger">*</span></label>
            <input type="text" name="location" id="edit-location" class="form-control seeker_input" placeholder="Location" value="">
            <span class="text-danger" id="edit-location-error"></span>
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
        <div class="form-group mt-1 col-6 col-md-3">
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
        if(degree != '' && major_subject != '' && location != '' && from != '' && to != '' && to > from && to != from)
        {
            $('.btn-close').click();
            $.ajax({
                type: 'POST',
                data: {
                    'degree' : degree,
                    'major_subject' : major_subject,
                    'location' : location,
                    'from' : from,
                    'to' : to,
                    'seeker_id' : seeker_id
                },
                url: '{{ route("education.store") }}',
            }).done(function(response){
                if(response.status == 'success') {
                    $("#edu-table").removeClass('d-none');
                    $("#edu-table").append('<tr class="edu-tr-'+response.education.id+'"><td class="edu-degree-'+response.education.id+'">'+response.education.degree+'</td><td class="edu-major_subject-'+response.education.id+'">'+response.education.major_subject+'</td><td class="edu-location-'+response.education.id+'">'+response.education.location+'</td><td class="edu-from-'+response.education.id+'">'+response.education.from+'</td><td class="edu-to-'+response.education.id+'">'+response.education.to+'</td><td><a onclick="editEdu('+response.education.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a><a id="deleteEdu-'+response.education.id+'" class="deleteEdu btn border-0 text-danger" value="'+response.education.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>')
                    $(".resume-edu-form").addClass('d-none');
                    // alert(response.msg);
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
                        if(response.seeker_educations_count == 0) {
                            $("#edu-table").addClass('d-none');
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
                $("#edit-degree").val(response.education.degree);
                $("#edit-major_subject").val(response.education.major_subject);
                $("#edit-location").val(response.education.location);
                $("#edit-from").val(response.education.from);
                $("#edit-to").val(response.education.to);
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
        if(edit_degree != '' && edit_major_subject != '' && edit_location != '' && edit_from != '' && edit_to != '' && edit_to > edit_from) {
            $('.btn-close').click();
            $.ajax({
                type: 'POST',
                data: {
                    'degree' : edit_degree,
                    'major_subject' : edit_major_subject,
                    'location' : edit_location,
                    'from' : edit_from,
                    'to' : edit_to,
                    'seeker_id' : seeker_id
                },
                url: 'education/update/'+id,
                cache: false,
            }).done(function(response){
                if(response.status == 'success') {
                    $('.edu-degree-'+id).html(response.education.degree);
                    $('.edu-major_subject-'+id).html(response.education.major_subject);
                    $('.edu-location-'+id).html(response.education.location);
                    $('.edu-from-'+id).html(response.education.from);
                    $('.edu-to-'+id).html(response.education.to);
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