<div class="container-fluid p-5 edit-profile-header-border" id="edit-profile-header">
    <div class="">
        <h5>Favourite Jobs ( {{ $saveJobs->count() }} )</h5>
    </div>
</div>
@if($saveJobs->count() > 0)
<div class="my-2 pb-3" id="edit-profile-body">
    <div class="px-5 m-0 pb-0 pt-5">
        <h5>Your Favourite Jobs</h5>
    </div>
    <div class="row px-5 m-0 pb-0 pt-5">
        @foreach($saveJobs as $saveJob)
        <div class="col-md-6 col-12">
            
            <div class="row job-content mb-3 m-1">
                <!-- Job List Start -->
                
                <div class="col-lg-10 col-md-10 py-4 d-flex">
                    <a href="{{ route('jobpost-detail', $saveJob->JobPost->slug) }}">
                        <div style="width: 100px">
                            @if($saveJob->JobPost->Employer->logo)
                            <img src="{{ asset('storage/employer_logo/'.$saveJob->JobPost->Employer->logo) }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 55px" id="ProfilePreview">
                            @else 
                            <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 55px" id="ProfilePreview">
                            @endif
                        </div>
                        <div>
                            <div class="job-company">{{ $saveJob->JobPost->Employer->name }}</div>
                            <div class="job-title">{{ $saveJob->JobPost->job_title }}</div>
                            @if($saveJob->JobPost->country == 'Myanmar' && $saveJob->JobPost->township_id)
                            <div class="job-location">{{ $saveJob->JobPost->Township->name }}</div>
                            @endif
                            <div class="job-salary my-3">@if($saveJob->JobPost->hide_salary == 1) Negotiate @else {{ $saveJob->JobPost->salary_range }} @endif</div>
                            <div class="">
                                <a href="" class="btn job-btn">{{ $saveJob->JobPost->MainFunctionalArea->name }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4">
                    <div class="row col-12 m-0 p-0">
                        
                        <div class="text-end mt-auto p-1">
                            <span>{{ $saveJob->JobPost->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <!-- Wishlist End -->
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif