@extends('frontend.layouts.app')
@section('content')

<div class="container m-auto">
    <div class="seeker-dashboard-header text-center py-5">
        @if(Auth::guard('seeker')->user()->image)
        <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
        @else
        <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
        @endif
        <div class="seeker-name p-0" style="color: #fff">{{ Auth::guard('seeker')->user()->first_name }} {{ Auth::guard('seeker')->user()->last_name }}</div>
    </div>
    <ul class="nav d-flex justify-content-between p-5" id="seekerTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="#" class="seeker-single-tab active" id="profile-dashboard-tab" data-bs-toggle="tab" data-bs-target="#profile-dashboard" role="tab" aria-controls="profile-dashboard" aria-selected="true">Profile Dashboard</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="seeker-single-tab" id="edit-profile-tab" data-bs-toggle="tab" data-bs-target="#edit-profile" role="tab" aria-controls="edit-profile" aria-selected="false">Edit Profile</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="seeker-single-tab" id="job-application-tab" data-bs-toggle="tab" data-bs-target="#job-application" role="tab" aria-controls="job-application" aria-selected="false">Job Applications</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="seeker-single-tab" id="fav-job-tab" data-bs-toggle="tab" data-bs-target="#fav-job" role="tab" aria-controls="fav-job" aria-selected="false">Favourite Jobs</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="seeker-single-tab" id="job-alert-tab" data-bs-toggle="tab" data-bs-target="#job-alert" role="tab" aria-controls="job-alert" aria-selected="false">Job Alerts</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="seeker-single-tab" id="who-view-tab" data-bs-toggle="tab" data-bs-target="#who-view" role="tab" aria-controls="who-view" aria-selected="false">Who Viewed</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="seeker-single-tab" id="manage-resume-tab" data-bs-toggle="tab" data-bs-target="#manage-resume" role="tab" aria-controls="manage-resume" aria-selected="false">Manage Resume</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="seeker-single-tab" id="my-following-tab" data-bs-toggle="tab" data-bs-target="#my-following" role="tab" aria-controls="my-following" aria-selected="false">My Following</a>
        </li>
    </ul>
    <div class="tab-content" id="seekerTabContent">
        <div class="tab-pane fade p-0 show active" id="profile-dashboard" role="tabpanel" aria-labelledby="profile-dashboard-tab">@include('seeker.profile.profile-dashboard')</div>
        <div class="tab-pane fade p-0" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">@include('seeker.profile.edit-profile')</div>
        <div class="tab-pane fade p-0" id="job-application" role="tabpanel" aria-labelledby="job-application-tab">Job Applications</div>
        <div class="tab-pane fade p-0" id="fav-job" role="tabpanel" aria-labelledby="fav-job-tab">Favourite Jobs</div>
        <div class="tab-pane fade p-0" id="job-alert" role="tabpanel" aria-labelledby="job-alert-tab">Job Alerts</div>
        <div class="tab-pane fade p-0" id="who-view" role="tabpanel" aria-labelledby="who-view-tab">Who Viewed</div>
        <div class="tab-pane fade p-0" id="manage-resume" role="tabpanel" aria-labelledby="manage-resume-tab">Manage Resume</div>
        <div class="tab-pane fade p-0" id="my-following" role="tabpanel" aria-labelledby="my-following-tab">My Following</div>
    </div>
    
</div>

@endsection
@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#profile-dashboard-tab').click(function() {
        window.location.reload();
    })
</script>
@endpush