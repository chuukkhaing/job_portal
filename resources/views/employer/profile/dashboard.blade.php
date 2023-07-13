@extends('frontend.layouts.app')
@section('content')

<div class="container m-auto">
    
    <ul class="nav d-flex justify-content-between p-5" id="employerTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="#" class="employer-single-tab active" id="employer-dashboard-tab" data-bs-toggle="tab" data-bs-target="#employer-dashboard" role="tab" aria-controls="employer-dashboard" aria-selected="true">Dashboard</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="employer-single-tab" id="employer-profile-edit-tab" data-bs-toggle="tab" data-bs-target="#employer-profile-edit" role="tab" aria-controls="employer-profile-edit" aria-selected="false">Edit Profile</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="employer-single-tab" id="employer-profile-tab" data-bs-toggle="tab" data-bs-target="#employer-profile" role="tab" aria-controls="employer-profile" aria-selected="false">Employer Profile</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="employer-single-tab" id="post-job-tab" data-bs-toggle="tab" data-bs-target="#post-job" role="tab" aria-controls="post-job" aria-selected="false">Post Jobs</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="employer-single-tab" id="employer-job-tab" data-bs-toggle="tab" data-bs-target="#employer-job" role="tab" aria-controls="employer-job" aria-selected="false">Employer Jobs</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="employer-single-tab" id="applicant-tracking-tab" data-bs-toggle="tab" data-bs-target="#applicant-tracking" role="tab" aria-controls="applicant-tracking" aria-selected="false">Applicant Tracking</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#" class="employer-single-tab" id="follower-tab" data-bs-toggle="tab" data-bs-target="#follower" role="tab" aria-controls="follower" aria-selected="false">Followers</a>
        </li>
    </ul>
    <div class="tab-content" id="employerTabContent">
        <div class="tab-pane fade p-0 show active" id="employer-dashboard" role="tabpanel" aria-labelledby="employer-dashboard-tab">Dashboard</div>
        <div class="tab-pane fade p-0" id="employer-profile-edit" role="tabpanel" aria-labelledby="employer-profile-edit-tab">@include('employer.profile.edit')</div>
        <div class="tab-pane fade p-0" id="employer-profile" role="tabpanel" aria-labelledby="employer-profile-tab">Employer Profile</div>
        <div class="tab-pane fade p-0" id="post-job" role="tabpanel" aria-labelledby="post-job-tab">@include('employer.profile.post-job')</div>
        <div class="tab-pane fade p-0" id="employer-job" role="tabpanel" aria-labelledby="employer-job-tab">@include('employer.profile.employer-job')</div>
        <div class="tab-pane fade p-0" id="applicant-tracking" role="tabpanel" aria-labelledby="applicant-tracking-tab">@include('employer.profile.applicant-tracking')</div>
        <div class="tab-pane fade p-0" id="follower" role="tabpanel" aria-labelledby="follower-tab">Followers</div>
    </div>
    
</div>

@endsection
