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
                        </div>
                        <div class="py-2">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Access</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ Auth::guard('employer')->user()->email }}</td>
                                            <td>@if(Auth::guard('employer')->user()->is_active == 1)<span class="badge text-light bg-success">Active</span>@else <span class="badge text-light bg-danger">In-Active</span> @endif</td>
                                            <td>{{ Auth::guard('employer')->user()->employer_id ? 'Member' : 'Admin' }}</td>
                                            <td>
                                                <a href="{{ route('member-user.edit', Auth::guard('employer')->user()->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if(Auth::guard('employer')->user()->employer_id == Null)
                                <div class="text-end">
                                    <a href="{{ route('member-user.index') }}" class="btn profile-save-btn">Manage User</a>
                                </div>
                                @endif
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
                                    <span class="employer-image-text">Company Logo</span> <span style="color: #696968">200 x 200</span>
                                </div>
                                
                                @if($employer->logo)
                                <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" class="img-responsive w-100 employer-logo" alt="employer-logo">
                                @else
                                <img src="https://placehold.jp/200x200.png" class="img-responsive w-100 employer-logo" alt="employer-logo">
                                @endif
                                <div class="py-3 text-center">
                                    <label for="imageUpload" style="color: #696968">Tap to Change</label>
                                    <input type="file" class="employer-logo-upload" name="logo" id="imageUpload" accept="image/*" />
                                    <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if($employer->logo) @else d-none @endif employer-logo-remove"><i class="fa-solid fa-xmark"></i></button>
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
                                    <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if($employer->background) @else d-none @endif employer-background-remove"><i class="fa-solid fa-xmark"></i></button>
                                    <input type="hidden" name="backgroundStatus" id="backgroundStatus" value="">
                                </div>
                            </div>
                            {{--<div class="col-2">
                                <div class="py-3">
                                    <span class="employer-image-text">Company QR</span>
                                </div>
                                @if($employer->qr)
                                <img src="{{ asset('storage/employer_qr/'.$employer->qr) }}" class="img-responsive w-100 employer-qr" alt="employer-qr">
                                @else
                                <img src="https://placehold.jp/200x200.png" class="img-responsive w-100 employer-qr" alt="employer-qr">
                                @endif
                                <div class="py-3 text-center">
                                    <label for="qrUpload" style="color: #696968">Tap to Change</label>
                                    <input type="file" class="employer-qr-upload" name="qr" id="qrUpload" accept="image/*" />
                                    <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if($employer->qr) @else d-none @endif employer-qr-remove"><i class="fa-solid fa-xmark"></i></button>
                                    <input type="hidden" name="qrStatus" id="qrStatus" value="">
                                </div>
                            </div>--}}
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
                                @foreach($packageItems as $packageItem)
                                @if($packageItem->name == 'Website Integration')
                                <div class="col-6 form-group">
                                    <label class="seeker_label" for="website"><strong>Website URL</strong></label>
                                    <input type="url" class="form-control seeker_input" id="website" name="website" placeholder="Enter Company Website" value="{{ $employer->website }}" />
                                </div>
                                @endif
                                @endforeach

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
                                                <td><a id="deleteAddress-{{ $address->id }}" class="deleteAddress btn border-0 text-danger" value="{{ $address->id }}"><i class="fa-solid fa-trash-can"></i></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group col-6">
                                    <label for="country" class="seeker_label">Country </label>
                                    <select name="country" id="country_address" class="seeker_input" style="width: 100%">
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
                @foreach($packageItems as $packageItem)
                @if($packageItem->name == 'Testimonials')
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
                                <a onclick="addTestimonial()" class="btn profile-save-btn float-end text-light"><i class="fa-solid fa-plus"></i> Add</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered employer-testimonial @if($employer->EmployerTestimonial->count() > 0) @else d-none @endif">
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
                                        <td>@if(isset($test->image)) <img src="{{ asset('storage/employer_testimonial/'.$test->image) }}" width="80px" height="80px" alt="Testimonial Image"> @else - @endif</td>
                                        <td>{{ $test->name ?? '-' }}</td>
                                        <td>{{ $test->title ?? '-' }}</td>
                                        <td>{{ $test->remark ?? '-' }}</td>
                                        <td><a id="deleteTest-{{ $test->id }}" class="deleteTest btn border-0 text-danger" value="{{ $test->id }}"><i class="fa-solid fa-trash-can"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="py-2">
                            <div class="row" style="background: #F5F9FF; border: 1px solid #E8EFF7">
                                <div class="d-flex align-items-center py-3">
                                    <div class="test-image-box d-inline-block">
                                        <img src="https://placehold.co/200x200/#E4E3E2" class="test-image-preview">
                                        <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle d-none test-image-remove"><i class="fa-solid fa-xmark"></i></button>
                                        
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
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
                
                @if($packageItems->whereIn('name',['Employer Profile with Photos','Employer Profile with Videos'])->count() > 0)
                <div class="row">
                    <div class="col-1">
                        <div class="step">
                            @if($packageItems->where('name','Testimonials')->count() == 1)
                            Step 4
                            @else 
                            Step 3
                            @endif
                        </div>
                    </div>
                    <div class="col-11">
                        <div class="row mb-2">
                            <div class="col-9">
                                <div class="py-2">
                                    <h5>Upload Company Photos and Videos</h5>
                                    <span>Showcase Your Career with Up to 8 Photos or Videos on Our Job Website</span>
                                </div>
                            </div>
                            
                        </div>
                        @foreach($packageItems as $packageItem)
                        @if($packageItem->name == 'Employer Profile with Photos')
                        <div class="row mb-4">
                            <div class="col-3">
                                <label for="upload_image_1">
                                @if(isset($employer_image_media[0]))
                                <img src="{{ asset('storage/employer_media/'.$employer_image_media[0]->name) }}" width="280px" height="140px" id="image_upload_preview_1" alt="{{ $employer_image_media[0]->name }}">
                                @else
                                <img src="https://placehold.co/280x140/#E4E3E2"width="280px" height="140px" id="image_upload_preview_1" alt="">
                                @endif
                                </label>
                                <input type="file" name="upload_image_1" id="upload_image_1" accept="image/*" class="d-none">
                                <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(isset($employer_image_media[0])) @else d-none @endif image_upload_remove" attr-id=@if(isset($employer_image_media[0])) "{{ $employer_image_media[0]->id}}" @else "" @endif id="image_upload_remove_1"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="col-3">
                                <label for="upload_image_2">
                                @if(isset($employer_image_media[1]))
                                <img src="{{ asset('storage/employer_media/'.$employer_image_media[1]->name) }}" width="280px" height="140px" id="image_upload_preview_2" alt="{{ $employer_image_media[1]->name }}">
                                @else
                                <img src="https://placehold.co/280x140/#E4E3E2"width="280px" height="140px" id="image_upload_preview_2" alt="">
                                @endif
                                </label>
                                <input type="file" name="upload_image_2" id="upload_image_2" accept="image/*" class="d-none">
                                <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(isset($employer_image_media[1])) @else d-none @endif image_upload_remove" attr-id=@if(isset($employer_image_media[1])) "{{ $employer_image_media[1]->id}}" @else "" @endif id="image_upload_remove_2"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="col-3">
                                <label for="upload_image_3">
                                @if(isset($employer_image_media[2]))
                                <img src="{{ asset('storage/employer_media/'.$employer_image_media[2]->name) }}" width="280px" height="140px" id="image_upload_preview_3" alt="{{ $employer_image_media[2]->name }}">
                                @else
                                <img src="https://placehold.co/280x140/#E4E3E2"width="280px" height="140px" id="image_upload_preview_3" alt="">
                                @endif
                                </label>
                                <input type="file" name="upload_image_3" id="upload_image_3" accept="image/*" class="d-none">
                                <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(isset($employer_image_media[2])) @else d-none @endif image_upload_remove" attr-id=@if(isset($employer_image_media[2])) "{{ $employer_image_media[0]->id}}" @else "" @endif id="image_upload_remove_3"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="col-3">
                                <label for="upload_image_4">
                                @if(isset($employer_image_media[3]))
                                <img src="{{ asset('storage/employer_media/'.$employer_image_media[3]->name) }}" width="280px" height="140px" id="image_upload_preview_4" alt="{{ $employer_image_media[3]->name }}">
                                @else
                                <img src="https://placehold.co/280x140/#E4E3E2"width="280px" height="140px" id="image_upload_preview_4" alt="">
                                @endif
                                </label>
                                <input type="file" name="upload_image_4" id="upload_image_4" accept="image/*" class="d-none">
                                <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(isset($employer_image_media[3])) @else d-none @endif image_upload_remove" attr-id=@if(isset($employer_image_media[3])) "{{ $employer_image_media[0]->id}}" @else "" @endif id="image_upload_remove_4"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="col-3">
                                <label for="upload_image_5">
                                @if(isset($employer_image_media[4]))
                                <img src="{{ asset('storage/employer_media/'.$employer_image_media[4]->name) }}" width="280px" height="140px" id="image_upload_preview_5" alt="{{ $employer_image_media[4]->name }}">
                                @else
                                <img src="https://placehold.co/280x140/#E4E3E2"width="280px" height="140px" id="image_upload_preview_5" alt="">
                                @endif
                                </label>
                                <input type="file" name="upload_image_5" id="upload_image_5" accept="image/*" class="d-none">
                                <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(isset($employer_image_media[4])) @else d-none @endif image_upload_remove" attr-id=@if(isset($employer_image_media[4])) "{{ $employer_image_media[0]->id}}" @else "" @endif id="image_upload_remove_5"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="col-3">
                                <label for="upload_image_6">
                                @if(isset($employer_image_media[5]))
                                <img src="{{ asset('storage/employer_media/'.$employer_image_media[5]->name) }}" width="280px" height="140px" id="image_upload_preview_6" alt="{{ $employer_image_media[5]->name }}">
                                @else
                                <img src="https://placehold.co/280x140/#E4E3E2"width="280px" height="140px" id="image_upload_preview_6" alt="">
                                @endif
                                </label>
                                <input type="file" name="upload_image_6" id="upload_image_6" accept="image/*" class="d-none">
                                <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(isset($employer_image_media[5])) @else d-none @endif image_upload_remove" attr-id=@if(isset($employer_image_media[5])) "{{ $employer_image_media[0]->id}}" @else "" @endif id="image_upload_remove_6"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="col-3">
                                <label for="upload_image_7">
                                @if(isset($employer_image_media[6]))
                                <img src="{{ asset('storage/employer_media/'.$employer_image_media[6]->name) }}" width="280px" height="140px" id="image_upload_preview_7" alt="{{ $employer_image_media[6]->name }}">
                                @else
                                <img src="https://placehold.co/280x140/#E4E3E2"width="280px" height="140px" id="image_upload_preview_7" alt="">
                                @endif
                                </label>
                                <input type="file" name="upload_image_7" id="upload_image_7" accept="image/*" class="d-none">
                                <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(isset($employer_image_media[6])) @else d-none @endif image_upload_remove" attr-id=@if(isset($employer_image_media[6])) "{{ $employer_image_media[0]->id}}" @else "" @endif id="image_upload_remove_7"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="col-3">
                                <label for="upload_image_8">
                                @if(isset($employer_image_media[7]))
                                <img src="{{ asset('storage/employer_media/'.$employer_image_media[7]->name) }}" width="280px" height="140px" id="image_upload_preview_8" alt="{{ $employer_image_media[7]->name }}">
                                @else
                                <img src="https://placehold.co/280x140/#E4E3E2"width="280px" height="140px" id="image_upload_preview_8" alt="">
                                @endif
                                </label>
                                <input type="file" name="upload_image_8" id="upload_image_8" accept="image/*" class="d-none">
                                <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(isset($employer_image_media[7])) @else d-none @endif image_upload_remove" attr-id=@if(isset($employer_image_media[7])) "{{ $employer_image_media[0]->id}}" @else "" @endif id="image_upload_remove_8"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                        </div>
                        @endif
                        
                        
                        @if($packageItem->name == 'Employer Profile with Videos')
                        <div class="table-responsive">
                            <table class="table table-bordered employer-media @if($employer->EmployerMedia->where('type','Video Link')->count() > 0) @else d-none @endif">
                                <tbody>
                                    @foreach($employer->EmployerMedia->where('type','Video Link') as $link)
                                    <tr class="media-tr-{{ $link->id }}">
                                        <td>{{ $link->name ?? '-' }}</td>
                                        <td><a id="deleteMedia-{{ $link->id }}" class="deleteMedia btn border-0 text-danger" value="{{ $link->id }}"><i class="fa-solid fa-trash-can"></i></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row d-flex align-items-end">
                            <div class="col-6 form-group video_add mb-4">
                                <label for="video_link" class="seeker_label">Video Link (Youtube Link)</label>
                                <input type="url" name="video_link" id="video_link" class="form-control seeker_input" placeholder="Paste youtube link">
                                <span class="text-danger video-link-error d-none">Please Fill the Video Link</span>
                            </div>
                            <div class="col-6 form-group mb-4">
                                <a onclick="addLink()" class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i> Add Link</a>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="row">
                    <div class="col-1">
                        <div class="step">
                        @if(($packageItems->where('name','Testimonials')->count() == 1 && ($packageItems->where('name','Employer Profile with Videos')->where('name','!=','Employer Profile with Photo')->count() == 1 || $packageItems->where('name','Employer Profile with Photos')->where('name','!=','Employer Profile with Videos')->count() == 1)) || 
                            ($packageItems->where('name','Testimonials')->count() == 1 && ($packageItems->where('name','Employer Profile with Videos')->count() == 1 || $packageItems->where('name','Employer Profile with Photos')->count() == 1)))
                            Step 5
                        @elseif($packageItems->where('name','Testimonials')->count() == 0 && $packageItems->where('name','Employer Profile with Videos')->count() == 0 && $packageItems->where('name','Employer Profile with Photos')->count() == 0)
                            Step 3
                        @elseif($packageItems->where('name','Testimonials')->count() == 0 || $packageItems->where('name','Employer Profile with Videos')->where('name','!=','Employer Profile with Photo')->count() == 0 || $packageItems->where('name','Employer Profile with Photos')->where('name','!=','Employer Profile with Videos')->count() == 0)
                            Step 4
                        @endif
                        </div>
                    </div>
                    <div class="col-11">
                        <div class="row mb-2">
                            <div class="col-9">
                                <div class="py-2">
                                    <h5>Company Vision, Mission, and Values</h5>
                                    <span>Learn About What Drives Us - Our Purpose, Goals, and Principles That Guide Our Company Forward</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label for="company_summary" class="seeker_label">Company Summary</label>
                                    <textarea name="company_summary" id="company_summary" cols="30" rows="5" class="seeker_input form-control">{{ $employer->summary }}</textarea>
                                </div>
                                <div class="col-6 form-group">
                                    <label for="company_value" class="seeker_label">Company Value</label>
                                    <textarea name="company_value" id="company_value" cols="30" rows="5" class="seeker_input form-control">{{ $employer->value }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn profile-save-btn">Update Profile and Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal" id="upload_logo">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Crop Image And Upload</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="resizer"></div>
                <button class="btn btn-block btn-dark" id="upload" > 
                Crop And Upload</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    var el = document.getElementById('resizer');
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

    $("#upload").on("click", function() {
        croppie.result('base64').then(function(base64) {
            $("#upload_logo").modal("hide"); 
            base64ImageToBlob(base64);
            $('.employer-logo').attr('src', base64);
            $('.employer-logo-remove').removeClass('d-none');
            $('#logoStatus').val('');
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

    $('.employer-logo-remove').click(function() {
        $('.employer-logo').attr('src', 'https://placehold.jp/200x200.png');
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
                        var township_name = '-';
                        if(response.data.township_name == undefined) {
                            townsip_name = '-';
                        }else {
                            township_name = response.data.township_name;
                        }
                        $('.employer-address').append('<tr class="address-tr-'+response.data.id+'"><td>'+response.data.country+'</td><td>'+response.data.state_name+'</td><td>'+township_name+'</td><td>'+addressDetail+'</td><td><a id="deleteAddress-'+response.data.id+'" class="deleteAddress btn border-0 text-danger" value="'+response.data.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                        $("#country_address").val('');
                        $("#state_id").empty().trigger('change');
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
                        $("#state_id").empty().trigger('change');
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

    $(document).on('click', '.deleteAddress', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    data: {
                        'employer_id' : {{ $employer->id }}
                    },
                    url: 'employer-address/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".address-tr-"+id).empty();
                        if(response.address_count == 0) {
                            $(".employer-address").addClass('d-none');
                        }
                        MSalert.principal({
                            icon:'success',
                            title:'',
                            description:response.msg,
                        });
                    }
                })
            }            
        })
    });

    $("#test-image").change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.test-image-preview').attr('src', e.target.result);
                $('.test-image-remove').removeClass('d-none');
                
            };
            reader.readAsDataURL(this.files[0]);
        }
    })
    
    $('.test-image-remove').click(function() {
        $('.test-image-preview').attr('src', 'https://placehold.co/200x200/#E4E3E2');
        $('.test-image-remove').addClass('d-none');
        $('#test-image').val('');
        
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
            var fd = new FormData();
            var test_image = $("#test-image")[0].files[0];
            fd.append('test_image',test_image);
            fd.append('test_name',test_name);
            fd.append('test_title',test_title);
            fd.append('test_remark',test_remark);
            fd.append('employer_id',{{ $employer->id }});
            $.ajax({
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                url: '{{ route("employer-testimonial.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    $('.employer-testimonial').removeClass('d-none');
                    var remark = '-';
                    if(response.data.remark) {
                        remark = response.data.remark;
                    }
                    var image = '-';
                    if(response.data.image){
                        image = '<img src="'+window.origin+'/storage/employer_testimonial/'+response.data.image+'" width="80px" height="80px" alt="Testimonial Image">';
                    }
                    $(".employer-testimonial").append('<tr class="test-tr-'+response.data.id+'"><td>'+image+'</td><td>'+response.data.name+'</td><td>'+response.data.title+'</td><td>'+remark+'</td><td><a id="deleteTest-'+response.data.id+'" class="deleteTest btn border-0 text-danger" value="'+response.data.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                    $("#test-name").val('');
                    $("#test-title").val('');
                    $("#test-remark").val('');
                    $('.test-image-preview').attr('src', 'https://placehold.co/200x200/#E4E3E2');
                }
            })
        }
    }

    $(document).on('click', '.deleteTest', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    data: {
                        'employer_id' : {{ $employer->id }}
                    },
                    url: 'employer-testimonial/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".test-tr-"+id).empty();
                        if(response.test_count == 0) {
                            $(".employer-testimonial").addClass('d-none');
                        }
                        MSalert.principal({
                            icon:'success',
                            title:'',
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
                url: '{{ route("employer-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    $("#video_link").val('');
                    $(".employer-media").removeClass('d-none');
                    $(".employer-media").append('<tr class="media-tr-'+response.data.id+'"><td>'+response.data.name+'</td><td><a id="deleteMedia-'+response.data.id+'" class="deleteMedia btn border-0 text-danger" value="'+response.data.id+'"><i class="fa-solid fa-trash-can"></i></a></td></tr>');
                }
            })
        }
        
    }

    $(document).on('click', '.deleteMedia', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    data: {
                        'employer_id' : {{ $employer->id }}
                    },
                    url: 'employer-media/destory/'+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".media-tr-"+id).empty();
                        if(response.media_count == 0) {
                            $(".employer-media").addClass('d-none');
                        }
                        MSalert.principal({
                            icon:'success',
                            title:'',
                            description:response.msg,
                        });
                    }
                })
            }            
        })
    });

    $("#upload_image_1").change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_upload_preview_1').attr('src', e.target.result);
                $('#image_upload_remove_1').removeClass('d-none');
                
            };
            reader.readAsDataURL(this.files[0]);
            var fd = new FormData();
            fd.append("upload_image", $("#upload_image_1")[0].files[0]);
            fd.append('employer_id',{{ $employer->id }});

            $.ajax({
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                url: '{{ route("employer-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    
                }
            })
        }
    })

    $('#image_upload_remove_1').click(function() {
        $('#image_upload_preview_1').attr('src', 'https://placehold.co/280x140/#E4E3E2');
        $('#image_upload_remove_1').addClass('d-none');
        $('#upload_image_1').val('');
        var id = $(this).attr('attr-id');
        $.ajax({
            type: 'POST',
            data: {
                'employer_id' : {{ $employer->id }}
            },
            url: 'employer-media/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                
                MSalert.principal({
                    icon:'success',
                    title:'',
                    description:response.msg,
                });
            }
        })
    })

    $("#upload_image_2").change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_upload_preview_2').attr('src', e.target.result);
                $('#image_upload_remove_2').removeClass('d-none');
                
            };
            reader.readAsDataURL(this.files[0]);
            var fd = new FormData();
            fd.append("upload_image", $("#upload_image_2")[0].files[0]);
            fd.append('employer_id',{{ $employer->id }});

            $.ajax({
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                url: '{{ route("employer-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    
                }
            })
        }
    })

    $('#image_upload_remove_2').click(function() {
        $('#image_upload_preview_2').attr('src', 'https://placehold.co/280x140/#E4E3E2');
        $('#image_upload_remove_2').addClass('d-none');
        $('#upload_image_2').val('');
        var id = $(this).attr('attr-id');
        $.ajax({
            type: 'POST',
            data: {
                'employer_id' : {{ $employer->id }}
            },
            url: 'employer-media/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                
                MSalert.principal({
                    icon:'success',
                    title:'',
                    description:response.msg,
                });
            }
        })
    })

    $("#upload_image_3").change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_upload_preview_3').attr('src', e.target.result);
                $('#image_upload_remove_3').removeClass('d-none');
                
            };
            reader.readAsDataURL(this.files[0]);
            var fd = new FormData();
            fd.append("upload_image", $("#upload_image_3")[0].files[0]);
            fd.append('employer_id',{{ $employer->id }});

            $.ajax({
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                url: '{{ route("employer-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    
                }
            })
        }
    })

    $('#image_upload_remove_3').click(function() {
        $('#image_upload_preview_3').attr('src', 'https://placehold.co/280x140/#E4E3E2');
        $('#image_upload_remove_3').addClass('d-none');
        $('#upload_image_3').val('');
        var id = $(this).attr('attr-id');
        $.ajax({
            type: 'POST',
            data: {
                'employer_id' : {{ $employer->id }}
            },
            url: 'employer-media/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                
                MSalert.principal({
                    icon:'success',
                    title:'',
                    description:response.msg,
                });
            }
        })
    })

    $("#upload_image_4").change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_upload_preview_4').attr('src', e.target.result);
                $('#image_upload_remove_4').removeClass('d-none');
                
            };
            reader.readAsDataURL(this.files[0]);
            var fd = new FormData();
            fd.append("upload_image", $("#upload_image_4")[0].files[0]);
            fd.append('employer_id',{{ $employer->id }});

            $.ajax({
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                url: '{{ route("employer-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    
                }
            })
        }
    })

    $('#image_upload_remove_4').click(function() {
        $('#image_upload_preview_4').attr('src', 'https://placehold.co/280x140/#E4E3E2');
        $('#image_upload_remove_4').addClass('d-none');
        $('#upload_image_4').val('');
        var id = $(this).attr('attr-id');
        $.ajax({
            type: 'POST',
            data: {
                'employer_id' : {{ $employer->id }}
            },
            url: 'employer-media/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                
                MSalert.principal({
                    icon:'success',
                    title:'',
                    description:response.msg,
                });
            }
        })
    })

    $("#upload_image_5").change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_upload_preview_5').attr('src', e.target.result);
                $('#image_upload_remove_5').removeClass('d-none');
                
            };
            reader.readAsDataURL(this.files[0]);
            var fd = new FormData();
            fd.append("upload_image", $("#upload_image_5")[0].files[0]);
            fd.append('employer_id',{{ $employer->id }});

            $.ajax({
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                url: '{{ route("employer-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    
                }
            })
        }
    })

    $('#image_upload_remove_5').click(function() {
        $('#image_upload_preview_5').attr('src', 'https://placehold.co/280x140/#E4E3E2');
        $('#image_upload_remove_5').addClass('d-none');
        $('#upload_image_5').val('');
        var id = $(this).attr('attr-id');
        $.ajax({
            type: 'POST',
            data: {
                'employer_id' : {{ $employer->id }}
            },
            url: 'employer-media/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                
                MSalert.principal({
                    icon:'success',
                    title:'',
                    description:response.msg,
                });
            }
        })
    })

    $("#upload_image_6").change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_upload_preview_6').attr('src', e.target.result);
                $('#image_upload_remove_6').removeClass('d-none');
                
            };
            reader.readAsDataURL(this.files[0]);
            var fd = new FormData();
            fd.append("upload_image", $("#upload_image_6")[0].files[0]);
            fd.append('employer_id',{{ $employer->id }});

            $.ajax({
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                url: '{{ route("employer-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    
                }
            })
        }
    })

    $('#image_upload_remove_6').click(function() {
        $('#image_upload_preview_6').attr('src', 'https://placehold.co/280x140/#E4E3E2');
        $('#image_upload_remove_6').addClass('d-none');
        $('#upload_image_6').val('');
        var id = $(this).attr('attr-id');
        $.ajax({
            type: 'POST',
            data: {
                'employer_id' : {{ $employer->id }}
            },
            url: 'employer-media/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                
                MSalert.principal({
                    icon:'success',
                    title:'',
                    description:response.msg,
                });
            }
        })
    })

    $("#upload_image_7").change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_upload_preview_7').attr('src', e.target.result);
                $('#image_upload_remove_7').removeClass('d-none');
                
            };
            reader.readAsDataURL(this.files[0]);
            var fd = new FormData();
            fd.append("upload_image", $("#upload_image_7")[0].files[0]);
            fd.append('employer_id',{{ $employer->id }});

            $.ajax({
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                url: '{{ route("employer-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    
                }
            })
        }
    })

    $('#image_upload_remove_7').click(function() {
        $('#image_upload_preview_7').attr('src', 'https://placehold.co/280x140/#E4E3E2');
        $('#image_upload_remove_7').addClass('d-none');
        $('#upload_image_7').val('');
        var id = $(this).attr('attr-id');
        $.ajax({
            type: 'POST',
            data: {
                'employer_id' : {{ $employer->id }}
            },
            url: 'employer-media/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                
                MSalert.principal({
                    icon:'success',
                    title:'',
                    description:response.msg,
                });
            }
        })
    })

    $("#upload_image_8").change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_upload_preview_8').attr('src', e.target.result);
                $('#image_upload_remove_8').removeClass('d-none');
                
            };
            reader.readAsDataURL(this.files[0]);
            var fd = new FormData();
            fd.append("upload_image", $("#upload_image_8")[0].files[0]);
            fd.append('employer_id',{{ $employer->id }});

            $.ajax({
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                url: '{{ route("employer-media.store") }}'
            }).done(function(response){
                if(response.status == 'success') {
                    
                }
            })
        }
    })

    $('#image_upload_remove_8').click(function() {
        $('#image_upload_preview_8').attr('src', 'https://placehold.co/280x140/#E4E3E2');
        $('#image_upload_remove_8').addClass('d-none');
        $('#upload_image_8').val('');
        var id = $(this).attr('attr-id');
        $.ajax({
            type: 'POST',
            data: {
                'employer_id' : {{ $employer->id }}
            },
            url: 'employer-media/destory/'+id,
        }).done(function(response){
            if(response.status == 'success') {
                
                MSalert.principal({
                    icon:'success',
                    title:'',
                    description:response.msg,
                });
            }
        })
    })
</script>
@endpush