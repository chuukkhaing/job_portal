<div class="my-2 row">
    <button type="button" class="btn btn profile-save-btn m-2 col-6" data-bs-toggle="modal" data-bs-target="#refModal">
        <i class="fa-solid fa-plus"></i> Add Reference
    </button>
</div>

<div class="my-2 row">
    <div id="reference-table" class="@if($references->count() == 0) d-none @endif">
        @foreach($references as $reference)
        <div class="row reference-tr-{{ $reference->id }}">
            <div class="col">
                <div class="fw-bold reference-name-{{$reference->id}}">{{ $reference->name }}</div>
                <div class="reference-position-{{$reference->id}}">{{ $reference->position }}</div>
                <div class="text-blue reference-company-{{$reference->id}}">{{ $reference->company }}</div>
                <div class="reference-contact-{{$reference->id}}">{{ $reference->contact }}</div>
            </div>
            <div class="col">
                <a onclick="editReference({{ $reference->id }})" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>
                <a id="deleteReference-{{ $reference->id }}" class="deleteReference btn border-0 text-danger" value="{{ $reference->id }}"><i class="fa-solid fa-trash-can"></i></a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="refModal" tabindex="-1" aria-labelledby="refModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refModalLabel">Add Reference Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="ref_name" class="seeker_label my-2">Name <span class="text-danger">*</span></label>
                        <input type="text" name="ref_name" id="ref_name" class="form-control seeker_input" placeholder="Name" value="">
                        <span class="text-danger" id="ref_name-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="ref_position" class="seeker_label my-2">Position <span class="text-danger">*</span></label>
                        <input type="text" name="ref_position" id="ref_position" class="form-control seeker_input" placeholder="Position" value="">
                        <span class="text-danger" id="ref_position-error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="ref_company" class="seeker_label my-2">Company <span class="text-danger">*</span></label>
                        <input type="text" name="ref_company" id="ref_company" class="form-control seeker_input" placeholder="Company" value="">
                        <span class="text-danger" id="ref_company-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="ref_contact" class="seeker_label my-2">Contact No. <span class="text-danger">*</span></label>
                        <input type="text" name="ref_contact" id="ref_contact" class="form-control seeker_input" placeholder="09xxxxxxxxx" value="">
                        <span class="text-danger" id="ref_contact-error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                <span class="btn profile-save-btn" id="save-reference">Save changes</span>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="refEditModal" tabindex="-1" aria-labelledby="refEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refEditModalLabel">Edit Reference Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_ref_name" class="seeker_label my-2">Name <span class="text-danger">*</span></label>
                        <input type="text" name="edit_ref_name" id="edit_ref_name" class="form-control seeker_input" placeholder="Name" value="">
                        <span class="text-danger" id="edit_ref_name-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_ref_position" class="seeker_label my-2">Position <span class="text-danger">*</span></label>
                        <input type="text" name="edit_ref_position" id="edit_ref_position" class="form-control seeker_input" placeholder="Position" value="">
                        <span class="text-danger" id="edit_ref_position-error"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_ref_company" class="seeker_label my-2">Company <span class="text-danger">*</span></label>
                        <input type="text" name="edit_ref_company" id="edit_ref_company" class="form-control seeker_input" placeholder="Company" value="">
                        <span class="text-danger" id="edit_ref_company-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="edit_ref_contact" class="seeker_label my-2">Contact No. <span class="text-danger">*</span></label>
                        <input type="text" name="edit_ref_contact" id="edit_ref_contact" class="form-control seeker_input" placeholder="09xxxxxxxxx" value="">
                        <span class="text-danger" id="edit_ref_contact-error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                <span class="btn profile-save-btn" id="update-reference">Update changes</span>
            </div>
            
        </div>
    </div>
</div>
    
@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var seeker_id = {{ Auth::guard("seeker")->user()->id }};
    $("#save-reference").on('click', function(e)  {
        e.preventDefault();
        var ref_name = $("#ref_name").val();
        var ref_position = $("#ref_position").val();
        var ref_company = $("#ref_company").val();
        var ref_contact = $("#ref_contact").val();
        
        if(ref_name == '') {
            $("#ref_name-error").html('Reference name need to fill.');
        }else {
            $("#ref_name-error").html('');
        }
        if(ref_position == '') {
            $("#ref_position-error").html('Reference position need to fill.');
        }else {
            $("#ref_position-error").html('');
        }
        if(ref_company == '') {
            $("#ref_company-error").html('Reference company need to fill.');
        }else {
            $("#ref_company-error").html('');
        }
        if(ref_contact == '') {
            $("#ref_contact-error").html('Reference contact need to fill.');
        }else {
            $("#ref_contact-error").html('');
        }
        
        
        if(ref_name != '' && ref_position != '' && ref_company != '' && ref_contact != '')
        {
            $('.btn-close').click();
            $.ajax({
                type: 'POST',
                data: {
                    'ref_name' : ref_name,
                    'ref_position' : ref_position,
                    'ref_company' : ref_company,
                    'ref_contact' : ref_contact,
                    'seeker_id' : seeker_id
                },
                url: '{{ route("reference.store") }}',
                success: function(response){
                            if(response.status == 'success') {
                                $('#reference-table').removeClass('d-none');

                                $('.reference_label').removeClass('d-none');

                                $('#reference-table').append('<div class="row reference-tr-'+response.reference.id+'"><div class="col"><div class="fw-bold reference-name-'+response.reference.id+'">'+response.reference.name+'</div><div class="reference-position-'+response.reference.id+'">'+response.reference.position+'</div><div class="text-blue reference-company-'+response.reference.id+'">'+response.reference.company+'</div><div class="reference-contact-'+response.reference.id+'">'+response.reference.contact+'</div></div><div class="col"><a onclick="editReference('+response.reference.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a><a id="deleteReference-'+response.reference.id+'" class="deleteReference btn border-0 text-danger" value="'+response.reference.id+'"><i class="fa-solid fa-trash-can"></i></a></div></div>');

                                $(".reference_label").append('<div class="row py-2 reference-resume-'+response.reference.id+'"><span class="reference-name-'+response.reference.id+' fw-bold">'+response.reference.name+'</span><span class="reference-position-'+response.reference.id+'">'+response.reference.position+'</span><span class="reference-company-'+response.reference.id+' text-blue">'+response.reference.company+'</span><span class="reference-contact-'+response.reference.id+'">'+response.reference.contact+'</span></div>');

                                MSalert.principal({
                                        icon:'success',
                                        title:'Success',
                                        description:response.msg,
                                    });
                                $("#ref_name").val('');
                                $("#ref_position").val('');
                                $("#ref_company").val('');
                                $("#ref_contact").val('');
                            }
                        },
                error: function (data) {
                    var errors = $.parseJSON(data.responseText);
                    if(errors.errors['ref_contact']) {
                        MSalert.principal({
                            icon:'error',
                            title:'Error',
                            description:'The contact No. must be valid myanmar phone number.',
                        })
                    }
                }
            })
        }
    })

    $(document).on('click', '.deleteReference', function (e) {
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
                    url: '/seeker/reference/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".reference-tr-"+id).empty();
                        $(".reference-resume-"+id).hide();
                        if(response.seeker_references_count == 0) {
                            $("#reference-table").addClass('d-none');
                            $(".reference_label").addClass('d-none');
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

    function editReference(id)
    {
        $("#refEditModal").modal('show');
        $.ajax({
            type: 'GET',
            url: '/seeker/reference/edit/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                $("#edit_ref_name").val(response.reference.name);
                $("#edit_ref_position").val(response.reference.position);
                $("#edit_ref_company").val(response.reference.company);
                $("#edit_ref_contact").val(response.reference.contact);
            }
        })

        $("#update-reference").one('click', function(e)  {
            e.preventDefault();
            var edit_ref_name = $("#edit_ref_name").val();
            var edit_ref_position = $("#edit_ref_position").val();
            var edit_ref_company = $("#edit_ref_company").val();
            var edit_ref_contact = $("#edit_ref_contact").val();
            
            if(edit_ref_name == '') {
                $("#edit_ref_name-error").html('Reference name need to fill.');
            }else {
                $("#edit_ref_name-error").html('');
            }
            if(edit_ref_position == '') {
                $("#edit_ref_position-error").html('Reference position need to fill.');
            }else {
                $("#edit_ref_position-error").html('');
            }
            if(edit_ref_company == '') {
                $("#edit_ref_company-error").html('Reference company need to fill.');
            }else {
                $("#edit_ref_company-error").html('');
            }
            if(edit_ref_contact == '') {
                $("#edit_ref_contact-error").html('Reference contact need to fill.');
            }else {
                $("#edit_ref_contact-error").html('');
            }
            if(edit_ref_name != '' && edit_ref_position != '' && edit_ref_company != '' && edit_ref_contact != '') {
                $('.btn-close').click();
                $.ajax({
                    type: 'POST',
                    data: {
                        'ref_name' : edit_ref_name,
                        'ref_position' : edit_ref_position,
                        'ref_company' : edit_ref_company,
                        'ref_contact' : edit_ref_contact,
                        'seeker_id' : seeker_id
                    },
                    url: '/seeker/reference/update/'+id,
                    success: function(edit_response){
                                if(edit_response.status == 'success') {
                                    $('.reference-name-'+id).html(edit_response.reference.name);
                                    $('.reference-company-'+id).html(edit_response.reference.company);
                                    $('.reference-contact-'+id).html(edit_response.reference.contact);
                                    $('.reference-position-'+id).html(edit_response.reference.position);
                                    MSalert.principal({
                                        icon:'success',
                                        title:'Success',
                                        description:edit_response.msg,
                                    })
                                }
                            },
                    error: function (data) {
                        var errors = $.parseJSON(data.responseText);
                        if(errors.errors['ref_contact']) {
                            MSalert.principal({
                                icon:'error',
                                title:'Error',
                                description:'The contact No. must be valid myanmar phone number.',
                            })
                        }
                    }
                })
            }
        })
    }
</script>
@endpush