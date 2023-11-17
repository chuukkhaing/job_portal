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
            <input type="text" name="first_name" id="first_name" class="form-control" value="" onchange="updateProfile('first_name', this.value)" placeholder="First Name">
        </div>
        <div class="form-group col-12 col-lg-6">
            <label for="last_name" class="">Last Name <span class="text-danger">*</span></label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="" onchange="updateProfile('last_name', this.value)" placeholder="Last Name">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-12 col-lg-6">
            <label for="dob" class="">Date of Birth <span class="text-danger">*</span></label>
            <div class="datepicker date input-group" id="dob">
                
                <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" autocomplete="off" value="" onchange="updateProfile('date_of_birth', this.value)" placeholder="Date of Birth">
                
                <div class="input-group-append">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group col-12 col-lg-6">
            <label for="phone" class="">Phone <span class="text-danger">*</span></label>
            <input type="number" name="phone" id="phone" class="form-control " value="" placeholder="09xxxxxxxxx">
        </div>
        <div class="form-group col-12 col-lg-6">
            <label for="gender" class="">Gender  <span class="text-danger">*</span></label>
            <select name="gender" id="gender" class="form-control resume_select_2" style="width: 100%" onchange="updateProfile('gender', this.value)">
                <option value="">Choose</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="form-group col-12 col-lg-6">
            <label for="marital_status" class="">Marital Status</label>
            <select name="marital_status" id="marital_status" class="form-control resume_select_2" style="width: 100%" onchange="updateProfile('marital_status', this.value)">
                <option value="">Choose</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
            </select>
        </div>
        <div class="form-group col-12 col-lg-6">
            <label for="nationality" class="">Nationality <span class="text-danger">*</span></label>
            <select name="nationality" id="nationality" class="form-control resume_select_2" style="width: 100%" onchange="updateProfile('nationality', this.value)">
                <option value="">Choose</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-group col-12 col-lg-6" id="nrc_field">
            <label for="nrc" class="">NRC <span class="text-danger">*</span></label>
            <input type="text" name="nrc" id="nrc" class="form-control" value="" onchange="updateProfile('nrc', this.value)" placeholder="NRC">
        </div>

        <div class="form-group col-12 col-lg-6" id="id_card_field">
            <label for="id_card" class="">ID Card <span class="text-danger">*</span></label>
            <input type="text" name="id_card" id="id_card" class="form-control" value="" onchange="updateProfile('id_card', this.value)" placeholder="ID Card">
        </div>

        <div class="form-group col-12 col-lg-6">
            <label for="country" class="">Country <span class="text-danger">*</span></label>
            <select name="country" id="country" class="form-control select_2" style="width: 100%" onchange="updateProfile('country', this.value)">
                <option value="">Choose...</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group col-12 col-lg-6" id="state_id_field">
            <label for="state_id" class="">State or Region <span class="text-danger">*</span></label><br>
            <select name="state_id" id="state_id" class="select_2 form-control" style="width: 100%" onchange="updateProfile('state_id', this.value)">
                <option value="">Choose...</option>
                @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group col-12 col-lg-6" id="township_id_field">
            <label for="township_id" class="">City/ Township <span class="text-danger">*</span></label><br>
            <select name="township_id" id="township_id" class="select_2 form-control" style="width: 100%" onchange="updateProfile('township_id', this.value)">
                <option value="">Choose...</option>
                @foreach($townships as $township)
                <option value="{{ $township->id }}">{{ $township->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mt-1 col-12">
            <label for="address_detail" class="">Address Detail</label>
            <textarea name="address_detail" id="address_detail" class="form-control" cols="30" rows="2" onchange="updateProfile('address_detail', this.value)"></textarea>
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