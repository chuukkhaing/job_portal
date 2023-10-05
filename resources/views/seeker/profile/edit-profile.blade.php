@extends('frontend.layouts.app')
@section('content')

<div class="col-xl-10 col-lg-12 m-auto" style="">
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
        <div class="tab-pane fade p-0 show active edit-profile-header-border" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
            <div class="container-fluid">
                <div class="m-0 px-3">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="job-post-detail nav-link active" id="nav-cv-build-tab" data-bs-toggle="tab" data-bs-target="#nav-cv-build" type="button" role="tab" aria-controls="nav-cv-build" aria-selected="true">Build Your CV </button>
                            <button class="job-post-detail nav-link" id="nav-career-choice-tab" data-bs-toggle="tab" data-bs-target="#nav-career-choice" type="button" role="tab" aria-controls="nav-career-choice" aria-selected="false">Career of Choice</button>
                            <button class="job-post-detail nav-link" id="nav-cv-attach-tab" data-bs-toggle="tab" data-bs-target="#nav-cv-attach" type="button" role="tab" aria-controls="nav-cv-attach" aria-selected="false">CV Attachment</button>
                        </div>
                    </nav>
                    
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-cv-build" role="tabpanel" aria-labelledby="nav-cv-build-tab">
                            
                            <div class="container-fluid p-0">
                                <div class="row">
                                    <div class="col mx-0" id="resume-form">
                                        <div class="container-fluid m-auto px-0">
                                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                                        Personal Information
                                                    </button>
                                                    </h2>
                                                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        @include('seeker.resume.personal_information')
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingTwo">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                    Career History
                                                    </button>
                                                    </h2>
                                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        @include('seeker.resume.experience')
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingThree">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                                        Education
                                                    </button>
                                                    </h2>
                                                    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            @include('seeker.resume.education')
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingFour">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                                        Skills
                                                    </button>
                                                    </h2>
                                                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            @include('seeker.resume.skill')
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingFive">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                                        Languages
                                                    </button>
                                                    </h2>
                                                    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            @include('seeker.resume.language')
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingSive">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSive" aria-expanded="false" aria-controls="flush-collapseSive">
                                                        References
                                                    </button>
                                                    </h2>
                                                    <div id="flush-collapseSive" class="accordion-collapse collapse" aria-labelledby="flush-headingSive" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            @include('seeker.resume.reference')
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col p-2 resume-template-background">
                                        <page size="A4">
                                            <h4 class="text-center">Resume</h4>
                                            @include('seeker.resume.personal_details')
                                            <div class="row resume-section mb-3 summary_label @if(Auth::guard('seeker')->user()->summary) @else d-none @endif">
                                                <h6 class="text-white resume-header py-2">Profile Summary</h6>
                                                <div class="col py-2">
                                                    <span class="summary">{!! Auth::guard('seeker')->user()->summary !!}</span>
                                                </div>
                                            </div>
                                            @include('seeker.resume.exp_details')
                                            @include('seeker.resume.edu_details')
                                            @include('seeker.resume.skill_details')
                                            @include('seeker.resume.language_details')
                                            @include('seeker.resume.reference_details')
                                        </page>
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-12 text-end">
                                        <a href="{{ url('/seeker/download-ic-cv/'. Auth::guard('seeker')->user()->id) }}" class="btn btn-sm profile-save-btn">Download CV</a>
                                        <button type="button" class="btn btn-sm profile-save-btn next-career-history">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-3 fade" id="nav-career-choice" role="tabpanel" aria-labelledby="nav-career-choice-tab">
                            @include('seeker.resume.career-of-choice')
                        </div>
                        <div class="tab-pane p-3 fade" id="nav-cv-attach" role="tabpanel" aria-labelledby="nav-cv-attach-tab">
                            @include('seeker.resume.cv-attach')
                        </div>
                    </div>
                </div>
            </div>
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

    $('.next-career-history').click(function() {
        $("#nav-cv-build-tab").removeClass('active');
        $("#nav-career-choice-tab").addClass('active');
        $("#nav-cv-attach-tab").removeClass('active');
        $("#nav-cv-build").removeClass('show active');
        $("#nav-career-choice").addClass('show active');
        $("#nav-cv-attach").removeClass('show active');
    })
</script>
@endpush