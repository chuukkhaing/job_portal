<form action="{{ route('profile.update', Auth::guard('seeker')->user()->id) }}" method="post" enctype="multipart/form-data">
    @csrf 
    @method('PUT')
    <div class="container-fluid p-5" id="edit-profile-header">
        <div class="row">
            <div class="col-12 col-md-6">
                <h5>Edit your profile information</h5>
            </div>
            <div class="col-12 col-md-6 text-end">
                <a href="#" class="btn profile-preview mx-2">Preview</a>
                <button type="submit" class="btn profile-save-btn">Update Profile and Save</button>
            </div>
        </div>
    </div>
    <div class="container-fluid my-2" id="edit-profile-body">
        <div class="px-5 m-0 pb-0 pt-5">
            <h5>Account Information</h5>
            <div class="my-2 row">
                <div class="col-12 col-md-6">
                    @if(Auth::guard('seeker')->user()->image)
                    <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                    @else
                    <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                    @endif
                    <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(Auth::guard('seeker')->user()->image) @else d-none @endif  profile-remove"><i class="fa-solid fa-xmark"></i></button>
                    <input type="file" name="image" id="seeker_profile_upload" accept="image/*" class="seeker_image_input">
                    <label for="seeker_profile_upload" class="seeker_image_input_label mx-5">Upload profile image</label>
                    <input type="hidden" name="imageStatus" id="imageStatus" value="">
                </div>
                
            </div>
            <div class="row">
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="email" class="seeker_label my-2">Mail <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control seeker_input" value="{{ Auth::guard('seeker')->user()->email }}" placeholder="Mail Address" required>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="password" class="seeker_label my-2">Password</label>
                    <input type="password" name="password" id="password" class="form-control seeker_input" value="" placeholder="********">
                </div>
            </div>
            <div class="row">
                
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="confirm-password" class="seeker_label my-2">Confirm Password</label>
                    <input type="password" name="confirm-password" id="confirm-password" class="form-control seeker_input" value="" placeholder="********">
                </div>
            </div>
        </div>
        <div class="px-5 m-0 pb-0 pt-5">
            <h5>Personal Information</h5>
            <div class="row">
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="first_name" class="seeker_label my-2">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" id="first_name" class="form-control seeker_input" value="{{ Auth::guard('seeker')->user()->first_name }}" required placeholder="First Name">
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="last_name" class="seeker_label my-2">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" id="last_name" class="form-control seeker_input" value="{{ Auth::guard('seeker')->user()->last_name }}" required placeholder="Last Name">
                </div>
            </div>
            <div class="row">
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="date_of_birth" class="seeker_label my-2">Date of Birth <span class="text-danger">*</span></label>
                    <div class="datepicker date input-group" id="date_of_birth">
                        <input type="text" name="date_of_birth" id="date_of_birth" class="form-control seeker_input" value="{{ date('d-m-Y', strtotime(Auth::guard('seeker')->user()->date_of_birth)) }}" required placeholder="Date of Birth">
                        <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="phone" class="seeker_label my-2">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control seeker_input" value="{{ Auth::guard('seeker')->user()->phone }}" required placeholder="Phone">
                </div>
            </div>
            <div class="row">
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="gender" class="seeker_label my-2">Gender  <span class="text-danger">*</span></label>
                    <select name="gender" id="gender" class="form-control seeker_input select_2" required style="width: 100%">
                        <option value="Male" @if(Auth::guard('seeker')->user()->gender == "Male") selected @endif>Male</option>
                        <option value="Female" @if(Auth::guard('seeker')->user()->gender == "Female") selected @endif>Female</option>
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="marital_status" class="seeker_label my-2">Marital Status</label>
                    <select name="marital_status" id="marital_status" class="form-control seeker_input select_2" style="width: 100%">
                        <option value="Single" @if(Auth::guard('seeker')->user()->marital_status == "Single") selected @endif>Single</option>
                        <option value="Married" @if(Auth::guard('seeker')->user()->marital_status == "Married") selected @endif>Married</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="nationality" class="seeker_label my-2">Nationality <span class="text-danger">*</span></label>
                    <select name="nationality" id="nationality" class="form-control seeker_input select_2" style="width: 100%" required>
                        <option value="Myanmar" @if(Auth::guard('seeker')->user()->nationality == "Myanmar") selected @endif>Myanmar</option>
                        <option value="Other" @if(Auth::guard('seeker')->user()->nationality == "Other") selected @endif>Other</option>
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6 @if(Auth::guard('seeker')->user()->nationality == 'Other') d-none @endif" id="nrc_field">
                    <label for="nrc" class="seeker_label my-2">NRC <span class="text-danger">*</span></label>
                    <input type="text" name="nrc" id="nrc" class="form-control seeker_input" value="{{ Auth::guard('seeker')->user()->nrc }}" placeholder="NRC">
                </div>
                <div class="form-group mt-1 col-12 col-md-6 @if(Auth::guard('seeker')->user()->nationality == 'Myanmar') d-none @endif" id="id_card_field">
                    <label for="id_card" class="seeker_label my-2">ID Card <span class="text-danger">*</span></label>
                    <input type="text" name="id_card" id="id_card" class="form-control seeker_input" value="{{ Auth::guard('seeker')->user()->id_card }}" placeholder="ID Card">
                </div>
            </div>
            <div class="row">
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="country" class="seeker_label my-2">Country <span class="text-danger">*</span></label>
                    <select name="country" id="country" class="form-control seeker_input select_2" style="width: 100%" required>
                        <option value="Myanmar" @if(Auth::guard('seeker')->user()->country == "Myanmar") selected @endif>Myanmar</option>
                        <option value="Other" @if(Auth::guard('seeker')->user()->country == "Other") selected @endif>Other</option>
                    </select>
                </div>
                <div class="form-group mt-1 col-12 col-md-6 @if(Auth::guard('seeker')->user()->country == 'Other') d-none @endif" id="state_id_field">
                    <label for="state_id" class="seeker_label my-2">State or Region <span class="text-danger">*</span></label><br>
                    <select name="state_id" id="state_id" class="select_2 form-control seeker_input" style="width: 100%">
                        <option value="">Choose...</option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}" @if(Auth::guard('seeker')->user()->state_id == $state->id) selected @endif>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group mt-1 col-12 col-md-6 @if(Auth::guard('seeker')->user()->country == 'Other') d-none @endif" id="township_id_field">
                    <label for="township_id" class="seeker_label my-2">City/ Township <span class="text-danger">*</span></label><br>
                    <select name="township_id" id="township_id" class="select_2 form-control seeker_input" style="width: 100%">
                        <option value="">Choose...</option>
                        @foreach($townships as $township)
                        <option value="{{ $township->id }}" @if(Auth::guard('seeker')->user()->township_id == $township->id) selected @endif>{{ $township->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-1 col-6">
                    <label for="address_detail" class="seeker_label my-2">Address Detail</label>
                    <textarea name="address_detail" id="address_detail" class="form-control seeker_input" cols="30" rows="2">{{ Auth::guard('seeker')->user()->address_detail }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group mt-1 col-6">
                    <label for="summary" class="seeker_label my-2">Summary</label>
                    <textarea name="summary" id="summary" class="form-control seeker_input" cols="30" rows="2">{{ Auth::guard('seeker')->user()->summary }}</textarea>
                </div>
            </div>
        </div>
        <div class="px-5 m-0 pb-0 pt-5">
            <h5>Career of Choice</h5>
            <div class="row">
                
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="main_functional_area_id" class="seeker_label my-2">Main Functional Area <span class="text-danger">*</span></label>
                    <select name="main_functional_area_id" id="main_functional_area_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                        <option value="">Choose...</option>
                        @foreach($functional_areas as $functional_area)
                        <option value="{{ $functional_area->id }}" @if(Auth::guard('seeker')->user()->main_functional_area_id == $functional_area->id) selected @endif>{{ $functional_area->name }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="sub_functional_area_id" class="seeker_label my-2">Sub Functional Area <span class="text-danger">*</span></label>
                    <select name="sub_functional_area_id" id="sub_functional_area_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                        <option value="">Choose...</option>
                        @foreach($sub_functional_areas as $sub_functional_area)
                        <option value="{{ $sub_functional_area->id }}" @if(Auth::guard('seeker')->user()->sub_functional_area_id == $sub_functional_area->id) selected @endif>{{ $sub_functional_area->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="job_title" class="seeker_label my-2">Job Title <span class="text-danger">*</span></label>
                    <input type="text" name="job_title" id="job_title" class="form-control seeker_input" required placeholder="Job Title" value="{{ Auth::guard('seeker')->user()->job_title }}">
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="job_type" class="seeker_label my-2">Job Type <span class="text-danger">*</span></label>
                    <select name="job_type" id="job_type" class="select_2 form-control seeker_input" style="width: 100%" required>
                        <option value="">Choose...</option>
                        @foreach(config('jobtype') as $jobtype)
                        <option value="{{ $jobtype }}" @if(Auth::guard('seeker')->user()->job_type == $jobtype) selected @endif>{{ $jobtype }}</option>
                        @endforeach
                    </select>
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
                </div>
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="preferred_salary" class="seeker_label my-2">Preferred Salary (MMK)<span class="text-danger">*</span></label>
                    <input type="number" name="preferred_salary" id="preferred_salary" class="form-control seeker_input" required placeholder="Preferred Salary - MMK" value="{{ (Auth::guard('seeker')->user()->preferred_salary) }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group mt-1 col-12 col-md-6">
                    <label for="industry_id" class="seeker_label my-2">Industry <span class="text-danger">*</span></label>
                    <select name="industry_id" id="industry_id" class="select_2 form-control seeker_input" style="width: 100%" required>
                        <option value="">Choose...</option>
                        @foreach($industries as $industry)
                        <option value="{{ $industry->id }}" @if(Auth::guard('seeker')->user()->industry_id == $industry->id) selected @endif>{{ $industry->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @include('seeker.profile.cv_attach')
        @include('seeker.profile.education')
        @include('seeker.profile.career-history')
        @include('seeker.profile.skill')
        @include('seeker.profile.language')
        @include('seeker.profile.reference')
        <div class="row mb-4">
            <div class="col-12 text-end">
                <button type="submit" class="btn profile-save-btn">Update Profile and Save</button>
            </div>
        </div>
    </div>
</form>
@push('scripts')
<script>
    $(document).ready(function() {

        $('#date_of_birth').datepicker({
            language: "es",
            autoclose: true,
            format: "dd-mm-yyyy"
        });

        $("#seeker_profile_upload").change(function() {
            var imgControlName = ".seeker-profile";
            readURL(this, imgControlName);
        });

        function readURL(input, imgControlName) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(imgControlName).attr('src', e.target.result);
                $('.profile-remove').removeClass('d-none');
                $('#imageStatus').val('');
            };
            reader.readAsDataURL(input.files[0]);
            }
        }

        $('.profile-remove').click(function() {
            $('.seeker-profile').attr('src', document.location.origin+'/img/undraw_profile_1.svg');
            $('.profile-remove').addClass('d-none');
            $('#seeker_profile_upload').val('');
            $('#imageStatus').val('empty');
        });

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#state_id').change(function(e){
            e.preventDefault();
            if($(this).val() != "") {
                var state_id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: 'get-township/'+state_id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $("#township_id").empty();
                        $("#township_id").append('<option value="">Choose</option>')
                        $.each(response.data, function(index, township) {
                        
                        $("#township_id").append('<option value=' + township.id + '>' + township.name +'</option>');
                        })
                    }
                })
            }else {
                $("#township_id").empty();
            }
        });

        $('#main_functional_area_id').change(function(e){
            e.preventDefault();
            if($(this).val() != "") {
                var main_functional_area_id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: 'get-sub-functional-area/'+main_functional_area_id,
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

        if($("#nationality").val() == "Myanmar") {
            $("#nrc_field").removeClass('d-none');
            $("#id_card_field").addClass('d-none');
            $("#id_card").val('');
            $("#nrc").prop('required',true);
            $("#id_card").prop('required',false);
        }else {
            $("#nrc_field").addClass('d-none');
            $("#id_card_field").removeClass('d-none');
            $("#nrc").val('');
            $("#nrc").prop('required',false);
            $("#id_card").prop('required',true);
        }

        $("#nationality").change(function() {
            if($(this).val() == "Myanmar") {
                $("#nrc_field").removeClass('d-none');
                $("#id_card_field").addClass('d-none');
                $("#id_card").val('');
                $("#nrc").prop('required',true);
                $("#id_card").prop('required',false);
            }else {
                $("#nrc_field").addClass('d-none');
                $("#id_card_field").removeClass('d-none');
                $("#nrc").val('');
                $("#nrc").prop('required',false);
                $("#id_card").prop('required',true);
            }
        })

        if($("#country").val() == "Myanmar") {
            $("#state_id_field").removeClass('d-none');
            $("#township_id_field").removeClass('d-none');
            $("#state_id").prop('required',true);
            $("#township_id").prop('required',true);
        }else {
            $("#state_id_field").addClass('d-none');
            $("#township_id_field").addClass('d-none');
            $("#state_id_field").val('');
            $("#township_id_field").val('');
            $("#state_id").prop('required',false);
            $("#township_id").prop('required',false);
        }

        $("#country").change(function() {
            if($(this).val() == "Myanmar") {
                $("#state_id_field").removeClass('d-none');
                $("#township_id_field").removeClass('d-none');
                $("#state_id").prop('required',true);
                $("#township_id").prop('required',true);
            }else {
                $("#state_id_field").addClass('d-none');
                $("#township_id_field").addClass('d-none');
                $("#state_id_field").val('');
                $("#township_id_field").val('');
                $("#state_id").prop('required',false);
                $("#township_id").prop('required',false);
            }
        })
    })
</script>
@endpush