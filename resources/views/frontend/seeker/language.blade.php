<div class="px-5 m-0 pb-0 pt-5">
    <h5>Languages</h5>
    <div class="my-2 row">
        <table id="language-table" class="@if($languages->count() == 0) d-none @endif table border-1 table-responsive">
            <thead>
                <tr>
                    <th>Language Name</th>
                    <th>Language Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($languages as $language)
                <tr class="language-tr-{{ $language->id }}">
                    <td class="language-name-{{$language->id}}">{{ $language->name }}</td>
                    <td class="language-level-{{$language->id}}">{{ $language->level }}</td>
                    <td>
                        <a onclick="editLanguage({{ $language->id }})" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a>
                        <a onclick="deleteLanguage({{ $language->id }})" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="my-2 row">
        <button type="button" class="btn profile-save-btn m-2 col-6" data-bs-toggle="modal" data-bs-target="#langModal">
            <i class="fa-solid fa-plus"></i> Add Language
        </button>
    </div>
    <div class="modal fade" id="langModal" tabindex="-1" aria-labelledby="langModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="langModalLabel">Add Language Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="language_name" class="seeker_label my-2">Language Name <span class="text-danger">*</span></label>
                            <input type="text" name="language_name" id="language_name" class="form-control seeker_input" placeholder="Language Name" value="">
                            <span class="text-danger" id="language_name-error"></span>
                        </div>
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="language_level" class="seeker_label my-2">Language Level <span class="text-danger">*</span></label><br>
                            <select name="language_level" id="language_level" class="form-control seeker_input">
                                <option value="">Choose...</option>
                                <option value="Fluent">Fluent (4 skills)</option>
                                <option value="Advance">Advance</option>
                                <option value="Conversational">Conversational</option>
                                <option value="Basic">Basic</option>
                            </select>
                            <span class="text-danger language_level-error"></span>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                    <span class="btn profile-save-btn" id="save-language">Save changes</span>
                </div>
                
            </div>
        </div>
    </div>
    <div class="modal fade" id="langEditModal" tabindex="-1" aria-labelledby="langEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="langEditModalLabel">Edit Language Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="edit_language_name" class="seeker_label my-2">Language Name <span class="text-danger">*</span></label>
                            <input type="text" name="edit_language_name" id="edit_language_name" class="form-control seeker_input" placeholder="Language Name" value="">
                            <span class="text-danger" id="edit_language_name-error"></span>
                        </div>
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="edit_language_level" class="seeker_label my-2">Language Level <span class="text-danger">*</span></label><br>
                            <select name="edit_language_level" id="edit_language_level" class="form-control seeker_input">
                                <option value="">Choose...</option>
                                <option value="Fluent">Fluent (4 skills)</option>
                                <option value="Advance">Advance</option>
                                <option value="Conversational">Conversational</option>
                                <option value="Basic">Basic</option>
                            </select>
                            <span class="text-danger edit_language_level-error"></span>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                    <span class="btn profile-save-btn" id="update-language">Update changes</span>
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
    $("#save-language").click(function() {
        var language_name = $("#language_name").val();
        var language_level = $("#language_level").val();
        
        if(language_name == '') {
            $("#language_name-error").html('Language name need to fill.');
        }else {
            $("#language_name-error").html('');
        }
        if(language_level == '') {
            $(".language_level-error").html('Language level need to select.');
        }else {
            $(".language_level-error").html('');
        }
        
        if(language_name != '' && language_level != '')
        {
            $('.btn-close').click();
            $.ajax({
                type: 'POST',
                data: {
                    'language_name' : language_name,
                    'language_level' : language_level,
                    'seeker_id' : seeker_id
                },
                url: '{{ route("language.store") }}',
            }).done(function(response){
                if(response.status == 'success') {
                    $('#language-table').removeClass('d-none');
                    $('#language-table').append('<tr class="language-tr-'+response.language.id+'"><td class="language-name-'+response.language.id+'">'+response.language.name+'</td><td class="language-level-'+response.language.id+'">'+response.language.level+'</td><td><a onclick="editLanguage('+response.language.id+')" class="btn border-0 text-warning"><i class="fa-solid fa-pencil"></i></a><a onclick="deleteLanguage('+response.language.id+')" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>')
                    alert(response.msg)
                }
            })
        }
    })

    function deleteLanguage(id)
    {
        $.ajax({
            type: 'POST',
            data: {
                "seeker_id": seeker_id
            },
            url: 'language/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                $(".language-tr-"+id).empty();
                if(response.seeker_languages_count == 0) {
                    $("#language-table").addClass('d-none');
                }
                alert(response.msg)
            }
        })
    }

    function editLanguage(id)
    {
        $("#langEditModal").modal('show');
        $.ajax({
            type: 'GET',
            url: 'language/edit/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                $("#edit_language_name").val(response.language.name);
                $("#edit_language_level").val(response.language.level);
            }
        })

        $("#update-language").click(function() {
            var edit_language_name = $("#edit_language_name").val();
            var edit_language_level = $("#edit_language_level").val();
            
            if(edit_language_name == '') {
                $("#edit_language_name-error").html('Language name need to fill.');
            }else {
                $("#edit_language_name-error").html('');
            }
            if(edit_language_level == '') {
                $(".edit_language_level-error").html('Language level need to select.');
            }else {
                $(".edit_language_level-error").html('');
            }
            if(edit_language_name != '' && edit_language_level != '') {
                $('.btn-close').click();
                $.ajax({
                    type: 'POST',
                    data: {
                        'language_name' : edit_language_name,
                        'language_level' : edit_language_level,
                        'seeker_id' : seeker_id
                    },
                    url: 'language/update/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $('.language-name-'+id).html(response.language.name);
                        $('.language-level-'+id).html(response.language.level);
                        alert(response.msg)
                    }
                })
            }
        })
    }
</script>
@endpush