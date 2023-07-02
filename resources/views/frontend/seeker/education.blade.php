<div class="px-5 m-0 pb-0 pt-5">
    <h5>Educations</h5>
    <div class="my-2 row">
        <table id="edu-table" class="@if($educations->count() == 0) d-none @endif table border-1 table-responsive">
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
                        <a onclick="deleteEdu({{ $education->id }})" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="my-2 row">
        <button type="button" class="btn profile-save-btn m-2 col-6" data-bs-toggle="modal" data-bs-target="#educationModal">
            <i class="fa-solid fa-plus"></i> Add Education
        </button>
    </div>
    <div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="educationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="educationModalLabel">Add Education Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="degree" class="seeker_label my-2">Degree <span class="text-danger">*</span></label><br>
                            <select name="degree" id="degree" class="form-control seeker_input">
                                <option value="">Choose...</option>
                                @foreach(config('seekerdegree') as $degree)
                                <option value="{{ $degree }}" >{{ $degree }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="degree-error"></span>
                        </div>
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="major_subject" class="seeker_label my-2">Major Subject/Area of Study <span class="text-danger">*</span></label>
                            <input type="text" name="major_subject" id="major_subject" class="form-control seeker_input" placeholder="Major Subject" value="">
                            <span class="text-danger" id="major_subject-error"></span>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="location" class="seeker_label my-2">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" id="location" class="form-control seeker_input" placeholder="Location" value="">
                            <span class="text-danger" id="location-error"></span>
                        </div>
                        <div class="form-group mt-1 px-1 col-6 col-md-3">
                            <label for="from" class="seeker_label my-2">Start Year <span class="text-danger">*</span></label>
                            <div class="datepicker date input-group year">
                                <input type="text" name="from" id="from" class="form-control seeker_input" value="" placeholder="Start Year">
                                <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <span class="text-danger" id="from-error"></span>
                        </div>
                        <div class="form-group mt-1 px-1 col-6 col-md-3">
                            <label for="to" class="seeker_label my-2">End Year <span class="text-danger">*</span></label>
                            <div class="datepicker date input-group year">
                                <input type="text" name="to" id="to" class="form-control seeker_input" value="" placeholder="End Year">
                                <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <span class="text-danger" id="to-error"></span>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                    <span class="btn profile-save-btn" id="save-edu">Save changes</span>
                </div>
                
            </div>
        </div>
    </div>
    <div class="modal fade" id="educationEditModal" tabindex="-1" aria-labelledby="educationEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="educationEditModalLabel">Edit Education Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
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
                    </div>
                    <div class="row">
                        
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
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger update-close-btn" data-bs-dismiss="modal">Close</button>
                    <span class="btn profile-save-btn" id="update-edu">Update changes</span>
                </div>
                
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('.year').datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            autoclose: true
        });
        
    })
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var seeker_id = {{ Auth::guard("seeker")->user()->id }};
    $("#save-edu").click(function() {
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
        if(degree != '' && major_subject != '' && location != '' && from != '' && to != '' && to > from)
        {
            $('.close-btn').click();
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
                    $("#edu-table").append('<tr data-id="'+response.education.id+'"><td>'+response.education.degree+'</td><td>'+response.education.major_subject+'</td><td>'+response.education.location+'</td><td>'+response.education.from+'</td><td>'+response.education.to+'</td><td><a onclick="editEdu('+response.education.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i> </a> <a onclick="deleteEdu('+response.education.id+')" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>')
                    alert(response.msg)
                }
            })
        }
    })

    function editEdu(id)
    {
        $("#educationEditModal").modal('show');
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
            }
        })

        $("#update-edu").click(function() {
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
                $('.update-close-btn').click();
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
                }).done(function(response){
                    if(response.status == 'success') {
                        $('.edu-degree-'+id).html(response.education.degree);
                        $('.edu-major_subject-'+id).html(response.education.major_subject);
                        $('.edu-location-'+id).html(response.education.location);
                        $('.edu-from-'+id).html(response.education.from);
                        $('.edu-to-'+id).html(response.education.to);
                        alert(response.msg)
                    }
                })
            }
        })
    }

    function deleteEdu(id)
    {
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
                alert(response.msg)
            }
        })
    }
</script>
@endpush