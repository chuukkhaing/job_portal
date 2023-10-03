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
                <a href="{{ route('home') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ route('find-jobs') }}" class="nav-item nav-link {{ Request::is('find-jobs') ? 'active' : '' }} {{ Request::is('search-job') ? 'active' : '' }} {{ Request::is('industry-job*') ? 'active' : '' }} {{ Request::is('job-post*') ? 'active' : '' }}">Find Jobs</a>
                <a href="{{ route('job-categories') }}" class="nav-item nav-link {{ Request::is('job-categories') ? 'active' : '' }}">Job Category</a>
                <a href="{{ route('companies') }}" class="nav-item nav-link {{ Request::is('company*') ? 'active' : '' }} {{ Request::is('find-company*') ? 'active' : '' }}">Employers</a>
                <a href="{{ route('contact-us') }}" class="nav-item nav-link {{ Request::is('contact-us') ? 'active' : '' }}">Contact Us</a>
                <a class="nav-item nav-link d-none d-lg-block">|</a>
                @auth('seeker')
                <div class="btn-group">
                    @if(Auth::guard('seeker')->user()->image)
                    <a class="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="{{ auth()->guard('seeker')->user()->email }}" class="img-profile rounded-circle">
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
                            <a class="dropdown-item" href="{{ route('seeker.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-power-off fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('seeker.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                @elseauth('employer')
                <div class="btn-group">
                    @if(Auth::guard('employer')->user()->logo)
                    <a class="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('/storage/employer_logo/'.Auth::guard('employer')->user()->logo) }}" alt="{{ auth()->guard('employer')->user()->email }}" class="img-profile rounded-circle">
                    </a>
                    @else
                    <a class="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('img/profile.svg') }}" alt="{{ auth()->guard('employer')->user()->email }}" class="img-profile rounded-circle">
                    </a>
                    @endif
                    <ul class="dropdown-menu profile-dropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('employer-profile.index') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employer.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-power-off fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('employer.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                @elseauth('web')
                <a href="{{ route('dashboard') }}" class="nav-item nav-link">Admin</a>
                @else
                <a href="{{ route('login-form') }}" class="nav-item nav-link {{ Request::is('login-form') ? 'active' : '' }}">Seeker <br> Sign In</a>
                <a href="{{ route('employer-login-form') }}" class="nav-item nav-link {{ Request::is('employer/login-form') ? 'active' : '' }}">Employer <br> Sign In</a>
                <span class="nav-item nav-link"><a href="{{ route('register-form') }}" class="header-btn">Sign Up</a></span>
                @endauth
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->