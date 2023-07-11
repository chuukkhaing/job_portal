<div class="container" id="edit-profile-header">
    <div class="px-5 m-0 pb-0 pt-5">
        <div class="row">
            <h5>Employer Jobs</h5>
        </div>
        @if($jobPosts->count() > 0)
        <div class="row m-0 pb-0 pt-5">
            @foreach($jobPosts as $jobPost)
            <div class="col-md-6 col-12 p-1">
                <a href="{{ route('jobpost-detail', $jobPost->slug) }}">
                    <div class="m-0 mb-2 pb-0 seeker-job-list rounded">
                        <div class="row">
                            <div class="col-2">
                                @if(Auth::guard('employer')->user()->logo)
                                <img src="{{ asset('storage/employer_logo/'.Auth::guard('employer')->user()->logo) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                @else 
                                <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                @endif
                            </div>
                            <div class="col-6">
                                <span class="jobpost-attr">{{ Auth::guard('employer')->user()->name }}</span>
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
                            <div class="col-4 d-flex align-items-end flex-column bd-highlight mb-3">
                                <div class="text-end px-3 p-2 bd-highlight" style="color: #0355D0"></div>
                                
                            </div>
                            <div class="text-end">
                            <span style="color: #46454E;" class="px-3"><strong>Date {{ date('d/m/Y', strtotime($jobPost->updated_at)) }}</strong></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>