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
                <a href="{{ route('profile.index') }}" class="seeker-single-tab active" id="profile-dashboard-tab">Dashboard</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="seeker-single-tab" id="edit-profile-tab">Profile</a>
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
        <div class="tab-pane fade p-0 show active" id="profile-dashboard" role="tabpanel" aria-labelledby="profile-dashboard-tab">@include('seeker.profile.profile-dashboard')</div>
    </div>
    
</div>

@endsection