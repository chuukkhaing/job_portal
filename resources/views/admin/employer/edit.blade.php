@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Employers</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Employer Edit</h6>
            <div class="col">
                <a href="{{ route('employers.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('employers.update', $employer->id) }}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('put')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="logo-upload form-group">
                    <div class="logo-edit">
                        <input type="file" class="form-control" name="logo" id="imageUpload" accept="image/*" />
                        <label for="imageUpload"></label>
                    </div>
                    <div class="logo-remove">
                        <label for="imageRemove"></label>
                    </div>
                    <div class="logo-preview">
                        @if($employer->logo)
                        <div id="imagePreview" style="background-image: url({{url('storage/employer_logo/'.$employer->logo)}});">
                        @else
                        <div id="imagePreview" style="background-image: url(https://placehold.jp/150x150.png);">
                        @endif
                        </div>
                    </div>
                    <input type="hidden" name="imageRemove" value="" id="imageRemove">
                </div>
                
                <div class="row">
                    <div class="col-6 form-group">
                        <label for="name">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Company name" required value="{{ $employer->name }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="email">Company Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Company Email" required value="{{ $employer->email }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="">
                    </div>

                    <div class="col-6 form-group">
                        <label for="ceo">CEO Name </label>
                        <input type="ceo" class="form-control" name="ceo" id="ceo" placeholder="Enter CEO Name" value="{{ $employer->ceo }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="industry_id">Choose Industry <span class="text-danger">*</span></label>
                        <select name="industry_id" id="industry_id" class="form-control select_2" required>
                            <option value=""></option>
                            @foreach ($industries as $industry)
                            <option value="{{ $industry->id }}" @if($industry->id == $employer->industry_id) selected @endif>{{ $industry->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label for="ownership_type_id">Choose Ownership Type <span class="text-danger">*</span></label>
                        <select name="ownership_type_id" id="ownership_type_id" class="form-control select_2" required>
                            <option value=""></option>
                            @foreach ($ownershipTypes as $ownershipType)
                            <option value="{{ $ownershipType->id }}" @if($ownershipType->id == $employer->ownership_type_id) selected @endif>{{ $ownershipType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4 form-group">
                        <label for="type_of_employer">Choose Type of Employer <span class="text-danger">*</span></label>
                        <select name="type_of_employer" id="type_of_employer" class="form-control select_2" required>
                            <option value=""></option>
                            @foreach (config('typeOfEmployer.value') as $typeofemployer)
                            <option value="{{ $typeofemployer }}" @if($typeofemployer == $employer->type_of_employer) selected @endif>{{ $typeofemployer }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4 form-group">
                        <label for="package_id">Choose Package </label>
                        <select name="package_id" id="package_id" class="form-control select_2">
                            <option value=""></option>
                            @foreach ($packages as $package)
                            <option value="{{ $package->id }}" @if($package->id == $employer->package_id) selected @endif>{{ $package->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4 form-group">
                        <label for="package_start_date">Package Effective Date <span class="text-danger package_start_date_required d-none">*</span></label>
                        <input type="date" class="form-control" name="package_start_date" id="package_start_date" placeholder="Package Effective Date" value="{{ $employer->package_start_date }}">
                    </div>

                    <div class="form-group">
                        <label for="description"><strong>Description</strong></label>
                        <textarea class="summernote form-control" id="description" name="description">{!! $employer->description !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="address"><strong>Address</strong></label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $employer->address }}" placeholder="Enter Company Address" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="no_of_offices">Number of Offices </label>
                        <select name="no_of_offices" id="no_of_offices" class="form-control select_2">
                            <option value=""></option>
                            @foreach (config('number.offices') as $office)
                            <option value="{{ $office }}" @if($office == $employer->no_of_offices) selected @endif>{{ $office }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label for="no_of_employees">Number of Employees </label>
                        <select name="no_of_employees" id="no_of_employees" class="form-control select_2">
                            <option value=""></option>
                            @foreach (config('number.employees') as $employee)
                            <option value="{{ $employee }}" @if($employee == $employer->no_of_employees) selected @endif>{{ $employee }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label for="website"><strong>Website</strong></label>
                        <input type="url" class="form-control" id="website" name="website" placeholder="Enter Company Website" value="{{ $employer->website }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="established_in">Established In </label>
                        <select name="established_in" id="established_in" class="form-control select_2">
                            <option value=""></option>
                            @foreach (config('number.years') as $year)
                            <option value="{{ $year }}" @if($year == $employer->established_in) selected @endif>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label for="fax"><strong>Fax</strong></label>
                        <input type="text" class="form-control" name="fax" id="fax" placeholder="Enter Fax" value="{{ $employer->fax }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="phone"><strong>Phone</strong></label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone" value="{{ $employer->phone }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="facebook"><strong>facebook</strong></label>
                        <input type="url" class="form-control" name="facebook" id="facebook" placeholder="Enter Facebook" value="{{ $employer->facebook }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="twitter"><strong>Twitter</strong></label>
                        <input type="url" class="form-control" name="twitter" id="twitter" placeholder="Enter Twitter" value="{{ $employer->twitter }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="linkedin"><strong>Linkedin</strong></label>
                        <input type="url" class="form-control" name="linkedin" id="linkedin" placeholder="Enter Linkedin" value="{{ $employer->linkedin }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="instagram"><strong>Instagram</strong></label>
                        <input type="url" class="form-control" name="instagram" id="instagram" placeholder="Enter Instagram" value="{{ $employer->instagram }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="youtube"><strong>Youtube</strong></label>
                        <input type="url" class="form-control" name="youtube" id="youtube" placeholder="Enter Youtube" value="{{ $employer->youtube }}" />
                    </div>

                    <div class="col-6"></div>

                    <div class="col-6 form-group">
                        <label for="state_id">Choose State </label>
                        <select name="state_id" id="state_id" class="form-control select_2">
                            <option value=""></option>
                            @foreach ($states as $state)
                            <option value="{{ $state->id }}" @if($state->id == $employer->state_id) selected @endif>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label for="township_id">Choose Township </label>
                        <select name="township_id" id="township_id" class="form-control select_2">
                            <option value=""></option>
                            @foreach ($townships as $township)
                            <option value="{{ $township->id }}" @if($township->id == $employer->township_id) selected @endif>{{ $township->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label for="contact_person_name"><strong>Contact Person Name</strong></label>
                        <input type="text" class="form-control" name="contact_person_name" id="contact_person_name" placeholder="Enter Contact Person Name" value="{{ $employer->contact_person_name }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="contact_person_phone"><strong>Contact Person Phone</strong></label>
                        <input type="text" class="form-control" name="contact_person_phone" id="contact_person_phone" placeholder="Enter Contact Person Phone" value="{{ $employer->contact_person_phone }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="contact_person_email"><strong>Contact Person Email</strong></label>
                        <input type="email" class="form-control" name="contact_person_email" id="contact_person_email" placeholder="Enter Contact Person Email" value="{{ $employer->contact_person_email }}" />
                    </div>

                    <div class="col-6 form-group">
                        <label for="map"><strong>Google Map</strong></label>
                        <input type="text" class="form-control" name="map" id="map" placeholder="Enter Google Map" value="{{ $employer->map }}" />
                    </div>

                    <div class="form-group">
                        <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                        <input type="radio" name="is_active" id="active" class="" value="1" @if($employer->is_active == 1) checked required @endif> <label for="active"> Active</label><br>
                        <input type="radio" name="is_active" id="in_active" class="" value="0" @if($employer->is_active == 0) checked required @endif> <label for="in_active"> In Active</label>
                    </div>
                </div>

                <button class="btn btn-primary btn-icon-split btn-sm" type="submit">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Save</span>
                </button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("#package_id").change(function() {
            if($(this).val() != "") {
                $(".package_start_date_required").removeClass("d-none");
                $("#package_start_date").prop("required", true);
            }else {
                $(".package_start_date_required").addClass("d-none");
                $("#package_start_date").prop("required", false);
            }
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

        $(".logo-remove").click(function(){
            $("#imageUpload").val('');
            $('#imagePreview').css('background-image', 'url(https://placehold.jp/150x150.png)');
            $("#imageRemove").val('empty');
        })
    });
</script>
@endsection