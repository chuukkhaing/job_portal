<div class="container-fluid bg-light" id="edit-profile-header">
    <form action="{{ route('employer-profile.update', $employer->id) }}" method="post" enctype="multipart/form-data">
        <div class="px-5 m-0 pb-0 pt-5">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-dark">Edit Company Information</h5>
                </div>
                <div class="col-12 col-md-6 text-end">
                    <button type="submit" class="btn profile-save-btn">Update Profile and Save</button>
                </div>
            </div>
            
            <div class="py-3">
                @csrf 
                @method('put')
                <div class="row">
                    <div class="col-1">
                        <div class="step">
                            Step 1
                        </div>
                    </div>
                    <div class="col-11">
                        <div class="py-2">
                            <h5>Account Information</h5>
                            <span>Fill company email and password</span>
                        </div>
                        <div class="py-2">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Users</th>
                                            <th>Status</th>
                                            <th>Access</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $employer->email }}</td>
                                            <td>{{ $employer->is_active }}</td>
                                            <td>Admin</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <div class="step">
                            Step 2
                        </div>
                    </div>
                    <div class="col-11">
                        <div class="py-2">
                            <h5>Employer Information</h5>
                            <span>Upload photos,profile information, social links and contact address details</span>
                        </div>
                        <h5 class="py-2">Company Profile Photo</h5>
                        <div class="row">
                            <div class="col-2">
                                <div class="py-3">
                                    <span class="employer-image-text">Company Logo</span> <span style="color: #696968">120 x 120</span>
                                </div>
                                @if($employer->logo)
                                <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" class="img-responsive w-100 employer-logo" alt="employer-logo">
                                @else
                                <img src="https://placehold.jp/120x120.png" class="img-responsive w-100 employer-logo" alt="employer-logo">
                                @endif
                                <div class="py-3 text-center">
                                    <label for="imageUpload" style="color: #696968">Tap to Change</label>
                                    <input type="file" class="employer-logo-upload" name="logo" id="imageUpload" accept="image/*" />
                                    <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(Auth::guard('employer')->user()->logo) @else d-none @endif employer-logo-remove"><i class="fa-solid fa-xmark"></i></button>
                                    <input type="hidden" name="logoStatus" id="logoStatus" value="">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="py-3">
                                    <span class="employer-image-text">Company Background Photo</span> <span style="color: #696968">1903 x 950</span>
                                </div>
                                @if($employer->background)
                                <img src="{{ asset('storage/employer_background/'.$employer->background) }}" class="img-responsive w-100 employer-background" height="200px" alt="employer-background">
                                @else
                                <img src="https://placehold.jp/1903x950.png" class="img-responsive w-100 employer-background" alt="employer-background" height="200px">
                                @endif
                                <div class="py-3 text-center">
                                    <label for="backgroundUpload" style="color: #696968">Tap to Change</label>
                                    <input type="file" class="employer-background-upload" name="background" id="backgroundUpload" accept="image/*" />
                                    <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(Auth::guard('employer')->user()->background) @else d-none @endif employer-background-remove"><i class="fa-solid fa-xmark"></i></button>
                                    <input type="hidden" name="backgroundStatus" id="backgroundStatus" value="">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="py-3">
                                    <span class="employer-image-text">Company QR</span>
                                </div>
                                @if($employer->qr)
                                <img src="{{ asset('storage/employer_qr/'.$employer->qr) }}" class="img-responsive w-100 employer-qr" alt="employer-qr">
                                @else
                                <img src="https://placehold.jp/120x120.png" class="img-responsive w-100 employer-qr" alt="employer-qr">
                                @endif
                                <div class="py-3 text-center">
                                    <label for="qrUpload" style="color: #696968">Tap to Change</label>
                                    <input type="file" class="employer-qr-upload" name="qr" id="qrUpload" accept="image/*" />
                                    <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(Auth::guard('employer')->user()->qr) @else d-none @endif employer-qr-remove"><i class="fa-solid fa-xmark"></i></button>
                                    <input type="hidden" name="qrStatus" id="qrStatus" value="">
                                </div>
                            </div>
                            <h5 class="py-3">Company Profile Information</h5>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label class="seeker_label" for="name">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control seeker_input" name="name" id="name" placeholder="Enter Company name" required value="{{ $employer->name }}">
                                </div>

                                <div class="col-6 form-group">
                                    <label class="seeker_label" for="industry_id">Industry <span class="text-danger">*</span></label>
                                    <select name="industry_id" id="industry_id" class="form-control seeker_input select_2" style="width:100%" required>
                                        <option value=""></option>
                                        @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}" @if($industry->id == $employer->industry_id) selected @endif>{{ $industry->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6 form-group">
                                    <label class="seeker_label" for="ownership_type_id">Ownership Type <span class="text-danger">*</span></label>
                                    <select name="ownership_type_id" id="ownership_type_id" class="form-control seeker_input select_2" style="width:100%" required>
                                        <option value=""></option>
                                        @foreach ($ownershipTypes as $ownershipType)
                                        <option value="{{ $ownershipType->id }}" @if($ownershipType->id == $employer->ownership_type_id) selected @endif>{{ $ownershipType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6 form-group">
                                    <label class="seeker_label" for="type_of_employer">Type of Employer <span class="text-danger">*</span></label>
                                    <select name="type_of_employer" id="type_of_employer" class="form-control seeker_input select_2" style="width:100%" required>
                                        <option value=""></option>
                                        @foreach (config('typeOfEmployer.value') as $typeofemployer)
                                        <option value="{{ $typeofemployer }}" @if($typeofemployer == $employer->type_of_employer) selected @endif>{{ $typeofemployer }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <h5 class="py-3">Company Detail Information</h5>

                                <div class="col-6 form-group">
                                    <label class="seeker_label" for="phone"><strong>Phone No.</strong></label>
                                    <input type="text" class="form-control seeker_input" name="phone" id="phone" placeholder="Enter Phone" value="{{ $employer->phone }}" />
                                </div>

                                <div class="col-6 form-group">
                                    <label class="seeker_label" for="website"><strong>Website URL</strong></label>
                                    <input type="url" class="form-control seeker_input" id="website" name="website" placeholder="Enter Company Website" value="{{ $employer->website }}" />
                                </div>

                                <div class="col-6 form-group">
                                    <label class="seeker_label" for="no_of_offices">Number of Offices </label>
                                    <select name="no_of_offices" id="no_of_offices" class="form-control seeker_input select_2" style="width:100%">
                                        <option value=""></option>
                                        @foreach (config('number.offices') as $office)
                                        <option value="{{ $office }}" @if($office == $employer->no_of_offices) selected @endif>{{ $office }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6 form-group">
                                    <label class="seeker_label" for="no_of_employees">Number of Employees </label>
                                    <select name="no_of_employees" id="no_of_employees" class="form-control seeker_input select_2" style="width:100%">
                                        <option value=""></option>
                                        @foreach (config('number.employees') as $employee)
                                        <option value="{{ $employee }}" @if($employee == $employer->no_of_employees) selected @endif>{{ $employee }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <h5 class="py-3">Company Address Detail</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered employer-address @if($employer->EmployerAddress->count() > 0) @else d-none @endif">
                                        <thead>
                                            <tr>
                                                <th>Country</th>
                                                <th>State</th>
                                                <th>Township</th>
                                                <th>Address Detail</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($employer->EmployerAddress as $address)
                                            <tr class="address-tr-{{ $address->id }}">
                                                <td>{{ $address->country }}</td>
                                                <td>{{ $address->State->name ?? '-' }}</td>
                                                <td>{{ $address->Township->name ?? '-' }}</td>
                                                <td>{{ $address->address_detail ?? '-' }}</td>
                                                <td><a onclick="deleteAddress({{ $address->id }})" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group col-6">
                                    <label for="country" class="seeker_label">Country </label>
                                    <select name="country" id="country_address" class="form-control seeker_input" style="width: 100%">
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <small class="text-danger d-none error-country">Need to Choose Country</small>
                                </div>

                                <div class="form-group col-6">
                                    <label for="address_detail" class="seeker_label">Address Detail</label>
                                    <textarea name="address_detail" id="address_detail" class="form-control seeker_input" cols="30" rows="2"></textarea>
                                </div>

                                <div class="form-group col-6" id="state_id_field">
                                    <label for="state_id" class="seeker_label">State or Region </label><br>
                                    <select name="state_id" id="state_id" class="select_2 form-control seeker_input" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger d-none error-state">Need to Choose State</small>
                                </div>
                                <div class="col-6">
                                    <a id="addNewAddress" onclick="addNewAddress()" class="btn btn-outline-primary float-end rounded-3"><i class="fa-solid fa-plus"></i> Add New Address</a>
                                </div>
                                <div class="form-group col-6" id="township_id_field">
                                    <label for="township_id" class="seeker_label">City/ Township </label><br>
                                    <select name="township_id" id="township_id" class="select_2 form-control seeker_input" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach($townships as $township)
                                        <option value="{{ $township->id }}">{{ $township->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger d-none error-township">Need to Choose Township</small>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <div class="step">
                            Step 3
                        </div>
                    </div>
                    <div class="col-11">
                        <div class="row">
                            <div class="col-9">
                                <div class="py-2">
                                    <h5>Add Testimonials to Elevate Your Profile</h5>
                                    <span>Discover how incorporating testimonials can enhance your profile, showcasing your credibility and building trust with potential clients or employers.</span>
                                </div>
                            </div>
                            <div class="col-3">
                                <a onclick="addTestimonial()" class="btn btn-primary float-end text-light"><i class="fa-solid fa-plus"></i> Add</a>
                            </div>
                        </div>
                        <div class="py-2">
                            <div class="row" style="background: #F5F9FF; border: 1px solid #E8EFF7">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
    $('.employer-logo-upload').change(function() {
        var employer_logo = '.employer-logo';
        readURL(this, employer_logo);
    });

    function readURL(input, employer_logo) {
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(employer_logo).attr('src', e.target.result);
            $('.employer-logo-remove').removeClass('d-none');
            $('#logoStatus').val('');
        };
        reader.readAsDataURL(input.files[0]);
        }
    }

    $('.employer-logo-remove').click(function() {
        $('.employer-logo').attr('src', 'https://placehold.jp/120x120.png');
        $('.employer-logo-remove').addClass('d-none');
        $('.employer-logo-upload').val('');
        $('#logoStatus').val('empty');
    })

    $('.employer-background-upload').change(function() {
        var employer_background = '.employer-background';
        readBackgroundURL(this, employer_background);
    });

    function readBackgroundURL(input, employer_background) {
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(employer_background).attr('src', e.target.result);
            $('.employer-background-remove').removeClass('d-none');
            $('#backgroundStatus').val('');
        };
        reader.readAsDataURL(input.files[0]);
        }
    }

    $('.employer-background-remove').click(function() {
        $('.employer-background').attr('src', 'https://placehold.jp/1903x950.png');
        $('.employer-background-remove').addClass('d-none');
        $('.employer-background-upload').val('');
        $('#backgroundStatus').val('empty');
    })

    $('.employer-qr-upload').change(function() {
        var employer_qr = '.employer-qr';
        readQRURL(this, employer_qr);
    });

    function readQRURL(input, employer_qr) {
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(employer_qr).attr('src', e.target.result);
            $('.employer-qr-remove').removeClass('d-none');
            $('#qrStatus').val('');
        };
        reader.readAsDataURL(input.files[0]);
        }
    }

    $('.employer-qr-remove').click(function() {
        $('.employer-qr').attr('src', 'https://placehold.jp/1903x950.png');
        $('.employer-qr-remove').addClass('d-none');
        $('.employer-qr-upload').val('');
        $('#qrStatus').val('empty');
    })

    function addNewAddress() {
        var country = $("#country_address").val();
        var state = $("#state_id").val();
        var township = $("#township_id").val();
        var address_detail = $("#address_detail").val();

        if(country == null)
        {
            $('.error-country').removeClass('d-none');
        }else {
            $('.error-country').addClass('d-none');
        }
        if(country == 'Myanmar') {
            if(state == '') {
                $('.error-state').removeClass('d-none');
            }else {
                $('.error-state').addClass('d-none');
            }

            if(township == '') {
                $('.error-township').removeClass('d-none');
            }else {
                $('.error-township').addClass('d-none');
            }
            if(country != null && state != '' && township != '') {
                $.ajax({
                    type: 'POST',
                    data: {
                        'country' : country,
                        'state_id' : state,
                        'township_id' : township,
                        'address_detail' : address_detail,
                        'employer_id' : {{ Auth::guard("employer")->user()->id }}
                    },
                    url: '{{ route("employer-address.store") }}',
                }).done(function(response){
                    if(response.status = 'success') {
                        $('.employer-address').removeClass('d-none');
                        var addressDetail = '';
                        if(response.data.address_detail == null ) {
                            addressDetail = '-';
                        }else {
                            addressDetail = response.data.address_detail;
                        }
                        $('.employer-address').append('<tr class="address-tr-'+response.data.id+'"><td>'+response.data.country+'</td><td>'+response.data.state_name+'</td><td>'+response.data.township_name+'</td><td>'+addressDetail+'</td><td><a onclick="deleteAddress('+response.data.id+')" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                        $("#country_address").val('');
                        $("#state_id").val('');
                        $("#township_id").val('');
                        $("#address_detail").val('');
                        $('.error-state').addClass('d-none');
                        $('.error-township').addClass('d-none');
                        $('.error-country').addClass('d-none');
                        $("#state_id_field").removeClass('d-none');
                        $("#township_id_field").removeClass('d-none');
                    }
                })
            }else {
                $('.error-state').removeClass('d-none');
                $('.error-township').removeClass('d-none');
                $('.error-country').removeClass('d-none');
            }
        }
        else {
            
            if(country != null) {
                $.ajax({
                    type: 'POST',
                    data: {
                        'country' : country,
                        'state_id' : state,
                        'township_id' : township,
                        'address_detail' : address_detail,
                        'employer_id' : {{ Auth::guard("employer")->user()->id }}
                    },
                    url: '{{ route("employer-address.store") }}',
                }).done(function(response){
                    if(response.status = 'success') {
                        $('.employer-address').removeClass('d-none');
                        var addressDetail = '';
                        if(response.data.address_detail == null ) {
                            addressDetail = '-';
                        }else {
                            addressDetail = response.data.address_detail;
                        }
                        $('.employer-address').append('<tr class="address-tr-'+response.data.id+'"><td>'+response.data.country+'</td><td>-</td><td>-</td><td>'+addressDetail+'</td><td><a onclick="deleteAddress('+response.data.id+')" class="btn border-0 text-danger"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                        $("#country_address").val('');
                        $("#state_id").val('');
                        $("#township_id").val('');
                        $("#address_detail").val('');
                        $('.error-state').addClass('d-none');
                        $('.error-township').addClass('d-none');
                        $('.error-country').addClass('d-none');
                        $("#state_id_field").removeClass('d-none');
                        $("#township_id_field").removeClass('d-none');
                    }
                })
            }else {
                $('.error-state').removeClass('d-none');
                $('.error-township').removeClass('d-none');
                $('.error-country').removeClass('d-none');
            }
        }
    }

    $("#country_address").change(function() {
        if($(this).val() == "Myanmar") {
            $("#state_id_field").removeClass('d-none');
            $("#township_id_field").removeClass('d-none');
        }else {
            $("#state_id_field").addClass('d-none');
            $("#township_id_field").addClass('d-none');
        }
    })

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

    function deleteAddress(id)
    {
        $.ajax({
            type: 'POST',
            data: {
                'employer_id' : {{ Auth::guard("employer")->user()->id }}
            },
            url: 'employer-address/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                $(".address-tr-"+id).empty();
                if(response.address_count == 0) {
                    $(".employer-address").addClass('d-none');
                }
                alert(response.msg)
            }
        })
    }
</script>
@endpush