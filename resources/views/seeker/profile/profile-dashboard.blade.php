<div class="container-fluid px-5 edit-profile-header-border" id="edit-profile-header">
    <div class="row">
        <div class="col-12">
            <div class="row pb-3">
                <div class="col-1">
                    @if(Auth::guard('seeker')->user()->image)
                    <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                    @else
                    <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                    @endif
                </div>
                <div class="col-8 p-0 m-0 align-self-center">
                    <div class="col-12 m-0">
                        <div class="seeker-name">{{ Auth::guard('seeker')->user()->first_name }} {{ Auth::guard('seeker')->user()->last_name }}</div>
                    </div>
                    <div class="col-12 p-0 m-0 row">
                        @if(Auth::guard('seeker')->user()->phone)
                        <div class="col-3">
                            <i class="fa-solid fa-phone seeker-icon"></i><a href="tel:+{{ Auth::guard('seeker')->user()->phone }}" class="seeker-info px-2">{{ Auth::guard('seeker')->user()->phone }}</a>
                        </div>
                        @endif
                        <div class="col-5 p-0 m-0">
                            <i class="fa-solid fa-envelope seeker-icon"></i><a href="mailto:{{ Auth::guard('seeker')->user()->email }}" class="seeker-info px-2">{{ Auth::guard('seeker')->user()->email }}</a>
                        </div>
                        <div class="col-4 p-0 m-0">
                            <i class="fa-solid fa-link seeker-icon"></i><span class="seeker-info px-2">Member Since, {{ date('M d, Y', strtotime(Auth::guard('seeker')->user()->register_at)) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-3 pb-2 text-end">
                    <div class="d-flex form-check form-switch mt-3">
                        <div class="mt-3">
                        <label class="form-check-label seeker-name" for="immediate_available">Immediate Available</label><br>
                        </div>
                        <input class="form-check-input mt-4" type="checkbox" @if(Auth::guard('seeker')->user()->is_immediate_available == 1) checked @endif role="switch" id="immediate_available">
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid my-2" id="edit-profile-body">
    <div class="col-12 row">
        <div class="align-self-center col px-5 py-3">
            <div class="border-right-profile">
            <p class="profile-count">Profile Views</p>
            <span class="profile-number">0</span>
            </div>
        </div>
        <div class="align-self-center col py-3">
            <div class="border-right-profile">
            <p class="profile-count">My CV Lists</p>
            <span class="profile-number">{{ Auth::guard('seeker')->user()->SeekerAttach->count() }}</span>
            </div>
        </div>
        <div class="align-self-center col px-5 py-3">
            <div class="border-right-profile">
            <p class="profile-count">My Following</p>
            <span class="profile-number">0</span>
            </div>
        </div>
        {{--<div class="col py-3">
            <div class="border-right-profile">
            <p class="profile-count">Message</p>
            <span class="profile-number">0</span>
            </div>
        </div>--}}
        <div class="align-self-center col py-3">
            <div class="text-center">
                <div class="pie animate" style="--p:{{ Auth::guard('seeker')->user()->percentage }};"> {{ Auth::guard('seeker')->user()->percentage }}%</div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid my-2" id="edit-profile-body">
    @if(Auth::guard('seeker')->user()->percentage < 80)
    <div class="row px-0 py-3" id="edit-profile-text">
        <div class="col-12 col-md-9">
        <div>Please upload your CV as an attachment or update your profile to a minimum of 80% completion for us to consider your qualifications. </div>
        </div>
        <div class="col-md-3">
        <a href="#edit-profile-tab" class="btn vertical-tab profile-save-btn">Update Infinity Careers Profile</a>
        </div>
    </div>
    @endif
    <div class="row p-0">
        <div class="col-12 col-md-9">
            <div class="px-5 py-3 m-0">
                <h5 style="color: #0355D0">Recommended Jobs</h5>
            </div>
            <div class="px-5 m-0 pb-0 ex3">
                @if($jobPosts->count() >0)
                @foreach($jobPosts as $jobPost)
                <a href="{{ route('jobpost-detail', $jobPost->slug) }}">
                    <div class="row job-content mb-3">
                        <!-- Job List Start -->
                        
                        <div class="col-lg-10 col-md-10 py-4 d-flex">
                            <div style="width: 100px" class="align-self-center">
                                @if($jobPost->job_post_type == 'feature' || $jobPost->job_post_type == 'trending')
                                @if($jobPost->Employer->logo)
                                <img src="{{ asset('storage/employer_logo/'.$jobPost->Employer->logo) }}" alt="Profile Image" class="mb-2 img-responsive center-block d-block mx-auto" style="width: 75px" id="ProfilePreview">
                                @else 
                                <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="mb-2 img-responsive center-block d-block mx-auto" style="width: 75px" id="ProfilePreview">
                                @endif
                                <div class="text-center">
                                @if($jobPost->job_post_type == 'feature')<span class="badge badge-pill job-post-badge" style="background: #0355D0"> Featured @elseif($jobPost->job_post_type == 'trending') <span class="badge badge-pill job-post-badge" style="background: #FB5404"> Trending @endif</span>
                                </div>
                                @endif
                            </div>
                            <div class="align-self-center">
                                <div class="mt-1 job-company">{{ $jobPost->Employer->name }}</div>
                                <div class="mt-1">{{ $jobPost->job_title }}</div>
                                @if($jobPost->township_id)
                                <div class="mt-1 job-location">{{ $jobPost->Township->name }}</div>
                                @endif
                                @if($jobPost->job_post_type == 'trending')
                                <p class="job-post-preview">{!! \Illuminate\Support\Str::limit(strip_tags($jobPost->job_requirement), $limit = 200, $end = '...') !!}</p>
                                @endif
                                <div class="mt-1 ">
                                    <a href="{{ route('search-main-function', $jobPost->main_functional_area_id) }}" class="mt-1 job-post-area"># {{ $jobPost->MainFunctionalArea->name }}</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Job List End -->

                        <!-- Wishlist Start -->
                        <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4">
                            <div class="row col-12 m-0 p-0">
                                @auth('seeker')
                                <div class="text-end p-0" style="cursor: pointer">
                                    <i id="savejobdashboard-{{ $jobPost->id }}" onclick="saveJobDashboard({{ $jobPost->id }})" class="text-blue @if(Auth::guard('seeker')->user()->SaveJob->where('job_post_id', $jobPost->id)->count() > 0) fa-solid @else fa-regular @endif fa-heart"></i>
                                </div>
                                @endauth
                                <div class="text-end mt-auto p-1">
                                    <span>{{ $jobPost->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Wishlist End -->
                    </div>
                </a>
                @endforeach
                @endif
            </div>
        </div>
        <div class="col-md-3 p-3 profile-status">
            <h5 class="text-white">Your Status</h5>
            @foreach(Auth::guard('seeker')->user()->SeekerPercentage as $seekerpercentage)
            @if($seekerpercentage->title == 'Personal Information')
            <div class="py-2">
                <p class="text-white">Personal Information</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $seekerpercentage->percentage }}" aria-valuemin="0" aria-valuemax="100" style="max-width: {{ $seekerpercentage->percentage }}%">
                    </div>
                </div>
                <span class="title text-white">{{ $seekerpercentage->percentage }}%</span>
            </div>
            @elseif($seekerpercentage->title == 'Career of Choice')
            <div class="py-2">
                <p class="text-white">Career of Choice</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $seekerpercentage->percentage }}" aria-valuemin="0" aria-valuemax="100" style="max-width: {{ $seekerpercentage->percentage }}%">
                    </div>
                </div>
                <span class="title text-white">{{ $seekerpercentage->percentage }}%</span>
            </div>
            @elseif($seekerpercentage->title == 'Resume Attachment')
            <div class="py-2">
                <p class="text-white">Resume Attachment</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $seekerpercentage->percentage }}" aria-valuemin="0" aria-valuemax="100" style="max-width: {{ $seekerpercentage->percentage }}%">
                    </div>
                </div>
                <span class="title text-white">{{ $seekerpercentage->percentage }}%</span>
            </div>
            @elseif($seekerpercentage->title == 'Education')
            <div class="py-2">
                <p class="text-white">Education</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $seekerpercentage->percentage }}" aria-valuemin="0" aria-valuemax="100" style="max-width: {{ $seekerpercentage->percentage }}%">
                    </div>
                </div>
                <span class="title text-white">{{ $seekerpercentage->percentage }}%</span>
            </div>
            @elseif($seekerpercentage->title == 'Career History')
            <div class="py-2">
                <p class="text-white">Career History</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $seekerpercentage->percentage }}" aria-valuemin="0" aria-valuemax="100" style="max-width: {{ $seekerpercentage->percentage }}%">
                    </div>
                </div>
                <span class="title text-white">{{ $seekerpercentage->percentage }}%</span>
            </div>
            @elseif($seekerpercentage->title == 'Skills')
            <div class="py-2">
                <p class="text-white">Skills</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $seekerpercentage->percentage }}" aria-valuemin="0" aria-valuemax="100" style="max-width: {{ $seekerpercentage->percentage }}%">
                    </div>
                </div>
                <span class="title text-white">{{ $seekerpercentage->percentage }}%</span>
            </div>
            @elseif($seekerpercentage->title == 'Language')
            <div class="py-2">
                <p class="text-white">Language</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $seekerpercentage->percentage }}" aria-valuemin="0" aria-valuemax="100" style="max-width: {{ $seekerpercentage->percentage }}%">
                    </div>
                </div>
                <span class="title text-white">{{ $seekerpercentage->percentage }}%</span>
            </div>
            @elseif($seekerpercentage->title == 'Reference')
            <div class="py-2">
                <p class="text-white">Reference</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $seekerpercentage->percentage }}" aria-valuemin="0" aria-valuemax="100" style="max-width: {{ $seekerpercentage->percentage }}%">
                    </div>
                </div>
                <span class="title text-white">{{ $seekerpercentage->percentage }}%</span>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
@if($employers->count() > 0)
<div class="container-fluid my-2 bg-white" id="edit-profile-body">
    <div class="row m-auto py-3 justify-content-center">
        <div class="px-3 pb-3 m-0 bg-white">
            <h5 style="color: #0355D0">Leading Employers</h5>
        </div>
        <div class="owl-slider py-3">
            <div class="row col-12 m-0">
                <div id="multiple-carousel" class="owl-carousel">
                    @foreach($employers as $employer)
                    <a href="{{ route('company-detail',$employer->slug) }}">
                        <div class="item d-flex justify-content-center">
                            <div class="row px-3 align-items-center">
                                <div class="employer-img py-2">
                                    @if($employer->logo)
                                    <img src="{{ asset('/storage/employer_logo'.'/'.$employer->logo) }}" class="center-block d-block mx-auto w-25" alt="{{ $employer->name }}">
                                    @else
                                    <img src="{{ asset('/img/logo/ICLogo.png') }}" class="center-block d-block mx-auto w-25" alt="{{ $employer->name }}">
                                    @endif
                                    
                                </div>
                                <div class="employer-title text-dark text-center py-2">{{ $employer->name }}</div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>		
</div>
@endif
@push('scripts')
<script>
    $('#multiple-carousel').owlCarousel({
        margin: 20,
        dots:false,
        loop: true,
        autoplay: false,
        autoplayTimeout:700,
        slideSpeed : 200,
        nav : true,
        responsiveClass:true,
        autoHeight: true,
        smartSpeed: 800,
        responsive: {
            0: {
            items: 1
            },

            600: {
            items: 2
            },

            1024: {
            items: 4
            },

            1366: {
            items: 6
            }
        }
    });

    $('.vertical-tab').on('click', function(e) {
        e.preventDefault();
        var attr = $(this).attr('href');
        $(".seeker-single-tab").removeClass('active');
        $(attr).addClass('active');
        $(attr).attr('aria-selected',true);
        $('.tab-pane').removeClass('show active');
        $('#edit-profile').addClass('show active');
    });
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $("#immediate_available").change(function(){
        var is_immediate_available = {{ Auth::guard("seeker")->user()->is_immediate_available }};
        if($(this).is(":checked") == true) {
            var is_immediate_available = 1
        }else {
            var is_immediate_available = 0
        }
        var seeker_id = {{ Auth::guard("seeker")->user()->id }};
        $.ajax({
            type: 'POST',
            data: {
                'is_immediate_available' : is_immediate_available
            },
            url: 'immediate-available/update/'+seeker_id,
        }).done(function(response){
            if(response.status == 'success') {
                if(response.status == 'success') {
                    // MSalert.principal({
                    //     icon:'success',
                    //     title:'',
                    //     description:response.msg,
                    // })
                }
            }
        })
    })

    function saveJobDashboard(id) {
        $.ajax({
            type: 'GET',
            data: id,
            url: "save-job/"+id,
        }).done(function(response){
            if(response.status == 'create') {
                // MSalert.principal({
                //     icon:'success',
                //     title:'',
                //     description:response.msg,
                // });
                $('#savejobdashboard-'+id).removeClass('fa-regular');
                $('#savejobdashboard-'+id).addClass('fa-solid');
            }else if(response.status == 'remove') {
                // MSalert.principal({
                //     icon:'success',
                //     title:'',
                //     description:response.msg,
                // });
                $('#savejobdashboard-'+id).removeClass('fa-solid');
                $('#savejobdashboard-'+id).addClass('fa-regular');
            }
        })
    }

</script>
@endpush