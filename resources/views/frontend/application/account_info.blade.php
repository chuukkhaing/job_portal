<div class="row">
    
    <div class="row col-12 col-lg-9">
        <div class="form-group col-12 col-lg-12">
            <label for="email" class="">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" onchange="updateProfile('email', this.value)" placeholder="Email">
            <small class="text-danger email-error"></small>
        </div>
        
        <div class="form-group col-12 col-lg-12">
            <label for="password" class="">Password <span class="text-danger">*</span></label>
            <input type="password" name="password" id="password" class="form-control" onchange="updateProfile('password', this.value)" value="" placeholder="password">
            <small class="text-danger password-error"></small>
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

    $("#email").change(function() {
        if($(this).val() != '' && $("#password").val() != '') {
            $.ajax({
                type        : 'POST',
                url         : "{{ route('application-register') }}",
                data        : {
                    'email' : $("#email").val(),
                    'password' : $("#password").val()
                },
                success     : function(response) {
                    $("#seeker_id").val(response.seeker.id);
                    $(".accordion-button").attr('disabled', false);
                    $("#email").attr('readonly', true);
                    $("#password").attr('readonly', true);
                    $(".tab-disable").attr('data-bs-toggle', 'tab');
                    $(".external-cv-download").attr('disabled', false);
                    
                    $(".external-cv-download-link").attr('action', window.location.origin + '/seeker/download-ic-cv/' + $("#seeker_id").val())
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
                }
            });
        }
    })
    $("#password").change(function() {
        if($(this).val() != '' && $("#email").val() != '') {
            $.ajax({
                type        : 'POST',
                url         : "{{ route('application-register') }}",
                data        : {
                    'email' : $("#email").val(),
                    'password' : $("#password").val()
                },
                success     : function(response) {
                    $("#seeker_id").val(response.seeker.id);
                    $(".accordion-button").attr('disabled', false);
                    $("#email").attr('readonly', true);
                    $("#password").attr('readonly', true);
                    $(".tab-disable").attr('data-bs-toggle', 'tab');
                    $(".external-cv-download").attr('disabled', false);
                    
                    $(".external-cv-download-link").attr('action', window.location.origin + '/seeker/download-ic-cv/' + $("#seeker_id").val())
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
                }
            });
        }
    })
    
</script>
@endpush