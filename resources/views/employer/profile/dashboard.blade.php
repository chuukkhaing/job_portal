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
                    <a href="http://" class="btn btn-outline-primary">Add-on Features</a>
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
        <li class="nav-item" role="presentation">
            <a href="#employer-dashboard" class="employer-single-tab active" id="employer-dashboard-tab" data-bs-toggle="tab" data-bs-target="#employer-dashboard" role="tab" aria-controls="employer-dashboard" aria-selected="true">Dashboard</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="#employer-profile-edit" class="employer-single-tab" id="employer-profile-edit-tab" data-bs-toggle="tab" data-bs-target="#employer-profile-edit" role="tab" aria-controls="employer-profile-edit" aria-selected="false">Employer Profile</a>
        </li>
        {{--<li class="nav-item" role="presentation">
            <a href="#employer-profile" class="employer-single-tab" id="employer-profile-tab" data-bs-toggle="tab" data-bs-target="#employer-profile" role="tab" aria-controls="employer-profile" aria-selected="false">Employer Profile</a>
        </li>--}}
        {{--<li class="nav-item" role="presentation">
            <a href="#post-job" class="employer-single-tab" id="post-job-tab" data-bs-toggle="tab" data-bs-target="#post-job" role="tab" aria-controls="post-job" aria-selected="false">Post Jobs</a>
        </li>--}}
        <li class="nav-item" role="presentation">
            <a href="#employer-job" class="employer-single-tab" id="employer-job-tab" data-bs-toggle="tab" data-bs-target="#employer-job" role="tab" aria-controls="employer-job" aria-selected="false">Manage Job</a>
        </li>
        @foreach($packageItems as $packageItem)
        @if($packageItem->name == 'Application Management')
        <li class="nav-item" role="presentation">
            <a href="#applicant-tracking" class="employer-single-tab" id="applicant-tracking-tab" data-bs-toggle="tab" data-bs-target="#applicant-tracking" role="tab" aria-controls="applicant-tracking" aria-selected="false">Applicant Tracking</a>
        </li>
        @endif
        @endforeach
        {{--<li class="nav-item" role="presentation">
            <a href="#follower" class="employer-single-tab" id="follower-tab" data-bs-toggle="tab" data-bs-target="#follower" role="tab" aria-controls="follower" aria-selected="false">Followers</a>
        </li>--}}
    </ul>
    <div class="tab-content" id="employerTabContent">
        <div class="tab-pane fade p-0 show active" id="employer-dashboard" role="tabpanel" aria-labelledby="employer-dashboard-tab">@include('employer.profile.employer-dashboard')</div>
        <div class="tab-pane fade p-0" id="employer-profile-edit" role="tabpanel" aria-labelledby="employer-profile-edit-tab">@include('employer.profile.edit')</div>
        {{--<div class="tab-pane fade p-0" id="employer-profile" role="tabpanel" aria-labelledby="employer-profile-tab">Employer Profile</div>--}}
        {{--<div class="tab-pane fade p-0" id="post-job" role="tabpanel" aria-labelledby="post-job-tab">@include('employer.profile.post-job')</div>--}}
        <div class="tab-pane fade p-0" id="employer-job" role="tabpanel" aria-labelledby="employer-job-tab">@include('employer.profile.employer-job')</div>
        <div class="tab-pane fade p-0" id="applicant-tracking" role="tabpanel" aria-labelledby="applicant-tracking-tab">@include('employer.profile.applicant-tracking')</div>
        {{--<div class="tab-pane fade p-0" id="follower" role="tabpanel" aria-labelledby="follower-tab">Followers</div>--}}
    </div>
    
</div>

<!-- Modal -->
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="container-fluid">
                    <h4 class="text-center fs-5 py-3">Infinity Careers Platform Pricing</h4>
                    <div class="row text-light my-3">
                        <div class="col-lg-4 px-4 py-3">
                            <h4 class="fz17 pb-2">Job Seeker Pricing Plans</h4>
                            <p class="text-black">
                                Our packing pricing design allows you to choose the right package that best fits your business needs. We offer a variety of options, each with different features, points, and pricing. Simply select the package that works best for you, and our team will take care of the rest.
                            </p>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                @foreach($packages as $package)
                                @if($package->name == 'Economy Package')
                                <div class="col-lg-4 economy px-4 py-3">
                                    <h3 class="economy-title">Economy</h3>
                                    <p class="economy-desc mb-4">Our Basic Package is perfect for small businesses or start-ups looking to post their job listings and start attracting qualified candidates.</p>
                                    <p class="package-price mb-0">
                                        <span class="fw-bold text-black">{{ number_format($package->price) }}</span><span class="fw-bold text-dark"> Kyats</span>
                                    </p>
                                    <p class="package-promotion py-2"></p>
                                    <p class="package-plans">Billed annually yearly plans available</p>
                                    <button type="button" class="btn btn-outline-economy">Select  Plan</button>
                                </div>
                                @endif
                                @if($package->name == 'Standard Package')
                                <div class="col-lg-4 standard px-4 py-3">
                                    <h3 class="standard-title">Standard</h3>
                                    <p class="standard-desc mb-4">Our Standard Package is ideal for growing businesses that want to expand their recruitment efforts and streamline their hiring process.</p>
                                    <p class="package-price mb-0">
                                        <span class="fw-bold text-black">{{ number_format($package->price) }}</span><span class="fw-bold text-dark"> Kyats</span>
                                    </p>
                                    <p class="package-promotion py-2">15% OFF</p>
                                    <p class="package-plans">Billed annually yearly plans available</p>
                                    <button type="button" class="btn btn-outline-standard">Select  Plan</button>
                                </div>
                                @endif
                                @if($package->name == 'Premium Package')
                                <div class="col-lg-4 premium px-4 py-3">
                                    <h3 class="premium-title">Premium</h3>
                                    <p class="premium-desc mb-4">Our Basic Package is perfect for small businesses or start-ups looking to post their job listings and start attracting qualified candidates.</p>
                                    <p class="package-price mb-0">
                                        <span class="fw-bold text-black">{{ number_format($package->price) }}</span><span class="fw-bold text-dark"> Kyats</span>
                                    </p>
                                    <p class="package-promotion py-2">30% OFF</p>
                                    <p class="package-plans">Billed annually yearly plans available</p>
                                    <button type="button" class="btn btn-outline-premium">Select  Plan</button>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row text-light py-4">
                        <div class="col-lg-12">
                            <h4 class="text-blue fz17">Employer Branding Option</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Rotating Home Page Logo</td>
                                        <td><i class="fa-solid fa-xmark"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Sector Banner</td>
                                        <td><i class="fa-solid fa-xmark"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Leading Employer Banner ( Top employer )</td>
                                        <td><i class="fa-solid fa-xmark"></i></td>
                                        <td>Add on</td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Testimonials ( Reviews of working in client:s Company )</td>
                                        <td><i class="fa-solid fa-xmark"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Video Content Creation (info Graphic) ( Video posting in employer page )</td>
                                        <td>Add on</td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Employer Profile with Photo</td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->

@endsection

@push('css')
    <style>
        .modal-dialog {
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