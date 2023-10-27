<div class="row employer-dashboard-header m-0">
    <div class="col-lg-2 col-md-3 p-3">
        <a href="{{ route('employer-profile.index') }}">
        @if($employer->logo)
        <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Employer Logo" class="employer-header-logo shadow-lg">
        @else
        <img src="{{ asset('img/icon/company.png') }}" alt="Employer Logo" class="employer-header-logo shadow-lg">
        @endif
        </a>
    </div>
    <div class="col-lg-10 col-md-9 p-3">
        <div class="mb-4">
            <h4 class="fw-bold d-inline-block">Upgrade Your Package</h4>
            <div class="float-end">
                {{--<a href="http://" class="btn btn-outline-primary">Add-on Features</a>--}}
                <a href="http://" class="btn profile-save-btn" data-bs-toggle="modal" data-bs-target="#cardModal">Buy Your Points</a>
                <a href="http://" class="btn profile-save-btn" data-bs-toggle="modal" data-bs-target="#cardModal">Package Details</a>
            </div>
        </div>
        <p>Our packing pricing design allows you to choose the right package that best fits your business needs. We offer a variety of options, each with different features, points, and pricing. Simply select the package that works best for you, and our team will take care of the rest.</p>
        <div class="row d-lg-flex d-none">
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
    <div class="row d-lg-none d-flex">
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
@if(Request::is('employer/point-history'))
@else
<div class="px-lg-5 px-md-3 px-0 ">
    <ul class="nav nav-tabs d-flex justify-content-between p-2 my-1" id="employerTab">
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','dashboard')->count() > 0))
        <li class="nav-item">
            <a href="{{ route('employer-profile.index') }}" class="employer-single-tab {{ Request::is('employer/employer-profile') ? 'active' : '' }}">Dashboard</a>
        </li>
        @endif
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','profile')->count() > 0))
        <li class="nav-item">
            <a href="{{ route('employer-profile.edit', $employer->id) }}" class="employer-single-tab {{ Request::is('employer/employer-profile/*') ? 'active' : '' }} {{ Request::is('employer/member-user*') ? 'active' : '' }}">Profile</a>
        </li>
        @endif
        
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','manage_job')->count() > 0))
        <li class="nav-item">
            <a href="{{ route('manageJob') }}" class="employer-single-tab {{ Request::is('employer/manage-job') ? 'active' : '' }} {{ Request::is('employer/employer-job-post*') ? 'active' : '' }}" >Manage Job</a>
        </li>
        @endif
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','application_tracking')->count() > 0))
        @foreach($packageItems as $packageItem)
        @if($packageItem->name == 'Application Management')
        <li class="nav-item">
            <a href="{{ route('applicantTracking') }}" class="employer-single-tab {{ Request::is('employer/applicant-tracking') ? 'active' : '' }}" >Applicant Tracking</a>
        </li>
        @endif
        @endforeach
        @endif
    </ul>
</div>
@endif
<hr style="border-bottom: 5px solid gray;">   