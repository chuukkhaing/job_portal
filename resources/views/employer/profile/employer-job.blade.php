@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    <div class="row employer-dashboard-header m-0">
        <div class="col-lg-2 col-md-3 p-3">
            <a href="{{ route('employer-profile.index') }}">
            @if($employer->logo)
            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Employer Logo" class="employer-header-logo shadow-lg">
            @else
            <img src="{{ asset('img/employer/Vertical Logo.svg') }}" alt="Employer Logo" class="employer-header-logo shadow-lg">
            @endif
            </a>
        </div>
        <div class="col-lg-10 col-md-9 p-3">
            <div class="mb-4">
                <h4 class="d-inline-block">Upgrade Your Package</h4>
                <div class="float-end">
                    {{--<a href="http://" class="btn btn-outline-primary">Add-on Features</a>--}}
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
    <div class="px-lg-5 px-md-3 px-0 ">
        <ul class="nav nav-tabs d-flex justify-content-between p-2 my-1" id="employerTab">
            @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','dashboard')->count() > 0))
            <li class="nav-item">
                <a href="{{ route('employer-profile.index') }}" class="employer-single-tab ">Dashboard</a>
            </li>
            @endif
            @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','profile')->count() > 0))
            <li class="nav-item">
                <a href="{{ route('employer-profile.edit', $employer->id) }}" class="employer-single-tab">Profile</a>
            </li>
            @endif
            
            @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','manage_job')->count() > 0))
            <li class="nav-item">
                <a href="{{ route('manageJob') }}" class="employer-single-tab active" >Manage Job</a>
            </li>
            @endif
            @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','application_tracking')->count() > 0))
            @foreach($packageItems as $packageItem)
            @if($packageItem->name == 'Application Management')
            <li class="nav-item">
                <a href="{{ route('applicantTracking') }}" class="employer-single-tab" >Applicant Tracking</a>
            </li>
            @endif
            @endforeach
            @endif
        </ul>
    </div>
    <hr style="border-bottom: 5px solid gray;">
    <div class="tab-content" id="employerTabContent">
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','manage_job')->count() > 0))
        <div class="tab-pane fade p-0 show active" id="employer-dashboard">
            <div class="container-fluid" id="edit-profile-header">
                <nav class="py-3">
                    <div class="nav nav-tabs manage-jobs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-pending-tab" data-bs-toggle="tab" data-bs-target="#nav-pending" type="button" role="tab" aria-controls="nav-pending" aria-selected="true">Pending</button>
                        <button class="nav-link" id="nav-online-tab" data-bs-toggle="tab" data-bs-target="#nav-online" type="button" role="tab" aria-controls="nav-online" aria-selected="false">Online (Approved)</button>
                        <button class="nav-link" id="nav-reject-tab" data-bs-toggle="tab" data-bs-target="#nav-reject" type="button" role="tab" aria-controls="nav-reject" aria-selected="false">Reject</button>
                        <button class="nav-link" id="nav-expire-tab" data-bs-toggle="tab" data-bs-target="#nav-expire" type="button" role="tab" aria-controls="nav-expire" aria-selected="false">Expire</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                        
                        <div class="table-responsive" id="applicant-tracking-section">
                            <table class="table table-hover table-sm dataTable" width="100%" >
                                <thead>
                                    <tr>
                                        <td>No.</td>
                                        <td>Job Title</td>
                                        <td>Job Function</td>
                                        <td>Status</td>
                                        <td>Date</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($pendingjobPosts as $key => $pendingjobPost)
                                <tr>
                                    <td class="text-black">{{ $key+1 }}</td>
                                    <td class="text-black">{{ $pendingjobPost->job_title }}</td>
                                    <td class="text-black">
                                        {{ $pendingjobPost->MainFunctionalArea->name }} , 
                                        {{ $pendingjobPost->SubFunctionalArea->name }}
                                    </td>
                                    <td>
                                        <div class="job-post-status-{{$pendingjobPost->id}}">
                                            @if($pendingjobPost->is_active == 0)
                                            <span class="badge rounded-pill px-3 bg-secondary">Deactive</span>
                                            @else
                                                @if($pendingjobPost->status == 'Pending')
                                                <span class="badge rounded-pill px-3 bg-primary">{{ $pendingjobPost->status }}</span>
                                                @elseif($pendingjobPost->status == 'Online')
                                                <span class="badge rounded-pill px-3 bg-success">{{ $pendingjobPost->status }}</span>
                                                @elseif($pendingjobPost->status == 'Reject')
                                                <span class="badge rounded-pill px-3 bg-warning text-black">{{ $pendingjobPost->status }}</span>
                                                @elseif($pendingjobPost->status == 'Expire')
                                                <span class="badge rounded-pill px-3 bg-danger">{{ $pendingjobPost->status }}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span style="" class="text-black">
                                        {{ date('d M, Y', strtotime($pendingjobPost->updated_at)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="">
                                            <a href="{{ route('employer-job-post.edit', $pendingjobPost->id) }}" class="text-black"><i class="fas fa-edit"></i> Edit</a>
                                            <div class="d-inline-block form-switch ms-3 fw-bold">
                                                <input class="form-check-input employer-form-check form-switch" type="checkbox" @if($pendingjobPost->is_active == 0) checked @endif role="switch" id="job_post_is_active_{{ $pendingjobPost->id }}" onclick="changeJobPostStatus({{ $pendingjobPost->id }}, {{ $pendingjobPost->is_active }})">
                                                <label for="job_post_is_active" id="job_post_is_active-{{$pendingjobPost->id}}">@if($pendingjobPost->is_active == 1) Activate @else Deactivate @endif</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="nav-online" role="tabpanel" aria-labelledby="nav-online-tab">
                        
                        <div class="table-responsive" id="applicant-tracking-section">
                            <table class="table table-hover table-sm dataTable" width="100%" >
                                <thead>
                                    <tr>
                                        <td>No.</td>
                                        <td>Job Title</td>
                                        <td>Job Function</td>
                                        <td>Status</td>
                                        <td>Date</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($onlinejobPosts as $key => $onlinejobPost)
                                <tr>
                                    <td class="text-black">{{ $key+1 }}</td>
                                    <td class="text-black">{{ $onlinejobPost->job_title }}</td>
                                    <td class="text-black">
                                        {{ $onlinejobPost->MainFunctionalArea->name }} , 
                                        {{ $onlinejobPost->SubFunctionalArea->name }}
                                    </td>
                                    <td>
                                        <div class="job-post-status-{{$onlinejobPost->id}}">
                                            @if($onlinejobPost->is_active == 0)
                                            <span class="badge rounded-pill px-3 bg-secondary">Deactive</span>
                                            @else
                                                @if($onlinejobPost->status == 'Pending')
                                                <span class="badge rounded-pill px-3 bg-primary">{{ $onlinejobPost->status }}</span>
                                                @elseif($onlinejobPost->status == 'Online')
                                                <span class="badge rounded-pill px-3 bg-success">{{ $onlinejobPost->status }}</span>
                                                @elseif($onlinejobPost->status == 'Reject')
                                                <span class="badge rounded-pill px-3 bg-warning text-black">{{ $onlinejobPost->status }}</span>
                                                @elseif($onlinejobPost->status == 'Expire')
                                                <span class="badge rounded-pill px-3 bg-danger">{{ $onlinejobPost->status }}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span style="" class="text-black">
                                        {{ date('d M, Y', strtotime($onlinejobPost->updated_at)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="">
                                            <a href="{{ route('employer-job-post.edit', $onlinejobPost->id) }}" class="text-black"><i class="fas fa-edit"></i> Edit</a>
                                            <div class="d-inline-block form-switch ms-3 fw-bold">
                                                <input class="form-check-input employer-form-check form-switch" type="checkbox" @if($onlinejobPost->is_active == 0) checked @endif role="switch" id="job_post_is_active_{{ $onlinejobPost->id }}" onclick="changeJobPostStatus({{ $onlinejobPost->id }}, {{ $onlinejobPost->is_active }})">
                                                <label for="job_post_is_active" id="job_post_is_active-{{$onlinejobPost->id}}">@if($onlinejobPost->is_active == 1) Activate @else Deactivate @endif</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="nav-reject" role="tabpanel" aria-labelledby="nav-reject-tab">
                        
                        <div class="table-responsive" id="applicant-tracking-section">
                            <table class="table table-hover table-sm dataTable" width="100%" >
                                <thead>
                                    <tr>
                                        <td>No.</td>
                                        <td>Job Title</td>
                                        <td>Job Function</td>
                                        <td>Status</td>
                                        <td>Date</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($rejectjobPosts as $key => $rejectjobPost)
                                <tr>
                                    <td class="text-black">{{ $key+1 }}</td>
                                    <td class="text-black">{{ $rejectjobPost->job_title }}</td>
                                    <td class="text-black">
                                        {{ $rejectjobPost->MainFunctionalArea->name }} , 
                                        {{ $rejectjobPost->SubFunctionalArea->name }}
                                    </td>
                                    <td>
                                        <div class="job-post-status-{{$rejectjobPost->id}}">
                                            @if($rejectjobPost->is_active == 0)
                                            <span class="badge rounded-pill px-3 bg-secondary">Deactive</span>
                                            @else
                                                @if($rejectjobPost->status == 'Pending')
                                                <span class="badge rounded-pill px-3 bg-primary">{{ $rejectjobPost->status }}</span>
                                                @elseif($rejectjobPost->status == 'Online')
                                                <span class="badge rounded-pill px-3 bg-success">{{ $rejectjobPost->status }}</span>
                                                @elseif($rejectjobPost->status == 'Reject')
                                                <span class="badge rounded-pill px-3 bg-warning text-black">{{ $rejectjobPost->status }}</span>
                                                @elseif($rejectjobPost->status == 'Expire')
                                                <span class="badge rounded-pill px-3 bg-danger">{{ $rejectjobPost->status }}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span style="" class="text-black">
                                        {{ date('d M, Y', strtotime($rejectjobPost->updated_at)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="">
                                            <a href="{{ route('employer-job-post.edit', $rejectjobPost->id) }}" class="text-black"><i class="fas fa-edit"></i> Edit</a>
                                            <div class="d-inline-block form-switch ms-3 fw-bold">
                                                <input class="form-check-input employer-form-check form-switch" type="checkbox" @if($rejectjobPost->is_active == 0) checked @endif role="switch" id="job_post_is_active_{{ $rejectjobPost->id }}" onclick="changeJobPostStatus({{ $rejectjobPost->id }}, {{ $rejectjobPost->is_active }})">
                                                <label for="job_post_is_active" id="job_post_is_active-{{$rejectjobPost->id}}">@if($rejectjobPost->is_active == 1) Activate @else Deactivate @endif</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="nav-expire" role="tabpanel" aria-labelledby="nav-expire-tab">
                        
                        <div class="table-responsive" id="applicant-tracking-section">
                            <table class="table table-hover table-sm dataTable" width="100%" >
                                <thead>
                                    <tr>
                                        <td>No.</td>
                                        <td>Job Title</td>
                                        <td>Job Function</td>
                                        <td>Status</td>
                                        <td>Date</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($expirejobPosts as $key => $expirejobPost)
                                <tr>
                                    <td class="text-black">{{ $key+1 }}</td>
                                    <td class="text-black">{{ $expirejobPost->job_title }}</td>
                                    <td class="text-black">
                                        {{ $expirejobPost->MainFunctionalArea->name }} , 
                                        {{ $expirejobPost->SubFunctionalArea->name }}
                                    </td>
                                    <td>
                                        <div class="job-post-status-{{$expirejobPost->id}}">
                                            @if($expirejobPost->is_active == 0)
                                            <span class="badge rounded-pill px-3 bg-secondary">Deactive</span>
                                            @else
                                                @if($expirejobPost->status == 'Pending')
                                                <span class="badge rounded-pill px-3 bg-primary">{{ $expirejobPost->status }}</span>
                                                @elseif($expirejobPost->status == 'Online')
                                                <span class="badge rounded-pill px-3 bg-success">{{ $expirejobPost->status }}</span>
                                                @elseif($expirejobPost->status == 'Reject')
                                                <span class="badge rounded-pill px-3 bg-warning text-black">{{ $expirejobPost->status }}</span>
                                                @elseif($expirejobPost->status == 'Expire')
                                                <span class="badge rounded-pill px-3 bg-danger">{{ $expirejobPost->status }}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span style="" class="text-black">
                                        {{ date('d M, Y', strtotime($expirejobPost->updated_at)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="">
                                            <a href="{{ route('employer-job-post.edit', $expirejobPost->id) }}" class="text-black"><i class="fas fa-edit"></i> Edit</a>
                                            <div class="d-inline-block form-switch ms-3 fw-bold">
                                                <input class="form-check-input employer-form-check form-switch" type="checkbox" @if($expirejobPost->is_active == 0) checked @endif role="switch" id="job_post_is_active_{{ $expirejobPost->id }}" onclick="changeJobPostStatus({{ $expirejobPost->id }}, {{ $expirejobPost->is_active }})">
                                                <label for="job_post_is_active" id="job_post_is_active-{{$expirejobPost->id}}">@if($expirejobPost->is_active == 1) Activate @else Deactivate @endif</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    
</div>

@endsection
@push('scripts')
<script>

    $(document).ready(function() {
        var show_success_modal = "{{ session()->pull('success') }}";
        if(show_success_modal != '') {
            MSalert.principal({
                icon:'success',
                title:'',
                description: show_success_modal,
            })
        }

        var show_error_modal = "{{ session()->pull('error') }}";
        if(show_error_modal != '') {
            MSalert.principal({
                icon:'error',
                title:'',
                description: show_error_modal,
            })
        }
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function changeJobPostStatus(id, is_active) {
        var status = is_active;
        if(is_active == 1) {
            status = 0
        }else {
            status = 1
        }

        $.ajax({
            type: 'POST',
            data: {
                'id' : id,
                'status' : status,
            },
            url: '{{ route("job-post.status") }}',
        }).done(function(response){
            if(response.status == 'success') {
                if(response.data.is_active == 0) {
                    $('.job-post-status-'+id).html('<span class="badge rounded-pill px-3 bg-secondary">Deactive</span>');
                    $("#job_post_is_active_"+id).attr('onclick','changeJobPostStatus('+id+', '+response.data.is_active+')');
                    $("#job_post_is_active-"+id).text('');
                    $("#job_post_is_active-"+id).text('Deactivate');
                }else {
                    $("#job_post_is_active_"+id).attr('onclick','changeJobPostStatus('+id+', '+response.data.is_active+')');
                    var bg_color = 'primary';
                    if(response.data.status == 'Online') {
                        var bg_color = 'success'
                    }else if(response.data.status == 'Expire') {
                        var bg_color = 'danger'
                    }else if(response.data.status == 'Reject') {
                        var bg_color = 'warning'
                    }
                    $('.job-post-status-'+id).html('<span class="badge rounded-pill px-3 bg-'+bg_color+'">'+response.data.status+'</span>');
                    $("#job_post_is_active-"+id).text('');
                    $("#job_post_is_active-"+id).text('Activate');
                }
            }
        })
        
    }
    
</script>
@endpush