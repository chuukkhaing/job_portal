<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/logo/ic-logo.png') }}" alt="IC Logo" width="100">
        </div>
        
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Location Menu -->
    <li class="nav-item {{ Request::is('admin/state*') ? 'active' : '' }} {{ Request::is('admin/city*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#location"
            aria-expanded="true" aria-controls="location">
            <i class="fas fa-map-marked-alt"></i>
            <span>Locations</span>
        </a>
        <div id="location" class="collapse {{ Request::is('admin/state*') ? 'show' : '' }} {{ Request::is('admin/city*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('admin/state*') ? 'active' : '' }}" href="{{ route('state.index') }}">States & Regions</a>
                <a class="collapse-item {{ Request::is('admin/city*') ? 'active' : '' }}" href="{{ route('city.index') }}">Cities</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Employer Attribute Menu -->
    <li class="nav-item {{ Request::is('admin/industry*') ? 'active' : '' }} {{ Request::is('admin/ownership-type*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#employerAttribute"
            aria-expanded="true" aria-controls="employerAttribute">
            <i class="fas fa-network-wired"></i>
            <span>Employer Attributes</span>
        </a>
        <div id="employerAttribute" class="collapse {{ Request::is('admin/industry*') ? 'show' : '' }} {{ Request::is('admin/ownership-type*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('admin/industry*') ? 'active' : '' }}" href="{{ route('industry.index') }}">Industries</a>
                <a class="collapse-item {{ Request::is('admin/ownership-type*') ? 'active' : '' }}" href="{{ route('ownership-type.index') }}">Ownership Type</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Seeker Attribute Menu -->
    <li class="nav-item {{ Request::is('admin/skill*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#seekerAttribute"
            aria-expanded="true" aria-controls="seekerAttribute">
            <i class="fa-solid fa-user-pen"></i>
            <span>Seeker Attributes</span>
        </a>
        <div id="seekerAttribute" class="collapse {{ Request::is('admin/skill*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('admin/skill*') ? 'active' : '' }}" href="{{ route('skill.index') }}">Skills</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Job Attribute Menu -->
    <li class="nav-item {{ Request::is('admin/main-functional-area*') ? 'active' : '' }} {{ Request::is('admin/sub-functional-area*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#jobAttribute"
            aria-expanded="true" aria-controls="jobAttribute">
            <i class="fas fa-arrows-up-down-left-right"></i>
            <span>Functional Areas</span>
        </a>
        <div id="jobAttribute" class="collapse {{ Request::is('admin/main-functional-area*') ? 'show' : '' }} {{ Request::is('admin/sub-functional-area*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('admin/main-functional-area*') ? 'active' : '' }}" href="{{ route('main-functional-area.index') }}">Main Functional Areas</a>
                <a class="collapse-item {{ Request::is('admin/sub-functional-area*') ? 'active' : '' }}" href="{{ route('sub-functional-area.index') }}">Sub Functional Areas</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Package Menu -->
    <li class="nav-item {{ Request::is('admin/package-item*') ? 'active' : '' }} {{ Request::is('admin/package-type*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#package"
            aria-expanded="true" aria-controls="package">
            <i class="fas fa-cubes"></i>
            <span>Packages</span>
        </a>
        <div id="package" class="collapse {{ Request::is('admin/package-item*') ? 'show' : '' }} {{ Request::is('admin/package*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('admin/package-item*') ? 'active' : '' }}" href="{{ route('package-item.index') }}">Package Items</a>
                <a class="collapse-item {{ Request::is('admin/package-type*') ? 'active' : '' }}" href="{{ route('package-type.index') }}">Package Type</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Employer Menu -->
    <li class="nav-item {{ Request::is('admin/employers*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('employers.index') }}">
            <i class="fas fa-user-tie"></i>
            <span>Employers</span>
        </a>
    </li>

    <!-- Nav Item - Slider Menu -->
    <li class="nav-item {{ Request::is('admin/slider*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('slider.index') }}">
            <i class="fas fa-images"></i>
            <span>Sliders</span>
        </a>
    </li>
    
    <!-- Nav Item - Feedback Menu -->
    <li class="nav-item {{ Request::is('admin/feedback*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ route('feedback.index') }}">
            <i class="fas fa-comments"></i>
            <span>Seeker/Employer Contact</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>