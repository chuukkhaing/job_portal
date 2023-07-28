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
                @if(Auth::guard('employer')->user()->package_end_date)
                <span class="fw-bold" style="color: #B2B1B0">Package Expire Date :</span>
                <span class="text-light fw-bold">{{ date('F d, Y', strtotime(Auth::guard('employer')->user()->package_end_date)) }}</span>
                @endif
                <a href="{{ route('employer-job-post.create') }}" class="btn bg-light" style="color: #0355D0; margin: 10px">
                    Post a Job
                </a>
                
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
                            <a class="dropdown-item" href="{{ route('member-user.index') }}">
                                <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
                                Manage User
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

<!-- Modal -->
@if($packages->count() > 0)
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="container-fluid">
                    <h4 class="text-center fs-5 py-3">Infinity Careers Platform Pricing</h4>
                    <div class="row text-light my-3">
                        <div class="col-lg-4 px-4 py-3">
                            <h4 class="fz17 pb-2">Job Seeker Pricing Plans</h4>
                            <p class="text-black">
                                Our packing pricing design allows you to choose the right package that best fits your business needs. We offer a variety of options, each with different features, points, and pricing. Simply select the package that works best for you, and our team will take care of the rest.
                            </p>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                @foreach($packages as $package)
                                @if($package->name == 'Economy Package')
                                <div class="col-lg-4 economy px-4 py-3">
                                    <h3 class="economy-title">Economy</h3>
                                    <p class="economy-desc mb-4">Our Basic Package is perfect for small businesses or start-ups looking to post their job listings and start attracting qualified candidates.</p>
                                    <p class="package-price mb-0">
                                        <span class="fw-bold text-black">1,000,000</span><span class="fw-bold text-dark"> Kyats</span>
                                    </p>
                                    <p class="package-promotion py-2"></p>
                                    <p class="package-plans">Billed annually yearly plans available</p>
                                    {{--<button type="button" class="btn btn-outline-economy">Select  Plan</button>--}}
                                </div>
                                @endif
                                @if($package->name == 'Standard Package')
                                <div class="col-lg-4 standard px-4 py-3">
                                    <h3 class="standard-title">Standard</h3>
                                    <p class="standard-desc mb-4">Our Standard Package is ideal for growing businesses that want to expand their recruitment efforts and streamline their hiring process.</p>
                                    <p class="package-price mb-0">
                                        <span class="fw-bold text-black">1,500,000</span><span class="fw-bold text-dark"> Kyats</span>
                                    </p>
                                    {{--<p class="package-promotion py-2">15% OFF</p>--}}
                                    <p class="package-plans">Billed annually yearly plans available</p>
                                    {{--<button type="button" class="btn btn-outline-standard">Select  Plan</button>--}}
                                </div>
                                @endif
                                @if($package->name == 'Premium Package')
                                <div class="col-lg-4 premium px-4 py-3">
                                    <h3 class="premium-title">Premium</h3>
                                    <p class="premium-desc mb-4">Our Basic Package is perfect for small businesses or start-ups looking to post their job listings and start attracting qualified candidates.</p>
                                    <p class="package-price mb-0">
                                        <span class="fw-bold text-black">2,000,000</span><span class="fw-bold text-dark"> Kyats</span>
                                    </p>
                                    {{--<p class="package-promotion py-2">30% OFF</p>--}}
                                    <p class="package-plans">Billed annually yearly plans available</p>
                                    {{--<button type="button" class="btn btn-outline-premium">Select  Plan</button>--}}
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row text-light py-4">
                        <div class="col-lg-12">
                            <h4 class="text-blue fz17">Employer Branding Option</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Rotating Home Page Logo</td>
                                        <td><i class="fa-solid fa-xmark"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Sector Banner</td>
                                        <td><i class="fa-solid fa-xmark"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Leading Employer Banner ( Top employer )</td>
                                        <td><i class="fa-solid fa-xmark"></i></td>
                                        <td>Add on</td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Testimonials ( Reviews of working in client:s Company )</td>
                                        <td><i class="fa-solid fa-xmark"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Video Content Creation (info Graphic) ( Video posting in employer page )</td>
                                        <td>Add on</td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                    <tr>
                                        <td>Employer Profile with Photo</td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                        <td><i class="fa-solid fa-check"></i></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Modal End -->