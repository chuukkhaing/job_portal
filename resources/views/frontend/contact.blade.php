@extends('frontend.layouts.app')
@section('content')

<div class="container my-5">
    <div class="row my-5">
        <div class="col-12 col-md-6 p-3 p-lg-5 contact-box">
            <div class="contact-header py-3">
                <h2 class="">Get In Touch</h2>
                <p>Our team is available to provide support and help you find what you're looking for.</p>
            </div>
            <div class="my-3 mx-1 mx-md-3">
                <div class="row">
                    <div class="col-2 text-end">
                        <div class="contact-icon d-inline-block my-3">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                    </div>
                    <div class="col-10 my-3">
                    <h5 class="text-light">Contact with Us</h5>
                    <p class="text-light">"Connect with us directly to get the help you need by reaching out through our chat feature."</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 text-end">
                        <div class="contact-icon d-inline-block my-3">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                    <div class="col-10 my-3">
                    <h5 class="text-light">Our Office</h5>
                    <p class="text-light">"Visit us in person by stopping by our physical location and speaking with a member of our team."</p>
                    <p class="text-light">No47, Thazin Street, Baho Road, Ahlone Township, Yangon, Myanmar </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 text-end">
                        <div class="contact-icon d-inline-block my-3">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                    </div>
                    <div class="col-10 my-3">
                    <h5 class="text-light">Phone</h5>
                    <p class="text-light">"Give us a call to speak directly with a member of our team by dialing our office's phone line."</p>
                    <p class="text-light"><a href="tel:+959880915475" class="text-decoration-none text-white">09 880915475</a> , <a class="text-decoration-none text-white" href="tel:+959 880915476">09 880915476</a></p>
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
        <div class="col-12 col-md-6 p-3 p-lg-5 mt-2 mt-md-0 contact-form-box">
            <div class="contact-form-header py-3">
                <h2 class="" style="color: #FB5404">Contact us</h2>
                <p>"Get in touch with our team by reaching out through one of our available communication channels."</p>
            </div>
            <div class="hr-speech my-3">
                <form action="{{ route('contact-us') }}" method="post">
                    @csrf 
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control seeker_input @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control seeker_input @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone </label>
                        <input type="number" name="phone" id="phone" class="form-control seeker_input @error('phone') is-invalid @enderror" placeholder="Phone" value="{{ old('phone') }}">
                        @error('phone')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="4" class="form-control seeker_input">{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="form-group p-2">
                        <button type="submit" class="btn btn-sm col-12 btn-signup"> Send Message  </button>
                    </div>   
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container my-5 p-0">
<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d30558.6606030118!2d96.1135371!3d16.7850033!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1eb145fa8c913%3A0x99b9dad98198dd4e!2sInfinity%20Careers%20Co.%2CLtd!5e0!3m2!1sen!2snl!4v1696927244836!5m2!1sen!2snl" width="100%" height="290" style="border:1px solid #88C3FF;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

</div>
@endsection