
<div class="px-lg-3 px-0 m-0 pb-0 pt-3">
    <div class="row">
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="main_functional_area_id" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
            <select name="main_functional_area_id" id="main_functional_area_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                <option value="">Choose...</option>
                @foreach($functional_areas as $functional_area)
                <option value="{{ $functional_area->id }}" @if(Auth::guard('seeker')->user()->main_functional_area_id == $functional_area->id) selected @endif>{{ $functional_area->name }}</option>
                @endforeach
            </select>
            <small class="text-danger d-none main_functional_area_id_error">Please Choose Main Functional Area</small>
        </div>
    
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="sub_functional_area_id" class="seeker_label my-2">Sub Functional Area <span class="text-danger">*</span></label>
            <select name="sub_functional_area_id" id="sub_functional_area_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                <option value="">Choose...</option>
                @foreach($sub_functional_areas as $sub_functional_area)
                <option value="{{ $sub_functional_area->id }}" @if(Auth::guard('seeker')->user()->sub_functional_area_id == $sub_functional_area->id) selected @endif>{{ $sub_functional_area->name }}</option>
                @endforeach
            </select>
            <small class="text-danger d-none sub_functional_area_id_error">Please Choose Sub Functional Area</small>
        </div>
    </div>
    <div class="row">
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="job_title" class="seeker_label my-2">Job Title <span class="text-danger">*</span></label>
            <input type="text" name="job_title" id="job_title" class="form-control seeker_input" required placeholder="Job Title" value="{{ Auth::guard('seeker')->user()->job_title }}">
            <small class="text-danger d-none job_title_error">Please Fill Job Title</small>
        </div>
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="job_type" class="seeker_label my-2">Job Type <span class="text-danger">*</span></label>
            <select name="job_type" id="job_type" class="select_2 form-control seeker_input" style="width: 100%" required>
                <option value="">Choose...</option>
                @foreach(config('jobtype') as $jobtype)
                <option value="{{ $jobtype }}" @if(Auth::guard('seeker')->user()->job_type == $jobtype) selected @endif>{{ $jobtype }}</option>
                @endforeach
            </select>
            <small class="text-danger d-none job_type_error">Please Choose Job Type</small>
        </div>
    </div>
    <div class="row">
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="career_level" class="seeker_label my-2">Career Level <span class="text-danger">*</span></label>
            <select name="career_level" id="career_level" class="select_2 form-control seeker_input" style="width: 100%" required>
                <option value="">Choose...</option>
                @foreach(config('careerlevel') as $careerlevel)
                <option value="{{ $careerlevel }}" @if(Auth::guard('seeker')->user()->career_level == $careerlevel) selected @endif>{{ $careerlevel }}</option>
                @endforeach
            </select>
            <small class="text-danger d-none career_level_error">Please Choose Career Level</small>
        </div>
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="preferred_salary" class="seeker_label my-2">Preferred Salary (MMK)<span class="text-danger">*</span></label>
            <input type="number" name="preferred_salary" id="preferred_salary" class="form-control seeker_input" required placeholder="Preferred Salary - MMK" value="{{ (Auth::guard('seeker')->user()->preferred_salary) }}">
            <small class="text-danger d-none preferred_salary_error">Please Fill Preferred Salary</small>
        </div>
    </div>
    <div class="row">
        <div class="form-group mt-1 col-12 col-md-6">
            <label for="industry_id" class="seeker_label my-2">{{ __('message.Industry') }} <span class="text-danger">*</span></label>
            <select name="industry_id" id="industry_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                <option value="">Choose...</option>
                @foreach($industries as $industry)
                <option value="{{ $industry->id }}" @if(Auth::guard('seeker')->user()->industry_id == $industry->id) selected @endif>{{ $industry->name }}</option>
                @endforeach
            </select>
            <small class="text-danger d-none industry_id_error">Please Choose Industry</small>
        </div>
    </div>
</div>
<div class="row my-4">
    <div class="col-12 text-end">
        <button type="button" class="btn btn-sm profile-save-btn pre-cv-attach">Previous</button>
    
        <button type="button" class="btn btn-sm profile-save-btn next-cv-attach">Save & Next</button>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {

        $('.pre-cv-attach').click(function() {
            $("#nav-cv-build-tab").addClass('active');
            $("#nav-career-choice-tab").removeClass('active');
            $("#nav-cv-attach-tab").removeClass('active');
            $("#nav-cv-build").addClass('show active');
            $("#nav-career-choice").removeClass('show active');
            $("#nav-cv-attach").removeClass('show active');
        })

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#main_functional_area_id').change(function(e){
            e.preventDefault();
            if($(this).val() != "") {
                var main_functional_area_id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '/seeker/get-sub-functional-area/'+main_functional_area_id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $("#sub_functional_area_id").empty();
                        $("#sub_functional_area_id").append('<option value="">Choose</option>')
                        $.each(response.data, function(index, sub_functional_area) {
                        
                        $("#sub_functional_area_id").append('<option value=' + sub_functional_area.id + '>' + sub_functional_area.name +'</option>');
                        })
                    }
                })
            }else {
                $("#sub_functional_area_id").empty();
            }
        });
    })

    $('.next-cv-attach').click(function() {
        var main_functional_area_id = $('#main_functional_area_id').val();
        var sub_functional_area_id  = $("#sub_functional_area_id").val();
        var job_title               = $("#job_title").val();
        var job_type                = $("#job_type").val();
        var career_level            = $("#career_level").val();
        var preferred_salary        = $('#preferred_salary').val();
        var industry_id             = $("#industry_id").val();

        if(main_functional_area_id == '') {
            $('.main_functional_area_id_error').removeClass('d-none')
        }else {
            $('.main_functional_area_id_error').addClass('d-none')
        }

        if(sub_functional_area_id == '') {
            $('.sub_functional_area_id_error').removeClass('d-none')
        }else {
            $('.sub_functional_area_id_error').addClass('d-none')
        }

        if(job_title == '') {
            $('.job_title_error').removeClass('d-none')
        }else {
            $('.job_title_error').addClass('d-none')
        }

        if(job_type == '') {
            $('.job_type_error').removeClass('d-none')
        }else {
            $('.job_type_error').addClass('d-none')
        }

        if(career_level == '') {
            $('.career_level_error').removeClass('d-none')
        }else {
            $('.career_level_error').addClass('d-none')
        }

        if(preferred_salary == '') {
            $('.preferred_salary_error').removeClass('d-none')
        }else {
            $('.preferred_salary_error').addClass('d-none')
        }

        if(industry_id == '') {
            $('.industry_id_error').removeClass('d-none')
        }else {
            $('.industry_id_error').addClass('d-none')
        }

        if(main_functional_area_id != '' && sub_functional_area_id != '' && job_title != '' && job_type != '' && career_level != '' && preferred_salary != '' && industry_id != '' ) {
            $.ajax({
                type : 'POST',
                url  : '{{ route("seeker-career.create") }}',
                data : {
                    'seeker_id' : {{ Auth::guard('seeker')->user()->id }},
                    'main_functional_area_id' : main_functional_area_id,
                    'sub_functional_area_id' : sub_functional_area_id,
                    'job_title' : job_title,
                    'job_type' : job_type,
                    'career_level' : career_level,
                    'preferred_salary' : preferred_salary,
                    'industry_id' : industry_id,
                }
            }).done(function(response){
                    if(response.status == 'success') {
                        MSalert.principal({
                            icon:'success',
                            title:'Success',
                            description:response.msg,
                        });
                        $("#nav-cv-build-tab").removeClass('active');
                        $("#nav-career-choice-tab").removeClass('active');
                        $("#nav-cv-attach-tab").addClass('active');
                        $("#nav-cv-build").removeClass('show active');
                        $("#nav-career-choice").removeClass('show active');
                        $("#nav-cv-attach").addClass('show active');
                    }
                })
        }
    })
</script>
@endpush