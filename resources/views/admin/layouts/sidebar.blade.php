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
    @canany(['role-list','user-list', 'job-post-list', 'state-list', 'township-list', 'package-item-list', 'package-type-list', 'point-package-list', 'slider-list', 'seeker-employer-contact-list', 'industry-list' ,'ownership-type-list', 'main-functional-area-list', 'sub-functional-area-list', 'skill-list', 'blog-category-list', 'blog-post-list'])  
    <!-- Nav Item - Manage Admin User Menu -->
    <li class="nav-item {{ Request::is('admin/roles*') ? 'active' : '' }} {{ Request::is('admin/users*') ? 'active' : '' }} {{ Request::is('admin/job-posts*') ? 'active' : '' }} {{ Request::is('admin/state*') ? 'active' : '' }} {{ Request::is('admin/city*') ? 'active' : '' }} {{ Request::is('admin/package-item*') ? 'active' : '' }} {{ Request::is('admin/package-type*') ? 'active' : '' }} {{ Request::is('admin/point-package*') ? 'active' : '' }} {{ Request::is('admin/point-topup*') ? 'active' : '' }} {{ Request::is('admin/slider*') ? 'active' : '' }} {{ Request::is('admin/feedback*') ? 'active' : '' }} {{ Request::is('admin/industry*') ? 'active' : '' }} {{ Request::is('admin/ownership-type*') ? 'active' : '' }} {{ Request::is('admin/main-functional-area*') ? 'active' : '' }} {{ Request::is('admin/sub-functional-area*') ? 'active' : '' }} {{ Request::is('admin/skill*') ? 'active' : '' }} {{ Request::is('admin/blog-category*') ? 'active' : '' }} {{ Request::is('admin/blog-post*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#user_manage"
            aria-expanded="true" aria-controls="user_manage">
            <i class="fa-solid fa-user-lock"></i>
            <span>Admin</span>
        </a>
        <div id="user_manage" class="collapse {{ Request::is('admin/roles*') ? 'show' : '' }} {{ Request::is('admin/users*') ? 'show' : '' }} {{ Request::is('admin/job-posts*') ? 'show' : '' }} {{ Request::is('admin/state*') ? 'show' : '' }} {{ Request::is('admin/city*') ? 'show' : '' }} {{ Request::is('admin/package-item*') ? 'show' : '' }} {{ Request::is('admin/package-type*') ? 'show' : '' }} {{ Request::is('admin/point-package*') ? 'show' : '' }} {{ Request::is('admin/point-topup*') ? 'show' : '' }} {{ Request::is('admin/slider*') ? 'show' : '' }} {{ Request::is('admin/feedback*') ? 'show' : '' }} {{ Request::is('admin/industry*') ? 'show' : '' }} {{ Request::is('admin/ownership-type*') ? 'show' : '' }} {{ Request::is('admin/main-functional-area*') ? 'show' : '' }} {{ Request::is('admin/sub-functional-area*') ? 'show' : '' }} {{ Request::is('admin/skill*') ? 'show' : '' }} {{ Request::is('admin/blog-category*') ? 'show' : '' }} {{ Request::is('admin/blog-post*') ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('role-list')
                <a class="collapse-item {{ Request::is('admin/roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">Roles</a>
                @endcan
                @can('user-list')
                <a class="collapse-item {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a>
                @endcan

                @canany(['role-list', 'user-list'])
                <hr style="margin: 0.5rem 0">
                @endcan

                @can('job-post-list')
                <a class="collapse-item {{ Request::is('admin/job-posts*') ? 'active' : '' }}" href="{{ route('job-posts.index') }}">Job Posts</a>
                <hr style="margin: 0.5rem 0">
                @endcan

                @can('state-list')
                <a class="collapse-item {{ Request::is('admin/state*') ? 'active' : '' }}" href="{{ route('state.index') }}">States & Regions</a>
                @endcan
                @can('township-list')
                <a class="collapse-item {{ Request::is('admin/city*') ? 'active' : '' }}" href="{{ route('city.index') }}">Cities & Townships</a>
                @endcan

                @canany(['state-list', 'township-list'])
                <hr style="margin: 0.5rem 0">
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
                @can('point-topup-list')
                <a class="collapse-item {{ Request::is('admin/point-topup*') ? 'active' : '' }}" href="{{ route('point-topup.index') }}">Point Topup</a>
                @endcan

                @canany(['package-item-list', 'package-type-list', 'point-package-list', 'point-topup-list'])
                <hr style="margin: 0.5rem 0">
                @endcan

                @can('industry-list')
                <a class="collapse-item {{ Request::is('admin/industry*') ? 'active' : '' }}" href="{{ route('industry.index') }}">Industries</a>
                @endcan 
                @can('ownership-type-list')
                <a class="collapse-item {{ Request::is('admin/ownership-type*') ? 'active' : '' }}" href="{{ route('ownership-type.index') }}">Ownership Type</a>
                @endcan
                @can('main-functional-area-list')
                <a class="collapse-item {{ Request::is('admin/main-functional-area*') ? 'active' : '' }}" href="{{ route('main-functional-area.index') }}">Main Functional Areas</a>
                @endcan
                @can('sub-functional-area-list')
                <a class="collapse-item {{ Request::is('admin/sub-functional-area*') ? 'active' : '' }}" href="{{ route('sub-functional-area.index') }}">Sub Functional Areas</a>
                @endcan
                @can('skill-list')
                <a class="collapse-item {{ Request::is('admin/skill*') ? 'active' : '' }}" href="{{ route('skill.index') }}">Skills</a>
                @endcan

                @canany(['industry-list', 'ownership-type-list', 'main-functional-area-list', 'sub-functional-area-list', 'skill-list'])
                <hr style="margin: 0.5rem 0">
                @endcan

                @can('slider-list')
                <a class="collapse-item {{ Request::is('admin/slider*') ? 'active' : '' }}" href="{{ route('slider.index') }}">Sliders</a>
                @endcan
                @can('seeker-employer-contact-list')
                <a class="collapse-item {{ Request::is('admin/feedback*') ? 'active' : '' }}" href="{{ route('feedback.index') }}">Seeker/Employer Contact</a>
                @endcan

                @canany(['slider-list', 'seeker-employer-contact-list'])
                <hr style="margin: 0.5rem 0">
                @endcan
                @can('blog-category-list')
                <a class="collapse-item {{ Request::is('admin/blog-category*') ? 'active' : '' }}" href="{{ route('blog-category.index') }}">Blog Categories</a>
                @endcan
                @can('blog-post-list')
                <a class="collapse-item {{ Request::is('admin/blog-post*') ? 'active' : '' }}" href="{{ route('blog-post.index') }}">Blog Posts</a>
                @endcan

                @canany('seo-list')
                <hr style="margin: 0.5rem 0">
                <a class="collapse-item {{ Request::is('admin/seo*') ? 'active' : '' }}" href="{{ route('seo.index') }}">Page SEO</a>
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
    <li class="nav-item {{ Request::is('admin/seeker*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#seekers"
            aria-expanded="true" aria-controls="seekers">
            <i class="fa-solid fa-user-pen"></i>
            <span>Seekers</span>
        </a>
        <div id="seekers" class="collapse {{ Request::is('admin/seeker*') ? 'show' : '' }}" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('seeker-list')
                <a class="collapse-item {{ Request::is('admin/seeker*') ? 'active' : '' }}" href="{{ route('seeker.index') }}">Seekers</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan

    <!-- Nav Item - Job Apply Menu -->
    @canany(['job-apply', 'job-apply-seeker'])
    <li class="nav-item {{ Request::is('admin/bank-info*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#jobApplied"
            aria-expanded="true" aria-controls="jobApplied">
            <i class="fa-solid fa-file-circle-check"></i>
            <span>Applied Jobs</span>
        </a>
        <div id="jobApplied" class="collapse {{ Request::is('admin/job-apply*') ? 'show' : '' }}" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('job-apply')
                <a class="collapse-item {{ Request::is('admin/job-apply*') ? 'active' : '' }}" href="{{ route('job-apply.index') }}">Applied Jobs</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan

    <!-- Nav Item - Finance Menu -->
    @canany(['bank-info-list', 'commercial-tax', 'invoice-list'])
    <li class="nav-item {{ Request::is('admin/bank-info*') ? 'active' : '' }} {{ Request::is('admin/tax*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#finance"
            aria-expanded="true" aria-controls="finance">
            <i class="fa-solid fa-hand-holding-dollar"></i>
            <span>Finance</span>
        </a>
        <div id="finance" class="collapse {{ Request::is('admin/invoice*') ? 'show' : '' }} {{ Request::is('admin/bank-info*') ? 'show' : '' }} {{ Request::is('admin/tax*') ? 'show' : '' }}" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('bank-info-list')
                <a class="collapse-item {{ Request::is('admin/bank-info*') ? 'active' : '' }}" href="{{ route('bank-info.index') }}">Bank Information</a>
                @endcan
                @can('commercial-tax')
                <a class="collapse-item {{ Request::is('admin/tax*') ? 'active' : '' }}" href="{{ route('tax.index') }}">Commercial Tax</a>
                @endcan
                @can('invoice-list')
                <a class="collapse-item {{ Request::is('admin/invoice*') ? 'active' : '' }}" href="{{ route('invoice.index') }}">Invoices</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan

    <li class="nav-item {{ Request::is('admin/online-booking-time*') ? 'active' : '' }} {{ Request::is('admin/inperson-booking-time*') ? 'active' : '' }} {{ Request::is('admin/close-online-booking-time*') ? 'active' : '' }} {{ Request::is('admin/close-inperson-booking-time*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#booking_schedule"
            aria-expanded="true" aria-controls="booking_schedule">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Booking Schedule</span>
        </a>
        <div id="booking_schedule" class="collapse {{ Request::is('admin/online-booking-time*') ? 'show' : '' }} {{ Request::is('admin/inperson-booking-time*') ? 'show' : '' }} {{ Request::is('admin/close-online-booking-time*') ? 'show' : '' }} {{ Request::is('admin/close-inperson-booking-time*') ? 'show' : '' }}" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('admin/online-booking-time*') ? 'active' : '' }}" href="{{ route('online-booking-time.index') }}">Online Booking Time</a>
                <a class="collapse-item {{ Request::is('admin/close-online-booking-time*') ? 'active' : '' }}" href="{{ route('close-online-booking-time.index') }}">Unavailable Online <br> Booking Time</a>
                <a class="collapse-item {{ Request::is('admin/inperson-booking-time*') ? 'active' : '' }}" href="{{ route('inperson-booking-time.index') }}">In-Person Booking Time</a>
                <a class="collapse-item {{ Request::is('admin/close-inperson-booking-time*') ? 'active' : '' }}" href="{{ route('close-inperson-booking-time.index') }}">Unavailable In-Person <br> Booking Time</a>
            </div>
        </div>
        
    </li>

    <li class="nav-item {{ Request::is('admin/onlinebooking*') ? 'active' : '' }} {{ Request::is('admin/inpersonbooking*') ? 'active' : '' }} ">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#booking"
            aria-expanded="true" aria-controls="booking">
            <i class="fa-solid fa-clock"></i>
            <span>Booking</span>
        </a>
        <div id="booking" class="collapse {{ Request::is('admin/onlinebooking*') ? 'show' : '' }} {{ Request::is('admin/inpersonbooking*') ? 'show' : '' }}" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('admin/onlinebooking*') ? 'active' : '' }}" href="{{ route('onlinebooking.index') }}">Online Booking</a>
                <a class="collapse-item {{ Request::is('admin/inpersonbooking*') ? 'active' : '' }}" href="{{ route('inpersonbooking.index') }}">In-Person Booking</a>
            </div>
        </div>
        
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>