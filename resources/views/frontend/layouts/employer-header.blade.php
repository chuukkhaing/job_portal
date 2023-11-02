@php 
    $packageItems = App\Models\Admin\PackageItem::whereIn('id',Auth::guard('employer')->user()->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
@endphp
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
                        <img src="{{ asset('img/icon/company.png') }}" alt="{{ auth()->guard('employer')->user()->email }}" class="img-profile rounded-circle">
                    </a>
                    @endif
                    <ul class="dropdown-menu profile-dropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('employer-profile.index') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                My Profile
                            </a>
                        </li>
                        @if(Auth::guard('employer')->user()->employer_id == Null)
                        <li>
                            <a class="dropdown-item" href="{{ route('member-user.index') }}">
                                <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
                                Manage User
                            </a>
                        </li>
                        @endif
                        
                        <li>
                            <a class="dropdown-item" href="{{ route('buy-point.index') }}">
                                <i class="fas fa-coins fa-sm fa-fw mr-2 text-gray-400"></i>
                                Point Order History
                            </a>
                        </li>
                        
                        <li>
                            <a class="dropdown-item" href="#" id="LogoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
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
@if($packages->count() > 0)
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-pricing modal-dialog-scrollable" style="">
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
                                        <span class="fw-bold text-black">{{ number_format($package->price) }}</span><span class="fw-bold text-dark"> Kyats</span>
                                    </p>
                                    {{--<p class="package-promotion py-2"></p>--}}
                                    <p class="package-plans">Billed annually yearly plans available</p>
                                    {{--<button type="button" class="btn btn-outline-economy">Select  Plan</button>--}}
                                </div>
                                @endif
                                @if($package->name == 'Standard Package')
                                <div class="col-lg-4 standard px-4 py-3">
                                    <h3 class="standard-title">Standard</h3>
                                    <p class="standard-desc mb-4">Our Standard Package is ideal for growing businesses that want to expand their recruitment efforts and streamline their hiring process.</p>
                                    <p class="package-price mb-0">
                                        <span class="fw-bold text-black">{{ number_format($package->price) }}</span><span class="fw-bold text-dark"> Kyats</span>
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
                                        <span class="fw-bold text-black">{{ number_format($package->price) }}</span><span class="fw-bold text-dark"> Kyats</span>
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
                                        <td width="50%">Home Page Banner</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $home_page_banner = App\Models\Admin\PackageItem::where('name','Home Page Banner')->pluck('id')->toArray();
                                                $home_page_banner_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$home_page_banner)->count();
                                            @endphp
                                            @if($home_page_banner_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Top Employer</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $top_employer = App\Models\Admin\PackageItem::where('name','Top Employer')->pluck('id')->toArray();
                                                $top_employer_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$top_employer)->count();
                                            @endphp
                                            @if($top_employer_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Testimonials</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $testimonial = App\Models\Admin\PackageItem::where('name','Testimonials')->pluck('id')->toArray();
                                                $testimonial_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$testimonial)->count();
                                            @endphp
                                            @if($testimonial_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Employer Profile with Photos</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $photo = App\Models\Admin\PackageItem::where('name','Employer Profile with Photos')->pluck('id')->toArray();
                                                $photo_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$photo)->count();
                                            @endphp
                                            @if($photo_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Employer Profile with Videos</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $video = App\Models\Admin\PackageItem::where('name','Employer Profile with Videos')->pluck('id')->toArray();
                                                $video_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$video)->count();
                                            @endphp
                                            @if($video_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Specific Job Adv on Social Media</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $media = App\Models\Admin\PackageItem::where('name','Specific Job Adv on Social Media')->pluck('id')->toArray();
                                                $media_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$media)->count();
                                            @endphp
                                            @if($media_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12">
                            <h4 class="text-blue fz17">ATS System</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td width="50%">Application Management</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $application = App\Models\Admin\PackageItem::where('name','Application Management')->pluck('id')->toArray();
                                                $application_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$application)->count();
                                            @endphp
                                            @if($application_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Application Unlock</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $cv_unlock = App\Models\Admin\PackageItem::where('name','Application Unlock')->pluck('id')->toArray();
                                                $cv_unlock_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$cv_unlock)->count();
                                            @endphp
                                            @if($cv_unlock_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Up to 10 User Accounts</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $user_10 = App\Models\Admin\PackageItem::where('name','Up to 10 User Accounts')->pluck('id')->toArray();
                                                $user_10_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$user_10)->count();
                                            @endphp
                                            @if($user_10_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Up to 5 User Accounts</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $user_5 = App\Models\Admin\PackageItem::where('name','Up to 5 User Accounts')->pluck('id')->toArray();
                                                $user_5_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$user_5)->count();
                                            @endphp
                                            @if($user_5_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Website Integration</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $website = App\Models\Admin\PackageItem::where('name','Website Integration')->pluck('id')->toArray();
                                                $website_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$website)->count();
                                            @endphp
                                            @if($website_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Email Alerts for receiving Applications</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $email_alert = App\Models\Admin\PackageItem::where('name','Email Alerts for receiving Applications')->pluck('id')->toArray();
                                                $email_alert_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$email_alert)->count();
                                            @endphp
                                            @if($email_alert_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12">
                            <h4 class="text-blue fz17">Job Posting</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td width="50%">Trending Job Post</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $trending = App\Models\Admin\PackageItem::where('name','Trending Job Post')->pluck('id')->toArray();
                                                $trending_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$trending)->count();
                                            @endphp
                                            @if($trending_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Feature Job Post</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $feature = App\Models\Admin\PackageItem::where('name','Feature Job Post')->pluck('id')->toArray();
                                                $feature_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$feature)->count();
                                            @endphp
                                            @if($feature_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Pre-qualify questions</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $question = App\Models\Admin\PackageItem::where('name','Pre-qualify questions')->pluck('id')->toArray();
                                                $question_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$question)->count();
                                            @endphp
                                            @if($question_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Job Alert to candidates</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $job_alert = App\Models\Admin\PackageItem::where('name','Job Alert to candidates')->pluck('id')->toArray();
                                                $job_alert_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$job_alert)->count();
                                            @endphp
                                            @if($job_alert_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Invite to apply the suitable candidates</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $invite_to_apply = App\Models\Admin\PackageItem::where('name','Invite to apply the suitable candidates')->pluck('id')->toArray();
                                                $invite_to_apply_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$invite_to_apply)->count();
                                            @endphp
                                            @if($invite_to_apply_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Anonymous Posting</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                                $anonymous_post = App\Models\Admin\PackageItem::where('name','Anonymous Posting')->pluck('id')->toArray();
                                                $anonymous_post_id = App\Models\Admin\PackageWithPackageItem::where('package_id',$package->id)->whereIn('package_item_id',$anonymous_post)->count();
                                            @endphp
                                            @if($anonymous_post_id > 0)
                                            <td><i class="fa-solid fa-check"></i></td>
                                            @else
                                            <td><i class="fa-solid fa-xmark"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <h4 class="text-blue fz17">Point Detection Method</h4>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td width="50%">Posting Job</td>
                                        <td><strong>FOC</strong></td>
                                        <td><strong>FOC</strong></td>
                                        <td><strong>FOC</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Trending Job Post</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                            $trending = App\Models\Admin\PackageItem::where('name','Trending Job Post')->pluck('id')->toArray();
                                            $trending_count = $package->PackageWithPackageItem->where('package_id',$package->id)->whereIn('package_item_id',$trending)->count();
                                            if($trending_count == 1) {
                                                $trending_post = $package->PackageWithPackageItem->where('package_id',$package->id)->whereIn('package_item_id',$trending)->first();
                                                $trending_point = App\Models\Admin\PackageItem::where('name','Trending Job Post')->where('id',$trending_post->package_item_id)->first();
                                            }
                                            @endphp
                                            <td><strong>{{ $trending_point->point }} Points</strong></td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Feature Job Post</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                            $feature = App\Models\Admin\PackageItem::where('name','Feature Job Post')->pluck('id')->toArray();
                                            $feature_count = $package->PackageWithPackageItem->where('package_id',$package->id)->whereIn('package_item_id',$feature)->count();
                                            if($feature_count == 1) {
                                                $feature_post = $package->PackageWithPackageItem->where('package_id',$package->id)->whereIn('package_item_id',$feature)->first();
                                                $feature_point = App\Models\Admin\PackageItem::where('name','Feature Job Post')->where('id',$feature_post->package_item_id)->first();
                                            }
                                            @endphp
                                            <td><strong>{{ $feature_point->point }} Points</strong></td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Pre-qualify questions</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                            $question = App\Models\Admin\PackageItem::where('name','Pre-qualify questions')->pluck('id')->toArray();
                                            $question_count = $package->PackageWithPackageItem->where('package_id',$package->id)->whereIn('package_item_id',$question)->count();
                                            if($question_count == 1) {
                                                $question_post = $package->PackageWithPackageItem->where('package_id',$package->id)->whereIn('package_item_id',$question)->first();
                                                $question_point = App\Models\Admin\PackageItem::where('name','Pre-qualify questions')->where('id',$question_post->package_item_id)->first();
                                            }
                                            @endphp
                                            <td><strong>{{ $question_point->point }} Points</strong></td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td width="50%">Application Unlock</td>
                                        @foreach($packages->where('id','!=',4) as $package)
                                            @php 
                                            $cv_unlock = App\Models\Admin\PackageItem::where('name','Application Unlock')->pluck('id')->toArray();
                                            $cv_unlock_count = $package->PackageWithPackageItem->where('package_id',$package->id)->whereIn('package_item_id',$cv_unlock)->count();
                                            if($cv_unlock_count == 1) {
                                                $cv_unlock_post = $package->PackageWithPackageItem->where('package_id',$package->id)->whereIn('package_item_id',$cv_unlock)->first();
                                                $cv_unlock_point = App\Models\Admin\PackageItem::where('name','Application Unlock')->where('id',$cv_unlock_post->package_item_id)->first();
                                            }
                                            @endphp
                                            <td><strong>{{ $cv_unlock_point->point }} Points</strong></td>
                                        @endforeach
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
@push('scripts')
<script>
    $(document).on('click', '#LogoutModal', function (e) {
        
        MSalert.principal({
            icon:'info',
            title:'Info',
            description:'Are you sure to leave?',
            button:true
        }).then(result => {
            if (result === true){
                $.ajax({
                    type: 'POST',
                    url: "{{ route('employer.logout') }}",
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