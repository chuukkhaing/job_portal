@extends('frontend.layouts.app')
@section('content')

<div class="container my-5">
    <div class="row my-5">
        <div class="col-12 col-md-6 p-3 p-lg-5 contact-box">
            <div class="contact-header py-3">
                <h2 class="">Get In Touch</h2>
                <p>Our team is available to provide support and help you find what you're looking for.</p>
            </div>
            <div class="hr-speech my-3 mx-5">
                <div class="row">
                    <div class="col-2">
                        <div class="contact-icon d-inline-block my-3">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                    </div>
                    <div class="col-10 my-3">
                    <h5 class="text-light">Chat with Us</h5>
                    <p class="text-light">"Connect with us directly to get the help you need by reaching out through our chat feature."</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="contact-icon d-inline-block my-3">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                    <div class="col-10 my-3">
                    <h5 class="text-light">Our Office</h5>
                    <p class="text-light">"Visit us in person by stopping by our physical location and speaking with a member of our team."</p>
                    <h5 class="text-light">No47, Thazin Street, Baho Road, Ahlone Township, Yangon, Myanmar </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="contact-icon d-inline-block my-3">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                    </div>
                    <div class="col-10 my-3">
                    <h5 class="text-light">Office Phont</h5>
                    <p class="text-light">"Give us a call to speak directly with a member of our team by dialing our office's phone line."</p>
                    <h5 class="text-light"><a href="tel:+959447962279">09447962279</a> , <a href="tel:+959782436801">09782436801</a></h5>
                    </div>
                </div>
            </div>
            <div>
                <div class="bg-light social-icon d-inline-block mx-1">
                    <a href="https://www.facebook.com/infinitycareersmyanmar2021"><img src="{{ asset('img/icon/facebook.png') }}" alt="" width='17px' height='17px'></a>
                </div>
                <div class="bg-light social-icon d-inline-block mx-1">
                    <a href="https://www.linkedin.com/company/infinity-careers-myanmar-thebestrecruitmentagency/"><img src="{{ asset('img/icon/linkedin.png') }}" alt="" width='17px' height='17px'></a>
                </div>
                {{-- <div class="bg-light social-icon d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/twitter.png') }}" alt="" width='17px' height='17px'></a>
                </div>
                <div class="bg-light social-icon d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/instagram.png') }}" alt="" width='17px' height='17px'></a>
                </div>
                <div class="bg-light social-icon d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/tiktok.png') }}" alt="" width='17px' height='17px'></a>
                </div> --}}
            </div>
        </div>
        <div class="col-12 col-md-6 p-3 p-lg-5 contact-form-box">
            <div class="contact-form-header py-3">
                <h2 class="">Contact us</h2>
                <p>"Get in touch with our team by reaching out through one of our available communication channels."</p>
            </div>
            <div class="hr-speech my-3">
                <form action="{{ route('contact-us') }}" method="post">
                    @csrf 
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" required class="form-control seeker_input" placeholder="Name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" required class="form-control seeker_input" placeholder="Email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone <span class="text-danger">*</span></label>
                        <input type="number" name="phone" id="phone" required class="form-control seeker_input" placeholder="Phone" value="{{ old('phone') }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="4" class="form-control seeker_input">{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="form-group p-2">
                        <button type="submit" class="btn col-12 btn-signup"> Send Message  </button>
                    </div>   
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container my-5 p-0">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3819.8328077832693!2d96.12906685040467!3d16.78499174288229!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1eb728636d585%3A0x105c347c8acf4853!2sIGS!5e0!3m2!1sen!2snl!4v1689523356335!5m2!1sen!2snl" width="100%" height="290" style="border:1px solid #88C3FF;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
@endsection