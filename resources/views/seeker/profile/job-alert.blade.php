@extends('frontend.layouts.app')
@section('content')

<div class="col-xl-10 col-lg-12 m-auto">
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
        
    </div>
    <div class="tab-content" id="seekerTabContent">
        <div class="tab-pane fade p-0 show active" id="job-alert" role="tabpanel" aria-labelledby="job-alert-tab">
            <div class="container-fluid px-xl-5 px-lg-3 py-3 edit-profile-header-border" id="edit-profile-header">
                <div class="">
                    <h5 class="pb-3">My Job Alert List ( {{ $job_alerts->count() }} )</h5>

                    <a href="#" class="btn profile-save-btn btn-sm" onclick="createJobAlert()"><i class="fa-solid fa-plus pe-2"></i>Create Job Alerts</a>
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
                                        <option value="over 8 years">over 8 years</option>
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
            <div class="my-2 py-3 px-lg-5 px-md-3 @if($job_alerts->count() > 0) @else d-none @endif" id="edit-profile-body">
            @if($job_alerts->count() > 0)
                <div class="table-responsive" id="applicant-tracking-section">
                    <table class="table table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Job Title</th>
                                <th>Job Type</th>
                                <th>Job Function</th>
                                <th>Location</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($job_alerts as $key => $job_alert)
                            <tr class="job-alert-tr-{{ $job_alert->id }}">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $job_alert->job_title }}</td>
                                <td>{{ $job_alert->job_type ?? '-' }}</td>
                                <td>@if(isset($job_alert->functional_area_id))<a href="{{ route('search-main-function', $job_alert->functional_area_id) }}" class="fw-bold">{{ $job_alert->FunctionalArea->name }}</a>@else - @endif</td>
                                <td>{{ $job_alert->country }} @if(isset($job_alert->state_id)) , {{ $job_alert->State->name }} @endif</td>
                                <td class="fw-bold">{{ date('M d, Y',strtotime($job_alert->created_at)) }}</td>
                                <td>
                                    <button class="border-0 bg-transparent delete-confirm text-light" type="submit" id="confirmation-{{ $job_alert->id }}" value="{{ $job_alert->id }}"><i class="fas fa-trash-can text-danger"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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

    })

    $(document).on('click', '.delete-confirm', function (e) {
        var id       = $(this).attr('value');

        MSalert.principal({
            icon:'warning',
            title:'Warning',
            description:'Are you sure to delete this entry?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'DELETE',
                    data: {
                        "id": id
                    },
                    url: "/seeker/job-alert/"+id,
                }).done(function(response){
                    if(response.status == 'success') {
                        $(".job-alert-tr-"+id).empty();
                        MSalert.principal({
                            icon:'success',
                            title:'Success',
                            description:response.msg,
                        });
                    }
                })
            }            
        })
    });

    function createJobAlert(){
        $(".job-alert-create-form").removeClass('d-none');
    }

    function cancelJobAlert() {
        $(".job-alert-create-form").addClass('d-none');
        $("#job_alert_form .select_2").val('').trigger('change');
    }
    
</script>
@endpush