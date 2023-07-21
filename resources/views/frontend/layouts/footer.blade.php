<!-- Footer Start -->
<div class="container-fluid py-5 mt-5 wow fadeInUp border-top" data-wow-delay="0.3s">
    <div class="container pt-5">
        <div class="row g-5 pt-4">
            <div class="col-lg-4 col-md-6">
                <img src="{{ asset('img/logo/ic-logo.png') }}" class="w-75" alt="{{ config('app.name', 'Laravel') }}">
                <div class="py-4">
                    <p class="text-dark"><strong>Call us</strong></p>
                    <a class="footer-phone" href="tel:+959784569632"><strong>09 784569632</strong></a>
                </div>
                <div class="py-4">
                    <p class="footer-address">No47, Thazin Street, Baho Road, Ahlone Township, Yangon, Myanmar </p>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-lg-3 col-md-6 p-0">
                        <h6 class="mb-4">About Us</h6>
                        <hr class="footer-hr">
                        <div class="d-flex flex-column justify-content-start">
                            <a class="footer-links mb-2" href="{{ route('contact-us') }}">Contact Us</a>
                            <a class="footer-links mb-2" href="#">About Us</a>
                            <a class="footer-links mb-2" href="#">Terms of Use</a>
                            <a class="footer-links mb-2" href="#">Privacy Policies</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 p-0">
                        <h6 class="mb-4">For Jobseekers</h6>
                        <hr class="footer-hr">
                        <div class="d-flex flex-column justify-content-start">
                            <a class="footer-links mb-2" href="#">Registration</a>
                            <a class="footer-links mb-2" href="#">Browse Jobs</a>
                            <a class="footer-links mb-2" href="#">Job Function</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 p-0">
                        <h6 class="mb-4">For Employers</h6>
                        <hr class="footer-hr">
                        <div class="d-flex flex-column justify-content-start">
                            <a class="footer-links mb-2" href="#">Post a Job</a>
                            <a class="footer-links mb-2" href="#">Advertise with Us</a>
                            <a class="footer-links mb-2" href="#">News & Blogs</a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 p-0">
                        <h6 class="mb-4">Helpful Resources</h6>
                        <hr class="footer-hr">
                        <div class="d-flex flex-column justify-content-start">
                            <a class="footer-links mb-2" href="#">Linkedin</a>
                            <a class="footer-links mb-2" href="#">Telegram</a>
                            <a class="footer-links mb-2" href="#">Viber</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-light py-4 footer-copyright">
    <div class="container">
        <div class="row g-0 text-center">
            <p class="mb-md-0 fw-bold">Copyright &copy; {{ date("Y") }} Infinity Careers. All Rights Reserved. Design by: <a class="copyright-link" href="{{ url('/') }}">IGS</a></p>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>