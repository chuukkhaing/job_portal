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
                <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="seeker-single-tab" id="edit-profile-tab">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-applications') }}" class="seeker-single-tab" id="job-application-tab">Applications</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-saved-jobs') }}" class="seeker-single-tab" id="fav-job-tab">Saved Jobs</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-job-alerts') }}" class="seeker-single-tab active" id="job-alert-tab">Job Alerts</a>
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
                        <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="text-white" id="">Profile</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-applications') }}" class="text-white" id="">Applications</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-saved-jobs') }}" class="text-white" id="">Saved Jobs</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-job-alerts') }}" class="text-white active" id="">Job Alerts</a>
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
        <div class="tab-pane fade p-0 show active" id="job-alert" role="tabpanel" aria-labelledby="job-alert-tab">
            <div class="container-fluid px-xl-5 px-lg-3 py-3 edit-profile-header-border" id="edit-profile-header">
                <div class="">
                    <h5 class="pb-3">My Job Alert List ( {{ $job_alerts->count() }} )</h5>

                    <a href="#" class="btn profile-save-btn" onclick="createJobAlert()"><i class="fa-solid fa-plus pe-2"></i>Create Job Alerts</a>
                </div>
            </div>
            <div class="my-2 pb-3 job-alert-create-form d-none" id="edit-profile-body">
                <div class="px-xl-5 px-lg-3 p-3 pb-0">
                    <h5>Create Job Alert by Emails</h5>
                </div>
                <div class="row px-xl-5 px-lg-3 m-0 pb-0">
                    <form action="{{ route('job-alert.store') }}" method="post" id="job_alert_form">
                        @csrf
                        <div class="py-3">
                            <h5 class="text-blue">What is your email address?</h5>
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_alert_email" class="seeker_label my-2">Mail <span class="text-danger">*</span></label>
                                    <input type="email" name="job_alert_email" id="job_alert_email" class="form-control seeker_input @error('job_alert_email') is-invalid @enderror" placeholder="Enter Your Mail" style="width: 100%">
                                    @error('job_alert_email')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="py-3">
                            <h5 class="text-blue">Job Details</h5>
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_alert_title" class="seeker_label my-2">Job Alert Title <span class="text-danger">*</span></label>
                                    <input type="text" name="job_alert_title" id="job_alert_title" class="form-control seeker_input @error('job_alert_title') is-invalid @enderror" placeholder="Enter Job Title" style="width: 100%">
                                    @error('job_alert_title')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_alert_job_type" class="seeker_label my-2">Job Type </label>
                                    <select name="job_alert_job_type" id="job_alert_job_type" class="select_2 form-control seeker_input @error('job_alert_job_type') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach(config('jobtype') as $jobtype)
                                        <option value="{{ $jobtype }}" >{{ $jobtype }}</option>
                                        @endforeach
                                    </select>
                                    @error('job_alert_job_type')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_alert_industry" class="seeker_label my-2">Job Industry </label>
                                    <select name="job_alert_industry" id="job_alert_industry" class="select_2 form-control seeker_input @error('job_alert_industry') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach($industries as $industry)
                                        <option value="{{ $industry->id }}" >{{ $industry->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('job_alert_industry')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_alert_career_level" class="seeker_label my-2">Job Level/ Career Level </label>
                                    <select name="job_alert_career_level" id="job_alert_career_level" class="select_2 form-control seeker_input @error('job_alert_career_level') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach(config('careerlevel') as $careerlevel)
                                        <option value="{{ $careerlevel }}" >{{ $careerlevel }}</option>
                                        @endforeach
                                    </select>
                                    @error('job_alert_career_level')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_alert_functional_area" class="seeker_label my-2">Job Functional Area </label>
                                    <select name="job_alert_functional_area" id="job_alert_functional_area" class="select_2 form-control seeker_input @error('job_alert_functional_area') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach($functional_areas as $functional_area)
                                        <option value="{{ $functional_area->id }}" >{{ $functional_area->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('job_alert_functional_area')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="job_alert_experience_level" class="seeker_label my-2">Experience Level </label>
                                    <select name="job_alert_experience_level" id="job_alert_experience_level" class="select_2 form-control seeker_input @error('job_alert_experience_level') is-invalid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        <option value="Less than 1 year">Less than 1 year</option>
                                        <option value="1 year">1 year</option>
                                        <option value="2 years">2 years</option>
                                        <option value="3 years">3 years</option>
                                        <option value="4 years">4 years</option>
                                        <option value="5 years">5 years</option>
                                        <option value="6 years">6 years</option>
                                        <option value="7 years">7 years</option>
                                        <option value="8 years">8 years</option>
                                    </select>
                                    @error('job_alert_experience_level')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="py-3">
                            <h5 class="text-blue">Location</h5>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="job_alert_country" class="seeker_label my-2">Country </label>
                                    <select name="job_alert_country" id="job_alert_country" class="select_2 seeker_input @error('job_alert_country') is-invalid @enderror" style="width: 100%">
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    @error('job_alert_country')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6 job_alert_state_field">
                                    <label for="job_alert_state" class="seeker_label my-2">State or Region </label><br>
                                    <select name="job_alert_state" id="job_alert_state" class="select_2 form-control seeker_input @error('job_alert_state') is-valid @enderror" style="width: 100%">
                                        <option value="">Choose...</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('job_alert_state')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="reset" class="btn border seeker_image_input_label" onclick="cancelJobAlert()">Cancel</button>
                                <button type="submit" class="btn profile-save-btn">Save Job Alert</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if($job_alerts->count() > 0)
            <div class="my-2 pb-3" id="edit-profile-body">
                
                <div class="row px-xl-5 px-lg-3 m-0 pb-0 pt-3">
                    @foreach($job_alerts as $job_alert)
                    <div class="col-md-6 col-12 m-0 p-0">
                        
                        <div class="row job-content mb-3 m-1">
                            <!-- Job List Start -->
                            
                            <div class="col-lg-8 col-md-7 py-4">
                                @if(isset($job_alert->country))
                                <p>
                                    <span><i class="text-gray pe-2 fa-solid fa-location-pin"></i></span>
                                    <span class="text-gray">{{ $job_alert->country }} @if(isset($job_alert->state_id)) , {{ $job_alert->State->name }} @endif</span>
                                </p>
                                @endif
                                <h5 class="text-blue">{{ $job_alert->job_title }}</h5>
                                @if($job_alert->job_type)
                                <p>{{ $job_alert->job_type }}</p>
                                @endif
                                
                                <div class="">
                                    @if($job_alert->functional_area_id)
                                    <a href="{{ route('search-main-function', $job_alert->functional_area_id) }}" style="border: 1px solid #95B6D8; border-radius: 50px" class="text-dark p-2">{{ $job_alert->FunctionalArea->name }}</a>
                                    @endif
                                    <div class="text-end">
                                        <i class="fa-regular fa-bookmark"></i>
                                        <span>{{ date('M d, Y',strtotime($job_alert->created_at)) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Job List End -->

                            <!-- Wishlist Start -->
                            <div class="col-lg-4 col-md-5 d-md-flex d-none py-4">
                                <div class="row col-12 m-0 p-0">
                                    <div class="text-end p-1">
                                        <span><i class="fa-regular fa-bookmark"></i></span>
                                        <span>{{ date('M d, Y',strtotime($job_alert->created_at)) }}</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Wishlist End -->
                        </div>
                    </div>
                    @endforeach
                    <div class="row">
                        <div class="col pt-2">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                            {{ $job_alerts->appends(request()->all())->links('pagination::bootstrap-4') }}
                            </ul>
                        </nav>
                        </div>
                    </div>
                    
                </div>
            </div>
            @endif
        </div>
    </div>
    
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        var errors = [];
        errors = @json($errors->any());
        if(errors) {
            $(".job-alert-create-form").removeClass('d-none');
        }

        $("#job_alert_country").change(function() {
            if($(this).val() == "Myanmar") {
                $(".job_alert_state_field").removeClass('d-none');
            }else {
                $(".job_alert_state_field").addClass('d-none');
                $("#job_alert_state").val('').trigger('change');
            }
        })

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

    function createJobAlert(){
        $(".job-alert-create-form").removeClass('d-none');
    }

    function cancelJobAlert() {
        $(".job-alert-create-form").addClass('d-none');
        $("#job_alert_form .select_2").val('').trigger('change');
    }
    
</script>
@endpush