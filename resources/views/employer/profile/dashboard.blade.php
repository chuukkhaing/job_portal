@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    <div class="row employer-dashboard-header bg-light m-0">
        <div class="col-2 p-3">
            <a href="{{ route('employer-profile.index') }}">
            @if($employer->logo)
            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Company Logo" class="employer-header-logo">
            @else
            <img src="{{ asset('img/employer/Vertical Logo.svg') }}" alt="Company Logo" class="employer-header-logo">
            @endif
            </a>
        </div>
        <div class="col-10 p-3">
            <div class="mb-4">
                <h4 class="fw-bold d-inline-block">Upgrade Your Package</h4>
                <div class="float-end">
                    {{--<a href="http://" class="btn btn-outline-primary">Add-on Features</a>--}}
                    <a href="http://" class="btn profile-save-btn" data-bs-toggle="modal" data-bs-target="#cardModal">Package Details</a>
                </div>
            </div>
            <p>Our packing pricing design allows you to choose the right package that best fits your business needs. We offer a variety of options, each with different features, points, and pricing. Simply select the package that works best for you, and our team will take care of the rest.</p>
            <div class="row">
                <div class="col-4 p-1">
                    <div class="economy p-3" @if($employer->Package && $employer->Package->name == "Economy Package") style="border: 1px solid #0565FF" @endif>
                        Economy
                        @if($employer->Package && $employer->Package->name == "Economy Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
                <div class="col-4 p-1">
                    <div class="standard p-3" @if($employer->Package && $employer->Package->name == "Standard Package") style="border: 1px solid #C72C91" @endif>
                        Standard
                        @if($employer->Package && $employer->Package->name == "Standard Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
                <div class="col-4 p-1">
                    <div class="premium p-3" @if($employer->Package && $employer->Package->name == "Premium Package") style="border: 1px solid #F58220" @endif>
                        Premium
                        @if($employer->Package && $employer->Package->name == "Premium Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs d-flex justify-content-between p-3 my-1 bg-light" id="employerTab" role="tablist">
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','dashboard')->count() > 0))
        <li class="nav-item" role="presentation">
            <a href="#employer-dashboard" class="employer-single-tab active" id="employer-dashboard-tab" data-bs-toggle="tab" data-bs-target="#employer-dashboard" role="tab" aria-controls="employer-dashboard" aria-selected="true">Dashboard</a>
        </li>
        @endif
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','profile')->count() > 0))
        <li class="nav-item" role="presentation">
            <a href="#employer-profile-edit" class="employer-single-tab" id="employer-profile-edit-tab" data-bs-toggle="tab" data-bs-target="#employer-profile-edit" role="tab" aria-controls="employer-profile-edit" aria-selected="false">Employer Profile</a>
        </li>
        @endif
        {{--<li class="nav-item" role="presentation">
            <a href="#employer-profile" class="employer-single-tab" id="employer-profile-tab" data-bs-toggle="tab" data-bs-target="#employer-profile" role="tab" aria-controls="employer-profile" aria-selected="false">Employer Profile</a>
        </li>--}}
        {{--<li class="nav-item" role="presentation">
            <a href="#post-job" class="employer-single-tab" id="post-job-tab" data-bs-toggle="tab" data-bs-target="#post-job" role="tab" aria-controls="post-job" aria-selected="false">Post Jobs</a>
        </li>--}}
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','manage_job')->count() > 0))
        <li class="nav-item" role="presentation">
            <a href="#employer-job" class="employer-single-tab" id="employer-job-tab" data-bs-toggle="tab" data-bs-target="#employer-job" role="tab" aria-controls="employer-job" aria-selected="false">Manage Job</a>
        </li>
        @endif
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','application_tracking')->count() > 0))
        @foreach($packageItems as $packageItem)
        @if($packageItem->name == 'Application Management')
        <li class="nav-item" role="presentation">
            <a href="#applicant-tracking" class="employer-single-tab" id="applicant-tracking-tab" data-bs-toggle="tab" data-bs-target="#applicant-tracking" role="tab" aria-controls="applicant-tracking" aria-selected="false">Applicant Tracking</a>
        </li>
        @endif
        @endforeach
        @endif
        {{--<li class="nav-item" role="presentation">
            <a href="#follower" class="employer-single-tab" id="follower-tab" data-bs-toggle="tab" data-bs-target="#follower" role="tab" aria-controls="follower" aria-selected="false">Followers</a>
        </li>--}}
    </ul>
    <div class="tab-content" id="employerTabContent">
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','dashboard')->count() > 0))
        <div class="tab-pane fade p-0 show active" id="employer-dashboard" role="tabpanel" aria-labelledby="employer-dashboard-tab">@include('employer.profile.employer-dashboard')</div>
        @endif
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','profile')->count() > 0))
        <div class="tab-pane fade p-0" id="employer-profile-edit" role="tabpanel" aria-labelledby="employer-profile-edit-tab">@include('employer.profile.edit')</div>
        @endif
        {{--<div class="tab-pane fade p-0" id="employer-profile" role="tabpanel" aria-labelledby="employer-profile-tab">Employer Profile</div>--}}
        {{--<div class="tab-pane fade p-0" id="post-job" role="tabpanel" aria-labelledby="post-job-tab">@include('employer.profile.post-job')</div>--}}
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','manage_job')->count() > 0))
        <div class="tab-pane fade p-0" id="employer-job" role="tabpanel" aria-labelledby="employer-job-tab">@include('employer.profile.employer-job')</div>
        @endif
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','application_tracking')->count() > 0))
        <div class="tab-pane fade p-0" id="applicant-tracking" role="tabpanel" aria-labelledby="applicant-tracking-tab">@include('employer.profile.applicant-tracking')</div>
        @endif
        {{--<div class="tab-pane fade p-0" id="follower" role="tabpanel" aria-labelledby="follower-tab">Followers</div>--}}
    </div>
    
</div>

@endsection

@push('css')
    <style>
        .modal-pricing {
            max-width: 80%;
        }
    </style>
@endpush

@push('scripts')
<script>
    $('#employerTab a').click(function(e) {
        e.preventDefault();
        var target = $(this).attr('data-bs-target');
        localStorage.setItem('target',target)
    });
    var current_employer_tab = localStorage.getItem('target');
    var return_current_employer_tab = document.querySelector('#employerTab li a[href="'+current_employer_tab+'"]')
    var show_current_tab = new bootstrap.Tab(return_current_employer_tab)

    show_current_tab.show()
</script>
@endpush