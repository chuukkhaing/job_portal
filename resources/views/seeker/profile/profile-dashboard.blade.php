<div class="container px-5" id="edit-profile-header">
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
<div class="container my-2" id="edit-profile-body">
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
<div class="container my-2" id="edit-profile-body">
    <div class="row px-0 py-3" id="edit-profile-text">
        <div class="col-12 col-md-9">
        <div>Please upload your CV as an attachment or update your profile to a minimum of 80% completion for us to consider your qualifications. </div>
        </div>
        <div class="col-md-3">
        <a href="#edit-profile-tab" class="btn vertical-tab profile-save-btn">Update Infinity Careers Profile</a>
        </div>
    </div>
    <div class="row p-0">
        <div class="col-12 col-md-9">
            <div class="px-5 m-0 pb-0 pt-5">
                <h5 style="color: #0355D0">Recommended Jobs</h5>
            </div>
            <div class="px-5 m-0 pb-0 ex3">
                @foreach($jobPosts as $jobPost)
                <div class="m-0 mb-2 pb-0 seeker-job-list border rounded">
                    <div class="row">
                        <div class="col-2">
                            @if($jobPost->Employer->logo)
                            <img src="{{ asset('storage/employer_logo/'.$jobPost->Employer->logo) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                            @else 
                            <img src="{{ asset('img/profile.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                            @endif
                        </div>
                        <div class="col-8">
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
                            <p style="color: #181722">Negotiate</p>
                            @endif
                            @if($jobPost->salary_status != 'Hide' && $jobPost->salary_status != 'Negotiable')
                            @if($jobPost->salary_range)
                            <p style="color: #181722">{{ $jobPost->salary_range }} {{ $jobPost->currency }}</p>
                            @endif
                            @endif
                        </div>
                        <div class="col-2 d-flex align-items-end flex-column bd-highlight mb-3">
                            <div class="text-end px-3 p-2 bd-highlight job-post-fav"><i class="fa-regular fa-heart"></i></div>
                            <div class="mt-auto p-2 bd-highlight">
                            <span>{{ $jobPost->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
@push('scripts')
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