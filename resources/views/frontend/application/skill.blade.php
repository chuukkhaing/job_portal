<div class="my-2 row">
    <button type="button" class="btn btn-sm profile-save-btn m-2 col-6" data-bs-toggle="modal" data-bs-target="#skillModal">
        <i class="fa-solid fa-plus"></i> Add Skill
    </button>
</div>
<div class="my-2 row">
    <div id="skill-table" class="d-none">
        <div id="skill-tbody">
            
        </div>
    </div>
</div>

<div class="modal fade" id="skillModal" tabindex="-1" aria-labelledby="skillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="skillModalLabel">Add Skill Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="skill_main_functional_area_id" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
                        <select name="skill_main_functional_area_id" id="skill_main_functional_area_id" class="form-control seeker_input">
                            <option value="">Choose...</option>
                            @foreach($functional_areas as $functional_area)
                            <option value="{{ $functional_area->id }}">{{ $functional_area->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger skill_main_functional_area_id-error"></span>
                    </div>
                    <div class="form-group mt-1 col-12 col-md-6">
                        <label for="skill_id" class="seeker_label my-2">Skill Name <span class="text-danger">*</span></label><br>
                        <select name="skill_id[]" id="skill_id" class="form-control seeker_input select_2" style="width:100%" multiple>
                            <option value="">Choose...</option>
                            
                        </select><br>
                        <span class="text-danger skill_id-error"></span>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                <span class="btn profile-save-btn" id="save-skill">Save changes</span>
            </div>
            
        </div>
    </div>
</div>
@push('scripts')
<script>
    $('#skill_main_functional_area_id').change(function(e){
        e.preventDefault();
        if($(this).val() != "") {
            var skill_main_functional_area_id = $(this).val();
            $.ajax({
                type: 'GET',
                url: '/seeker/get-skill/'+skill_main_functional_area_id,
            }).done(function(response){
                if(response.status == 'success') {
                    $("#skill_id").empty();
                    $("#skill_id").append('<option value="">Choose...</option>')
                    $.each(response.data, function(index, skill) {
                    
                    $("#skill_id").append('<option value=' + skill.id + '>' + skill.name +'</option>');
                    })
                }
            })
        }else {
            $("#skill_id").empty();
        }
    });

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $("#save-skill").click(function() {
        var skill_main_functional_area_id = $("#skill_main_functional_area_id").val();
        var skill_id = $("#skill_id").val();
        var seeker_id = $("#seeker_id").val();

        if(skill_main_functional_area_id == '') {
            $(".skill_main_functional_area_id-error").html('Main functional area need to select.');
        }else {
            $(".skill_main_functional_area_id-error").html('');
        }
        if(skill_id == '') {
            $(".skill_id-error").html('Skill need to select.');
        }else {
            $(".skill_id-error").html('');
        }
        
        if(skill_main_functional_area_id != '' && skill_id != '')
        {
            $('.btn-close').click();
            $.ajax({
                type: 'POST',
                data: {
                    'skill_main_functional_area_id' : skill_main_functional_area_id,
                    'skill_id' : skill_id,
                    'seeker_id' : seeker_id
                },
                url: '{{ route("seeker-skill.store") }}',
            }).done(function(response){
                if(response.status == 'success') {
                    $("#skill-table").removeClass('d-none');
                    $("#skill-tbody").html('');

                    $(".skill_label").removeClass('d-none');
                    $("#skill_body").html('');
                    var function_name = '';
                    var skill_name_org = '';
                    $(response.skills).each(function(index, skill) {
                        $(response.skill_names).each(function(key, skill_name) {
                            if(skill.skill_id == skill_name.id){
                                skill_name_org = skill_name.name;
                            }
                        })
                        
                        $("#skill-tbody").append('<div class="row skill-tr-'+skill.id+'"><div class="col skill-skill_id-'+skill.id+'">'+skill_name_org+'</div><div class="col"><a id="deleteSkill-'+skill.id+'" class="deleteSkill btn border-0 text-danger" value="'+skill.id+'"><i class="fa-solid fa-trash-can"></i></a></div></div>');

                        $("#skill_body").append('<div class="row col-6 skill-list skill-resume-'+skill.id+' skill-skill_id-'+skill.id+'"><div class="row"><div class="col-1"><i class="fa-regular fa-circle" style="color: #0563C1"></i></div><div class="col"><span class="">'+skill_name_org+'</span></div></div></div>');
                    })
                    MSalert.principal({
                        icon:'success',
                        title:'Success',
                        description:response.msg,
                    })
                    $("#skill_main_functional_area_id").val('');
                    $('#skill_id').val("");
                    $("#skill_id").trigger("change");
                }
            })
        }
    })

    $(document).on('click', '.deleteSkill', function (e) {
        var id       = $(this).attr('value');
        var seeker_id = $("#seeker_id").val();
        
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
                    url: '/seeker/skill/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".skill-tr-"+id).empty();
                        $(".skill-resume-"+id).hide();
                        if(response.seeker_skills_count == 0) {
                            $("#skill-table").addClass('d-none');
                            $(".skill_label").addClass('d-none');
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