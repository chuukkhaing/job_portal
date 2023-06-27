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
                <a href="{{ route('home') }}" class="nav-item nav-link">Find Jobs</a>
                <a href="{{ route('home') }}" class="nav-item nav-link">Job Category</a>
                <a href="{{ route('home') }}" class="nav-item nav-link">Companies</a>
                <a href="{{ route('home') }}" class="nav-item nav-link">Contact Us</a>
                <a class="nav-item nav-link d-none d-lg-block">|</a>
                @auth('seeker')
                <div class="btn-group">
                    <a class="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('img/profile.svg') }}" alt="{{ auth()->guard('seeker')->user()->email }}" class="img-profile rounded-circle">
                    </a>
                    <ul class="dropdown-menu profile-dropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('seeker.profile') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                My Account
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
                @elseauth('web')
                <a href="{{ route('login-form') }}" class="nav-item nav-link">Admin</a>
                @else
                <a href="{{ route('login-form') }}" class="nav-item nav-link {{ Request::is('login-form') ? 'active' : '' }}">Sign In</a>
                <span class="nav-item nav-link"><a href="{{ route('register-form') }}" class="header-btn">Register</a></span>
                @endauth
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->