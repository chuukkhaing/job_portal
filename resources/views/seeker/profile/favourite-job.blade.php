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
                <a href="{{ route('seeker-saved-jobs') }}" class="seeker-single-tab active" id="fav-job-tab">Saved Jobs</a>
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
                        <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="text-white" id="">Profile</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-applications') }}" class="text-white" id="">Applications</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-saved-jobs') }}" class="text-white active" id="">Saved Jobs</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-job-alerts') }}" class="text-white" id="">Job Alerts</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        
    </div>
    <div class="tab-content" id="seekerTabContent">
        <div class="tab-pane fade p-0 show active" id="fav-job" role="tabpanel" aria-labelledby="fav-job-tab">
            <div class="container-fluid px-xl-5 px-lg-3 py-3 edit-profile-header-border" id="edit-profile-header">
                <div class="">
                    <h5>My Favorite Jobs ( <span id="save-job-count">{{ $saveJobs->count() }}</span> )</h5>
                </div>
            </div>
            
            <div class="my-2 py-3 px-lg-5 px-md-3" id="edit-profile-body">
                @if($saveJobs->count() > 0)
                <div class="table-responsive" id="applicant-tracking-section">
                    <table class="table table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Job Title</th>
                                <th>Company</th>
                                <th>Job Function</th>
                                <th>Location</th>
                                <th>Applied Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($saveJobs as $key => $saveJob)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td class="fw-bold"><a href="{{ route('jobpost-detail', $saveJob->JobPost->slug) }}" class="text-black">{{ $saveJob->JobPost->job_title }}</a></td>
                                <td class="text-blue">{{ $saveJob->JobPost->Employer->name }} @if($saveJob->JobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</td>
                                <td>
                                    {{ $saveJob->JobPost->MainFunctionalArea->name }} , 
                                    {{ $saveJob->JobPost->SubFunctionalArea->name }}
                                </td>
                                <td>
                                    {{ $saveJob->JobPost->Township->name ?? '' }} {{ $saveJob->JobPost->Township ? ',' : '' }} 
                                    {{ $saveJob->JobPost->State->name ?? '' }}
                                </td>
                                <td class="fw-bold">{{ date('d M,Y', strtotime($saveJob->created_at)) }}</td>
                                <td>
                                <a href="" onclick="saveJob({{ $saveJob->JobPost->id }})" class="text-danger"><i class="fas fa-trash-can"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
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

    function saveJob(id) {
        $.ajax({
            type: 'GET',
            data: id,
            url: "/seeker/save-job/"+id,
        }).done(function(response){
            if(response.status == 'remove') {
                
                $('#job-id-'+id).remove();
                $("#save-job-count").text(response.saveJobCount)
                if(response.saveJobCount == 0) {
                    $("#edit-profile-body").addClass('d-none');
                }else {
                    $("#edit-profile-body").removeClass('d-none');
                }
            }
        })
    }

</script>
@endpush