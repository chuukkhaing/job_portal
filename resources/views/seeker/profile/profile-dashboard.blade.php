<div class="container-fluid px-5 edit-profile-header-border" id="edit-profile-header">
    <div class="row">
        <div class="col-12">
            <div class="row pb-5">
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
                        <div class="col-3">
                            <i class="fa-solid fa-phone seeker-icon"></i><a href="tel:+{{ Auth::guard('seeker')->user()->phone }}" class="seeker-info px-2">{{ Auth::guard('seeker')->user()->phone }}</a>
                        </div>
                        <div class="col-4 p-0 m-0">
                            <i class="fa-solid fa-envelope seeker-icon"></i><a href="mailto:{{ Auth::guard('seeker')->user()->email }}" class="seeker-info px-2">{{ Auth::guard('seeker')->user()->email }}</a>
                        </div>
                        <div class="col-5 p-0 m-0">
                            <i class="fa-solid fa-link seeker-icon"></i><span class="seeker-info px-2">Member Since, {{ date('M d, Y', strtotime(Auth::guard('seeker')->user()->register_at)) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-3 align-self-end pb-2 text-end">
                    <div class="d-flex form-check form-switch">
                        <div>
                        <label class="form-check-label seeker-name" for="immediate_available">Immediate Available</label><br>
                        </div>
                        <input class="form-check-input" type="checkbox" @if(Auth::guard('seeker')->user()->is_immediate_available == 1) checked @endif role="switch" id="immediate_available">
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid my-2" id="edit-profile-body">
    <div class="col-12 row">
        <div class="col p-5">
            <div class="border-right-profile">
            <p class="profile-count">Profile Views</p>
            <span class="profile-number">0</span>
            </div>
        </div>
        <div class="col py-5">
            <div class="border-right-profile">
            <p class="profile-count">My CV Lists</p>
            <span class="profile-number">0</span>
            </div>
        </div>
        <div class="col p-5">
            <div class="border-right-profile">
            <p class="profile-count">My Following</p>
            <span class="profile-number">0</span>
            </div>
        </div>
        <div class="col py-5">
            <div class="border-right-profile">
            <p class="profile-count">Message</p>
            <span class="profile-number">0</span>
            </div>
        </div>
        <div class="col py-5">
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
            <div class="p-5 m-0">
                <h5 style="color: #0355D0">Recommended Jobs</h5>
            </div>
            <div class="px-5 m-0 pb-0 ex3">
                @if($jobPosts->count() >0)
                @foreach($jobPosts as $jobPost)
                <a href="{{ route('jobpost-detail', $jobPost->slug) }}">
                    <div class="m-0 mb-2 pb-0 seeker-job-list rounded">
                        <div class="row">
                            <div class="col-2">
                                @if($jobPost->Employer->logo)
                                <img src="{{ asset('storage/employer_logo/'.$jobPost->Employer->logo) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                @else 
                                <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                                @endif
                            </div>
                            <div class="col-7">
                                <span class="jobpost-attr">{{ $jobPost->Employer->name }}</span>
                                <h5>{{ $jobPost->job_title }}</h5>
                                @if($jobPost->state_id)
                                <span class="jobpost-attr">{{ $jobPost->State->name }} ,</span>
                                @endif
                                @if($jobPost->township_id)
                                <span class="jobpost-attr">{{ $jobPost->Township->name }}</span>
                                @endif
                                @if($jobPost->country == 'Other') 
                                <span class="jobpost-attr">Other Country</span>
                                @endif
                                @if($jobPost->salary_status == 'Negotiable')
                                <p class="p-0 m-0" style="color: #181722">Negotiate</p>
                                @endif
                                @if($jobPost->salary_status != 'Hide' && $jobPost->salary_status != 'Negotiable')
                                @if($jobPost->salary_range)
                                <p class="p-0 m-0" style="color: #181722">{{ $jobPost->salary_range }} {{ $jobPost->currency }}</p>
                                @endif
                                @endif
                            </div>
                            <div class="col-3 d-flex align-items-end flex-column bd-highlight mb-3">
                                <div class="text-end px-3 p-2 bd-highlight job-post-fav"><i class="fa-regular fa-heart"></i></div>
                                <div class="mt-auto p-1 bd-highlight">
                                <span>{{ $jobPost->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
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

<div class="container-fluid my-2 bg-white" id="edit-profile-body">
    <div class="row m-auto py-5 justify-content-center">
        <div class="px-5 pb-3 m-0 bg-white">
            <h5 style="color: #0355D0">Leading Employers</h5>
        </div>
        <div id="recipeCarousel" class="carousel slide px-5 py-3 bg-white" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner py-3" role="listbox" data-bs-interval="false">
                <div class="carousel-item active">
                    <div class="col-md-2 bg-white">
                        <div class="card border-0">
                            <div class="card-img">
                                <img src="{{ asset('storage/seeker/profile/employer-image.jpg') }}" class="center-block d-block mx-auto img-fluid">
                            </div>
                            <div class="cart-title text-center py-2">Imagine Solutions</div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item bg-white">
                    <div class="col-md-2">
                        <div class="card border-0">
                            <div class="card-img">
                                <img src="{{ asset('storage/seeker/profile/SMDI.jpg') }}" class="center-block d-block mx-auto img-fluid">
                            </div>
                            <div class="cart-title text-center py-2">Stark Industries</div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item bg-white">
                    <div class="col-md-2">
                        <div class="card border-0">
                            <div class="card-img">
                                <img src="{{ asset('storage/seeker/profile/employer-image.jpg') }}" class="center-block d-block mx-auto img-fluid">
                            </div>
                            <div class="cart-title text-center py-2">Kappa - Kappa Corporation</div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item bg-white">
                    <div class="col-md-2">
                        <div class="card border-0">
                            <div class="card-img">
                                <img src="{{ asset('storage/seeker/profile/SMDI.jpg') }}" class="center-block d-block mx-auto img-fluid">
                            </div>
                            <div class="cart-title text-center py-2">Tech - Technologies Co.</div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item bg-white">
                    <div class="col-md-2">
                        <div class="card border-0">
                            <div class="card-img">
                                <img src="{{ asset('storage/seeker/profile/employer-image.jpg') }}" class="center-block d-block mx-auto img-fluid">
                            </div>
                            <div class="cart-title text-center py-2">Best Buy</div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item bg-white">
                    <div class="col-md-2">
                        <div class="card border-0">
                            <div class="card-img">
                                <img src="{{ asset('storage/seeker/profile/SMDI.jpg') }}" class="center-block d-block mx-auto img-fluid">
                            </div>
                            <div class="cart-title text-center py-2">Publix Super Markets</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <a class="carousel-control-prev w-aut" href="#recipeCarousel" role="button" data-bs-slide="prev"  style="width: 3% !important">
                <svg width="2em" height="2em" viewBox="0 0 16 16" class="text-dark mt-3" fill="#0355D0" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path>
                </svg>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next w-aut" href="#recipeCarousel" role="button" data-bs-slide="next" style="width: 3% !important">
                <svg width="2em" height="2em" viewBox="0 0 16 16" class="text-dark mt-3" fill="#0355D0" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
                </svg>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    </div>		
</div>

@push('css')
    <link href="{{ asset('frontend/css/custom-multiple-carousel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('frontend/js/custom-multiple-carousel.js') }}"></script>

<script>
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
                    alert(response.msg)
                }
            }
        })
    })
</script>
@endpush