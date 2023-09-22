<form action="{{ route('profile.update', Auth::guard('seeker')->user()->id) }}" method="post" enctype="multipart/form-data">
    @csrf 
    @method('PUT')
    <div class="container-fluid px-5 py-3 edit-profile-header-border"  id="edit-profile-header">
        <h5>Account Information</h5>
            
        <div class="row">
            <div class="form-group mt-1 col">
                <label for="email" class="seeker_label my-2">Mail <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control seeker_input" value="{{ old('email', Auth::guard('seeker')->user()->email) }}" placeholder="Mail Address">

                @error('email')
                    <span class="text-danger mb-1">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        
            <div class="form-group mt-1 col">
                <label for="password" class="seeker_label my-2">Password</label>
                <input type="password" name="password" id="password" class="form-control seeker_input" value="" placeholder="********">
            </div>
            <div class="form-group mt-1 col">
                <label for="confirm-password" class="seeker_label my-2">Confirm Password</label>
                <input type="password" name="confirm-password" id="confirm-password" class="form-control seeker_input" value="" placeholder="********">
            </div>
            <div class="form-group mt-1 col align-self-end">
                <button type="submit" class="btn btn-sm profile-save-btn">Update Profile and Save</button>
                <a href="{{ route('resume.create') }}" class="btn btn-sm profile-save-btn">CV build</a>
            </div>
        </div>
        
    </div>
</form>
