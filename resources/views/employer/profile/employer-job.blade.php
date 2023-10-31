@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    @include('employer.profile.employer-sub-header')
    <div class="tab-content" id="employerTabContent">
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','manage_job')->count() > 0))
        <div class="tab-pane fade p-0 show active" id="employer-dashboard">
            <div class="container-fluid" id="edit-profile-header">
                <nav class="py-3">
                    <div class="nav nav-tabs manage-jobs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-pending-tab" data-bs-toggle="tab" data-bs-target="#nav-pending" type="button" role="tab" aria-controls="nav-pending" aria-selected="true">Pending</button>
                        <button class="nav-link" id="nav-online-tab" data-bs-toggle="tab" data-bs-target="#nav-online" type="button" role="tab" aria-controls="nav-online" aria-selected="false">Approved</button>
                        <button class="nav-link" id="nav-reject-tab" data-bs-toggle="tab" data-bs-target="#nav-reject" type="button" role="tab" aria-controls="nav-reject" aria-selected="false">Reject</button>
                        <button class="nav-link" id="nav-expire-tab" data-bs-toggle="tab" data-bs-target="#nav-expire" type="button" role="tab" aria-controls="nav-expire" aria-selected="false">Expire</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
                        
                        <div class="table-responsive" id="applicant-tracking-section">
                            <table class="table table-hover table-borderless table-sm dataTable" width="100%" >
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">No.</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Title</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Post Type</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Function</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Status</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Date</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($pendingjobPosts as $key => $pendingjobPost)
                                <tr>
                                    <td class="text-black">{{ $key+1 }}</td>
                                    <td class="text-black">{{ $pendingjobPost->job_title }} ({{ $pendingjobPost->no_of_candidate }} - posts)</td>
                                    <td>@if($pendingjobPost->job_post_type == 'trending') <span class="badge rounded-pill px-3" style="background: #FB5404">Trending</span> @elseif($pendingjobPost->job_post_type == 'feature') <span class="badge rounded-pill px-3" style="background: #0355D0">Feature</span> @else <span class="badge rounded-pill px-3 bg-success"> Standard </span> @endif</td>
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
                                                <span class="badge rounded-pill px-3 bg-warning text-dark">{{ $pendingjobPost->status }}</span>
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
                            <table class="table table-hover table-borderless table-sm dataTable" width="100%" >
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">No.</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Title</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Post Type</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Function</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Status</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Date</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($onlinejobPosts as $key => $onlinejobPost)
                                <tr>
                                    <td class="text-black">{{ $key+1 }}</td>
                                    <td class="text-black">{{ $onlinejobPost->job_title }} ({{ $onlinejobPost->no_of_candidate }} - posts)</td>
                                    <td>
                                    @if($onlinejobPost->job_post_type == 'trending') <span class="badge rounded-pill px-3" style="background: #FB5404">Trending</span> @elseif($onlinejobPost->job_post_type == 'feature') <span class="badge rounded-pill px-3" style="background: #0355D0">Feature</span> @else <span class="badge rounded-pill px-3 bg-success"> Standard </span> @endif
                                    </td>
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
                                                <span class="badge rounded-pill px-3 bg-warning text-dark">{{ $onlinejobPost->status }}</span>
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
                            <table class="table table-hover table-borderless table-sm dataTable" width="100%" >
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">No.</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Title</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Post Type</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Function</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Status</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Date</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($rejectjobPosts as $key => $rejectjobPost)
                                <tr>
                                    <td class="text-black">{{ $key+1 }}</td>
                                    <td class="text-black">{{ $rejectjobPost->job_title }} ({{ $rejectjobPost->no_of_candidate }} - posts)</td>
                                    <td>
                                    @if($rejectjobPost->job_post_type == 'trending') <span class="badge rounded-pill px-3" style="background: #FB5404">Trending</span> @elseif($rejectjobPost->job_post_type == 'feature') <span class="badge rounded-pill px-3" style="background: #0355D0">Feature</span> @else <span class="badge rounded-pill px-3 bg-success"> Standard </span> @endif
                                    </td>
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
                                                <span class="badge rounded-pill px-3 bg-warning text-dark">{{ $rejectjobPost->status }}</span>
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
                            <table class="table table-hover table-borderless table-sm dataTable" width="100%" >
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">No.</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Title</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Post Type</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Job Function</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Status</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Date</th>
                                        <th style="border-bottom: 1px solid #E5E9EB; border-top: 1px solid #E5E9EB">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($expirejobPosts as $key => $expirejobPost)
                                <tr>
                                    <td class="text-black">{{ $key+1 }}</td>
                                    <td class="text-black">{{ $expirejobPost->job_title }} ({{ $expirejobPost->no_of_candidate }} - posts)</td>
                                    <td>
                                    @if($expirejobPost->job_post_type == 'trending') <span class="badge rounded-pill px-3" style="background: #FB5404">Trending</span> @elseif($expirejobPost->job_post_type == 'feature') <span class="badge rounded-pill px-3" style="background: #0355D0">Feature</span> @else <span class="badge rounded-pill px-3 bg-success"> Standard </span> @endif
                                    </td>
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
                                                <span class="badge rounded-pill px-3 bg-warning text-dark">{{ $expirejobPost->status }}</span>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })

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