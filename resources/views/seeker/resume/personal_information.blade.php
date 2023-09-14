<div class="row">
    <div class="col-3">
        <div class="px-1">
            <small>Profile Image </small>
            <div class="float-end @if(Auth::guard('seeker')->user()->image) @else d-none @endif profile-remove-icon">
                
                <a class="dropdown btn" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fz13 float-end fa-solid fa-ellipsis-vertical"></i>
                </a>
                <ul class="dropdown-menu p-0">
                    <li>
                        <a class="dropdown-item" onclick="removeProfileImage()">
                            <i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i>
                            Delete
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <label for="resume_img" class="w-100">
            @if(Auth::guard('seeker')->user()->image)
            <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="img-thumbnail resume_profile_img" id="resume_profile_img">
            @else
            <img src="https://placehold.jp/200x200.png" alt="Profile Image" class="img-thumbnail resume_profile_img" id="resume_profile_img">
            @endif
        </label>
        <input type="file" name="resume_img" id="resume_img" accept="image/*">
    </div>
    <div class="row col-9">
        <div class="form-group col-6">
            <label for="first_name" class="">First Name <span class="text-danger">*</span></label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ Auth::guard('seeker')->user()->first_name }}" placeholder="First Name">
        </div>
        <div class="form-group col-6">
            <label for="last_name" class="">Last Name <span class="text-danger">*</span></label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ Auth::guard('seeker')->user()->last_name }}" placeholder="First Name">
        </div>
        <div class="form-group col-12">
            <label for="email" class="">Mail <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control" value="{{ Auth::guard('seeker')->user()->email }}" placeholder="Mail Address">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12">
            <label for="date_of_birth" class="">Date of Birth <span class="text-danger">*</span></label>
            <div class="datepicker date input-group" id="date_of_birth">
                <input type="text" name="date_of_birth" id="dob" class="form-control" autocomplete="off" value="{{ date('d-m-Y', strtotime(Auth::guard('seeker')->user()->date_of_birth)) }}" placeholder="Date of Birth">
                <div class="input-group-append">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group col-12">
            <label for="phone" class="">Phone <span class="text-danger">*</span></label>
            <input type="number" name="phone" id="phone" class="form-control " value="{{ Auth::guard('seeker')->user()->phone }}" placeholder="09xxxxxxxxx">
        </div>
        <div class="form-group col-12">
            <label for="gender" class="">Gender  <span class="text-danger">*</span></label>
            <select name="gender" id="gender" class="form-control resume_select_2" style="width: 100%">
                <option value="">Choose</option>
                <option value="Male" @if(Auth::guard('seeker')->user()->gender == "Male") selected @endif>Male</option>
                <option value="Female" @if(Auth::guard('seeker')->user()->gender == "Female") selected @endif>Female</option>
            </select>
        </div>
        <div class="form-group col-12">
            <label for="marital_status" class="">Marital Status</label>
            <select name="marital_status" id="marital_status" class="form-control resume_select_2" style="width: 100%">
                <option value="">Choose</option>
                <option value="Single" @if(Auth::guard('seeker')->user()->marital_status == "Single") selected @endif>Single</option>
                <option value="Married" @if(Auth::guard('seeker')->user()->marital_status == "Married") selected @endif>Married</option>
            </select>
        </div>
        <div class="form-group col-12">
            <label for="nationality" class="">Nationality <span class="text-danger">*</span></label>
            <select name="nationality" id="nationality" class="form-control resume_select_2" style="width: 100%">
                <option value="">Choose</option>
                <option value="Myanmar" @if(Auth::guard('seeker')->user()->nationality == "Myanmar") selected @endif>Myanmar</option>
                <option value="Other" @if(Auth::guard('seeker')->user()->nationality == "Other") selected @endif>Other</option>
            </select>
        </div>

        <div class="form-group col-12 @if(Auth::guard('seeker')->user()->nationality == 'Other') d-none @endif" id="nrc_field">
            <label for="nrc" class="">NRC <span class="text-danger">*</span></label>
            <input type="text" name="nrc" id="nrc" class="form-control" value="{{ Auth::guard('seeker')->user()->nrc }}" placeholder="NRC">
        </div>

        <div class="form-group col-12 @if(Auth::guard('seeker')->user()->nationality == 'Myanmar') d-none @endif" id="id_card_field">
            <label for="id_card" class="">ID Card <span class="text-danger">*</span></label>
            <input type="text" name="id_card" id="id_card" class="form-control" value="{{ Auth::guard('seeker')->user()->id_card }}" placeholder="ID Card">
        </div>

        <div class="form-group col-12">
            <label for="country" class="">Country <span class="text-danger">*</span></label>
            <select name="country" id="country" class="form-control select_2" style="width: 100%">
                <option value="">Choose...</option>
                <option value="Myanmar" @if(Auth::guard('seeker')->user()->country == "Myanmar") selected @endif>Myanmar</option>
                <option value="Other" @if(Auth::guard('seeker')->user()->country == "Other") selected @endif>Other</option>
            </select>
        </div>
        <div class="form-group col-12" id="state_id_field">
            <label for="state_id" class="">State or Region <span class="text-danger">*</span></label><br>
            <select name="state_id" id="state_id" class="select_2 form-control" style="width: 100%">
                <option value="">Choose...</option>
                @foreach($states as $state)
                <option value="{{ $state->name }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group col-12" id="township_id_field">
            <label for="township_id" class="">City/ Township <span class="text-danger">*</span></label><br>
            <select name="township_id" id="township_id" class="select_2 form-control" style="width: 100%">
                <option value="">Choose...</option>
                @foreach($townships as $township)
                <option value="{{ $township->name }}">{{ $township->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mt-1 col-12">
            <label for="address_detail" class="">Address Detail</label>
            <textarea name="address_detail" id="address_detail" class="form-control" cols="30" rows="2">{{ Auth::guard('seeker')->user()->address_detail }}</textarea>
        </div>
        <div class="form-group col-12">
            <label for="summary" class="">Summary</label>
            <textarea name="summary" id="summary" class="form-control" cols="30" rows="2">{{ Auth::guard('seeker')->user()->summary }}</textarea>
        </div>
    </div>
</div>

<!-- upload profile image modal  -->
<div class="modal" id="upload_profile">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crop Image And Upload</h4>
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="resizer_logo"></div>
                <button class="btn btn-block btn-dark" id="upload_profile_submit" > 
                Crop And Upload</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var el = document.getElementById('resizer_logo');
    $("#resume_img").on("change", function(event) {
        $("#upload_profile").modal('show');
        croppie = new Croppie(el, {
            viewport: {
                width: 200,
                height: 200,
                type: 'square'
            },
            boundary: {
                width: 250,
                height: 250
            }
        });
        getImage(event.target, croppie); 
    });
    
    function getImage(input, croppie) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {  
                croppie.bind({
                    url: e.target.result,
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#upload_profile_submit").on("click", function() {
        croppie.result('base64').then(function(base64) {
            $("#upload_profile").modal("hide"); 
            
            var formData = new FormData();
            formData.append("profile_image", base64ImageToBlob(base64));
            formData.append("seeker_id", {{ Auth::guard('seeker')->user()->id }})

            $.ajax({
                type        : 'POST',
                url         : "{{ route('seeker-profile-img.store') }}",
                data        : formData,
                processData : false,
                contentType : false,
                success     : function(response) {
                    if (response.status == "success") {
                        $('.resume_profile_img').attr('src', base64);
                        $('.profile-img-preview').removeClass('d-none');
                        $('.profile-remove-icon').removeClass('d-none');
                    }
                }
            });
            croppie.destroy();
        });
    });

    function base64ImageToBlob(str) {
        var pos = str.indexOf(';base64,');
        var type = str.substring(5, pos);
        var b64 = str.substr(pos + 8);

        var imageContent = atob(b64);
        
        var buffer = new ArrayBuffer(imageContent.length);
        var view = new Uint8Array(buffer);
      
        for (var n = 0; n < imageContent.length; n++) {
          view[n] = imageContent.charCodeAt(n);
        }
      
        var blob = new Blob([buffer], { type: type });
        
        return blob;
    }

    function removeProfileImage()
    {
        var formData = new FormData();
        formData.append("seeker_id", {{ Auth::guard('seeker')->user()->id }})

        $.ajax({
            type        : 'POST',
            url         : "{{ route('seeker-profile-img.destory') }}",
            data        : formData,
            processData : false,
            contentType : false,
            success     : function(response) {
                if (response.status == "success") {
                    $('.resume_profile_img').attr('src', 'https://placehold.jp/200x200.png');
                    $('.profile-img-preview').addClass('d-none');
                    $('.profile-remove-icon').addClass('d-none');
                }
            }
        });
    }

    $(document).ready(function() {

        $('#date_of_birth').datepicker({
            language: "es",
            autoclose: true,
            format: "dd-mm-yyyy",
        });

        $("#first_name").change(function(){
            $(".first_name").text($(this).val());
            $('.personal-info-preview').removeClass('d-none');
        })

        $("#last_name").change(function(){
            $(".last_name").text($(this).val());
            $('.personal-info-preview').removeClass('d-none');
        })

        $("#dob").change(function(){
            $(".dob").text($(this).val());
            $('.personal-info-preview').removeClass('d-none');
        })

        $("#phone").change(function(e){
            e.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : "{{ route('seeker-phone.store') }}",
                data        : {
                    'seeker_id' : {{ Auth::guard('seeker')->user()->id }},
                    'phone'     : $(this).val()
                },
                success     : function(response) {
                    if (response.status == "success") {
                        $(".phone").text(response.phone);
                        $('.personal-info-preview').removeClass('d-none');
                    }
                },
                error: function (data, response) {
                    var errors = $.parseJSON(data.responseText);
                    if(errors.errors['phone']) {
                        MSalert.principal({
                            icon:'error',
                            title:'',
                            description: errors.errors['phone'],
                        })
                    }
                }
            });
        })

        $("#gender").change(function(){
            $(".gender").text($(this).val());
            $('.personal-info-preview').removeClass('d-none');
            if($(this).val() == "Malw") {
                $(".gender_type").text('Mr.');
            }else {
                $(".gender_type").text('Ms.');
            }
        });

        $("#marital_status").change(function(){
            $(".marital_status").text($(this).val());
            $('.personal-info-preview').removeClass('d-none');
        })

        $("#nationality").change(function(){
            $(".nationality").text($(this).val());
            $('.personal-info-preview').removeClass('d-none');
            if($(this).val() == "Myanmar") {
                $("#nrc_field").removeClass('d-none');
                $("#id_card_field").addClass('d-none');
                $("#id_card").val('');
                $(".id_card").text('');
            }else {
                $("#nrc_field").addClass('d-none');
                $("#id_card_field").removeClass('d-none');
                $("#nrc").val('');
                $(".nrc").text('');
            }
        })

        $("#nrc").change(function(){
            $(".nrc").text($(this).val());
            $('.personal-info-preview').removeClass('d-none');
        })

        $("#id_card").change(function(){
            $(".id_card").text($(this).val());
            $('.personal-info-preview').removeClass('d-none');
        })

        $("#country").change(function(){
            $(".country").text($(this).val());
            $('.personal-info-preview').removeClass('d-none');
        })

        $("#state_id").change(function(){
            $(".state").text($(this).val()+',');
            $('.personal-info-preview').removeClass('d-none');
        })

        $("#township_id").change(function(){
            $(".township").text($(this).val()+',');
            $('.personal-info-preview').removeClass('d-none');
        })

        $("#address_detail").change(function(){
            $(".address_detail").text($(this).val());
            $('.personal-info-preview').removeClass('d-none');
        })

        $("#summary").change(function(){
            $(".career-description").text($(this).val());
            $('.career-description-preview').removeClass('d-none');
        })

        $("#email").change(function(e){
            e.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : "{{ route('seeker-email.store') }}",
                data        : {
                    'seeker_id' : {{ Auth::guard('seeker')->user()->id }},
                    'email'     : $(this).val()
                },
                success     : function(response) {
                    if (response.status == "success") {
                        $(".email").text(response.email);
                    }
                },
                error: function (data, response) {
                    var errors = $.parseJSON(data.responseText);
                    if(errors.errors['email']) {
                        MSalert.principal({
                            icon:'error',
                            title:'',
                            description: errors.errors['email'],
                        })
                    }
                }
            });
        })
    })
</script>
@endpush