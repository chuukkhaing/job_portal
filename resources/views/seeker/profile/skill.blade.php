<div class="px-5 m-0 pb-0 pt-5">
    <h5>Skills</h5>
    <div class="my-2 row table-responsive">
        <table id="skill-table" class="@if($skills->count() == 0) d-none @endif table table-bordered ">
            <thead>
                <tr>
                    <th>Main Functional Area Name</th>
                    <th>Skill Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="skill-tbody">
                @foreach($skills as $skill)
                <tr class="skill-tr-{{ $skill->id }}">
                    <td class="skill-main_functional_area_id-{{$skill->id}}">{{ $skill->MainFunctionalArea->name }}</td>
                    <td class="skill-skill_id-{{$skill->id}}">{{ $skill->Skill->name }}</td>
                    <td>
                        <a id="deleteSkill-{{ $skill->id }}" class="deleteSkill btn border-0 text-danger" value="{{ $skill->id }}"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="my-2 row">
        <button type="button" class="btn profile-save-btn m-2 col-6" data-bs-toggle="modal" data-bs-target="#skillModal">
            <i class="fa-solid fa-plus"></i> Add Skill
        </button>
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
    
</div>
@push('scripts')
<script>
    $('#skill_main_functional_area_id').change(function(e){
        e.preventDefault();
        if($(this).val() != "") {
            var skill_main_functional_area_id = $(this).val();
            $.ajax({
                type: 'GET',
                url: 'get-skill/'+skill_main_functional_area_id,
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
    var seeker_id = {{ Auth::guard("seeker")->user()->id }};
    $("#save-skill").click(function() {
        var skill_main_functional_area_id = $("#skill_main_functional_area_id").val();
        var skill_id = $("#skill_id").val();
        
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
                    var function_name = '';
                    var skill_name_org = '';
                    $(response.skills).each(function(index, skill) {
                        $(response.skill_functions).each(function(key, function_area) {
                            if(skill.main_functional_area_id == function_area.id){
                                function_name = function_area.name;
                            }
                        })
                        $(response.skill_names).each(function(key, skill_name) {
                            if(skill.skill_id == skill_name.id){
                                skill_name_org = skill_name.name;
                            }
                        })
                        $("#skill-table").append('<tr class="skill-tr-'+skill.id+'"><td class="skill-main_functional_area_id-'+skill.id+'">'+function_name+'</td><td class="skill-skill_id-'+skill.id+'">'+skill_name_org+'</td><td><a id="deleteSkill-'+skill.id+'" class="deleteSkill btn border-0 text-danger" value="'+skill.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>')
                    })
                    MSalert.principal({
                        icon:'success',
                        title:'',
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
                    url: 'skill/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".skill-tr-"+id).empty();
                        if(response.seeker_skills_count == 0) {
                            $("#skill-table").addClass('d-none');
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