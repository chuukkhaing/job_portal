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
            
            <div class="row job-content mb-3 m-1">
                <!-- Job List Start -->
                
                <div class="col-lg-10 col-md-10 py-4 d-flex">
                    <a href="{{ route('jobpost-detail', $jobApplyBySeeker->JobPost->slug) }}">
                        <div style="width: 100px">
                            @if($jobApplyBySeeker->Employer->logo)
                            <img src="{{ asset('storage/employer_logo/'.$jobApplyBySeeker->Employer->logo) }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 55px" id="ProfilePreview">
                            @else 
                            <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="img-responsive center-block d-block mx-auto" style="width: 55px" id="ProfilePreview">
                            @endif
                        </div>
                        <div>
                            <div class="job-company">{{ $jobApplyBySeeker->Employer->name }}</div>
                            <div class="job-title">{{ $jobApplyBySeeker->JobPost->job_title }}</div>
                            @if($jobApplyBySeeker->JobPost->country == 'Myanmar' && $jobApplyBySeeker->JobPost->township_id)
                            <div class="job-location">{{ $jobApplyBySeeker->JobPost->Township->name }}</div>
                            @endif
                            <div class="job-salary my-3">@if($jobApplyBySeeker->JobPost->hide_salary == 1) Negotiate @else {{ $jobApplyBySeeker->JobPost->salary_range }} @endif</div>
                            <div class="">
                                <a href="" class="btn job-btn">{{ $jobApplyBySeeker->JobPost->MainFunctionalArea->name }}</a>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4">
                    <div class="row col-12 m-0 p-0">
                        @auth('seeker')
                        <div class="text-end p-0" style="cursor:pointer">
                                <i id="savejobapply-{{ $jobApplyBySeeker->JobPost->id }}" onclick="saveJob({{ $jobApplyBySeeker->JobPost->id }})" class="text-blue @if(Auth::guard('seeker')->user()->SaveJob->where('job_post_id', $jobApplyBySeeker->JobPost->id)->count() > 0) fa-solid @else fa-regular @endif fa-heart"></i>
                        </div>
                        @endauth
                        <div class="text-end mt-auto p-1">
                            <span>{{ $jobApplyBySeeker->JobPost->updated_at->diffForHumans() }}</span>
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
                alert(response.msg);
                $('#savejobapply-'+id).removeClass('fa-regular');
                $('#savejobapply-'+id).addClass('fa-solid');
            }else if(response.status == 'remove') {
                alert(response.msg);
                $('#savejobapply-'+id).removeClass('fa-solid');
                $('#savejobapply-'+id).addClass('fa-regular');
            }
        })
    }
</script>
@endpush