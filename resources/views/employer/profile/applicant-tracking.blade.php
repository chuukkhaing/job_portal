@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    @include('employer.profile.employer-sub-header')
    <div class="tab-content" id="employerTabContent">
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','application_tracking')->count() > 0))
        <div class="tab-pane fade p-0 show active" id="employer-dashboard">
            <div class="container-fluid" id="edit-profile-header">
                <nav class="py-3">
                    <div class="nav nav-tabs manage-jobs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-active-tab" data-bs-toggle="tab" data-bs-target="#nav-active" type="button" role="tab" aria-controls="nav-active" aria-selected="true">Active Jobs</button>
                        <button class="nav-link" id="nav-expire-tab" data-bs-toggle="tab" data-bs-target="#nav-expire" type="button" role="tab" aria-controls="nav-expire" aria-selected="false">Expired Jobs</button>
                        <button class="nav-link" id="nav-deactive-tab" data-bs-toggle="tab" data-bs-target="#nav-deactive" type="button" role="tab" aria-controls="nav-deactive" aria-selected="false">Deactivated Jobs</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
                        
                        <div class="table-responsive applicant-tracking-section">
                            <table class="table table-hover table-borderless table-sm " width="100%" >
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">No.</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Title</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Post Type</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB"># Apps</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Contact Name</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Not Suitable</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Shorted List</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Hired</th>
                                        {{--<th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Note</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">QR</th>--}}
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Posted Date</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($activejobApplicants as $key => $activejobApplicant)
                                    <tr>
                                        <td class="text-black">{{ $key+1 }}</td>
                                        <td class="text-black"><a href="{{ route('jobpost-detail', $activejobApplicant->slug) }}">{{ $activejobApplicant->job_title }} ({{ $activejobApplicant->no_of_candidate }} - posts)</a></td>
                                        <td>
                                        @if($activejobApplicant->job_post_type == 'trending') <span class="badge rounded-pill px-3" style="background: #FB5404">Trending</span> @elseif($activejobApplicant->job_post_type == 'feature') <span class="badge rounded-pill px-3" style="background: #0355D0">Feature</span> @else <span class="badge rounded-pill px-3 bg-success"> Standard </span> @endif
                                        </td>
                                        <td class ="text-blue ">
                                            @if($activejobApplicant->JobApply->count() > 0)
                                            <a href="#" onclick="getCVList({{$activejobApplicant->id}},'received')" class="text-blue">{{ $activejobApplicant->JobApply->count() }} CVs</a>
                                            @else 
                                            {{ $activejobApplicant->JobApply->count() }} CV
                                            @endif
                                        </td>
                                        <td class="text-black">{{ $activejobApplicant->recruiter_name }}</td>
                                        <td>
                                            @if($activejobApplicant->JobApply->where('status','not-suitable')->count() > 0)
                                            <a href="#" class="text-danger " onclick="getCVList({{$activejobApplicant->id}},'not-suitable')">{{ $activejobApplicant->JobApply->where('status','not-suitable')->count() }} CVs</a>
                                            @else 
                                            <span class="text-danger ">{{ $activejobApplicant->JobApply->where('status','not-suitable')->count() }} CV</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($activejobApplicant->JobApply->where('status','short-listed')->count() > 0)
                                            <a href="#" class="" style="color: #4AA8BF" onclick="getCVList({{$activejobApplicant->id}},'short-listed')">{{ $activejobApplicant->JobApply->where('status','short-listed')->count() }} CVs</a>
                                            @else 
                                            <span class="" style="color: #4AA8BF">{{ $activejobApplicant->JobApply->where('status','short-listed')->count() }} CV</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($activejobApplicant->JobApply->where('status','hire')->count() > 0)
                                            <a href="#" class="text-success " onclick="getCVList({{$activejobApplicant->id}},'hire')">{{ $activejobApplicant->JobApply->where('status','hire')->count() }} CVs</a>
                                            @else 
                                            <span class="text-success ">{{ $activejobApplicant->JobApply->where('status','hire')->count() }} CV</span>
                                            @endif
                                        </td>
                                        {{--<td></td>
                                        <td></td>--}}
                                        <td class=" text-black">{{ date('d M, Y', strtotime($activejobApplicant->updated_at)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                        <div class="d-felx justify-content-center">

                            {{ $activejobApplicants->onEachSide(1)->links() }}

                        </div>
                    </div>
                    <div class="tab-pane fade " id="nav-expire" role="tabpanel" aria-labelledby="nav-expire-tab">
                        
                        <div class="table-responsive applicant-tracking-section">
                            <table class="table table-hover table-borderless table-sm " width="100%" >
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">No.</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Title</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Post Type</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB"># Apps</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Contact Name</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Not Suitable</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Shorted List</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Hired</th>
                                        {{--<th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Note</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">QR</th>--}}
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Posted Date</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($expirejobApplicants as $key => $expirejobApplicant)
                                    <tr>
                                        <td class="text-black">{{ $key+1 }}</td>
                                        <td class="text-black"><a href="{{ route('jobpost-detail', $expirejobApplicant->slug) }}">{{ $expirejobApplicant->job_title }} ({{ $expirejobApplicant->no_of_candidate }} - posts)</a></td>
                                        <td>
                                        @if($expirejobApplicant->job_post_type == 'trending') <span class="badge rounded-pill px-3" style="background: #FB5404">Trending</span> @elseif($expirejobApplicant->job_post_type == 'feature') <span class="badge rounded-pill px-3" style="background: #0355D0">Feature</span> @else <span class="badge rounded-pill px-3 bg-success"> Standard </span> @endif
                                        </td>
                                        <td class ="text-blue ">
                                            @if($expirejobApplicant->JobApply->count() > 0)
                                            <a href="#" onclick="getCVList({{$expirejobApplicant->id}},'received')" class="text-blue">{{ $expirejobApplicant->JobApply->count() }} CVs</a>
                                            @else 
                                            {{ $expirejobApplicant->JobApply->count() }} CV
                                            @endif
                                        </td>
                                        <td class="text-black">{{ $expirejobApplicant->recruiter_name }}</td>
                                        <td>
                                            @if($expirejobApplicant->JobApply->where('status','not-suitable')->count() > 0)
                                            <a href="#" class="text-danger " onclick="getCVList({{$expirejobApplicant->id}},'not-suitable')">{{ $expirejobApplicant->JobApply->where('status','not-suitable')->count() }} CVs</a>
                                            @else 
                                            <span class="text-danger ">{{ $expirejobApplicant->JobApply->where('status','not-suitable')->count() }} CV</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($expirejobApplicant->JobApply->where('status','short-listed')->count() > 0)
                                            <a href="#" class="" style="color: #4AA8BF" onclick="getCVList({{$expirejobApplicant->id}},'short-listed')">{{ $expirejobApplicant->JobApply->where('status','short-listed')->count() }} CVs</a>
                                            @else 
                                            <span class="" style="color: #4AA8BF">{{ $expirejobApplicant->JobApply->where('status','short-listed')->count() }} CV</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($expirejobApplicant->JobApply->where('status','hire')->count() > 0)
                                            <a href="#" class="text-success " onclick="getCVList({{$expirejobApplicant->id}},'hire')">{{ $expirejobApplicant->JobApply->where('status','hire')->count() }} CVs</a>
                                            @else 
                                            <span class="text-success ">{{ $expirejobApplicant->JobApply->where('status','hire')->count() }} CV</span>
                                            @endif
                                        </td>
                                        {{--<td></td>
                                        <td></td>--}}
                                        <td class=" text-black">{{ date('d M, Y', strtotime($expirejobApplicant->updated_at)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                        <div class="d-felx justify-content-center">

                            {{ $expirejobApplicants->onEachSide(1)->links() }}

                        </div>
                    </div>
                    <div class="tab-pane fade " id="nav-deactive" role="tabpanel" aria-labelledby="nav-deactive-tab">
                        
                        <div class="table-responsive applicant-tracking-section">
                            <table class="table table-hover table-borderless table-sm " width="100%" >
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">No.</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Title</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Post Type</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB"># Apps</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Contact Name</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Not Suitable</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Shorted List</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Hired</th>
                                        {{--<th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Note</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">QR</th>--}}
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Posted Date</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($inactivejobApplicants as $key => $inactivejobApplicant)
                                    <tr>
                                        <td class="text-black">{{ $key+1 }}</td>
                                        <td class="text-black"><a href="{{ route('jobpost-detail', $inactivejobApplicant->slug) }}">{{ $inactivejobApplicant->job_title }} ({{ $inactivejobApplicant->no_of_candidate }} - posts)</a></td>
                                        <td>
                                        @if($inactivejobApplicant->job_post_type == 'trending') <span class="badge rounded-pill px-3" style="background: #FB5404">Trending</span> @elseif($inactivejobApplicant->job_post_type == 'feature') <span class="badge rounded-pill px-3" style="background: #0355D0">Feature</span> @else <span class="badge rounded-pill px-3 bg-success"> Standard </span> @endif
                                        </td>
                                        <td class ="text-blue ">
                                            @if($inactivejobApplicant->JobApply->count() > 0)
                                            <a href="#" onclick="getCVList({{$inactivejobApplicant->id}},'received')" class="text-blue">{{ $inactivejobApplicant->JobApply->count() }} CVs</a>
                                            @else 
                                            {{ $inactivejobApplicant->JobApply->count() }} CV
                                            @endif
                                        </td>
                                        <td class="text-black">{{ $inactivejobApplicant->recruiter_name }}</td>
                                        <td>
                                            @if($inactivejobApplicant->JobApply->where('status','not-suitable')->count() > 0)
                                            <a href="#" class="text-danger " onclick="getCVList({{$inactivejobApplicant->id}},'not-suitable')">{{ $inactivejobApplicant->JobApply->where('status','not-suitable')->count() }} CVs</a>
                                            @else 
                                            <span class="text-danger ">{{ $inactivejobApplicant->JobApply->where('status','not-suitable')->count() }} CV</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($inactivejobApplicant->JobApply->where('status','short-listed')->count() > 0)
                                            <a href="#" class="" style="color: #4AA8BF" onclick="getCVList({{$inactivejobApplicant->id}},'short-listed')">{{ $inactivejobApplicant->JobApply->where('status','short-listed')->count() }} CVs</a>
                                            @else 
                                            <span class="" style="color: #4AA8BF">{{ $inactivejobApplicant->JobApply->where('status','short-listed')->count() }} CV</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($inactivejobApplicant->JobApply->where('status','hire')->count() > 0)
                                            <a href="#" class="text-success " onclick="getCVList({{$inactivejobApplicant->id}},'hire')">{{ $inactivejobApplicant->JobApply->where('status','hire')->count() }} CVs</a>
                                            @else 
                                            <span class="text-success ">{{ $inactivejobApplicant->JobApply->where('status','hire')->count() }} CV</span>
                                            @endif
                                        </td>
                                        {{--<td></td>
                                        <td></td>--}}
                                        <td class=" text-black">{{ date('d M, Y', strtotime($inactivejobApplicant->updated_at)) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>
                        </div>
                        <div class="d-felx justify-content-center">

                            {{ $inactivejobApplicants->onEachSide(1)->links() }}

                        </div>
                    </div>
                    <h3 class="job-tracking-title" id="receive-job-title"></h3>
                    <div class="d-none" id="cv-list-section">
                        <div class="row">
                            <div class="col-4">
                                <h5 class="text-dark">Applicant Inbox</h5>
                                <div class="my-4">
                                    <ul class="cv-item p-0">
                                        <li class="cv-status cv-received active">
                                            <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Application Received ( <span id="receive-cv-length">0</span> )</span>
                                        </li>
                                        <li class="cv-status cv-viewed">
                                            <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Viewed Application ( <span id="view-cv-length">0</span> )</span>
                                        </li>
                                        <li class="cv-status cv-short-listed">
                                            <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Shorted Listed ( <span id="short-listed-cv-length">0</span> )</span>
                                        </li>
                                        <li class="cv-status cv-interview">
                                            <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Interview ( <span id="interview-cv-length">0</span> )</span>
                                        </li>
                                        <li class="cv-status cv-hire">
                                            <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Hire ( <span id="hire-cv-length">0</span> )</span>
                                        </li>
                                        <li class="cv-status cv-not-suitable">
                                            <i class="fa-solid fa-inbox"></i> <span>&nbsp;&nbsp;Not Suitable ( <span id="not-suitable-cv-length">0</span> )</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="my-4">
                                    <div class="table-responsive seeker_table">
                                        <table class="table applicant-receive-table" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Job Seeker Name</th>
                                                    <th class="text-end">Applied Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8 no-seeker">
                                <h5 class="text-dark d-inline-block">No Seeker</h5>
                                <div class="d-inline-block float-end">
                                <button class="btn profile-save-btn btn-sm precious-btn">Back</button>
                                </div>
                            </div>
                            <div class="col-8 profile-overview">
                                <h5 class="text-dark d-inline-block">Profile Overview</h5>
                                <div class="d-inline-block float-end">
                                    @foreach($packageItems as $packageItem)
                                    @if($packageItem->name == 'Application Unlock')
                                    <div class="dropdown d-inline-block">
                                        <a class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="modal" data-target="#pointDetection" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-download"></i>
                                        </a>

                                        <ul class="dropdown-menu d-none" aria-labelledby="dropdownMenuLink">
                                            <li><a class="dropdown-item download_seeker_cv" target="_blank" href="" download>Download Seeker's CV</a></li>
                                            <li><a class="dropdown-item download_ic_cv" href="#">Download IC Format CV</a></li>
                                        </ul>
                                    </div>
                                    @endif
                                    @endforeach
                                    <button class="btn profile-save-btn btn-sm precious-btn">Back</button>
                                </div>
                                <div class="modal fade" id="pointDetection" tabindex="-1" role="dialog" aria-labelledby="pointDetectionLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document" style="min-width: 30%">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pointDetectionLabel">Application Unlock</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure to unlock the Application? <br>
                                            @foreach($packageItems as $packageItem)
                                            @if($packageItem->name == 'Application Unlock')
                                            Application Unlock = {{ $packageItem->point }} points
                                            @endif
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="cv-unlock">Confirm</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <button type="button" class="btn btn-sm btn-received btn-status btn-outline-primary" data-id="received">Application Received</button>
                                    <button type="button" class="btn btn-sm btn-viewed btn-status btn-outline-dark" data-id="viewed">Viewed Application</button>
                                    <button type="button" class="btn btn-sm btn-short-listed btn-status btn-outline-info" data-id="short-listed">Shorted Listed</button>
                                    <button type="button" class="btn btn-sm btn-interview btn-status btn-outline-warning" data-id="interview">Interview</button>
                                    <button type="button" class="btn btn-sm btn-hire btn-status btn-outline-success" data-id="hire">Hire</button>
                                    <button type="button" class="btn btn-sm btn-not-suitable btn-status btn-outline-danger" data-id="not-suitable">Not Suitable</button>
                                </div>
                                <div class="mt-4">
                                    <div class="mb-4">
                                        
                                        <div class="row">
                                            <div class="col cv-unlock-data d-none">
                                                <p class="app_receive_name"> </p>
                                                <p id="app_receive_address">-</p>
                                                <p id="app_receive_phone">-</p>
                                                <p id="app_receive_email"></p>
                                            </div>
                                            <div class="col">
                                                <img class="app_receive_pic" src="{{ asset('img/undraw_profile_1.svg') }}" alt="profile_pic" width="160px" height="160px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="text-decoration-underline">Personal Information</h5>
                                        
                                        <div class="row my-3">
                                            <div class="col">
                                                <span>Name</span>
                                                <span class="float-end">:</span>
                                            </div>
                                            <div class="col">
                                                <span class="app_receive_name"></span>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col">
                                                <span>Date Of Birth</span>
                                                <span class="float-end">:</span>
                                            </div>
                                            <div class="col">
                                                <span class="app_receive_dob">-</span>
                                            </div>
                                        </div>
                                        <div class="row my-3 cv-unlock-data d-none">
                                            <div class="col">
                                                <span>NRC Number/ID</span>
                                                <span class="float-end">:</span>
                                            </div>
                                            <div class="col">
                                                <span class="app_receive_nrc">-</span>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col">
                                                <span>Nationality</span>
                                                <span class="float-end">:</span>
                                            </div>
                                            <div class="col">
                                                <span class="app_receive_nationality">-</span>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col">
                                                <span>Gender</span>
                                                <span class="float-end">:</span>
                                            </div>
                                            <div class="col">
                                                <span class="app_receive_gender">-</span>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col">
                                                <span>Marital Status</span>
                                                <span class="float-end">:</span>
                                            </div>
                                            <div class="col">
                                                <span class="app_receive_marital_status">-</span>
                                            </div>
                                        </div>
                                        <div class="row my-3 cv-unlock-data d-none">
                                            <div class="col">
                                                <span>Address Detail</span>
                                                <span class="float-end">:</span>
                                            </div>
                                            <div class="col">
                                                <span id="app_receive_address_detail">-</span>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col">
                                                <span class="fw-bold">Notice Period</span>
                                                <span class="float-end fw-bold">:</span>
                                            </div>
                                            <div class="col">
                                                <span class="app_receive_notice_period fw-bold">-</span>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col">
                                                <span class="fw-bold">Expected Salary</span>
                                                <span class="float-end fw-bold">:</span>
                                            </div>
                                            <div class="col">
                                                <span class="app_receive_expected_salary fw-bold">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 app_receive_job_post_question_box">
                                        <h5 class="text-decoration-underline">Job Post Question and Answers</h5>
                                        
                                        <p class="app_receive_job_post_question">-</p>
                                    </div>
                                    <div class="mb-4 app_receive_career_des_box">
                                        <h5 class="text-decoration-underline">Career Description</h5>
                                        
                                        <p class="app_receive_career_des">-</p>
                                    </div>
                                    <div class="mb-4 app_receive_education_box">
                                        <h5 class="text-decoration-underline">Education</h5>
                                        
                                        <div class="app_receive_education">-</div>
                                    </div>
                                    <div class="mb-4 app_receive_experience_box">
                                        <h5 class="text-decoration-underline">Career History</h5>
                                        
                                        <div class="app_receive_experience">-</div>
                                    </div>
                                    <div class="mb-4 app_receive_skill_box">
                                        <h5 class="text-decoration-underline">Skill</h5>
                                        
                                        <div class="app_receive_skill">-</div>
                                    </div>
                                    <div class="mb-4 app_receive_lang_box">
                                        <h5 class="text-decoration-underline">Language</h5>
                                        
                                        <div class="app_receive_lang">-</div>
                                    </div>
                                    <div class="mb-4 app_receive_ref_box">
                                        <h5 class="text-decoration-underline">Reference</h5>
                                        
                                        <div class="app_receive_ref">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div id="" class="loading hide-loader">
                        <div class="loader">
                            <div class="spinner-grow text-primary m-1" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="spinner-grow text-dark m-1" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="spinner-grow text-secondary m-1" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
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
<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>   
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> 
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    var table = $('.applicant-receive-table').DataTable({
        dom: 'Qfrtip',
        ordering: false,
        "columns": [
            null,
            { className: "text-end" }
        ]
    });

    $(document).ready(function() {
        $('.nav-link').click(function() {
            $(".applicant-tracking-section").removeClass('d-none');
            $("#cv-list-section").addClass('d-none');
        })
    })

    function getCVList(id,status) {
        $(".applicant-tracking-section").addClass('d-none');
        $("#cv-list-section").removeClass('d-none');
        table.rows().remove();
        getRelatedApplicantList(id,status);
        CVColor(status);
    }
    $(".precious-btn").click(function() {
        window.location.reload();
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function getRelatedApplicantList(id,status)
    {
        $(".loading").removeClass('hide-loader')
        $.ajax({
            type: 'GET',
            url: 'get-jobpost/'+id+'/'+status,
        }).done(function(response){
            if(response.status == 'success') {
                $(".loading").addClass('hide-loader')
                table.rows().remove();
                getSeekerData(response)
            }
        })
    }

    function cvUnlock(employerId, jobPostId, jobApplyId)
    {
        $.ajax({
            type: 'POST',
            data: {
                'employer_id' : employerId,
                'jobPost_id' : jobPostId,
                'jobApply_id' : jobApplyId
            },
            url: "{{ route('unlock.application') }}"
        }).done(function(response){
            if(response.status == 'success') {
                $('.close').click();
                if(response.data.status == 'Complete') {
                    $("#dropdownMenuLink").attr('data-toggle','');
                    $("#dropdownMenuLink").attr('data-target','');
                    $(".dropdown-menu").removeClass('d-none');
                    $('.cv-unlock-data').removeClass('d-none');
                }
            }
        })
    }

    function getSeekerData(response)
    {
        $("#receive-cv-length").text(response.count.received);
        $("#view-cv-length").text(response.count.viewed);
        $("#short-listed-cv-length").text(response.count.short-listed);
        $("#interview-cv-length").text(response.count.interview);
        $("#hire-cv-length").text(response.count.hire);
        $("#not-suitable-cv-length").text(response.count.notsuitable);
        $("#receive-job-title").text(response.jobPost.job_title);
        
        $(".btn-received").attr('onclick','changeStatus('+response.seeker.id+','+response.jobPost.id+',"received")');
        $(".btn-viewed").attr('onclick','changeStatus('+response.seeker.id+','+response.jobPost.id+',"viewed")');
        $(".btn-short-listed").attr('onclick','changeStatus('+response.seeker.id+','+response.jobPost.id+',"short-listed")');
        $(".btn-interview").attr('onclick','changeStatus('+response.seeker.id+','+response.jobPost.id+',"interview")');
        $(".btn-hire").attr('onclick','changeStatus('+response.seeker.id+','+response.jobPost.id+',"hire")');
        $(".btn-not-suitable").attr('onclick','changeStatus('+response.seeker.id+','+response.jobPost.id+',"not-suitable")');

        $(".cv-received").attr('onclick','getCVList('+response.jobPost.id+',"received")');
        $(".cv-viewed").attr('onclick','getCVList('+response.jobPost.id+',"viewed")');
        $(".cv-short-listed").attr('onclick','getCVList('+response.jobPost.id+',"short-listed")');
        $(".cv-interview").attr('onclick','getCVList('+response.jobPost.id+',"interview")');
        $(".cv-hire").attr('onclick','getCVList('+response.jobPost.id+',"hire")');
        $(".cv-not-suitable").attr('onclick','getCVList('+response.jobPost.id+',"not-suitable")');
        
        if(response.seeker != 'no-seeker') {
            
            $('.profile-overview').removeClass('d-none');
            $('.no-seeker').addClass('d-none');
            $(".seeker_table").removeClass('d-none');
            if(response.jobApply.length > 0) {
            
                $(response.jobApply).each(function(index,value) {
                    var active = '';
                    if(value.seeker_id == response.seeker.id) {
                        active = 'active'
                    }
                    var first_name = value.seeker_first_name === null ? '' : value.seeker_first_name;
                    var last_name = value.seeker_last_name === null ? '' : value.seeker_last_name;

                    table.row.add([
                        first_name+' '+last_name,
                        moment(value.seeker_applied_date).format("DD/MM/YYYY"),
                    ]).node().id = 'applicant_tr'+value.seeker_id;
                    table.draw();
                    $('#applicant_tr'+value.seeker_id).attr('onClick','getRelatedApplicantInfo('+value.seeker_id+','+value.job_post_id+',"'+value.status+'")');
                    $('#applicant_tr'+value.seeker_id).addClass(active);
                    if(response.cvunlock.length > 0) {
                        $(response.cvunlock).each(function(cv_index, cv_value) {
                            
                            if(value.seeker_id == response.seeker.id && cv_value.job_apply_id != value.id) {
                                $("#cv-unlock").attr('onclick','cvUnlock('+response.jobPost.employer_id+','+response.jobPost.id+','+value.id+')');
                                $("#dropdownMenuLink").attr('data-toggle','modal');
                                $("#dropdownMenuLink").attr('data-target','#pointDetection');
                                $(".dropdown-menu").addClass('d-none');
                                $('.cv-unlock-data').addClass('d-none');
                            }else if (cv_value.job_apply_id == value.id) {
                                $("#dropdownMenuLink").attr('data-toggle','');
                                $("#dropdownMenuLink").attr('data-target','');
                                $(".dropdown-menu").removeClass('d-none');
                                $('.cv-unlock-data').removeClass('d-none');
                            }
                        })
                    }else {
                        if(value.seeker_id == response.seeker.id) {
                            $("#cv-unlock").attr('onclick','cvUnlock('+response.jobPost.employer_id+','+response.jobPost.id+','+value.id+')');
                            $("#dropdownMenuLink").attr('data-toggle','modal');
                            $("#dropdownMenuLink").attr('data-target','#pointDetection');
                            $(".dropdown-menu").addClass('d-none');
                            $('.cv-unlock-data').addClass('d-none');
                        }
                    }
                    $(".download_seeker_cv").attr('href',response.seeker_cv);
                    $(".download_ic_cv").attr('href', document.location.origin+'/employer/download-ic-cv/'+response.seeker.id);
                    btnColor(value.status)

                    var first_name_check = response.seeker.first_name === null ? '' : response.seeker.first_name;
                    var last_name_check = response.seeker.last_name === null ? '' : response.seeker.last_name;

                    if(response.seeker.gender == 'Female') {
                        $(".app_receive_name").text('Ms.'+first_name_check+' '+last_name_check);
                    }else {
                        $(".app_receive_name").text('Mr.'+first_name_check+' '+last_name_check);
                    }
                    if(response.seeker_img){
                        $('.app_receive_pic').attr('src',response.seeker_img);
                    }else {
                        $('.app_receive_pic').attr('src',document.location.origin+'/img/undraw_profile_1.svg');
                    }
                    if(response.seeker.address_detail) {
                        $("#app_receive_address_detail").text(response.seeker.address_detail);
                    }
                    if(response.seeker.phone) {
                        $("#app_receive_phone").text(response.seeker.phone);
                    }
                    if(response.seeker.country == "Other") {
                        $('#app_receive_address').text('Country - Other');
                    }else {
                        if(response.seeker.twonship_name) {
                            $('#app_receive_address').text(response.seeker.township_name+', '+response.seeker.state_name+', '+response.seeker.country);
                        }else {
                            $('#app_receive_address').text(response.seeker.state_name+', '+response.seeker.country);
                        }
                    }
                    $("#app_receive_email").text(response.seeker.email);
                    $(".app_receive_dob").text(moment(response.seeker.date_of_birth).format("DD/MM/YYYY"));
                    if(response.seeker.nrc) {
                        $(".app_receive_nrc").text(response.seeker.nrc);
                    }else {
                        $(".app_receive_nrc").text(response.seeker.id_card);
                    }
                    $(".app_receive_nationality").text(response.seeker.nationality);
                    $(".app_receive_gender").text(response.seeker.gender);
                    $(".app_receive_marital_status").text(response.seeker.marital_status);
                    $(".app_receive_expected_salary").text((Number(response.seeker.preferred_salary)).toLocaleString()+' MMK');
                    if(response.seeker.is_immediate_available == 1) {
                        $(".app_receive_notice_period").text("Immediate available")
                    }
                    if(response.answers.length > 0) {
                        $(".app_receive_job_post_question_box").removeClass('d-none');
                        var html = '';
                        $(response.answers).each(function(answer_index, answer){
                            html+= '<table><tr><td width=150px><h6>Question : </h6></td><td><h6>'+answer.job_post_question.question+'</h6></td></tr><tr><td><h6>Answer : </h6></td><td><h6>'+answer.answer+'</h6></td></tr><tr><td><h6>Question Type : </h6></td><td><h6>'+answer.job_post_question.answer+'</h6></td></tr></table><hr>';
                        })
                        $(".app_receive_job_post_question").html(html)
                    }else {
                        $(".app_receive_job_post_question_box").addClass('d-none');
                    }
                    if(response.seeker.summary) {
                        $(".app_receive_career_des_box").removeClass('d-none');
                        $(".app_receive_career_des").html(response.seeker.summary)
                    }else {
                        $(".app_receive_career_des_box").addClass('d-none');
                    }
                    if(response.educations.length > 0) {
                        $('.app_receive_education_box').removeClass('d-none');
                        $('.app_receive_education').empty();
                        $(response.educations).each(function(edu_index, edu_value){
                            var edu_to = '';
                            if(edu_value.is_current == 1) {
                                edu_to = 'Present';
                            }else {
                                edu_to = edu_value.to;
                            }
                            if(edu_value.school == null) {
                                edu_school = '';
                            }else {
                                edu_school = edu_value.school;
                            }
                            $('.app_receive_education').append('<div class="my-3 px-3 border-bottom"><p><h4>'+edu_value.location+'</h4></p><p><h4 class="d-inline-block">'+edu_value.degree+'</h4> - '+edu_value.major_subject+'</p><p>'+edu_school+'</p><p>'+edu_value.from+' to '+edu_to+'</p></div>')
                        })
                    }else {
                        $('.app_receive_education_box').addClass('d-none');
                    }
                    if(response.experiences.length > 0) {
                        $('.app_receive_experience_box').removeClass('d-none');
                        $('.app_receive_experience').empty();
                        $(response.experiences).each(function(exp_index, exp_value) {
                            if(exp_value.is_experience == 0) {
                                $('.app_receive_experience').append('<div class="my-3 px-3">No Experience</div>')
                            }else {
                                var responsibility = '';
                                if(exp_value.job_responsibility){
                                    responsibility = '<div class="mx-3"><p class="fs-5 fw-bold">Job Responsibility</p><p class="mx-3">'+exp_value.job_responsibility+'</p></div>'
                                }
                                var end_date = moment(exp_value.end_date).format("YYYY MMM");
                                if(exp_value.is_current_job == 1) {
                                    end_date = 'Present';
                                }
                                $('.app_receive_experience').append('<div class="my-3 border-bottom px-3"><p class="fw-bold">'+exp_value.job_title+'</p><p>'+exp_value.industry_name+'</p><p>'+moment(exp_value.start_date).format("YYYY MMM")+' to '+end_date+'</p><p class="fw-bold fs-4">'+exp_value.company+'</p><p>'+exp_value.main_functional_area_name+' - '+exp_value.sub_functional_area_name+'</p><p>'+exp_value.country+'</p>'+responsibility+'</div>')
                            }
                        })
                    }else {
                        $('.app_receive_experience_box').addClass('d-none')
                    }
                    if(response.skill_main_functional_areas.length > 0) {
                        $('.app_receive_skill_box').removeClass('d-none')
                        $(".app_receive_skill").empty();
                        $(response.skill_main_functional_areas).each(function(skill_function_index, skill_function_value) {
                            $(".app_receive_skill").append('<div class="px-3"><h4>'+skill_function_value.main_functional_area_name+'</h4><ul id="skill_'+skill_function_value.main_functional_area_id+'"></ul></div>')
                            $(response.skills).each(function(skill_index, skill_value) {
                                if(skill_function_value.main_functional_area_id == skill_value.main_functional_area_id) {
                                    $('#skill_'+skill_value.main_functional_area_id).append('<li>'+skill_value.skill_name+'</li>')
                                }
                            })
                        })
                    }else {
                        $('.app_receive_skill_box').addClass('d-none');
                    }
                    if(response.languages.length > 0) {
                        $('.app_receive_lang_box').removeClass('d-none')
                        $('.app_receive_lang').empty();
                        $(response.languages).each(function(lang_index, lang_value){
                            $('.app_receive_lang').append('<div class="px-3 row"><div class="col-2"><h4>'+lang_value.name+'</h4></div><div class="col-2"><span>'+lang_value.level+'</span></div> </div>')
                        })
                    }else {
                        $('.app_receive_lang_box').addClass('d-none');
                    }
                    if(response.references.length > 0) {
                        $('.app_receive_ref_box').removeClass('d-none');
                        $('.app_receive_ref').empty();
                        $(response.references).each(function(ref_index, ref_value){
                            $('.app_receive_ref').append('<div class="my-3 px-3"><h4>'+ref_value.name+'</h4><p>'+ref_value.position+'</p><p>'+ref_value.company+'</p><p>'+ref_value.contact+'</p> </div>')
                        })
                    }else {
                        $('.app_receive_ref_box').addClass('d-none')
                    }
                })
            }
        }else {
            $('.no-seeker').removeClass('d-none');
            $(".seeker_table").addClass('d-none');
            $('.profile-overview').addClass('d-none')
        }
        
    }

    function getRelatedApplicantInfo(id, jobPostId, status)
    {
        $(".loading").removeClass('hide-loader')
        table.rows().remove();
        $.ajax({
            type: 'GET',
            url: 'get-jobpost-info/'+id+'/'+jobPostId+'/'+status,
        }).done(function(response){
            if(response.status == 'success') {
                $(".loading").addClass('hide-loader')
                table.rows().remove();
                getSeekerData(response)
            }
        })
    }

    function changeStatus (seekerId, jobPostId, status)
    {
        $(".loading").removeClass('hide-loader')
        $.ajax({
            type: 'GET',
            url: 'change-status/'+jobPostId+'/'+seekerId+'/'+status,
        }).done(function(response){
            if(response.status == 'success') {
                $(".loading").addClass('hide-loader')
                table.rows().remove();
                getSeekerData(response)
                CVColor(status)
                
            }
        })
    }

    function btnColor(status)
    {
        if(status == 'received') {
            $(".btn-received").removeClass('btn-outline-primary');
            $(".btn-received").addClass('btn-primary');
            $(".btn-received").html('<i class="fa-solid fa-check"></i> Application Received');

            $(".btn-viewed").removeClass('btn-dark');
            $(".btn-short-listed").removeClass('btn-info');
            $(".btn-interview").removeClass('btn-warning');
            $(".btn-hire").removeClass('btn-success');
            $(".btn-not-suitable").removeClass('btn-danger');

            $(".btn-viewed").addClass('btn-outline-dark');
            $(".btn-short-listed").addClass('btn-outline-info');
            $(".btn-interview").addClass('btn-outline-warning');
            $(".btn-hire").addClass('btn-outline-success');
            $(".btn-not-suitable").addClass('btn-outline-danger');

            $(".btn-viewed").html('Viewed Application');
            $(".btn-short-listed").html('Shorted Listed');
            $(".btn-interview").html('Interview');
            $(".btn-hire").html('Hire');
            $(".btn-not-suitable").html('Not Suitable');
        }else if(status == 'viewed') {
            $(".btn-viewed").removeClass('btn-outline-dark');
            $(".btn-viewed").addClass('btn-dark');
            $(".btn-viewed").html('<i class="fa-solid fa-check"></i> Viewed Application');

            $(".btn-received").removeClass('btn-primary');
            $(".btn-short-listed").removeClass('btn-info');
            $(".btn-interview").removeClass('btn-warning');
            $(".btn-hire").removeClass('btn-success');
            $(".btn-not-suitable").removeClass('btn-danger');

            $(".btn-received").addClass('btn-outline-primary');
            $(".btn-short-listed").addClass('btn-outline-info');
            $(".btn-interview").addClass('btn-outline-warning');
            $(".btn-hire").addClass('btn-outline-success');
            $(".btn-not-suitable").addClass('btn-outline-danger');

            $(".btn-received").html('Application Received');
            $(".btn-short-listed").html('Shorted Listed');
            $(".btn-interview").html('Interview');
            $(".btn-hire").html('Hire');
            $(".btn-not-suitable").html('Not Suitable');
        }else if(status == 'short-listed') {
            $(".btn-short-listed").removeClass('btn-outline-info');
            $(".btn-short-listed").addClass('btn-info');
            $(".btn-short-listed").html('<i class="fa-solid fa-check"></i> Short Listed');

            $(".btn-received").removeClass('btn-primary');
            $(".btn-viewed").removeClass('btn-dark');
            $(".btn-interview").removeClass('btn-warning');
            $(".btn-hire").removeClass('btn-success');
            $(".btn-not-suitable").removeClass('btn-danger');

            $(".btn-received").addClass('btn-outline-primary');
            $(".btn-viewed").addClass('btn-outline-dark');
            $(".btn-interview").addClass('btn-outline-warning');
            $(".btn-hire").addClass('btn-outline-success');
            $(".btn-not-suitable").addClass('btn-outline-danger');

            $(".btn-received").html('Application Received');
            $(".btn-viewed").html('Viewed Application');
            $(".btn-interview").html('Interview');
            $(".btn-hire").html('Hire');
            $(".btn-not-suitable").html('Not Suitable');
        }else if(status == 'interview') {
            $(".btn-interview").removeClass('btn-outline-warning');
            $(".btn-interview").addClass('btn-warning');
            $(".btn-interview").html('<i class="fa-solid fa-check"></i> Interview');

            $(".btn-received").removeClass('btn-primary');
            $(".btn-viewed").removeClass('btn-dark');
            $(".btn-short-listed").removeClass('btn-info');
            $(".btn-hire").removeClass('btn-success');
            $(".btn-not-suitable").removeClass('btn-danger');

            $(".btn-received").addClass('btn-outline-primary');
            $(".btn-viewed").addClass('btn-outline-dark');
            $(".btn-short-listed").addClass('btn-outline-info');
            $(".btn-hire").addClass('btn-outline-success');
            $(".btn-not-suitable").addClass('btn-outline-danger');

            $(".btn-received").html('Application Received');
            $(".btn-viewed").html('Viewed Application');
            $(".btn-short-listed").html('Shorted Listed');
            $(".btn-hire").html('Hire');
            $(".btn-not-suitable").html('Not Suitable');
        }else if(status == 'hire') {
            $(".btn-hire").removeClass('btn-outline-success');
            $(".btn-hire").addClass('btn-success');
            $(".btn-hire").html('<i class="fa-solid fa-check"></i> Hire');

            $(".btn-received").removeClass('btn-primary');
            $(".btn-viewed").removeClass('btn-dark');
            $(".btn-short-listed").removeClass('btn-info');
            $(".btn-interview").removeClass('btn-warning');
            $(".btn-not-suitable").removeClass('btn-danger');

            $(".btn-received").addClass('btn-outline-primary');
            $(".btn-viewed").addClass('btn-outline-dark');
            $(".btn-short-listed").addClass('btn-outline-info');
            $(".btn-interview").addClass('btn-outline-warning');
            $(".btn-not-suitable").addClass('btn-outline-danger');

            $(".btn-received").html('Application Received');
            $(".btn-viewed").html('Viewed Application');
            $(".btn-short-listed").html('Shorted Listed');
            $(".btn-interview").html('Interview');
            $(".btn-not-suitable").html('Not Suitable');
        }else if(status == 'not-suitable') {
            $(".btn-not-suitable").removeClass('btn-outline-danger');
            $(".btn-not-suitable").addClass('btn-danger');
            $(".btn-not-suitable").html('<i class="fa-solid fa-check"></i> Not Suitable');

            $(".btn-received").removeClass('btn-primary');
            $(".btn-viewed").removeClass('btn-dark');
            $(".btn-short-listed").removeClass('btn-info');
            $(".btn-interview").removeClass('btn-warning');
            $(".btn-hire").removeClass('btn-success');

            $(".btn-received").addClass('btn-outline-primary');
            $(".btn-viewed").addClass('btn-outline-dark');
            $(".btn-short-listed").addClass('btn-outline-info');
            $(".btn-interview").addClass('btn-outline-warning');
            $(".btn-hire").addClass('btn-outline-success');

            $(".btn-received").html('Application Received');
            $(".btn-viewed").html('Viewed Application');
            $(".btn-short-listed").html('Shorted Listed');
            $(".btn-interview").html('Interview');
            $(".btn-hire").html('Hire');
        }
    }

    function CVColor(status)
    {
        if(status == 'received') {
            $(".cv-status").removeClass('active');
            $(".cv-received").addClass('active');
        }else if(status == 'viewed') {
            $(".cv-status").removeClass('active');
            $(".cv-viewed").addClass('active');
        }else if(status == 'short-listed') {
            $(".cv-status").removeClass('active');
            $(".cv-short-listed").addClass('active');
        }else if(status == 'interview') {
            $(".cv-status").removeClass('active');
            $(".cv-interview").addClass('active');
        }else if(status == 'hire') {
            $(".cv-status").removeClass('active');
            $(".cv-hire").addClass('active');
        }else if(status == 'not-suitable') {
            $(".cv-status").removeClass('active');
            $(".cv-not-suitable").addClass('active');
        }
    }
</script>
@endpush