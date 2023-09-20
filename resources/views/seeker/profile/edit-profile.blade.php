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
            </div>
        </div>
        
    </div>
</form>
<div class="container-fluid my-2" id="edit-profile-body">
    <div class="m-0 pb-0 pt-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="p-3 job-post-detail nav-link active" id="nav-cv-build-tab" data-bs-toggle="tab" data-bs-target="#nav-cv-build" type="button" role="tab" aria-controls="nav-cv-build" aria-selected="true">Build Your CV </button>
                <button class="p-3 job-post-detail nav-link" id="nav-career-choice-tab" data-bs-toggle="tab" data-bs-target="#nav-career-choice" type="button" role="tab" aria-controls="nav-career-choice" aria-selected="false">Career of Choice</button>
                <button class="p-3 job-post-detail nav-link" id="nav-cv-attach-tab" data-bs-toggle="tab" data-bs-target="#nav-cv-attach" type="button" role="tab" aria-controls="nav-cv-attach" aria-selected="false">Career of Choice</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane p-3 fade show active" id="nav-cv-build" role="tabpanel" aria-labelledby="nav-cv-build-tab">
                @include('seeker.resume.create')
            </div>
            <div class="tab-pane fade" id="nav-career-choice" role="tabpanel" aria-labelledby="nav-career-choice-tab">
                ...
            </div>
            <div class="tab-pane fade" id="nav-cv-attach" role="tabpanel" aria-labelledby="nav-cv-attach-tab">
                ...
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12 text-end">
            <button type="button" class="btn btn-sm profile-save-btn">Next</button>
        </div>
    </div>
</div>
