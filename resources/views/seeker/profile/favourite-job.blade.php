<div class="container-fluid px-5 py-3 edit-profile-header-border" id="edit-profile-header">
    <div class="">
        <h5>Favourite Jobs ( {{ $saveJobs->count() }} )</h5>
    </div>
</div>
@if($saveJobs->count() > 0)
<div class="my-2 pb-3" id="edit-profile-body">
    <div class="px-5 m-0 pb-0 pt-3">
        <h5>Your Favourite Jobs</h5>
    </div>
    <div class="row px-5 m-0 pb-0 pt-3">
        @foreach($saveJobs as $saveJob)
        <div class="col-md-6 col-12">
            
            <div class="row job-content mb-3 m-1">
                <!-- Job List Start -->
                
                <div class="col-lg-9 col-md-9 py-4 d-flex">
                    <a href="{{ route('jobpost-detail', $saveJob->JobPost->slug) }}">
                        <div style="width: 100px" class="align-self-center">
                            @if($saveJob->JobPost->job_post_type == 'feature' || $saveJob->JobPost->job_post_type == 'trending')
                            @if($saveJob->JobPost->Employer->logo)
                            <img src="{{ asset('storage/employer_logo/'.$saveJob->JobPost->Employer->logo) }}" alt="Profile Image" class="mb-2 img-responsive center-block d-block mx-auto" style="width: 75px" id="ProfilePreview">
                            @else 
                            <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="mb-2 img-responsive center-block d-block mx-auto" style="width: 75px" id="ProfilePreview">
                            @endif
                            <div class="text-center">
                            @if($saveJob->JobPost->job_post_type == 'feature')<span class="badge badge-pill job-post-badge" style="background: #0355D0"> Featured @elseif($saveJob->JobPost->job_post_type == 'trending') <span class="badge badge-pill job-post-badge" style="background: #FB5404"> Trending @endif</span>
                            </div>
                            @endif
                        </div>
                        <div class="align-self-center">
                            <div class="mt-1 job-company">{{ $saveJob->JobPost->Employer->name }}</div>
                            <div class="mt-1">{{ $saveJob->JobPost->job_title }}</div>
                            @if($saveJob->JobPost->township_id)
                            <div class="mt-1 job-location">{{ $saveJob->JobPost->Township->name }}</div>
                            @endif
                            @if($saveJob->JobPost->job_post_type == 'trending')
                            <p class="job-post-preview">{!! \Illuminate\Support\Str::limit(strip_tags($saveJob->JobPost->job_requirement), $limit = 100, $end = '...') !!}</p>
                            @endif
                            <div class="mt-1 ">
                                <a href="{{ route('search-main-function', $saveJob->JobPost->main_functional_area_id) }}" class="mt-1 job-post-area"># {{ $saveJob->JobPost->MainFunctionalArea->name }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-lg-3 col-md-3 d-flex align-items-end flex-column bd-highlight py-4">
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
        <div class="row">
            <div class="col pt-2">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                {{ $saveJobs->appends(request()->all())->links('pagination::bootstrap-4') }}
                </ul>
            </nav>
            </div>
        </div>
    </div>
</div>
@endif