<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand p-0">
            <img src="{{ asset('frontend/img/logo/white_logo.svg') }}" alt="{{ config('app.name', 'Laravel') }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 d-flex align-items-center">
                <a href="{{ route('home') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">{{ __('message.Home') }}</a>
                <a href="{{ route('find-jobs') }}" class="nav-item nav-link {{ Request::is('find-jobs') ? 'active' : '' }} {{ Request::is('search-job') ? 'active' : '' }} {{ Request::is('industry-job*') ? 'active' : '' }} {{ Request::is('job-post*') ? 'active' : '' }}">{{ __('message.Find Jobs') }}</a>
                <a href="{{ route('job-categories') }}" class="nav-item nav-link {{ Request::is('job-categories') ? 'active' : '' }}">{{ __('message.Job Category') }}</a>
                <a href="{{ route('companies') }}" class="nav-item nav-link {{ Request::is('company*') ? 'active' : '' }} {{ Request::is('find-company*') ? 'active' : '' }}">{{ __('message.Employers') }}</a>
                <a href="{{ route('contact-us') }}" class="nav-item nav-link {{ Request::is('contact-us') ? 'active' : '' }}">{{ __('message.Contact Us') }}</a>
                <a class="nav-item nav-link d-none d-lg-block">|</a>
                @auth('seeker')
                <div class="btn-group">
                    @if(Auth::guard('seeker')->user()->image)
                    <a class="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ getS3File('seeker/profile/'.Auth::guard('seeker')->user()->id ,Auth::guard('seeker')->user()->image) }}" alt="{{ auth()->guard('seeker')->user()->email }}" class="img-profile rounded-circle">
                    </a>
                    @else
                    <a class="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('img/profile.svg') }}" alt="{{ auth()->guard('seeker')->user()->email }}" class="img-profile rounded-circle">
                    </a>
                    @endif
                    <ul class="dropdown-menu profile-dropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('seeker-change-password') }}">
                                <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                Change Password
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" id="seekerLogoutModal">
                                <i class="fas fa-power-off fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                            
                        </li>
                    </ul>
                </div>
                
                @elseauth('web')
                <a href="{{ route('dashboard') }}" class="nav-item nav-link">Admin</a>
                @else
                <a href="{{ route('login-form') }}" class="nav-item nav-link {{ Request::is('login-form') ? 'active' : '' }}">{{ __('message.Sign In') }}</a>
                <span class="nav-item nav-link"><a href="{{ route('register-form') }}" class="header-btn">{{ __('message.Sign Up') }}</a></span>
                <span class="nav-item nav-link"><a href="{{ route('employer-login-form') }}" class="header-btn">{{ __('message.For Employer') }}</a></span>
                
                @endauth
                <a class="nav-item nav-link d-none d-lg-block">|</a>
                    <div class="row">
                        
                        <div class="col-md-4">
                            <div class="btn-group">
                            
                            <a class="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-globe" style="color: #fff"></i>
                            </a>
                            
                            <ul class="dropdown-menu profile-dropdown">
                                <li>
                                    <a href="{{ route('changeLang', ['lang' => 'en']) }}" class="text-decoration-none text-black">
                                    <img src="{{ asset('frontend/img/logo/us.svg') }}" alt="" style="width: 25px; margin: 0 10px">
                                    English
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('changeLang', ['lang' => 'mm']) }}" class="text-decoration-none text-black">
                                    <img src="{{ asset('frontend/img/logo/mm.svg') }}" alt="" style="width: 25px; margin: 0 10px">
                                    Myanmar
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->
@push('scripts')
<script>
    $(document).on('click', '#seekerLogoutModal', function (e) {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        MSalert.principal({
            icon:'info',
            title:'Info',
            description:'Are you sure to leave?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    url: "{{ route('seeker.logout') }}",
                }).done(function(response){
                    if(response.status == 'success') {
                        window.location.href = "{{ route('home') }}";
                    }
                })
            }            
        })
    });
</script>
@endpush