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
                <span>Package Expire Date :</span>
                <span>Date</span>
                <a onclick="postJobHeader()" class="btn bg-light" style="color: #0355D0; margin: 10px">Post a Job</a>
                
                @auth('employer')
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
                <a href="{{ route('login-form') }}" class="nav-item nav-link {{ Request::is('login-form') ? 'active' : '' }}">Sign In</a>
                <span class="nav-item nav-link"><a href="{{ route('register-form') }}" class="header-btn">Register</a></span>
                @endauth
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->
@push('scripts')
<script>
    function postJobHeader()
    {
        url = window.origin+'/employer/employer-profile'
        window.location = url;
        localStorage.setItem('target','#employer-job')
    
        var employer_id = localStorage.getItem('target');
        var employer_job = document.querySelector('#employerTab li a[href="'+employer_id+'"]')
        var employer_job_tab = new bootstrap.Tab(employer_job)

        employer_job_tab.show();
    }
</script>
@endpush