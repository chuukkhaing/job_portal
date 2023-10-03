@extends('frontend.layouts.app')
@section('content')

<div class="container m-auto">
    <div class="seeker-dashboard-header text-center py-5 mt-4">
        @if(Auth::guard('seeker')->user()->image)
        <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
        @else
        <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
        @endif
        <div class="seeker-name p-0" style="color: #fff">{{ Auth::guard('seeker')->user()->first_name }} {{ Auth::guard('seeker')->user()->last_name }}</div>
    </div>
    <div class="edit-profile-tab-border">
        <ul class="nav d-flex justify-content-between py-3 px-5" id="seekerTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('profile.index') }}" class="seeker-single-tab" id="profile-dashboard-tab">Dashboard</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="seeker-single-tab active" id="edit-profile-tab">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-applications') }}" class="seeker-single-tab" id="job-application-tab">Applications</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-saved-jobs') }}" class="seeker-single-tab" id="fav-job-tab">Saved Jobs</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-job-alerts') }}" class="seeker-single-tab" id="job-alert-tab">Job Alerts</a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="seekerTabContent">
        <div class="tab-pane fade p-0 show active" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
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
        </div>
    </div>
    
</div>

@endsection