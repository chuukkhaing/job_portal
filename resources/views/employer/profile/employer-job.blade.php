<div class="container-fluid" id="edit-profile-header">
    <div class="row mt-1 px-5 pb-0 pt-5 bg-light">
        <div class="row">
            <div class="col-12 col-md-6">
                <h5>Manage Job</h5>
            </div>
            <div class="col-12 col-md-6 text-end">
                <button onclick="postAJob()" id="postAJob" class="btn btn-sm profile-save-btn"><i class="fa-solid fa-plus"></i> Post a Job</button>
                <button onclick="backToManageJob()" class="btn profile-save-btn btn-sm back-to-jobs-btn d-none"><i class="fa-solid fa-rotate-left"></i> Back</button>
            </div>
        </div>
        <div id="jobPostList">
            @if($jobPosts->count() > 0)
            <div class="row m-0 pb-0 pt-5">
                @foreach($jobPosts as $jobPost)
                <div class="col-12 p-1">
                    <a href="{{ route('jobpost-detail', $jobPost->slug) }}">
                        <div class="m-0 mb-2 pb-0 seeker-job-list rounded">
                            <div class="row p-3">
                                <div class="col-2 d-flex align-items-center ps-5">
                                    @if($employer->logo)
                                    <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                    @else 
                                    <img src="{{ asset('img/person.png') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                    @endif
                                </div>
                                <div class="col-6">
                                    <span class="jobpost-attr">{{ $employer->name }}</span>
                                    <h5>{{ $jobPost->job_title }}</h5>
                                    @if($jobPost->salary_status == 'Negotiable')
                                    <p class="p-0 m-0" style="color: #181722">Negotiate</p>
                                    @endif
                                    @if($jobPost->salary_status != 'Hide' && $jobPost->salary_status != 'Negotiable')
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
                                <div class="col-4 d-flex align-items-end flex-column bd-highlight">
                                    <div class="mt-auto p-2 bd-highlight ">
                                    <span style="color: #46454E;" class="px-3 text-muted">Date {{ date('d/m/Y', strtotime($jobPost->updated_at)) }}</span>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </a>
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
        <div id="jobPostCreate" class="d-none">
        @include('employer.profile.post-job')
        </div>
    </div>
</div>
@push('scripts')
<script>
    function postAJob()
    {
        $('#jobPostList').addClass('d-none');
        $('#jobPostCreate').removeClass('d-none');
        $('.back-to-jobs-btn').removeClass('d-none');
    }

    function backToManageJob()
    {
        $('#jobPostList').removeClass('d-none');
        $('#jobPostCreate').addClass('d-none');
        $('.back-to-jobs-btn').addClass('d-none');
    }
</script>
@endpush