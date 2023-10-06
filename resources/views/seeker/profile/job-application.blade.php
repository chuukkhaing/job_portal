@extends('frontend.layouts.app')
@section('content')

<div class="col-xl-10 col-lg-12 m-auto">
    <div class="seeker-dashboard-header text-center py-5 mt-4 d-none d-lg-block">
        @if(Auth::guard('seeker')->user()->image)
        <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
        @else
        <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
        @endif
        <div class="seeker-name p-0" style="color: #fff">{{ Auth::guard('seeker')->user()->first_name }} {{ Auth::guard('seeker')->user()->last_name }}</div>
    </div>
    <div class="edit-profile-tab-border d-none d-lg-block">
        <ul class="nav d-flex justify-content-between py-3 px-xl-5 px-lg-3" id="seekerTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{ route('profile.index') }}" class="seeker-single-tab" id="profile-dashboard-tab">Dashboard</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="seeker-single-tab" id="edit-profile-tab">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-applications') }}" class="seeker-single-tab active" id="job-application-tab">Applications</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-saved-jobs') }}" class="seeker-single-tab" id="fav-job-tab">Saved Jobs</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{ route('seeker-job-alerts') }}" class="seeker-single-tab" id="job-alert-tab">Job Alerts</a>
            </li>
        </ul>
    </div>
    <div class="d-block d-lg-none p-4 my-4 seeker-dashboard-mobile">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Seeker Toggle Mobile" id="seeker-toggle-mobile">
                <i class="fa-solid fa-bars text-white"></i> <span class="text-white">Profile Dashboard</span>
                </button>
                <div class="collapse navbar-collapse" id="navbarToggler">

                <ul class="navbar-nav">
                    <li class="nav-item pt-3">
                        <a href="{{ route('profile.index') }}" class="text-white" id="">Dashboard</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="text-white" id="">Profile</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-applications') }}" class="text-white active" id="">Applications</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-saved-jobs') }}" class="text-white" id="">Saved Jobs</a>
                    </li>
                    <li class="nav-item pt-3">
                        <a href="{{ route('seeker-job-alerts') }}" class="text-white" id="">Job Alerts</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        
    </div>
    <div class="tab-content" id="seekerTabContent">
        <div class="tab-pane fade p-0 show active" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
            <div class="container-fluid px-xl-5 px-lg-3 py-3 edit-profile-header-border" id="edit-profile-header">
                <div class="">
                    <h5>My Applications ( {{ $jobsApplyBySeeker->count() }} )</h5>
                </div>
            </div>
            @if($jobsApplyBySeeker->count() > 0)
            <div class="my-2" id="edit-profile-body">
                
                <div class="row m-0 pb-0 pt-3">
                    @foreach($jobsApplyBySeeker as $jobApplyBySeeker)
                    <div class="col-lg-6 col-12">
                        
                        <div class="row job-content mb-3 m-1">
                            <!-- Job List Start -->
                            
                            <div class="col-lg-9 col-md-9 py-4 d-flex">
                                <a href="{{ route('jobpost-detail', $jobApplyBySeeker->JobPost->slug) }}">
                                    <div style="width: 100px" class="align-self-center">
                                        @if($jobApplyBySeeker->JobPost->job_post_type == 'feature' || $jobApplyBySeeker->JobPost->job_post_type == 'trending')
                                        @if($jobApplyBySeeker->Employer->logo)
                                        <img src="{{ asset('storage/employer_logo/'.$jobApplyBySeeker->Employer->logo) }}" alt="Profile Image" class="mb-2 img-responsive center-block d-block mx-auto" style="width: 75px" id="ProfilePreview">
                                        @else 
                                        <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="mb-2 img-responsive center-block d-block mx-auto" style="width: 75px" id="ProfilePreview">
                                        @endif
                                        <div class="text-center">
                                        @if($jobApplyBySeeker->JobPost->job_post_type == 'feature')<span class="badge badge-pill job-post-badge" style="background: #0355D0"> Featured @elseif($jobApplyBySeeker->JobPost->job_post_type == 'trending') <span class="badge badge-pill job-post-badge" style="background: #FB5404"> Trending @endif</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="align-self-center">
                                        <div class="mt-1 job-company">{{ $jobApplyBySeeker->JobPost->Employer->name }}</div>
                                        <div class="mt-1">{{ $jobApplyBySeeker->JobPost->job_title }}</div>
                                        @if($jobApplyBySeeker->JobPost->township_id)
                                        <div class="mt-1 job-location">{{ $jobApplyBySeeker->JobPost->Township->name }}</div>
                                        @endif
                                        @if($jobApplyBySeeker->JobPost->job_post_type == 'trending')
                                        <p class="job-post-preview">{!! \Illuminate\Support\Str::limit(strip_tags($jobApplyBySeeker->JobPost->job_requirement), $limit = 100, $end = '...') !!}</p>
                                        @endif
                                        <div class="row mt-1 d-flex">
                                            <a href="{{ route('search-main-function', $jobApplyBySeeker->JobPost->main_functional_area_id) }}" class="job-post-area col-8 align-self-end"># {{ $jobApplyBySeeker->JobPost->MainFunctionalArea->name }}</a>
                                            <div class="d-md-none d-block col-4 text-end">
                                                @auth('seeker')
                                                <i style="cursor: pointer" id="savejob-{{ $jobApplyBySeeker->JobPost->id }}" onclick="saveJob({{ $jobApplyBySeeker->JobPost->id }})" class="text-blue @if(Auth::guard('seeker')->user()->SaveJob->where('job_post_id', $jobApplyBySeeker->JobPost->id)->count() > 0) fa-solid @else fa-regular @endif fa-heart"></i><br>
                                                @endauth
                                                <span>{{ $jobApplyBySeeker->JobPost->updated_at->shortRelativeDiffForHumans() }}</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Job List End -->

                            <!-- Wishlist Start -->
                            <div class="col-lg-3 col-md-3 d-md-flex d-none align-items-end flex-column bd-highlight py-4">
                                <div class="row col-12 m-0 p-0">
                                    @auth('seeker')
                                    <div class="text-end p-0" style="cursor:pointer">
                                            <i id="savejobapply-{{ $jobApplyBySeeker->JobPost->id }}" onclick="saveJob({{ $jobApplyBySeeker->JobPost->id }})" class="text-blue @if(Auth::guard('seeker')->user()->SaveJob->where('job_post_id', $jobApplyBySeeker->JobPost->id)->count() > 0) fa-solid @else fa-regular @endif fa-heart"></i>
                                    </div>
                                    @endauth
                                    <div class="text-end mt-auto p-1">
                                        <span>{{ $jobApplyBySeeker->JobPost->updated_at->shortRelativeDiffForHumans() }}</span>
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
                            {{ $jobsApplyBySeeker->appends(request()->all())->links('pagination::bootstrap-4') }}
                            </ul>
                        </nav>
                        </div>
                    </div>
                </div>
            </div>
            @endif
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
            if(response.status == 'create') {
                
                $('#savejobapply-'+id).removeClass('fa-regular');
                $('#savejobapply-'+id).addClass('fa-solid');
            }else if(response.status == 'remove') {
                
                $('#savejobapply-'+id).removeClass('fa-solid');
                $('#savejobapply-'+id).addClass('fa-regular');
            }
        })
    }
</script>
@endpush