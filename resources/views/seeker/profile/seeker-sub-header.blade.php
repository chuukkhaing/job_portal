<div class="seeker-dashboard-header text-center py-5 mt-4 d-none d-lg-block">
    @if(Auth::guard('seeker')->user()->image)
    <img src="{{ getS3File('seeker/profile/'.Auth::guard('seeker')->user()->id ,Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
    @else
    <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
    @endif
    <div class="seeker-name p-0" style="color: #fff">{{ Auth::guard('seeker')->user()->first_name }} {{ Auth::guard('seeker')->user()->last_name }}</div>
</div>
<div class="edit-profile-tab-border d-none d-lg-block">
    <ul class="nav d-flex justify-content-between py-3 px-xl-5 px-lg-3" id="seekerTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{ route('profile.index') }}" class="seeker-single-tab {{ Request::is('seeker/profile') ? 'active' : '' }}" id="profile-dashboard-tab">Dashboard</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="seeker-single-tab {{ Request::is('seeker/profile/*') ? 'active' : '' }}" id="edit-profile-tab">Profile</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('seeker-applications') }}" class="seeker-single-tab {{ Request::is('seeker/application') ? 'active' : '' }}" id="job-application-tab">Applications</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('seeker-saved-jobs') }}" class="seeker-single-tab {{ Request::is('seeker/saved-job') ? 'active' : '' }}" id="fav-job-tab">Saved Jobs</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('seeker-job-alerts') }}" class="seeker-single-tab {{ Request::is('seeker/job-alerts') ? 'active' : '' }}" id="job-alert-tab">Job Alerts</a>
        </li>
    </ul>
</div>
<div class="d-block d-lg-none p-4 my-4 seeker-dashboard-mobile">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Seeker Toggle Mobile" id="seeker-toggle-mobile">
            <i class="fa-solid fa-bars text-white"></i> <span class="text-white">Profile Dashboard</span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">

            <ul class="navbar-nav">
                <li class="nav-item pt-3">
                    <a href="{{ route('profile.index') }}" class="text-white {{ Request::is('seeker/profile') ? 'active' : '' }}" id="">Dashboard</a>
                </li>
                <li class="nav-item pt-3">
                    <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="text-white {{ Request::is('seeker/profile/*') ? 'active' : '' }}" id="">Profile</a>
                </li>
                <li class="nav-item pt-3">
                    <a href="{{ route('seeker-applications') }}" class="text-white {{ Request::is('seeker/application') ? 'active' : '' }}" id="">Applications</a>
                </li>
                <li class="nav-item pt-3">
                    <a href="{{ route('seeker-saved-jobs') }}" class="text-white {{ Request::is('seeker/saved-job') ? 'active' : '' }}" id="">Saved Jobs</a>
                </li>
                <li class="nav-item pt-3">
                    <a href="{{ route('seeker-job-alerts') }}" class="text-white {{ Request::is('seeker/job-alerts') ? 'active' : '' }}" id="">Job Alerts</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <div class="seeker-profile-mobile">
        <div class="px-4 pt-4">
        @if(Auth::guard('seeker')->user()->image)
            <img src="{{ getS3File('seeker/profile/'.Auth::guard('seeker')->user()->id ,Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle mb-2" id="ProfilePreview">
            @else
            <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle mb-2" id="ProfilePreview">
            @endif
            <div class="seeker-name p-0 mb-2" style="color: #fff">{{ Auth::guard('seeker')->user()->first_name }} {{ Auth::guard('seeker')->user()->last_name }}</div>
            @if(Auth::guard('seeker')->user()->phone)
            <div class="mb-2">
                <i class="fa-solid fa-phone seeker-icon text-white"></i><a href="tel:+{{ Auth::guard('seeker')->user()->phone }}" class="seeker-info text-white px-2">{{ Auth::guard('seeker')->user()->phone }}</a>
            </div>
            @endif
            <div class="mb-2">
                <i class="fa-solid fa-envelope seeker-icon text-white"></i><a href="mailto:{{ Auth::guard('seeker')->user()->email }}" class="seeker-info text-white px-2">{{ Auth::guard('seeker')->user()->email }}</a>
            </div>
            <div class="mb-2">
                <i class="fa-solid fa-link seeker-icon text-white"></i><span class="seeker-info text-white px-2">Member Since, {{ date('M d, Y', strtotime(Auth::guard('seeker')->user()->register_at)) }}</span>
            </div>
            <div class="d-flex form-check form-switch ms-4 mt-2">
                <div class="">
                <label class="form-check-label seeker-name text-white" for="immediate_available">Immediate Available</label><br>
                </div>
                <input class="form-check-input" type="checkbox" @if(Auth::guard('seeker')->user()->is_immediate_available == 1) checked @endif role="switch" id="immediate_available">
            </div>
        </div>
    </div>
</div>