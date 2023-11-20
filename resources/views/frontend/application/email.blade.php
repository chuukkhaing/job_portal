<div class="row">
    
    <div class="row col-12 col-lg-9">
        <div class="form-group col-12 col-lg-12">
            <label for="email" class="">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" onchange="updateProfile('email', this.value)" placeholder="Email">
            <small class="text-danger email-error"></small>
        </div>
        
        <div class="form-group col-12 col-lg-12">
            <label for="phone" class="">Phone <span class="text-danger">*</span></label>
            <input type="number" name="phone" id="phone" class="form-control" onchange="updateProfile('phone', this.value)" value="{{ old('phone') }}" placeholder="09xxxxxxxxx">
            <small class="text-danger phone-error"></small>
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
        $('.'+name).text(value);
    }

    $("#email").change(function() {
        if($(this).val() != '' && $("#phone").val() != '') {
            $.ajax({
                type        : 'POST',
                url         : "{{ route('application-register') }}",
                data        : {
                    'email' : $("#email").val(),
                    'phone' : $("#phone").val()
                },
                success     : function(response) {
                    
                },
                error: function (data, response) {
                    var errors = $.parseJSON(data.responseText);
                    if(errors.errors['phone']) {
                        $("#phone").addClass('is-invalid');
                        $('.phone-error').text(errors.errors['phone'])
                    }
                    if(errors.errors['email']) {
                        $("#email").addClass('is-invalid')
                        $('.email-error').text(errors.errors['email'])
                    }
                }
            });
        }
    })
    $("#phone").change(function() {
        if($(this).val() != '' && $("#email").val() != '') {
            $.ajax({
                type        : 'POST',
                url         : "{{ route('application-register') }}",
                data        : {
                    'email' : $("#email").val(),
                    'phone' : $("#phone").val()
                },
                success     : function(response) {
                    $("#seeker_id").val(response.seeker.id)
                },
                error: function (data, response) {
                    var errors = $.parseJSON(data.responseText);
                    if(errors.errors['phone']) {
                        $("#phone").addClass('is-invalid');
                        $('.phone-error').text(errors.errors['phone'])
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