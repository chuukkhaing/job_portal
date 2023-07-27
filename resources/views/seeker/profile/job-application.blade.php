<div class="container-fluid p-5 edit-profile-header-border" id="edit-profile-header">
    <div class="">
        <h5>Applied Jobs ( {{ $jobsApplyBySeeker->count() }} )</h5>
    </div>
</div>
@if($jobsApplyBySeeker->count() > 0)
<div class="my-2" id="edit-profile-body">
    <div class="px-5 m-0 pb-0 pt-5">
        <h5>Your Applied Jobs</h5>
    </div>
    <div class="row px-5 m-0 pb-0 pt-5">
        @foreach($jobsApplyBySeeker as $jobApplyBySeeker)
        <div class="col-md-6 col-12">
            <a href="{{ route('jobpost-detail', $jobApplyBySeeker->JobPost->slug) }}">
                <div class="m-0 mb-2 pb-0 seeker-job-list rounded">
                    <div class="row">
                        <div class="col-2">
                            @if($jobApplyBySeeker->Employer->logo)
                            <img src="{{ asset('storage/employer_logo/'.$jobApplyBySeeker->Employer->logo) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                            @else 
                            <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                            @endif
                        </div>
                        <div class="col-7">
                            <span class="jobpost-attr">{{ $jobApplyBySeeker->Employer->name }}</span>
                            <h5>{{ $jobApplyBySeeker->JobPost->job_title }}</h5>
                            @if($jobApplyBySeeker->JobPost->state_id)
                            <span class="jobpost-attr">{{ $jobApplyBySeeker->JobPost->State->name }} ,</span>
                            @endif
                            @if($jobApplyBySeeker->JobPost->township_id)
                            <span class="jobpost-attr">{{ $jobApplyBySeeker->JobPost->Township->name }}</span>
                            @endif
                            @if($jobApplyBySeeker->JobPost->country == 'Other') 
                            <span class="jobpost-attr">Other Country</span>
                            @endif
                            @if($jobApplyBySeeker->JobPost->salary_status == 'Negotiable')
                            <p class="p-0 m-0" style="color: #181722">Negotiate</p>
                            @endif
                            @if($jobApplyBySeeker->JobPost->salary_status != 'Hide' && $jobApplyBySeeker->JobPost->salary_status != 'Negotiable')
                            @if($jobApplyBySeeker->JobPost->salary_range)
                            <p class="p-0 m-0" style="color: #181722">{{ $jobApplyBySeeker->JobPost->salary_range }} {{ $jobApplyBySeeker->JobPost->currency }}</p>
                            @endif
                            @endif
                        </div>
                        <div class="col-3 d-flex align-items-end flex-column bd-highlight mb-3">
                            <div class="text-end px-3 p-2 bd-highlight" style="color: #0355D0">Applied</div>
                            <div class="mt-auto p-1 bd-highlight">
                            <span>{{ $jobApplyBySeeker->JobPost->updated_at->diffForHumans() }}</span>
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
                {{ $jobsApplyBySeeker->appends(request()->all())->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
            </div>
        </div>
    </div>
</div>
@endif