<div class="container-fluid" id="edit-profile-header">
    <form action="{{ route('employer-profile.update', $employer->id) }}" method="post" enctype="multipart/form-data">
        <div class="px-5 m-0 pb-0 pt-5">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5>Employer Information</h5>
                    <span>Upload photos,profile information, social links and contact address details</span>
                </div>
                <div class="col-12 col-md-6 text-end">
                    <button type="submit" class="btn profile-save-btn">Update Profile and Save</button>
                </div>
            </div>
            <div class="py-3">
                @csrf 
                @method('put')
                
                <h5>Company Profile Photo</h5>
                <div class="row">
                    <div class="col-2">
                        <div class="py-3">
                            <span class="employer-image-text">Company Logo</span>
                        </div>
                        @if($employer->logo)
                        <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" class="img-responsive w-100 employer-logo" alt="employer-logo">
                        @else
                        <img src="https://placehold.jp/150x150.png" class="img-responsive w-100 employer-logo" alt="employer-logo">
                        @endif
                        <div class="py-3 text-center">
                            <label for="imageUpload" style="color: #696968">Tap to Change</label>
                            <input type="file" class="employer-logo-upload" name="logo" id="imageUpload" accept="image/*" />
                            <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(Auth::guard('employer')->user()->logo) @else d-none @endif employer-logo-remove"><i class="fa-solid fa-xmark"></i></button>
                            <input type="hidden" name="logoStatus" id="logoStatus" value="">
                        </div>
                    </div>
                    {{--<div class="col-8">
                        <div class="py-3">
                            <span class="employer-image-text">Company Background Photo</span>
                        </div>
                        <div>
                            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" class="img-responsive w-100" alt="">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="py-3">
                            <span class="employer-image-text">Company QR</span>
                        </div>
                        <div>
                            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" class="img-responsive w-100" alt="">
                        </div>
                    </div>--}}
                </div>
                <h5 class="py-3">Company Profile Information</h5>
                <div class="row">
                    <div class="col-6 form-group">
                        <label class="seeker_label" for="name">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control seeker_input" name="name" id="name" placeholder="Enter Company name" required value="{{ $employer->name }}">
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="email">Company Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control seeker_input" name="email" id="email" placeholder="Enter Company Email" required value="{{ $employer->email }}">
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control seeker_input" name="password" id="password" placeholder="Enter Password" value="">
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="ceo">CEO Name </label>
                        <input type="ceo" class="form-control seeker_input" name="ceo" id="ceo" placeholder="Enter CEO Name" value="{{ $employer->ceo }}">
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="industry_id">Choose Industry <span class="text-danger">*</span></label>
                        <select name="industry_id" id="industry_id" class="form-control seeker_input select_2" style="width:100%" required>
                            <option value=""></option>
                            @foreach ($industries as $industry)
                            <option value="{{ $industry->id }}" @if($industry->id == $employer->industry_id) selected @endif>{{ $industry->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="ownership_type_id">Choose Ownership Type <span class="text-danger">*</span></label>
                        <select name="ownership_type_id" id="ownership_type_id" class="form-control seeker_input select_2" style="width:100%" required>
                            <option value=""></option>
                            @foreach ($ownershipTypes as $ownershipType)
                            <option value="{{ $ownershipType->id }}" @if($ownershipType->id == $employer->ownership_type_id) selected @endif>{{ $ownershipType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="type_of_employer">Choose Type of Employer <span class="text-danger">*</span></label>
                        <select name="type_of_employer" id="type_of_employer" class="form-control seeker_input select_2" style="width:100%" required>
                            <option value=""></option>
                            @foreach (config('typeOfEmployer.value') as $typeofemployer)
                            <option value="{{ $typeofemployer }}" @if($typeofemployer == $employer->type_of_employer) selected @endif>{{ $typeofemployer }}</option>
                            @endforeach
                        </select>
                    </div>
                    <h5 class="py-3">Company Detail Information</h5>
                    <div class="form-group">
                        <label class="seeker_label" for="description"><strong>Description</strong></label>
                        <textarea class="summernote form-control" id="description" name="description">{!! $employer->description !!}</textarea>
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

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="website"><strong>Website</strong></label>
                        <input type="url" class="form-control seeker_input" id="website" name="website" placeholder="Enter Company Website" value="{{ $employer->website }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="established_in">Established In </label>
                        <select name="established_in" id="established_in" class="form-control seeker_input select_2" style="width:100%">
                            <option value=""></option>
                            @foreach (config('number.years') as $year)
                            <option value="{{ $year }}" @if($year == $employer->established_in) selected @endif>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="fax"><strong>Fax</strong></label>
                        <input type="text" class="form-control seeker_input" name="fax" id="fax" placeholder="Enter Fax" value="{{ $employer->fax }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="phone"><strong>Phone</strong></label>
                        <input type="text" class="form-control seeker_input" name="phone" id="phone" placeholder="Enter Phone" value="{{ $employer->phone }}" />
                    </div>
                    <h5 class="py-3">Company Social Link</h5>
                    <div class="col-6 form-group">
                        <label class="seeker_label" for="facebook"><strong>facebook</strong></label>
                        <input type="url" class="form-control seeker_input" name="facebook" id="facebook" placeholder="Enter Facebook" value="{{ $employer->facebook }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="twitter"><strong>Twitter</strong></label>
                        <input type="url" class="form-control seeker_input" name="twitter" id="twitter" placeholder="Enter Twitter" value="{{ $employer->twitter }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="linkedin"><strong>Linkedin</strong></label>
                        <input type="url" class="form-control seeker_input" name="linkedin" id="linkedin" placeholder="Enter Linkedin" value="{{ $employer->linkedin }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="instagram"><strong>Instagram</strong></label>
                        <input type="url" class="form-control seeker_input" name="instagram" id="instagram" placeholder="Enter Instagram" value="{{ $employer->instagram }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="youtube"><strong>Youtube</strong></label>
                        <input type="url" class="form-control seeker_input" name="youtube" id="youtube" placeholder="Enter Youtube" value="{{ $employer->youtube }}" />
                    </div>

                    
                    <h5 class="py-3">Company Address Detail</h5>
                    <div class="col-6 form-group">
                        <label class="seeker_label" for="state_id">Choose State </label>
                        <select name="state_id" id="state_id" class="form-control seeker_input select_2" style="width:100%">
                            <option value=""></option>
                            @foreach ($states as $state)
                            <option value="{{ $state->id }}" @if($state->id == $employer->state_id) selected @endif>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="township_id">Choose Township </label>
                        <select name="township_id" id="township_id" class="form-control seeker_input select_2" style="width:100%">
                            <option value=""></option>
                            @foreach ($townships as $township)
                            <option value="{{ $township->id }}" @if($township->id == $employer->township_id) selected @endif>{{ $township->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="seeker_label" for="address"><strong>Address</strong></label>
                        <input type="text" class="form-control seeker_input" id="address" name="address" value="{{ $employer->address }}" placeholder="Enter Company Address" />
                    </div>
                    <div class="col-6 form-group">
                        <label class="seeker_label" for="contact_person_name"><strong>Contact Person Name</strong></label>
                        <input type="text" class="form-control seeker_input" name="contact_person_name" id="contact_person_name" placeholder="Enter Contact Person Name" value="{{ $employer->contact_person_name }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="contact_person_phone"><strong>Contact Person Phone</strong></label>
                        <input type="text" class="form-control seeker_input" name="contact_person_phone" id="contact_person_phone" placeholder="Enter Contact Person Phone" value="{{ $employer->contact_person_phone }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="contact_person_email"><strong>Contact Person Email</strong></label>
                        <input type="email" class="form-control seeker_input" name="contact_person_email" id="contact_person_email" placeholder="Enter Contact Person Email" value="{{ $employer->contact_person_email }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label class="seeker_label" for="map"><strong>Google Map</strong></label>
                        <input type="text" class="form-control seeker_input" name="map" id="map" placeholder="Enter Google Map" value="{{ $employer->map }}" />
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
        $('.employer-logo').attr('src', 'https://placehold.jp/150x150.png');
        $('.employer-logo-remove').addClass('d-none');
        $('.employer-logo-upload').val('');
        $('#logoStatus').val('empty');
    })
</script>
@endpush