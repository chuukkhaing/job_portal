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
            <div class="navbar-nav ms-auto py-0">
                <a href="{{ route('home') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
                <a href="{{ route('home') }}" class="nav-item nav-link">Find Jobs</a>
                <a href="{{ route('home') }}" class="nav-item nav-link">Job Category</a>
                <a href="{{ route('home') }}" class="nav-item nav-link">Companies</a>
                <a href="{{ route('home') }}" class="nav-item nav-link">Contact Us</a>
                <a class="nav-item nav-link d-none d-lg-block">|</a>
                <a href="{{ route('home') }}" class="nav-item nav-link">Sign In</a>
                <span class="nav-item nav-link"><a href="{{ route('register') }}" class="header-btn">Register</a></span>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->