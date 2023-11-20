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

