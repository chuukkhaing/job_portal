<div class="container-fluid">
    <div class="row">
        <div class=" col-4">
            <div class="row me-0 p-3 bg-light">
                <div class="col-8">
                    <p class="overview-title">Opening Jobs</p>
                    <span class="fw-bold fs-3">{{ $employer->JobPost->where('is_active',1)->count() }}</span>
                </div>
                <div class="col-4">
                    <div class="opening-job-icon float-end">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-4">
            <div class="row p-3 bg-light">
                <div class="col-8">
                    <p class="overview-title">Point Balance</p>
                    <span class="fw-bold fs-3">{{ $employer->JobPost->where('is_active',1)->count() }}</span>
                </div>
                <div class="col-4">
                    <div class="points-icon float-end">
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-4">
            <div class="row ms-0 p-3 bg-light">
                <div class="col-8">
                    <p class="overview-title">Purchased Points</p>
                    <span class="fw-bold fs-3">{{ $employer->JobPost->where('is_active',1)->count() }}</span>
                </div>
                <div class="col-4">
                    <div class="points-icon float-end">
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-1 p-0 bg-light" style="border-radius: 8px">
        <div class="px-5">
            <div class="row">
                <div class="col-8 my-5">
                    <div id="last-job-post" class="p-5 ">
                        <h5 class="fw-bold">Last Job Posts</h5>
                        <div class="row p-3">
                            @foreach($lastJobPosts as $jobPost)
                            <div class="col-8 p-2">
                                <a href="{{ route('jobpost-detail', $jobPost->slug) }}">
                                    <span class="text-muted fs-6">{{ $jobPost->job_title }}</span>
                                    @if($jobPost->country == 'Myanmar')
                                    <br>
                                    <span class=" text-primary">{{ $jobPost->State->name }}</span>
                                    @endif
                                </a>
                            </div>
                            <div class="col-4 p-2 d-flex align-items-end flex-row-reverse bd-highlight">
                                <a href="{{ route('jobpost-detail', $jobPost->slug) }}">
                                <span class="text-dark fw-bold fs-6">{{ date('M d', strtotime($jobPost->updated_at)) }}</span>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <a style="cursor: pointer" onclick="seeAllPost('#employer-job')" class="text-dark fw-bold">SEE ALL POSTS <i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="col-4 my-5">
                    <div id="last-job-post" class="py-5 px-3 ">
                        <h5 class="fw-bold">Job applied ranking</h5>
                        <div class="row p-3">
                            @foreach($lastJobPosts as $jobPost)
                            <div class="col-12 p-3">
                                <a href="{{ route('jobpost-detail', $jobPost->slug) }}">
                                    <span class="text-muted fs-6">{{ $jobPost->job_title }}</span>
                                    <span class="title float-end text-dark">{{ $jobPost->JobApply->count() }}</span>
                                    <div class="progress">
                                        <div class="apply-progress-bar" role="progressbar" aria-valuenow="{{ $jobPost->JobApply->count() }}" aria-valuemin="0" aria-valuemax="100" style="max-width: {{ $jobPost->JobApply->count() }}%">
                                        </div>
                                    </div>
                                    
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <a style="cursor: pointer" onclick="seeAllPost('#employer-job')" class="text-dark fw-bold">SEE ALL <i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@push('scripts')
<script>
    function seeAllPost(employerJob)
    {
        localStorage.setItem('target',employerJob)
    
        var employer_tab = localStorage.getItem('target');
        var employerJobTab = document.querySelector('#employerTab li a[href="'+employer_tab+'"]')
        var showTab = new bootstrap.Tab(employerJobTab)

        showTab.show()
    }
</script>
@endpush