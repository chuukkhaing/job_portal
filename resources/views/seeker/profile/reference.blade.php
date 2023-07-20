<div class="px-5 m-0 pb-0 pt-5">
    <h5>References</h5>
    <div class="my-2 row">
        <table id="reference-table" class="@if($references->count() == 0) d-none @endif table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($references as $reference)
                <tr class="reference-tr-{{ $reference->id }}">
                    <td class="reference-name-{{$reference->id}}">{{ $reference->name }}</td>
                    <td class="reference-position-{{$reference->id}}">{{ $reference->position }}</td>
                    <td class="reference-company-{{$reference->id}}">{{ $reference->company }}</td>
                    <td class="reference-contact-{{$reference->id}}">{{ $reference->contact }}</td>
                    <td>
                        <a onclick="editReference({{ $reference->id }})" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>
                        <a onclick="deleteReference({{ $reference->id }})" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="my-2 row">
        <button type="button" class="btn profile-save-btn m-2 col-6" data-bs-toggle="modal" data-bs-target="#refModal">
            <i class="fa-solid fa-plus"></i> Add Reference
        </button>
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
                            <label for="ref_contact" class="seeker_label my-2">Contact <span class="text-danger">*</span></label>
                            <input type="text" name="ref_contact" id="ref_contact" class="form-control seeker_input" placeholder="Contact" value="">
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
                            <label for="edit_ref_contact" class="seeker_label my-2">Contact <span class="text-danger">*</span></label>
                            <input type="text" name="edit_ref_contact" id="edit_ref_contact" class="form-control seeker_input" placeholder="Contact" value="">
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
    
</div>
@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var seeker_id = {{ Auth::guard("seeker")->user()->id }};
    $("#save-reference").click(function() {
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
            }).done(function(response){
                if(response.status == 'success') {
                    $('#reference-table').removeClass('d-none');
                    $('#reference-table').append('<tr class="reference-tr-'+response.reference.id+'"><td class="reference-name-'+response.reference.id+'">'+response.reference.name+'</td><td class="reference-position-'+response.reference.id+'">'+response.reference.position+'</td><td class="reference-company-'+response.reference.id+'">'+response.reference.company+'</td><td class="reference-contact-'+response.reference.id+'">'+response.reference.contact+'</td><td>    <a onclick="editReference('+response.reference.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>    <a onclick="deleteReference('+response.reference.id+')" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>')
                    alert(response.msg);
                    $("#ref_name").val('');
                    $("#ref_position").val('');
                    $("#ref_company").val('');
                    $("#ref_contact").val('');
                }
            })
        }
    })

    function deleteReference(id)
    {
        $.ajax({
            type: 'POST',
            data: {
                "seeker_id": seeker_id
            },
            url: 'reference/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                $(".reference-tr-"+id).empty();
                if(response.seeker_references_count == 0) {
                    $("#reference-table").addClass('d-none');
                }
                alert(response.msg)
            }
        })
    }

    function editReference(id)
    {
        $("#refEditModal").modal('show');
        $.ajax({
            type: 'GET',
            url: 'reference/edit/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                $("#edit_ref_name").val(response.reference.name);
                $("#edit_ref_position").val(response.reference.position);
                $("#edit_ref_company").val(response.reference.company);
                $("#edit_ref_contact").val(response.reference.contact);
            }
        })

        $("#update-reference").click(function() {
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
                    url: 'reference/update/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $('.reference-name-'+id).html(response.reference.name);
                        $('.reference-company-'+id).html(response.reference.company);
                        $('.reference-contact-'+id).html(response.reference.contact);
                        $('.reference-position-'+id).html(response.reference.position);
                        alert(response.msg)
                    }
                })
            }
        })
    }
</script>
@endpush