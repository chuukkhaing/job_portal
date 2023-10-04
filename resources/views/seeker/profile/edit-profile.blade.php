@extends('frontend.layouts.app')
@section('content')

<div class="container m-auto">
    <div class="seeker-dashboard-header text-center py-5 mt-4 d-none d-lg-block">
        @if(Auth::guard('seeker')->user()->image)
        <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
        @else
        <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
        @endif
        <div class="seeker-name p-0" style="color: #fff">{{ Auth::guard('seeker')->user()->first_name }} {{ Auth::guard('seeker')->user()->last_name }}</div>
    </div>
    <div class="edit-profile-tab-border d-none d-lg-block">
        <ul class="nav d-flex justify-content-between py-3 px-xl-5 px-lg-3" id="seekerTab" role="tablist">
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
    <div class="d-block d-lg-none p-4 my-4 seeker-dashboard-mobile">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Seeker Toggle Mobile" id="seeker-toggle-mobile">
                <i class="fa-solid fa-bars text-white"></i> <span class="text-white">Profile Dashboard</span>
                </button>
                <div class="collapse navbar-collapse" id="navbarToggler">

                <ul class="navbar-nav">
                    <li class="nav-item pt-3">
                        <a href="{{ route('profile.index') }}" class="text-white" id="">Dashboard</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="text-white active" id="">Profile</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-applications') }}" class="text-white" id="">Applications</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-saved-jobs') }}" class="text-white" id="">Saved Jobs</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-job-alerts') }}" class="text-white" id="">Job Alerts</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        <div class="seeker-profile-mobile">
            <div class="px-4 pt-4">
            @if(Auth::guard('seeker')->user()->image)
                <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle mb-2" id="ProfilePreview">
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
    <div class="tab-content" id="seekerTabContent">
        <div class="tab-pane fade p-0 show active" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
            <form action="{{ route('profile.update', Auth::guard('seeker')->user()->id) }}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                <div class="container-fluid px-xl-5 px-lg-3 py-3 edit-profile-header-border"  id="edit-profile-header">
                    <h5>Account Information</h5>
                        
                    <div class="row">
                        <div class="form-group mt-1 col-lg col-md-5">
                            <label for="email" class="seeker_label my-2">Mail <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control seeker_input" value="{{ old('email', Auth::guard('seeker')->user()->email) }}" placeholder="Mail Address">

                            @error('email')
                                <span class="text-danger mb-1">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <div class="form-group mt-1 col-lg col-md-5">
                            <label for="password" class="seeker_label my-2">Password</label>
                            <input type="password" name="password" id="password" class="form-control seeker_input" value="" placeholder="********">
                        </div>
                        <div class="form-group mt-1 col-lg col-md-5">
                            <label for="confirm-password" class="seeker_label my-2">Confirm Password</label>
                            <input type="password" name="confirm-password" id="confirm-password" class="form-control seeker_input" value="" placeholder="********">
                        </div>
                        <div class="form-group mt-1 col-lg col-md-5 align-self-end">
                            <button type="submit" class="btn btn-sm profile-save-btn">Update</button>
                            <a href="{{ route('resume.create') }}" class="btn btn-sm profile-save-btn">CV build</a>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
    
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $("#immediate_available").change(function(){
            var is_immediate_available = {{ Auth::guard("seeker")->user()->is_immediate_available }};
            if($(this).is(":checked") == true) {
                var is_immediate_available = 1
            }else {
                var is_immediate_available = 0
            }
            var seeker_id = {{ Auth::guard("seeker")->user()->id }};
            $.ajax({
                type: 'POST',
                data: {
                    'is_immediate_available' : is_immediate_available
                },
                url: '/seeker/immediate-available/update/'+seeker_id,
            }).done(function(response){
                if(response.status == 'success') {
                    if(response.status == 'success') {
                        
                    }
                }
            })
        })
    })
</script>
@endpush