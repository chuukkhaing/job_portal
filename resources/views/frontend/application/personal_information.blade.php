<div class="row">
    <div class="col-6 col-lg-3">
        <div class="px-1">
            
            <div class="profile-remove-icon">
                <small>Profile Image </small>
                <a class="float-end dropdown btn" data-bs-toggle="dropdown" aria-expanded="false">
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
            
            <img src="https://placehold.jp/200x200.png" alt="Profile Image" class="img-thumbnail resume_profile_img" id="resume_profile_img">
            
        </label>
        <input type="file" name="resume_img" id="resume_img" accept="image/*">
    </div>
    <div class="row col-12 col-lg-9">
        <div class="form-group col-12 col-lg-6">
            <label for="first_name" class="">First Name <span class="text-danger">*</span></label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="" onchange="updatePersonalInfo('first_name', this.value)" placeholder="First Name">
        </div>
        <div class="form-group col-12 col-lg-6">
            <label for="last_name" class="">Last Name <span class="text-danger">*</span></label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="" onchange="updatePersonalInfo('last_name', this.value)" placeholder="Last Name">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12 col-lg-6">
            <label for="dob" class="">Date of Birth <span class="text-danger">*</span></label>
            <div class="datepicker date input-group" id="dob">
                
                <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" autocomplete="off" value="" onchange="updatePersonalInfo('date_of_birth', this.value)" placeholder="Date of Birth">
                
                <div class="input-group-append">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group col-12 col-lg-6">
            <label for="phone" class="">Phone <span class="text-danger">*</span></label>
            <input type="number" name="phone" id="phone" class="form-control " value="" placeholder="09xxxxxxxxx">
            <small class="text-danger phone-error"></small>
        </div>
        <div class="form-group col-12 col-lg-6">
            <label for="gender" class="">Gender  <span class="text-danger">*</span></label>
            <select name="gender" id="gender" class="form-control resume_select_2" style="width: 100%" onchange="updatePersonalInfo('gender', this.value)">
                <option value="">Choose</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="form-group col-12 col-lg-6">
            <label for="marital_status" class="">Marital Status</label>
            <select name="marital_status" id="marital_status" class="form-control resume_select_2" style="width: 100%" onchange="updatePersonalInfo('marital_status', this.value)">
                <option value="">Choose</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
            </select>
        </div>
        <div class="form-group col-12 col-lg-6">
            <label for="nationality" class="">Nationality <span class="text-danger">*</span></label>
            <select name="nationality" id="nationality" class="form-control resume_select_2" style="width: 100%" onchange="updatePersonalInfo('nationality', this.value)">
                <option value="">Choose</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-group col-12 col-lg-6" id="nrc_field">
            <label for="nrc" class="">NRC <span class="text-danger">*</span></label>
            <input type="text" name="nrc" id="nrc" class="form-control" value="" onchange="updatePersonalInfo('nrc', this.value)" placeholder="NRC">
        </div>

        <div class="form-group col-12 col-lg-6" id="id_card_field">
            <label for="id_card" class="">ID Card <span class="text-danger">*</span></label>
            <input type="text" name="id_card" id="id_card" class="form-control" value="" onchange="updatePersonalInfo('id_card', this.value)" placeholder="ID Card">
        </div>

        <div class="form-group col-12 col-lg-6">
            <label for="country" class="">Country <span class="text-danger">*</span></label>
            <select name="country" id="country" class="form-control select_2" style="width: 100%" onchange="updatePersonalInfo('country', this.value)">
                <option value="">Choose...</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group col-12 col-lg-6" id="state_id_field">
            <label for="state_id" class="">State or Region <span class="text-danger">*</span></label><br>
            <select name="state_id" id="state_id" class="select_2 form-control" style="width: 100%" onchange="updatePersonalInfo('state_id', this.value)">
                <option value="">Choose...</option>
                @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group col-12 col-lg-6" id="township_id_field">
            <label for="township_id" class="">City/ Township <span class="text-danger">*</span></label><br>
            <select name="township_id" id="township_id" class="select_2 form-control" style="width: 100%" onchange="updatePersonalInfo('township_id', this.value)">
                <option value="">Choose...</option>
                @foreach($townships as $township)
                <option value="{{ $township->id }}">{{ $township->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mt-1 col-12">
            <label for="address_detail" class="">Address Detail</label>
            <textarea name="address_detail" id="address_detail" class="form-control" cols="30" rows="2" onchange="updatePersonalInfo('address_detail', this.value)"></textarea>
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
    $(document).ready(function() {
        // onChange callback
        $('.summernote_resume').summernote({
            toolbar: [
                ['font', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']]
            ],
            callbacks: {
                
                onPaste: function (e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('text/html');
                    e.preventDefault();
                    var div = $('<div />');
                    div.append(bufferText);
                    div.find('*').removeAttr('style');
                    setTimeout(function () {
                        document.execCommand('insertHtml', false, div.html());
                    }, 10);
                    updatePersonalInfo('summary', div.html())
                },
                onChange: function(contents, $editable) {
                    updatePersonalInfo('summary', contents)
                }
            }
        });
    })
    
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
            formData.append("seeker_id", $("#seeker_id").val())

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
        formData.append("seeker_id", $("#seeker_id").val())

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

        $('#state_id').change(function(e){
            e.preventDefault();
            if($(this).val() != "") {
                var state_id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '/seeker/get-township/'+state_id,
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

        
        var init_state_name = $("#state_id :selected").text();
        if(init_state_name == 'Choose...') {
            $(".state").text('');
        }else {
            $(".state").text(init_state_name);
        }
    
        var init_township_name = $("#township_id :selected").text();
        if(init_township_name == 'Choose...') {
            $(".township").text('');
        }else {
            $(".township").text(init_township_name);
        }

        $('#dob').datepicker({
            language: "es",
            autoclose: true,
            format: "dd-mm-yyyy",
        });

        $("#phone").change(function(e){
            e.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : "{{ route('seeker-phone.store') }}",
                data        : {
                    'seeker_id' : $("#seeker_id").val(),
                    'phone'     : $(this).val()
                },
                success     : function(response) {
                    if (response.status == "success") {
                        $(".phone").text(response.phone);
                        if(response.phone) {
                            $('.phone_label').removeClass('d-none');
                        }else {
                            $('.phone_label').addClass('d-none');
                        }
                        $("#phone").removeClass('is-invalid');
                        $(".phone-error").text('')
                    }
                },
                error: function (data, response) {
                    var errors = $.parseJSON(data.responseText);
                    if(errors.errors['phone']) {
                        $("#phone").addClass('is-invalid');
                        $(".phone-error").text(errors.errors['phone'])
                        
                    }
                }
            });
        });
    })

    function updatePersonalInfo(name, value) {
        $.ajax({
            type        : 'POST',
            url         : "{{ route('seeker-resume.update') }}",
            data        : {
                'seeker_id' : $("#seeker_id").val(),
                'column'    : name,
                'value'     : value
            },
            success     : function(response) {
                if (response.status == "success") {
                    $('.'+name).text(value);
                    if(value == '') {
                        $('.'+name+'_label').addClass('d-none');
                    }else {
                        $('.'+name+'_label').removeClass('d-none');
                    }
                    if(name == "first_name" || name == "last_name") {
                        $(".name_label").removeClass('d-none');
                        if($(".first_name").text() == '' && $(".first_name").text() == '') {
                            $(".name_label").addClass('d-none');
                        }
                    }
                    if(name == "gender") {
                        if(value == "Male") {
                            $(".gender_type").text('Mr.');
                        }else if(value == "Female") {
                            $(".gender_type").text('Ms.');
                        }else {
                            $(".gender_type").text('');
                        }
                    }

                    if(name == "nationality") {
                        if(value == "Myanmar") {
                            $("#nrc_field").removeClass('d-none');
                            $("#id_card_field").addClass('d-none');
                            $("#id_card").val('');
                            updatePersonalInfo('id_card', '')
                            $(".id_card").text('');
                        }else {
                            $("#nrc_field").addClass('d-none');
                            $("#id_card_field").removeClass('d-none');
                            $("#nrc").val('');
                            updatePersonalInfo('nrc', '')
                            $(".nrc").text('');
                        }
                    }

                    if(name == "country") {
                        if(value == "Myanmar") {
                            $("#state_id_field").removeClass('d-none');
                            $("#township_id_field").removeClass('d-none');
                        }else {
                            $("#state_id_field").addClass('d-none');
                            $("#township_id_field").addClass('d-none');
                            $("#state_id").val('').change();
                            $("#township_id").val('').change();
                            updatePersonalInfo('state_id', '');
                            updatePersonalInfo('township_id', '')
                            $(".state").text('');
                            $(".township").text('');
                        }
                    }

                    if(name == "state_id") {
                        var state_name = $("#state_id :selected").text();
                        if(state_name == 'Choose...' || state_name == 'Choose') {
                            $('.state_label').addClass('d-none');
                            $(".state").text('');
                        }else {
                            $('.state_label').removeClass('d-none');
                            $(".state").text(state_name);
                        }
                        updatePersonalInfo('township_id', '')
                        $("#township_id").val('').change();
                        $(".township").text('');
                    }
                    if(name == "township_id") {
                        var township_name = $("#township_id :selected").text();
                        if(township_name == 'Choose...' || township_name == 'Choose' || township_name == '') {
                            $('.township_label').addClass('d-none');
                            $(".township").text('');
                        }else {
                            $('.township_label').removeClass('d-none');
                            $(".township").text(township_name);
                        }
                    }

                    if(name == "summary"){
                        
                        $(".summary").html(value);
                        $('.summary_label').removeClass('d-none');
                    }

                    if(name == "summary" && value == ""){
                        $(".summary").text(value);
                        $('.summary_label').addClass('d-none');
                    }

                    if($('.resume-separater').height() > $('page').height()) {
                        let content = $('page').html();
                        $('page').html('');

                        let currentDiv;

                        content.split('<div>').forEach(word => {
                            if (!currentDiv) {
                                currentDiv = document.createElement('page');
                                $('.resume-template-background').append(currentDiv);
                            }

                            // Append words to the current div
                            
                            currentDiv.append(word)

                            // Check the height and create a new div if needed
                            if (currentDiv.clientHeight > $('page').height()) {
                                currentDiv = null; // Reset the current div
                            }
                        });
                    }
                    
                }
            },
            error: function (data, response) {
                var errors = $.parseJSON(data.responseText);
                if(errors.errors[value]) {
                    MSalert.principal({
                        icon:'error',
                        title:'Error',
                        description: errors.errors[value],
                    })
                }
            }
        });
    }
</script>
@endpush