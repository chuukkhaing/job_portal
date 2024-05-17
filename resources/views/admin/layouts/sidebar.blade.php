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
    <li class="nav-item {{ Request::is('roles*') ? 'active' : '' }} {{ Request::is('users*') ? 'active' : '' }} {{ Request::is('job-posts*') ? 'active' : '' }} {{ Request::is('state*') ? 'active' : '' }} {{ Request::is('city*') ? 'active' : '' }} {{ Request::is('package-item*') ? 'active' : '' }} {{ Request::is('package-type*') ? 'active' : '' }} {{ Request::is('point-package*') ? 'active' : '' }} {{ Request::is('point-topup*') ? 'active' : '' }} {{ Request::is('slider*') ? 'active' : '' }} {{ Request::is('feedback*') ? 'active' : '' }} {{ Request::is('industry*') ? 'active' : '' }} {{ Request::is('ownership-type*') ? 'active' : '' }} {{ Request::is('main-functional-area*') ? 'active' : '' }} {{ Request::is('sub-functional-area*') ? 'active' : '' }} {{ Request::is('skill*') ? 'active' : '' }} {{ Request::is('blog-category*') ? 'active' : '' }} {{ Request::is('blog-post*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#user_manage"
            aria-expanded="true" aria-controls="user_manage">
            <i class="fa-solid fa-user-lock"></i>
            <span>Admin</span>
        </a>
        <div id="user_manage" class="collapse {{ Request::is('roles*') ? 'show' : '' }} {{ Request::is('users*') ? 'show' : '' }} {{ Request::is('job-posts*') ? 'show' : '' }} {{ Request::is('state*') ? 'show' : '' }} {{ Request::is('city*') ? 'show' : '' }} {{ Request::is('package-item*') ? 'show' : '' }} {{ Request::is('package-type*') ? 'show' : '' }} {{ Request::is('point-package*') ? 'show' : '' }} {{ Request::is('point-topup*') ? 'show' : '' }} {{ Request::is('slider*') ? 'show' : '' }} {{ Request::is('feedback*') ? 'show' : '' }} {{ Request::is('industry*') ? 'show' : '' }} {{ Request::is('ownership-type*') ? 'show' : '' }} {{ Request::is('main-functional-area*') ? 'show' : '' }} {{ Request::is('sub-functional-area*') ? 'show' : '' }} {{ Request::is('skill*') ? 'show' : '' }} {{ Request::is('blog-category*') ? 'show' : '' }} {{ Request::is('blog-post*') ? 'show' : '' }}" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('role-list')
                <a class="collapse-item {{ Request::is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">Roles</a>
                @endcan
                @can('user-list')
                <a class="collapse-item {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a>
                @endcan

                @canany(['role-list', 'user-list'])
                <hr style="margin: 0.5rem 0">
                @endcan

                @can('job-post-list')
                <a class="collapse-item {{ Request::is('job-posts*') ? 'active' : '' }}" href="{{ route('job-posts.index') }}">Job Posts</a>
                <hr style="margin: 0.5rem 0">
                @endcan

                @can('state-list')
                <a class="collapse-item {{ Request::is('state*') ? 'active' : '' }}" href="{{ route('state.index') }}">States & Regions</a>
                @endcan
                @can('township-list')
                <a class="collapse-item {{ Request::is('city*') ? 'active' : '' }}" href="{{ route('city.index') }}">Cities & Townships</a>
                @endcan

                @canany(['state-list', 'township-list'])
                <hr style="margin: 0.5rem 0">
                @endcan

                @can('package-item-list')
                <a class="collapse-item {{ Request::is('package-item*') ? 'active' : '' }}" href="{{ route('package-item.index') }}">Package Items</a>
                @endcan
                @can('package-type-list')
                <a class="collapse-item {{ Request::is('package-type*') ? 'active' : '' }}" href="{{ route('package-type.index') }}">Package Type</a>
                @endcan
                @can('point-package-list')
                <a class="collapse-item {{ Request::is('point-package*') ? 'active' : '' }}" href="{{ route('point-package.index') }}">Point Package</a>
                @endcan
                @can('point-topup-list')
                <a class="collapse-item {{ Request::is('point-topup*') ? 'active' : '' }}" href="{{ route('point-topup.index') }}">Point Topup</a>
                @endcan

                @canany(['package-item-list', 'package-type-list', 'point-package-list', 'point-topup-list'])
                <hr style="margin: 0.5rem 0">
                @endcan

                @can('industry-list')
                <a class="collapse-item {{ Request::is('industry*') ? 'active' : '' }}" href="{{ route('industry.index') }}">Industries</a>
                @endcan 
                @can('ownership-type-list')
                <a class="collapse-item {{ Request::is('ownership-type*') ? 'active' : '' }}" href="{{ route('ownership-type.index') }}">Ownership Type</a>
                @endcan
                @can('main-functional-area-list')
                <a class="collapse-item {{ Request::is('main-functional-area*') ? 'active' : '' }}" href="{{ route('main-functional-area.index') }}">Main Functional Areas</a>
                @endcan
                @can('sub-functional-area-list')
                <a class="collapse-item {{ Request::is('sub-functional-area*') ? 'active' : '' }}" href="{{ route('sub-functional-area.index') }}">Sub Functional Areas</a>
                @endcan
                @can('skill-list')
                <a class="collapse-item {{ Request::is('skill*') ? 'active' : '' }}" href="{{ route('skill.index') }}">Skills</a>
                @endcan

                @canany(['industry-list', 'ownership-type-list', 'main-functional-area-list', 'sub-functional-area-list', 'skill-list'])
                <hr style="margin: 0.5rem 0">
                @endcan

                @can('slider-list')
                <a class="collapse-item {{ Request::is('slider*') ? 'active' : '' }}" href="{{ route('slider.index') }}">Sliders</a>
                @endcan
                @can('seeker-employer-contact-list')
                <a class="collapse-item {{ Request::is('feedback*') ? 'active' : '' }}" href="{{ route('feedback.index') }}">Seeker/Employer Contact</a>
                @endcan

                @canany(['slider-list', 'seeker-employer-contact-list'])
                <hr style="margin: 0.5rem 0">
                @endcan
                @can('blog-category-list')
                <a class="collapse-item {{ Request::is('blog-category*') ? 'active' : '' }}" href="{{ route('blog-category.index') }}">Blog Categories</a>
                @endcan
                @can('blog-post-list')
                <a class="collapse-item {{ Request::is('blog-post*') ? 'active' : '' }}" href="{{ route('blog-post.index') }}">Blog Posts</a>
                @endcan

                @canany('seo-list')
                <hr style="margin: 0.5rem 0">
                <a class="collapse-item {{ Request::is('seo*') ? 'active' : '' }}" href="{{ route('seo.index') }}">Page SEO</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan

    <!-- Nav Item - Employer Menu -->
    @canany(['employer-list', 'employer-info-list'])
    <li class="nav-item {{ Request::is('employers*') ? 'active' : '' }} {{ Request::is('employer-info*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#employers"
            aria-expanded="true" aria-controls="employers">
            <i class="fas fa-user-tie"></i>
            <span>Employers</span>
        </a>
        <div id="employers" class="collapse {{ Request::is('employers*') ? 'show' : '' }} {{ Request::is('employer-info*') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('employer-list')
                <a class="collapse-item {{ Request::is('employers*') ? 'active' : '' }}" href="{{ route('employers.index') }}">Employer Account</a>
                @endcan
                @can('employer-info-list')
                <a class="collapse-item {{ Request::is('employer-info*') ? 'active' : '' }}" href="{{ route('employer-info.index') }}">Employer Information</a>
                @endcan
            </div>
        </div>
    </li>
    
    @endcan
    <!-- Nav Item - Seeker Menu -->
    @canany(['seeker-list'])
    <li class="nav-item {{ Request::is('seeker*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#seekers"
            aria-expanded="true" aria-controls="seekers">
            <i class="fa-solid fa-user-pen"></i>
            <span>Seekers</span>
        </a>
        <div id="seekers" class="collapse {{ Request::is('seeker*') ? 'show' : '' }}" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('seeker-list')
                <a class="collapse-item {{ Request::is('seeker*') ? 'active' : '' }}" href="{{ route('seeker.index') }}">Seekers</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan

    <!-- Nav Item - Job Apply Menu -->
    @canany(['job-apply', 'job-apply-seeker'])
    <li class="nav-item {{ Request::is('bank-info*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#jobApplied"
            aria-expanded="true" aria-controls="jobApplied">
            <i class="fa-solid fa-file-circle-check"></i>
            <span>Applied Jobs</span>
        </a>
        <div id="jobApplied" class="collapse {{ Request::is('job-apply*') ? 'show' : '' }}" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('job-apply')
                <a class="collapse-item {{ Request::is('job-apply*') ? 'active' : '' }}" href="{{ route('job-apply.index') }}">Applied Jobs</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan

    <!-- Nav Item - Finance Menu -->
    @canany(['bank-info-list', 'commercial-tax', 'invoice-list'])
    <li class="nav-item {{ Request::is('bank-info*') ? 'active' : '' }} {{ Request::is('tax*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#finance"
            aria-expanded="true" aria-controls="finance">
            <i class="fa-solid fa-hand-holding-dollar"></i>
            <span>Finance</span>
        </a>
        <div id="finance" class="collapse {{ Request::is('invoice*') ? 'show' : '' }} {{ Request::is('bank-info*') ? 'show' : '' }} {{ Request::is('tax*') ? 'show' : '' }}" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('bank-info-list')
                <a class="collapse-item {{ Request::is('bank-info*') ? 'active' : '' }}" href="{{ route('bank-info.index') }}">Bank Information</a>
                @endcan
                @can('commercial-tax')
                <a class="collapse-item {{ Request::is('tax*') ? 'active' : '' }}" href="{{ route('tax.index') }}">Commercial Tax</a>
                @endcan
                @can('invoice-list')
                <a class="collapse-item {{ Request::is('invoice*') ? 'active' : '' }}" href="{{ route('invoice.index') }}">Invoices</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan

    <li class="nav-item {{ Request::is('online-booking-time*') ? 'active' : '' }} {{ Request::is('inperson-booking-time*') ? 'active' : '' }} {{ Request::is('unavailable-online-booking-time*') ? 'active' : '' }} {{ Request::is('unavailable-inperson-booking-time*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#booking_schedule"
            aria-expanded="true" aria-controls="booking_schedule">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Booking Schedule</span>
        </a>
        <div id="booking_schedule" class="collapse {{ Request::is('online-booking-time*') ? 'show' : '' }} {{ Request::is('inperson-booking-time*') ? 'show' : '' }} {{ Request::is('unavailable-online-booking-time*') ? 'show' : '' }} {{ Request::is('unavailable-inperson-booking-time*') ? 'show' : '' }}" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('online-booking-time*') ? 'active' : '' }}" href="{{ route('online-booking-time.index') }}">Online Booking Time</a>
                <a class="collapse-item {{ Request::is('unavailable-online-booking-time*') ? 'active' : '' }}" href="{{ route('unavailable-online-booking-time.index') }}">Unavailable Online <br> Booking Time</a>
                <a class="collapse-item {{ Request::is('inperson-booking-time*') ? 'active' : '' }}" href="{{ route('inperson-booking-time.index') }}">In-Person Booking Time</a>
                <a class="collapse-item {{ Request::is('unavailable-inperson-booking-time*') ? 'active' : '' }}" href="{{ route('unavailable-inperson-booking-time.index') }}">Unavailable In-Person <br> Booking Time</a>
            </div>
        </div>
        
    </li>

    <li class="nav-item {{ Request::is('online-booking*') ? 'active' : '' }} {{ Request::is('inperson-booking*') ? 'active' : '' }} ">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#booking"
            aria-expanded="true" aria-controls="booking">
            <i class="fa-solid fa-clock"></i>
            <span>Booking</span>
        </a>
        <div id="booking" class="collapse {{ Request::is('online-booking*') ? 'show' : '' }} {{ Request::is('inperson-booking*') ? 'show' : '' }}" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('online-booking*') ? 'active' : '' }}" href="{{ route('online-booking.index') }}">Online Booking</a>
                <a class="collapse-item {{ Request::is('inperson-booking*') ? 'active' : '' }}" href="{{ route('inperson-booking.index') }}">In-Person Booking</a>
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