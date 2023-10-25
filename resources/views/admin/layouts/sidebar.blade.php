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
    @canany(['role-list','user-list'])  
    <!-- Nav Item - Manage Admin User Menu -->
    <li class="nav-item {{ Request::is('admin/roles*') ? 'active' : '' }} {{ Request::is('admin/users*') ? 'active' : '' }} {{ Request::is('admin/job-posts*') ? 'active' : '' }} {{ Request::is('admin/state*') ? 'active' : '' }} {{ Request::is('admin/city*') ? 'active' : '' }} {{ Request::is('admin/package-item*') ? 'active' : '' }} {{ Request::is('admin/package-type*') ? 'active' : '' }} {{ Request::is('admin/point-package*') ? 'active' : '' }} {{ Request::is('admin/slider*') ? 'active' : '' }} {{ Request::is('admin/feedback*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#user_manage"
            aria-expanded="true" aria-controls="user_manage">
            <i class="fa-solid fa-user-lock"></i>
            <span>Admin</span>
        </a>
        <div id="user_manage" class="collapse {{ Request::is('admin/roles*') ? 'show' : '' }} {{ Request::is('admin/users*') ? 'show' : '' }} {{ Request::is('admin/job-posts*') ? 'show' : '' }} {{ Request::is('admin/state*') ? 'show' : '' }} {{ Request::is('admin/city*') ? 'show' : '' }} {{ Request::is('admin/package-item*') ? 'show' : '' }} {{ Request::is('admin/package-type*') ? 'show' : '' }} {{ Request::is('admin/point-package*') ? 'show' : '' }} {{ Request::is('admin/slider*') ? 'show' : '' }} {{ Request::is('admin/feedback*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('role-list')
                <a class="collapse-item {{ Request::is('admin/roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">Roles</a>
                @endcan
                @can('user-list')
                <a class="collapse-item {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a>
                @endcan
                @can('job-post-list')
                <a class="collapse-item {{ Request::is('admin/job-posts*') ? 'active' : '' }}" href="{{ route('job-posts.index') }}">Job Posts</a>
                @endcan
                @can('state-list')
                <a class="collapse-item {{ Request::is('admin/state*') ? 'active' : '' }}" href="{{ route('state.index') }}">States & Regions</a>
                @endcan
                @can('township-list')
                <a class="collapse-item {{ Request::is('admin/city*') ? 'active' : '' }}" href="{{ route('city.index') }}">Cities & Townships</a>
                @endcan
                @can('package-item-list')
                <a class="collapse-item {{ Request::is('admin/package-item*') ? 'active' : '' }}" href="{{ route('package-item.index') }}">Package Items</a>
                @endcan
                @can('package-type-list')
                <a class="collapse-item {{ Request::is('admin/package-type*') ? 'active' : '' }}" href="{{ route('package-type.index') }}">Package Type</a>
                @endcan
                @can('point-package-list')
                <a class="collapse-item {{ Request::is('admin/point-package*') ? 'active' : '' }}" href="{{ route('point-package.index') }}">Point Package</a>
                @endcan
                @can('slider-list')
                <a class="collapse-item {{ Request::is('admin/slider*') ? 'active' : '' }}" href="{{ route('slider.index') }}">Sliders</a>
                @endcan
                @can('seeker-employer-contact-list')
                <a class="collapse-item {{ Request::is('admin/feedback*') ? 'active' : '' }}" href="{{ route('feedback.index') }}">Seeker/Employer Contact</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan
    
    <!-- Nav Item - Employer Attribute Menu -->
    @canany(['industry-list','ownership-type-list'])
    <li class="nav-item {{ Request::is('admin/industry*') ? 'active' : '' }} {{ Request::is('admin/ownership-type*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#employerAttribute"
            aria-expanded="true" aria-controls="employerAttribute">
            <i class="fas fa-network-wired"></i>
            <span>Employer Attributes</span>
        </a>
        <div id="employerAttribute" class="collapse {{ Request::is('admin/industry*') ? 'show' : '' }} {{ Request::is('admin/ownership-type*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('industry-list')
                <a class="collapse-item {{ Request::is('admin/industry*') ? 'active' : '' }}" href="{{ route('industry.index') }}">Industries</a>
                @endcan 
                @can('ownership-type-list')
                <a class="collapse-item {{ Request::is('admin/ownership-type*') ? 'active' : '' }}" href="{{ route('ownership-type.index') }}">Ownership Type</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan
    
    <!-- Nav Item - Job Attribute Menu -->
    @canany(['main-functional-area-list','sub-functional-area-list'])
    <li class="nav-item {{ Request::is('admin/main-functional-area*') ? 'active' : '' }} {{ Request::is('admin/sub-functional-area*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#jobAttribute"
            aria-expanded="true" aria-controls="jobAttribute">
            <i class="fas fa-arrows-up-down-left-right"></i>
            <span>Functional Areas</span>
        </a>
        <div id="jobAttribute" class="collapse {{ Request::is('admin/main-functional-area*') ? 'show' : '' }} {{ Request::is('admin/sub-functional-area*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('main-functional-area-list')
                <a class="collapse-item {{ Request::is('admin/main-functional-area*') ? 'active' : '' }}" href="{{ route('main-functional-area.index') }}">Main Functional Areas</a>
                @endcan
                @can('sub-functional-area-list')
                <a class="collapse-item {{ Request::is('admin/sub-functional-area*') ? 'active' : '' }}" href="{{ route('sub-functional-area.index') }}">Sub Functional Areas</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan

    <!-- Nav Item - Employer Menu -->
    @canany(['employer-list', 'employer-info-list'])
    <li class="nav-item {{ Request::is('admin/employers*') ? 'active' : '' }} {{ Request::is('admin/employer-info*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#employers"
            aria-expanded="true" aria-controls="employers">
            <i class="fas fa-user-tie"></i>
            <span>Employers</span>
        </a>
        <div id="employers" class="collapse {{ Request::is('admin/employers*') ? 'show' : '' }} {{ Request::is('admin/employer-info*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('employer-list')
                <a class="collapse-item {{ Request::is('admin/employers*') ? 'active' : '' }}" href="{{ route('employers.index') }}">Employer Account</a>
                @endcan
                @can('employer-info-list')
                <a class="collapse-item {{ Request::is('admin/employer-info*') ? 'active' : '' }}" href="{{ route('employer-info.index') }}">Employer Information</a>
                @endcan
            </div>
        </div>
    </li>
    
    @endcan
    <!-- Nav Item - Seeker Menu -->
    @canany(['seeker-list'])
    <li class="nav-item {{ Request::is('admin/seeker*') ? 'active' : '' }} {{ Request::is('admin/skill*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#seekers"
            aria-expanded="true" aria-controls="seekers">
            <i class="fa-solid fa-user-pen"></i>
            <span>Seekers</span>
        </a>
        <div id="seekers" class="collapse {{ Request::is('admin/seeker*') ? 'show' : '' }} {{ Request::is('admin/skill*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('seeker-list')
                <a class="collapse-item {{ Request::is('admin/seeker*') ? 'active' : '' }}" href="{{ route('seeker.index') }}">Seekers</a>
                @endcan
                @can('skill-list')
                <a class="collapse-item {{ Request::is('admin/skill*') ? 'active' : '' }}" href="{{ route('skill.index') }}">Skills</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>