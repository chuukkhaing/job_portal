<div class="p-5 pb-0">
    <h5>Career History</h5>
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
        <button type="button" class="btn profile-save-btn m-2 col-6" data-bs-toggle="modal" data-bs-target="#experienceModal">
            <i class="fa-solid fa-plus"></i> Add Career History
        </button>
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
                            <label for="exp_job_title" class="seeker_label my-2">Job Title <span class="text-danger">*</span></label>
                            <input type="text" name="exp_job_title" id="exp_job_title" class="form-control seeker_input" placeholder="Job Title" value="">
                        </div>
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="exp_company" class="seeker_label my-2">Employment Company/Organization <span class="text-danger">*</span></label>
                            <input type="text" name="exp_company" id="exp_company" class="form-control seeker_input" placeholder="Employment Company/Organization" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="exp_main_functional_area_id" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
                            <select name="exp_main_functional_area_id" id="exp_main_functional_area_id" class="form-control seeker_input">
                                <option value="">Choose...</option>
                                @foreach($functional_areas as $functional_area)
                                <option value="{{ $functional_area->id }}">{{ $functional_area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="exp_sub_functional_area_id" class="seeker_label my-2">Sub Functional Area <span class="text-danger">*</span></label>
                            <select name="exp_sub_functional_area_id" id="exp_sub_functional_area_id" class="form-control seeker_input">
                                <option value="">Choose...</option>
                                @foreach($sub_functional_areas as $sub_functional_area)
                                <option value="{{ $sub_functional_area->id }}">{{ $sub_functional_area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="exp_career_level" class="seeker_label my-2">Career Level <span class="text-danger">*</span></label>
                            <select name="exp_career_level" id="exp_career_level" class="form-control seeker_input">
                                <option value="">Choose...</option>
                                @foreach(config('careerlevel') as $careerlevel)
                                <option value="{{ $careerlevel }}">{{ $careerlevel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="exp_industry_id" class="seeker_label my-2">Industry <span class="text-danger">*</span></label>
                            <select name="exp_industry_id" id="exp_industry_id" class="form-control seeker_input">
                                <option value="">Choose...</option>
                                @foreach($industries as $industry)
                                <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="country" class="seeker_label my-2">Country <span class="text-danger">*</span></label>
                            <select name="country" id="country" class="form-control seeker_input" >
                                <option value="Myanmar" >Myanmar</option>
                                <option value="Other" >Other</option>
                            </select>
                        </div>
                        <div class="form-group mt-1 col-12 col-md-6">
                            <br><br>
                            <input type="checkbox" name="current_job" id="current_job">
                            <label for="current_job" class="seeker_label my-2">Current Job </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="start_date" class="seeker_label my-2">Start Date <span class="text-danger">*</span></label>
                            <select name="start_date" id="start_date" class="form-control seeker_input">
                                <option value="">Select Year</option>
                                @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="from-error"></span>
                        </div>
                        <div class="form-group mt-1 col-12 col-md-6">
                            <label for="end_date" class="seeker_label my-2">End Date <span class="text-danger">*</span></label>
                            <select name="end_date" id="end_date" class="form-control seeker_input">
                                <option value="">Select Year</option>
                                @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="to-error"></span>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn profile-save-btn" id="save-edu">Save changes</button>
                </div>
                
            </div>
        </div>
    </div>
    
</div>
@push('scripts')
<script>
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
                    $("#exp_sub_functional_area_id").append('<option value="">Choose</option>')
                    $.each(response.data, function(index, sub_functional_area) {
                    
                    $("#exp_sub_functional_area_id").append('<option value=' + sub_functional_area.id + '>' + sub_functional_area.name +'</option>');
                    })
                }
            })
        }else {
            $("#exp_sub_functional_area_id").empty();
        }
    });
</script>
@endpush