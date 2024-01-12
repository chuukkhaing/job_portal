@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Employers</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4 col-10 m-auto p-0">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Employer Edit</h6>
            <div class="col">
                <a href="{{ route('employer-info.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('employer-info.update', $employer->id) }}" method="post" enctype="multipart/form-data">
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
                
                <div class="background">
                    <div class="background-edit position-relative">
                        <input type="file" class="form-control employer-background-upload d-none" name="background" id="employer-background" accept="image/*" />
                        <label for="employer-background" class="position-absolute top-0 start-0 badge rounded-pill text-muted bg-white employer-background-edit-icon p-2"><i class="fa-solid fa-pencil"></i></label>
                        <input type="hidden" name="background_base64">
                        <div class="employer-background-remove @if($employer->background) @else d-none @endif">
                            <a class="position-absolute top-0 badge rounded-pill bg-white text-danger employer-background-edit-icon p-2" style="left: 98%"><i class="fa-solid fa-trash-can"></i></a>
                        </div>
                    </div>
                    @if($employer->background)
                    <img src="{{ getS3File('employer_background',$employer->background) }}" class="w-100 img-responsive img-fluid background" alt="">
                    @else
                    <img src="https://placehold.jp/1835x510.png" class="w-100 img-responsive img-fluid background" alt="">
                    @endif
                </div>
                
                <div class="logo-upload form-group">
                    <div class="logo-edit">
                        <input type="file" class="form-control employer-logo-upload" name="logo" id="employer-logo" accept="image/*" />
                        <label for="employer-logo"></label>
                        <input type="hidden" name="image_base64">
                    </div>
                    
                    <div class="logo-remove @if($employer->logo) @else d-none @endif">
                        <label for="imageRemove"></label>
                    </div>
                    <div class="logo-preview">
                        @if($employer->logo)
                        <div id="imagePreview" style="background-image: url({{getS3File('employer_logo',$employer->logo)}});">
                        @else
                        <div id="imagePreview" style="background-image: url(https://placehold.jp/200x200.png);">
                        @endif
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-4 col-12 form-group">
                        <label class="seeker_label" for="name">Employer Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control seeker_input @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Employer name"  value="{{ $employer->name }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-12 form-group">
                        <label class="seeker_label" for="industry_id">Industry <span class="text-danger">*</span></label>
                        <select name="industry_id" id="industry_id" class="form-control seeker_input select_2 @error('industry_id') is-invalid @enderror" style="width:100%" >
                            <option value=""></option>
                            @foreach ($industries as $industry)
                            <option value="{{ $industry->id }}" @if($industry->id == $employer->industry_id) selected @endif>{{ $industry->name }}</option>
                            @endforeach
                        </select>
                        @error('industry_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-12 form-group">
                        <label class="seeker_label" for="ownership_type_id">Ownership Type <span class="text-danger">*</span></label>
                        <select name="ownership_type_id" id="ownership_type_id" class="form-control seeker_input select_2 @error('ownership_type_id') is-invalid @enderror" style="width:100%" >
                            <option value=""></option>
                            @foreach ($ownershipTypes as $ownershipType)
                            <option value="{{ $ownershipType->id }}" @if($ownershipType->id == $employer->ownership_type_id) selected @endif>{{ $ownershipType->name }}</option>
                            @endforeach
                        </select>
                        @error('ownership_type_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-12 form-group">
                        <label class="seeker_label" for="type_of_employer">Type of Employer <span class="text-danger">*</span></label>
                        <select name="type_of_employer" id="type_of_employer" class="form-control seeker_input select_2 @error('type_of_employer') is-invalid @enderror" style="width:100%" >
                            <option value=""></option>
                            @foreach (config('typeOfEmployer.value') as $typeofemployer)
                            <option value="{{ $typeofemployer }}" @if($typeofemployer == $employer->type_of_employer) selected @endif>{{ $typeofemployer }}</option>
                            @endforeach
                        </select>
                        @error('type_of_employer')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <hr>
                <h5 class="fw-bold">Employer Detail Information</h5>
                <div class="row">
                    <div class="col-lg-4 col-12 form-group">
                        <label class="seeker_label" for="phone"><strong>Phone No.</strong></label>
                        <input type="text" class="form-control seeker_input @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Enter Phone" value="{{ $employer->phone }}" />
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @foreach($packageItems as $packageItem)
                    @if($packageItem->name == 'Website Integration')
                    <div class="col-lg-4 col-12 form-group">
                        <label class="seeker_label" for="website"><strong>Website URL</strong></label>
                        <input type="url" class="form-control seeker_input" id="website" name="website" placeholder="Enter Employer Website" value="{{ $employer->website }}" />
                    </div>
                    @endif
                    @endforeach

                    <div class="col-lg-4 col-12 form-group">
                        <label class="seeker_label" for="no_of_offices">Number of Offices </label>
                        <select name="no_of_offices" id="no_of_offices" class="form-control seeker_input select_2" style="width:100%">
                            <option value=""></option>
                            @foreach (config('number.offices') as $office)
                            <option value="{{ $office }}" @if($office == $employer->no_of_offices) selected @endif>{{ $office }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4 col-12 form-group">
                        <label class="seeker_label" for="no_of_employees">Number of Employees </label>
                        <select name="no_of_employees" id="no_of_employees" class="form-control seeker_input select_2" style="width:100%">
                            <option value=""></option>
                            @foreach (config('number.employees') as $employee)
                            <option value="{{ $employee }}" @if($employee == $employer->no_of_employees) selected @endif>{{ $employee }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col form-group">
                        <label class="seeker_label" for="legal_docs">Please Attach Legal Document </label>
                        @if($employer->legal_docs)
                        <span class="legal_docs_link">
                            <a class="" href="{{ getS3File('employer_legal_docs',$employer->legal_docs) }}" class="text-decoration-none" target="_blank">{{ $employer->legal_docs }}</a> <a class="ms-2" onclick="removeLegalDocs()" style="cursor: pointer"><i class="fa-solid fa-trash-can text-danger"></i></a>
                        </span>
                        @endif
                        <input type="hidden" name="legal_docs_status" value="" id="legal_docs_status">
                        <input type="file" name="legal_docs" id="legal_docs" class="form-control" value="{{ $employer->legal_docs }}">
                    </div>
                    
                </div>

                <hr>
                <h5 class="fw-bold">Employer Address Detail</h5>
                <div class="row">
                    
                    <div class="col p-3 shadow" style="background: #F5F9FF; border: 1px solid #E8EFF7">
                        <div class="form-group  col-12">
                            <label for="country" class="seeker_label">Country </label>
                            <select name="country" id="country_address" class="form-control-sm" style="width: 100%">
                                <option value="Myanmar">Myanmar</option>
                                <option value="Other">Other</option>
                            </select>
                            <small class="text-danger d-none error-country">Need to Choose Country</small>
                        </div>

                        <div class="form-group  col-12" id="state_id_field">
                            <label for="state_id" class="seeker_label">State or Region </label><br>
                            <select name="state_id" id="state_id" class="select_2 form-control " style="width: 100%">
                                <option value="">Choose...</option>
                                @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger d-none error-state">Need to Choose State</small>
                        </div>
                        
                        <div class="form-group  col-12" id="township_id_field">
                            <label for="township_id" class="seeker_label">City/ Township </label><br>
                            <select name="township_id" id="township_id" class="select_2 form-control " style="width: 100%">
                                <option value="">Choose...</option>
                                @foreach($townships as $township)
                                <option value="{{ $township->id }}">{{ $township->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger d-none error-township">Need to Choose Township</small>
                        </div>
                        <div class="form-group  col-12">
                            <label for="address_detail" class="seeker_label">Address Detail</label>
                            <textarea name="address_detail" id="address_detail" class="form-control " cols="30" rows="2"></textarea>
                        </div>
                        <div class="form-group  col-12">
                            <a id="addNewAddress" onclick="addNewAddress()" class="btn btn-primary btn-sm text-white float-end rounded-3"><i class="fa-solid fa-plus"></i> Add New Address</a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table employer-address @if($employer->EmployerAddress->count() > 0) @else d-none @endif">
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
                                        <td><a id="deleteAddress-{{ $address->id }}" class="deleteAddress btn border-0 text-danger" value="{{ $address->id }}"><i class="fa-solid fa-trash-can"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="fw-bold">Add Testimonials to Elevate Your Profile</h5>
                <div class="row">
                    <div class="col p-3 shadow" style="background: #F5F9FF; border: 1px solid #E8EFF7">
                        <div class="d-flex align-items-center py-3">
                            <div class="test-image-box d-inline-block position-relative">
                                <img src="https://placehold.co/200x200/#E4E3E2" class="test-image-preview">
                                <input type="hidden" name="test_image_base64">
                                <a class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none test-image-remove text-white p-2">
                                <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                            <div class="px-3">
                                <label for="test-image" class="btn btn-outline-secondary"><i class="fa-solid fa-plus"></i> Upload Photo</label><br>
                                <input type="file" name="test-image" id="test-image" accept="image/*" class="d-none">
                                <span class="text-muted">200 * 200 pixels</span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label for="test-name" class="seeker_label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="test-name" id="test-name" class="form-control seeker_input" placeholder="Name" value="">
                                <span class="text-danger test-name-error d-none">Testimonial Name Need to Fill.</span>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="test-title" class="seeker_label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="test-title" id="test-title" class="form-control seeker_input" placeholder="Title" value="">
                                <span class="text-danger test-title-error d-none">Testimonial Title Need to Fill.</span>
                            </div>
                            <div class="form-group col-12">
                                <label for="test-remark" class="seeker_label">Remark</label>
                                <textarea name="test-remark" id="test-remark" cols="30" rows="5" class="form-control seeker_input"></textarea>
                            </div>
                            <div class="col-12">
                                <a onclick="addTestimonial()" class="btn btn-primary btn-sm float-end text-light"><i class="fa-solid fa-plus"></i> Add</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table employer-testimonial @if($employer->EmployerTestimonial->count() > 0) @else d-none @endif">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Remark</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employer->EmployerTestimonial as $test)
                                    <tr class="test-tr-{{ $test->id }}">
                                        <td>@if(isset($test->image)) <img src="{{ getS3File('employer_testimonial',$test->image) }}" width="80px" height="80px" alt="Testimonial Image"> @else - @endif</td>
                                        <td>{{ $test->name ?? '-' }}</td>
                                        <td>{{ $test->title ?? '-' }}</td>
                                        <td>{{ $test->remark ?? '-' }}</td>
                                        <td><a id="deleteTest-{{ $test->id }}" class="deleteTest btn border-0 text-danger" value="{{ $test->id }}"><i class="fa-solid fa-trash-can"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="fw-bold">Upload Employer Photos and Videos</h5>
                @foreach($packageItems as $packageItem)
                    @if($packageItem->name == 'Employer Profile with Photos')
                    <div class="row mb-4">
                        <div class="col-5 d-flex align-items-center pt-3">
                            
                            <label for="media-image" style="color: #696968">
                                <img src="https://placehold.co/280x140/#E4E3E2" class="media-image-preview">
                                <div class="pt-2 text-center">
                                    Tap to Change
                                </div>
                            </label><br>
                            <a class="mx-3 btn btn-sm btn-primary text-white upload_media_image"><i class="fa-solid fa-plus"></i> Upload Photo</a>
                            <input type="file" name="media-image" id="media-image" accept="image/*" class="d-none">
                            
                            <input type="hidden" name="media_image_base64">
                        </div>
                        @if($employer_image_media->count() > 0)
                        <div class="col row media_image @if($employer_image_media->count() > 0) @else d-none @endif">
                            @foreach($employer_image_media as $image_media)
                            <div class="col-md-3" id="media_image_{{ $image_media->id }}">
                                <img src="{{ asset('storage/employer_media/'.$image_media->name) }}"  class="w-100 rounded-3" id="image_upload_preview" alt="{{ $image_media->name }}">
                                
                                <a class="position-absolute top-0 translate-middle badge rounded-pill bg-danger text-white p-2" onclick="removeMedia({{ $image_media->id }})">
                                <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        
                    </div>
                    @endif
                    
                    @if($packageItem->name == 'Employer Profile with Videos')
                    <div class="shadow p-3" style="border: 1px dashed #95B6D8; border-radius: 8px">
                        <div class="table-responsive">
                            <table class="table employer-media @if($employer->EmployerMedia->where('type','Video Link')->count() > 0) @else d-none @endif">
                                <thead>
                                    <th>Link</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach($employer->EmployerMedia->where('type','Video Link') as $link)
                                    <tr class="media-tr-{{ $link->id }}">
                                        <td>{!! $link->name ?? '-' !!}</td>
                                        <td><a id="deleteMedia-{{ $link->id }}" class="deleteMedia border-0 text-danger" value="{{ $link->id }}"><i class="fa-solid fa-trash-can"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row d-flex align-items-end">
                            <div class="col-lg-6 col-12 form-group video_add mb-4">
                                <label for="video_link" class="seeker_label">Video Link (Youtube Link)</label>
                                <input type="url" name="video_link" id="video_link" class="form-control seeker_input" placeholder="Paste youtube link">
                                <span class="text-danger video-link-error d-none">Please Fill the Video Link</span>
                            </div>
                            <div class="col-lg-6 col-12 form-group mb-4">
                                <a onclick="addLink()" class="btn btn-primary btn-sm text-white"><i class="fa-solid fa-plus"></i> Add Link</a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach

                <hr>
                <h5 class="fw-bold">Employer Vision, Mission, and Values</h5>

                <div class="row">
                    <div class="col-lg-6 col-12 form-group">
                        <label for="company_summary" class="seeker_label">Employer Summary</label>
                        <textarea name="company_summary" id="company_summary" cols="30" rows="5" class="seeker_input employer_summernote form-control">{!! $employer->summary !!}</textarea>
                    </div>
                    <div class="col-lg-6 col-12 form-group">
                        <label for="company_value" class="seeker_label">Employer Value</label>
                        <textarea name="company_value" id="company_value" cols="30" rows="5" class="seeker_input form-control employer_summernote">{!! $employer->value !!}</textarea>
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
        <!-- upload logo modal  -->
        <div class="modal" id="upload_logo">
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
                        <div class="text-center">
                            <button class="btn btn-sm btn-primary" id="upload_logo_submit" > 
                            Crop And Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- upload logo background  -->
        <div class="modal" id="upload_background">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image And Upload</h5>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="resizer_background"></div>
                        <div class="text-center">
                            <button class="btn btn-sm btn-primary" id="upload_background_submit" > 
                            Crop And Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- upload test_image modal  -->
        <div class="modal" id="upload_test_image">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image And Upload</h5>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="resizer_test_image"></div>
                        <div class="text-center">
                            <button class="btn btn-primary" id="upload_test_image_submit" > 
                            Crop And Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- upload media_image modal  -->
        <div class="modal" id="upload_media_image">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title">Crop Image And Upload</h5>
                            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div id="resizer_media_image"></div>
                            <div class="text-center">
                                <button class="btn btn-primary" id="upload_media_image_submit" > 
                                Crop And Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- MSalert Javascript -->
<script src="{{ asset('frontend/js/MSalert.js') }}"></script>
<script>
    $(document).ready(function() {

        var el = document.getElementById('resizer_logo');
        $(".employer-logo-upload").on("change", function(event) {
            $("#upload_logo").modal('show');
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

        $(".close").click(function() {
            croppie.destroy();
        })
        
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

        $("#upload_logo_submit").on("click", function() {
            croppie.result('base64').then(function(base64) {

                $("#upload_logo").modal("hide"); 

                $('.logo-remove').removeClass('d-none');
                
                $('#imagePreview').attr('style', 'background-image: url('+base64+')');

                $("input[name='image_base64']").val(base64);
                croppie.destroy();
            });
        });

        $('.logo-remove').click(function() {
            
            $('#imagePreview').attr('style', 'background-image: url(https://placehold.jp/200x200.png)');
            $('.logo-remove').addClass('d-none');
            $('.employer-logo-upload').val('');
            $("input[name='image_base64']").val('Empty');
        })

        var el_bg = document.getElementById('resizer_background');
        $('.employer-background-upload').change(function() {
            $("#upload_background").modal('show');
            croppie = new Croppie(el_bg, {
                type: 'canvas',
                viewport: {
                    width: 400,
                    height: 112,
                    type: 'square'
                },
                boundary: {
                    width: 450,
                    height: 162,
                }
            });
            getImage(event.target, croppie); 
        });

        $("#upload_background_submit").on("click", function() {
            croppie.result({
                    type: 'base64',
                    size: { 
                        width: 1835, height: 510 
                    }
                }).then(function(base64) {
                $("#upload_background").modal("hide"); 
                
                $('.employer-background-remove').removeClass('d-none');
                
                $('.background').attr('src', base64);

                $("input[name='background_base64']").val(base64);
                croppie.destroy();
            });
        });

        $('.employer-background-remove').click(function() {
            
            $('.background').attr('src', 'https://placehold.jp/1835x510.png');
            $('.employer-background-remove').addClass('d-none');
            $('.employer-background-upload').val('');
            $("input[name='background_base64']").val('Empty');
        })

        $("#legal_docs").change(function() {
            $("#legal_docs_status").val('');
        })

    });

    function removeLegalDocs()
    {
        $("#legal_docs_status").val('empty');
        $(".legal_docs_link").addClass('d-none');
    }

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

            if(country != null && state != '') {
                $.ajax({
                    type: 'POST',
                    data: {
                        'country' : country,
                        'state_id' : state,
                        'township_id' : township,
                        'address_detail' : address_detail,
                        'employer_id' : {{ $employer->id }}
                    },
                    url: '{{ route("employer-info-address.store") }}',
                }).done(function(response){
                    if(response.status = 'success') {
                        $('.employer-address').removeClass('d-none');
                        var addressDetail = '';
                        if(response.data.address_detail == null ) {
                            addressDetail = '-';
                        }else {
                            addressDetail = response.data.address_detail;
                        }
                        var township_name = '-';
                        if(response.data.township_name == undefined) {
                            townsip_name = '-';
                        }else {
                            township_name = response.data.township_name;
                        }
                        $('.employer-address').append('<tr class="address-tr-'+response.data.id+'"><td>'+response.data.country+'</td><td>'+response.data.state_name+'</td><td>'+township_name+'</td><td>'+addressDetail+'</td><td><a id="deleteAddress-'+response.data.id+'" class="deleteAddress btn border-0 text-danger" value="'+response.data.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                        $("#country_address").val('');
                        $('#state_id').val('').trigger('change');
                        $("#township_id").empty().trigger('change');
                        $("#address_detail").val('');
                        $('.error-state').addClass('d-none');
                        $('.error-country').addClass('d-none');
                        $("#state_id_field").removeClass('d-none');
                        $("#township_id_field").removeClass('d-none');
                    }
                })
            }else {
                $('.error-state').removeClass('d-none');
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
                        'employer_id' : {{ $employer->id }}
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
                        $('.employer-address').append('<tr class="address-tr-'+response.data.id+'"><td>'+response.data.country+'</td><td>-</td><td>-</td><td>'+addressDetail+'</td><td><a id="deleteAddress-'+response.data.id+'" class="deleteAddress btn border-0 text-danger" value="'+response.data.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                        $("#country_address").val('');
                        $('#state_id').val('').trigger('change');
                        $("#township_id").empty().trigger('change');
                        $("#address_detail").val('');
                        $('.error-state').addClass('d-none');
                        $('.error-country').addClass('d-none');
                        $("#state_id_field").removeClass('d-none');
                        $("#township_id_field").removeClass('d-none');
                    }
                })
            }else {
                $('.error-state').removeClass('d-none');
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
                url: '/employers/get-township/'+state_id,
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

    $(document).on('click', '.deleteAddress', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'Warning',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    data: {
                        'employer_id' : {{ $employer->id }}
                    },
                    url: '/employer-info-address/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".address-tr-"+id).empty();
                        if(response.address_count == 0) {
                            $(".employer-address").addClass('d-none');
                        }
                        MSalert.principal({
                            icon:'success',
                            title:'Success',
                            description:response.msg,
                        });
                    }
                })
            }            
        })
    });

    var el = document.getElementById('resizer_test_image');
    $("#test-image").on("change", function(event) {
        $("#upload_test_image").modal('show');
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

    $("#upload_test_image_submit").on("click", function() {
        croppie.result('base64').then(function(base64) {
            $("#upload_test_image").modal("hide"); 
            $('.test-image-remove').removeClass('d-none');
            $('.test-image-preview').attr('src', base64);
            $("input[name='test_image_base64']").val(base64);
            croppie.destroy();
        });
    });
    
    $('.test-image-remove').click(function() {
        $('.test-image-preview').attr('src', 'https://placehold.co/200x200/#E4E3E2');
        $('.test-image-remove').addClass('d-none');
        $('#test-image').val('');
        $("input[name='test_image_base64']").val('');
    })
    function addTestimonial()
    {
        var test_name = $("#test-name").val();
        var test_title = $("#test-title").val();
        var test_remark = $("#test-remark").val();
        
        if(test_name == '') {
            $(".test-name-error").removeClass('d-none');
        }else {
            $(".test-name-error").addClass('d-none');
        }
        if(test_title == '') {
            $(".test-title-error").removeClass('d-none');
        }else {
            $(".test-title-error").addClass('d-none');
        }
        if(test_name != '' && test_title != '') {
            $.ajax({
                type: 'POST',
                data: {
                    'test_image' : $("input[name='test_image_base64']").val(),
                    'test_name' : test_name,
                    'test_title' : test_title,
                    'test_remark' : test_remark,
                    'employer_id' : {{ $employer->id }},
                },
                url: '{{ route("employer-info-testimonial.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    $('.employer-testimonial').removeClass('d-none');
                    var remark = '-';
                    if(response.data.remark) {
                        remark = response.data.remark;
                    }
                    var image = '-';
                    if(response.data.image){
                        image = '<img src="'+response.test_img+'" width="80px" height="80px" alt="Testimonial Image">';
                    }
                    $(".employer-testimonial").append('<tr class="test-tr-'+response.data.id+'"><td>'+image+'</td><td>'+response.data.name+'</td><td>'+response.data.title+'</td><td>'+remark+'</td><td><a id="deleteTest-'+response.data.id+'" class="deleteTest btn border-0 text-danger" value="'+response.data.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                    $("#test-name").val('');
                    $("#test-title").val('');
                    $("#test-remark").val('');
                    $('.test-image-preview').attr('src', 'https://placehold.co/200x200/#E4E3E2');
                    $('.test-image-remove').addClass('d-none');
                }
            })
        }
    }

    $(document).on('click', '.deleteTest', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'Warning',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    data: {
                        'employer_id' : {{ $employer->id }}
                    },
                    url: '/employer-info-testimonial/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".test-tr-"+id).empty();
                        if(response.test_count == 0) {
                            $(".employer-testimonial").addClass('d-none');
                        }
                        MSalert.principal({
                            icon:'success',
                            title:'Success',
                            description:response.msg,
                        });
                    }
                })
            }            
        })
    });

    function addLink()
    {
        if($("#video_link").val() == '') {
            $(".video-link-error").removeClass('d-none');
        }else {
            $(".video-link-error").addClass('d-none');
            var fd = new FormData();
            fd.append("video_link", $("#video_link").val());
            fd.append('employer_id',{{ $employer->id }});

            $.ajax({
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                url: '{{ route("employer-info-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    $("#video_link").val('');
                    $(".employer-media").removeClass('d-none');
                    $(".employer-media").append('<tr class="media-tr-'+response.data.id+'"><td>'+response.data.name+'</td><td><a id="deleteMedia-'+response.data.id+'" class="deleteMedia border-0 text-danger" value="'+response.data.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                }
            })
        }
        
    }

    $(document).on('click', '.deleteMedia', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'Warning',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    data: {
                        'employer_id' : {{ $employer->id }}
                    },
                    url: '/employer-info-media/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".media-tr-"+id).empty();
                        if(response.media_count == 0) {
                            $(".employer-media").addClass('d-none');
                        }
                        MSalert.principal({
                            icon:'success',
                            title:'Success',
                            description:response.msg,
                        });
                    }
                })
            }            
        })
    });

    var media_el = document.getElementById('resizer_media_image');
    $("#media-image").on("change", function(event) {
        $("#upload_media_image").modal('show');
        croppie = new Croppie(media_el, {
            viewport: {
                width: 280,
                height: 140,
                type: 'square'
            },
            boundary: {
                width: 330,
                height: 190
            }
        });
        getImage(event.target, croppie); 
    });

    $("#upload_media_image_submit").on("click", function() {
        croppie.result('base64').then(function(base64) {
            $("#upload_media_image").modal("hide"); 
            $('.media-image-preview').attr('src', base64);
            $("input[name='media_image_base64']").val(base64);
            croppie.destroy();
        });
    });

    $(".upload_media_image").click(function() {
        var media_image = $("input[name='media_image_base64']").val();
        $.ajax({
                type: 'POST',
                data: {
                    'employer_id' : {{ $employer->id }},
                    'upload_image' : media_image
                },
                url: '{{ route("employer-info-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    $('.media-image-preview').attr('src', 'https://placehold.co/280x140/#E4E3E2');
                    $("input[name='media_image_base64']").val('');
                    $(".media_image").removeClass('d-none');
                    $(".media_image").append('<div class="col-md-3 col-4" id="media_image_'+response.data.id+'"><img src="'+document.location.origin+'/storage/employer_media/'+response.data.name+'"  class="w-100 rounded-3" id="image_upload_preview" alt="'+response.data.name+'"><a class="position-absolute top-0 translate-middle badge rounded-pill bg-danger text-white p-2" onclick="removeMedia('+response.data.id+')"><i class="fa-solid fa-trash-can"></i></a></div>')
                }
            })
    })

    function removeMedia(id) {
        MSalert.principal({
            icon:'warning',
            title:'Warning',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    data: {
                        'employer_id' : {{ $employer->id }}
                    },
                    url: '/employer-info-media/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $("#media_image_"+id).remove();
                        if(response.media_count == 0) {
                            $(".media_image").addClass('d-none');
                        }
                        MSalert.principal({
                            icon:'success',
                            title:'Success',
                            description:response.msg,
                        });
                    }
                })
            }            
        })
    }

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
</script>
@endpush