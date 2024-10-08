<!-- Footer Start -->
<div class="container-fluid py-3 mt-1 wow fadeInUp border-top" data-wow-delay="0.3s">
    <div class="container">
        <div class="row py-3">
            <div class="col-lg-4 col-md-6">
                <div class="row px-2">
                    <div class="pb-3 mt-1">
                        <img src="{{ asset('img/logo/ic-logo.png') }}" class="w-75 p-0" alt="{{ config('app.name', 'Laravel') }}">
                    </div>
                    <div class="py-3">
                        <p class="text-dark">
                            <span><strong>{{ __('message.Call us') }} </strong></span>
                            <span><a href="tel:+959880915475" class="fw-bold" style="color: #0355D0">09 880915475</a>, <a href="tel:+959880915476" class="fw-bold" style="color: #0355D0">09 880915476</a>
                            </span>
                        </p>
                    </div>
                    <div class="py-3">
                        <p class="footer-address">No47, Thazin Street, Baho Road, Ahlone Township, Yangon, Myanmar </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row p-2 px-3">
                    <div class="col-lg-3 col-md-6 p-0">
                        <h6 class="my-3"><strong>{{ __('message.About Us') }}</strong></h6>
                        <hr class="footer-hr">
                        <div class="d-flex flex-column justify-content-start">
                            <a class="footer-links py-2" href="{{ route('contact-us') }}">{{ __('message.Contact Us') }}</a>
                            <a class="footer-links py-2" href="{{ route('about-us') }}">{{ __('message.About Us') }}</a>
                            <a class="footer-links py-2" href="{{ route('terms-of-use') }}">{{ __('message.Terms of Use') }}</a>
                            <a class="footer-links py-2" href="{{ route('privacy-policy') }}">{{ __('message.Privacy Policies') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 p-0">
                        <h6 class="my-3"><strong>{{ __('message.For Jobseekers') }}</strong></h6>
                        <hr class="footer-hr">
                        <div class="d-flex flex-column justify-content-start">
                            <a class="footer-links py-2" href="{{ route('register-form') }}">{{ __('message.Sign Up') }}</a>
                            <a class="footer-links py-2" href="{{ route('find-jobs') }}">{{ __('message.Find Jobs') }}</a>
                            <a class="footer-links py-2" href="{{ route('job-categories') }}">{{ __('message.Job Category') }}</a>
                            <a class="footer-links py-2" href="{{ route('login-form') }}">{{ __('message.Sign In') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 p-0">
                        <h6 class="my-3"><strong>{{ __('message.For Employers') }}</strong></h6>
                        <hr class="footer-hr">
                        <div class="d-flex flex-column justify-content-start">
                            <a class="footer-links py-2" href="{{ route('employer-register-form') }}">{{ __('message.Sign Up') }}</a>
                            <a class="footer-links py-2" href="{{ route('employer-job-post.create') }}">{{ __('message.Post a Job') }}</a>
                            <a class="footer-links py-2" href="{{ route('register-form') }}">{{ __('message.Advertise with Us') }}</a>
                            <a class="footer-links py-2" href="{{ route('employer-login-form') }}">{{ __('message.Sign In') }}</a>
                            {{--<a class="footer-links mb-2" href="#">News & Blogs</a>--}}
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 p-0">
                        <h6 class="my-3"><strong>Follow Us</strong></h6>
                        <hr class="footer-hr">
                        <div class="d-flex flex-column justify-content-start">
                            <a class="footer-links py-2" href="https://www.linkedin.com/company/infinity-careers-myanmar-thebestrecruitmentagency/">Linkedin</a>
                            <a class="footer-links py-2" href="https://www.facebook.com/infinitycareersmyanmar2021">Facebook</a>
                            {{-- <a class="footer-links mb-2" href="#">Telegram</a> --}}
                            <a class="footer-links py-2" href="https://invite.viber.com/?g2=AQBfOlaPXsJ6208t76pHaWT%2FqlOO%2BD4G6B9nQbRfU2UrK1C4KRstKkWJGBTjsffm">Viber</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-light py-3 footer-copyright">
    <div class="container">
        <div class="row g-0 text-center">
            <p class="mb-md-0 fw-bold">Copyright &copy; {{ date("Y") }} Infinity Careers. All Rights Reserved. Design by: <a class="copyright-link" href="{{ url('/') }}">IGS</a></p>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>