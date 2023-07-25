<div class="container-fluid" id="edit-profile-header">
    <div class="row mt-1 px-5 py-5 bg-light" style="border-radius: 8px">
        <div class="row">
            <div class="col-12 col-md-6">
                <h5>Manage Job</h5>
            </div>
            <div class="col-12 col-md-6 text-end">
                <a href="{{ route('employer-job-post.create') }}" class="btn btn-sm profile-save-btn"><i class="fa-solid fa-plus"></i> Post a Job</a>
            </div>
        </div>
        <div id="jobPostList">
            @if($jobPosts->count() > 0)
            <div class="row m-0 py-5">
                @foreach($jobPosts as $jobPost)
                <div class="col-12 p-1">
                    <div class="m-0 mb-2 pb-0 seeker-job-list rounded">
                        <div class="row p-3">
                            <div class="col-2 d-flex align-items-center ps-5">
                                @if($employer->logo)
                                <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                @elseif($jobPost->hide_company == 1)
                                <img src="{{ asset('img/person.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                @else 
                                <img src="{{ asset('img/person.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                @endif
                            </div>
                            <div class="col-5">
                                @if($jobPost->hide_company == 1)
                                <span class="jobpost-attr">Anonymous</span>
                                @else
                                <span class="jobpost-attr">{{ $employer->name }}</span>
                                @endif
                                <h5>{{ $jobPost->job_title }}</h5>
                                @if($jobPost->hide_salary == 1)
                                <p class="p-0 m-0" style="color: #181722">Negotiate</p>
                                @else
                                @if($jobPost->salary_range)
                                <p class="p-0 m-0" style="color: #181722">{{ $jobPost->salary_range }} {{ $jobPost->currency }}</p>
                                @endif
                                @endif
                                <span class="jobpost-attr"><i class="fa-solid fa-briefcase"></i> {{ $jobPost->Industry->name }}</span>
                                @if($jobPost->state_id)
                                <span class="jobpost-attr"><i class="fa-solid fa-location-dot"></i> {{ $jobPost->State->name }} ,</span>
                                @endif
                                @if($jobPost->township_id)
                                <span class="jobpost-attr">{{ $jobPost->Township->name }}</span>
                                @endif
                                @if($jobPost->country == 'Other') 
                                <span class="jobpost-attr"><i class="fa-solid fa-location-dot"></i> Other Country</span>
                                @endif
                            </div>
                            <div class="col-2 d-flex align-items-end flex-column bd-highlight">
                                <div class="px-4 job-post-status-{{$jobPost->id}}">
                                    @if($jobPost->is_active == 0)
                                    <span class="badge rounded-pill bg-warning">Deactive</span>
                                    @else
                                        @if($jobPost->status == 'Pending')
                                        <span class="badge rounded-pill bg-secondary">{{ $jobPost->status }}</span>
                                        @elseif($jobPost->status == 'Online')
                                        <span class="badge rounded-pill bg-success">{{ $jobPost->status }}</span>
                                        @elseif($jobPost->status == 'Reject')
                                        <span class="badge rounded-pill bg-warning">{{ $jobPost->status }}</span>
                                        @elseif($jobPost->status == 'Expire')
                                        <span class="badge rounded-pill bg-danger">{{ $jobPost->status }}</span>
                                        @endif
                                    @endif
                                </div>
                                <div class="mt-auto p-2 bd-highlight ">
                                <span style="color: #46454E;" class="px-3 text-muted">Date {{ date('d/m/Y', strtotime($jobPost->updated_at)) }}</span>
                                </div>
                            </div>
                            <div class="col-3 d-flex align-items-end flex-column bd-highlight">
                                <div class="mt-auto p-2 bd-highlight ">
                                    <a href="{{ route('employer-job-post.edit', $jobPost->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <div class="d-inline-block form-switch">
                                        <input class="form-check-input employer-form-check form-switch" type="checkbox" @if($jobPost->is_active == 0) checked @endif role="switch" id="job_post_is_active_{{ $jobPost->id }}" onclick="changeJobPostStatus({{ $jobPost->id }}, {{ $jobPost->is_active }})">
                                        <label for="job_post_is_active">Activate/Deactivate</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="row">
                    <div class="col pt-2">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                        {{ $jobPosts->appends(request()->all())->links('pagination::bootstrap-4') }}
                        </ul>
                    </nav>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@push('scripts')
<script>
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
                    $('.job-post-status-'+id).html('<span class="badge rounded-pill bg-warning">Deactive</span>');
                    $("#job_post_is_active_"+id).attr('onclick','changeJobPostStatus('+id+', '+response.data.is_active+')');
                }else {
                    $("#job_post_is_active_"+id).attr('onclick','changeJobPostStatus('+id+', '+response.data.is_active+')');
                    var bg_color = 'secondary';
                    if(response.data.status == 'Online') {
                        var bg_color = 'success'
                    }else if(response.data.status == 'Expire' || response.data.status == 'Reject') {
                        var bg_color = 'danger'
                    }
                    $('.job-post-status-'+id).html('<span class="badge rounded-pill bg-'+bg_color+'">'+response.data.status+'</span>')
                }
            }
        })
        
    }
    
</script>
@endpush