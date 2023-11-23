<div class="row">
    
    <div class="row col-12 col-lg-9">
        
        <div class="my-2">
            <div class="form-group input-group register-form-input p-1 mb-0">
                <div class="input-group-prepend d-flex">
                    <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                </div>
                <input type="email" name="email" id="email" class="form-control border-0" onchange="updateProfile('email', this.value)" placeholder="Email" value="{{ old('email') }}">
            </div>

            <small class="text-danger email-error"></small>
        </div>
        <div class="my-2">
            <div class="form-group input-group register-form-input p-1 mb-0">
                <div class="input-group-prepend d-flex">
                    <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-lock"></i> </span>
                </div>
                <input class="form-control border-0" onchange="updateProfile('password', this.value)" placeholder="Password" type="password" name="password" id="password"><i style="cursor: pointer" id="seeker-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showSeekerPassword()"></i>
            </div>

            <small class="text-danger password-error"></small>
        </div>
        <div class="my-2">
            <div class="form-group input-group register-form-input p-1 mb-0">
                <div class="input-group-prepend d-flex">
                    <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                </div>
                <input class="form-control border-0" placeholder="Confirm Password" type="password" name="confirmed" id="confirmPassword"><i style="cursor: pointer" id="seeker-confirm-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showSeekerConfirmPassword()"></i>
            </div>  
            <small class="text-danger confirmed-error"></small>
        </div>
        <input type="hidden" name="seeker_id" id="seeker_id" value="">
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

    function updateProfile(name, value) {
        $("."+name+"_label").removeClass("d-none");
        $('.'+name).text(value);
    }

    $("#email").change(function(e) {
        event.stopImmediatePropagation();
        if($(this).val() != '' && $("#password").val() != '' && $("#confirmPassword").val() != '') {
            $.ajax({
                type        : 'POST',
                url         : "{{ route('application-register') }}",
                data        : {
                    'email' : $("#email").val(),
                    'password' : $("#password").val(),
                    'confirmed' : $("#confirmPassword").val()
                },
                success     : function(response) {
                    $("#seeker_id").val(response.seeker.id);
                    $(".accordion-button").attr('disabled', false);
                    $("#email").attr('readonly', true);
                    $("#password").attr('readonly', true);
                    $("#confirmPassword").attr('readonly', true);
                    $(".tab-disable").attr('data-bs-toggle', 'tab');
                    $(".external-cv-download").attr('disabled', false);
                    
                    $(".external-cv-download-link").attr('action', window.location.origin + '/seeker/download-ic-cv/' + $("#seeker_id").val())

                    $("#password").removeClass('is-invalid');
                    $('.password-error').text('')
                
                    $("#email").removeClass('is-invalid')
                    $('.email-error').text('')
                
                    $("#confirmPassword").removeClass('is-invalid')
                    $('.confirmed-error').text('')

                    $(".account_info").addClass('collapsed');
                    $(".personal_info").removeClass('collapsed');

                    $(".account_info_collapse").removeClass('show');
                    $(".personal_info_collapse").addClass('show');

                    MSalert.principal({
                        icon:'success',
                        title:'Success',
                        description:response.msg,
                    })
                },
                error: function (data, response) {
                    var errors = $.parseJSON(data.responseText);
                    if(errors.errors['password']) {
                        $("#password").addClass('is-invalid');
                        $('.password-error').text(errors.errors['password'])
                    }
                    if(errors.errors['email']) {
                        $("#email").addClass('is-invalid')
                        $('.email-error').text(errors.errors['email'])
                    }
                    if(errors.errors['confirmed']) {
                        $("#confirmPassword").addClass('is-invalid')
                        $('.confirmed-error').text(errors.errors['confirmed'])
                    }
                }
            });
        }
    })
    $("#password").change(function(e) {
        event.stopImmediatePropagation();
        if($(this).val() != '' && $("#email").val() != '' && $("#confirmPassword").val() != '') {
            $.ajax({
                type        : 'POST',
                url         : "{{ route('application-register') }}",
                data        : {
                    'email' : $("#email").val(),
                    'password' : $("#password").val(),
                    'confirmed' : $("#confirmPassword").val()
                },
                success     : function(response) {
                    $("#seeker_id").val(response.seeker.id);
                    $(".accordion-button").attr('disabled', false);
                    $("#email").attr('readonly', true);
                    $("#password").attr('readonly', true);
                    $("#confirmPassword").attr('readonly', true);
                    $(".tab-disable").attr('data-bs-toggle', 'tab');
                    $(".external-cv-download").attr('disabled', false);
                    
                    $(".external-cv-download-link").attr('action', window.location.origin + '/seeker/download-ic-cv/' + $("#seeker_id").val())
                    
                    $("#password").removeClass('is-invalid');
                    $('.password-error').text('')
                
                    $("#email").removeClass('is-invalid')
                    $('.email-error').text('')
                
                    $("#confirmPassword").removeClass('is-invalid')
                    $('.confirmed-error').text('')

                    $(".account_info").addClass('collapsed');
                    $(".personal_info").removeClass('collapsed');

                    $(".account_info_collapse").removeClass('show');
                    $(".personal_info_collapse").addClass('show');
                    
                    MSalert.principal({
                        icon:'success',
                        title:'Success',
                        description:response.msg,
                    })
                },
                error: function (data, response) {
                    var errors = $.parseJSON(data.responseText);
                    if(errors.errors['password']) {
                        $("#password").addClass('is-invalid');
                        $('.password-error').text(errors.errors['password'])
                    }
                    if(errors.errors['email']) {
                        $("#email").addClass('is-invalid')
                        $('.email-error').text(errors.errors['email'])
                    }
                    if(errors.errors['confirmed']) {
                        $("#confirmPassword").addClass('is-invalid')
                        $('.confirmed-error').text(errors.errors['confirmed'])
                    }
                }
            });
        }
    })
    $("#confirmPassword").change(function(e) {
        event.stopImmediatePropagation();
        if($(this).val() != '' && $("#email").val() != '' && $("#confirmPassword").val() != '') {
            $.ajax({
                type        : 'POST',
                url         : "{{ route('application-register') }}",
                data        : {
                    'email' : $("#email").val(),
                    'password' : $("#password").val(),
                    'confirmed' : $("#confirmPassword").val()
                },
                success     : function(response) {
                    $("#seeker_id").val(response.seeker.id);
                    $(".accordion-button").attr('disabled', false);
                    $("#email").attr('readonly', true);
                    $("#password").attr('readonly', true);
                    $("#confirmPassword").attr('readonly', true);
                    $(".tab-disable").attr('data-bs-toggle', 'tab');
                    $(".external-cv-download").attr('disabled', false);
                    
                    $(".external-cv-download-link").attr('action', window.location.origin + '/seeker/download-ic-cv/' + $("#seeker_id").val())
                    
                    $("#password").removeClass('is-invalid');
                    $('.password-error').text('')
                
                    $("#email").removeClass('is-invalid')
                    $('.email-error').text('')
                
                    $("#confirmPassword").removeClass('is-invalid')
                    $('.confirmed-error').text('')

                    $(".account_info").addClass('collapsed');
                    $(".personal_info").removeClass('collapsed');

                    $(".account_info_collapse").removeClass('show');
                    $(".personal_info_collapse").addClass('show');
                    
                    MSalert.principal({
                        icon:'success',
                        title:'Success',
                        description:response.msg,
                    })
                },
                error: function (data, response) {
                    var errors = $.parseJSON(data.responseText);
                    if(errors.errors['password']) {
                        $("#password").addClass('is-invalid');
                        $('.password-error').text(errors.errors['password'])
                    }
                    if(errors.errors['email']) {
                        $("#email").addClass('is-invalid')
                        $('.email-error').text(errors.errors['email'])
                    }
                    if(errors.errors['confirmed']) {
                        $("#confirmPassword").addClass('is-invalid')
                        $('.confirmed-error').text(errors.errors['confirmed'])
                    }
                }
            });
        }
    })
    
    function showSeekerPassword() {
        var seekerPassword = document.getElementById("password");
        if (seekerPassword.type === "password") {
            seekerPassword.type = "text";
            $("#seeker-password-eye").removeClass('bi-eye-slash');
            $("#seeker-password-eye").addClass('bi-eye');
        } else {
            seekerPassword.type = "password";
            $("#seeker-password-eye").addClass('bi-eye-slash');
            $("#seeker-password-eye").removeClass('bi-eye');
        }
    }

    function showSeekerConfirmPassword() {
        var seekerConfirmPassword = document.getElementById("confirmPassword");
        if (seekerConfirmPassword.type === "password") {
            seekerConfirmPassword.type = "text";
            $("#seeker-confirm-password-eye").removeClass('bi-eye-slash');
            $("#seeker-confirm-password-eye").addClass('bi-eye');
        } else {
            seekerConfirmPassword.type = "password";
            $("#seeker-confirm-password-eye").addClass('bi-eye-slash');
            $("#seeker-confirm-password-eye").removeClass('bi-eye');
        }
    }
</script>
@endpush