@extends('frontend.layouts.app')
@section('content')

<div class="col-xl-10 col-lg-12 m-auto">
    @include('seeker.profile.seeker-sub-header')
    <div class="tab-content" id="seekerTabContent">
        <div class="tab-pane fade p-0 show active" id="fav-job" role="tabpanel" aria-labelledby="fav-job-tab">
            <div class="container-fluid px-xl-5 px-lg-3 py-3 edit-profile-header-border" id="edit-profile-header">
                <div class="">
                    <h5>My Favorite Jobs ( <span id="save-job-count">{{ $saveJobs->count() }}</span> )</h5>
                </div>
            </div>
            
            <div class="my-2 py-3 px-lg-5 px-md-3 @if($saveJobs->count() > 0) @else d-none @endif" id="edit-profile-body">
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
                                <th>Added Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($saveJobs as $key => $saveJob)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td class="fw-bold"><a data-bs-toggle="modal" class="jobpostModal" data-bs-target="#JobPostModal{{$saveJob->JobPost->id}}" class="text-black">{{ $saveJob->JobPost->job_title }}</a></td>
                                <td class="text-blue">@if($saveJob->JobPost->hide_company == 0) {{ $saveJob->JobPost->Employer->name }} @if($saveJob->JobPost->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif @else - @endif</td>
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
                            <!-- Modal -->
                            @include('frontend.job-post-modal', ['jobPost' => $saveJob->JobPost])
                            
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

    function applyJob(id) {
        $(this).attr('disabled','true');
        
    }
    
    $(document).ready(function() {
        var loggedIn = "{{ Auth::guard('seeker')->user() ? session(['returnUrl' => '']) : session(['returnUrl' => 'jobpost-detail', 'previous_url' => url()->current()]) }}";
        @if(count($errors) > 0) 
        MSalert.principal({
            icon:'error',
            title:'Error',
            description: "Need to answer all questions.",
        })
        @endif
    })

</script>
@endpush