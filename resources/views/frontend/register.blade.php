@extends('frontend.layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 p-3 p-lg-5">
            <div class="register-header py-3">
                <h2 class="">Join our job seeker community and find your dream job</h2>
            </div>
            <div class="hr-speech py-3">
                <div class="open-quote d-inline-block my-3">
                    <i class="fa-solid fa-quote-left"></i>
                </div>
                <p class="py-3">
                "I was struggling to find job openings that matched my skills and experience until I stumbled upon this job seeker website. <br><br>

                The website's user interface is also very intuitive and easy to use. I was able to apply for jobs quickly and easily through the website, and I even received a few job offers within a few weeks of using the website. <br><br>

                I highly recommend this website to anyone looking for their next career opportunity."
                </p>
            </div>
            <div class="row">
                <div class="col-2">
                    <img src="{{ asset('img/undraw_profile_3.svg') }}" alt="HR_Photo" class="">
                </div>
                <div class="col-10 align-self-center">
                    <div class="hr-name">
                        <h5>Michaël Semilinko</h5>
                    </div>
                    <div class="hr-position">
                        <span>HR. Manager</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 p-3 p-lg-5">
            <div class="shadow-lg p-0 p-lg-3 mb-5 bg-body register-box">
                <div class="p-3">
                    <ul class="nav register-btn mb-3 row" id="pills-tab" role="tablist">
                        <li class="nav-item col" role="presentation">
                            <button class="btn nav-link active col-12" id="pills-seeker-tab" data-bs-toggle="pill" data-bs-target="#pills-seeker" type="button" role="tab" aria-controls="pills-seeker" aria-selected="true">JOB SEEKER</button>
                        </li>
                        <li class="nav-item col" role="presentation">
                            <button class="btn nav-link col-12" id="pills-employer-tab" data-bs-toggle="pill" data-bs-target="#pills-employer" type="button" role="tab" aria-controls="pills-employer" aria-selected="false">EMPLOYER</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-seeker" role="tabpanel" aria-labelledby="pills-seeker-tab">
                            <div class="py-3">
                                <article class="mx-auto">
                                    <form action="{{ route('seeker-register') }}" method="post">
                                        @csrf
                                        <div class="form-group input-group register-form-input p-2 my-3">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                                            </div>
                                            <input name="email" class="form-control border-0" placeholder="Enter Email" type="email" value="{{ old('email') }}" required>
                                        </div>
                                        <div class="form-group input-group register-form-input p-2 my-3">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-phone"></i> </span>
                                            </div>
                                            <input name="phone" class="form-control border-0" placeholder="Eg., 09xxxxxxxxx" type="number" value="{{ old('phone') }}">
                                        </div>
                                        
                                        <div class="form-group input-group register-form-input p-2 my-3">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-lock"></i> </span>
                                            </div>
                                            <input class="form-control border-0" placeholder="Create password" type="password" name="password" required>
                                        </div>
                                        <div class="form-group input-group register-form-input p-2 my-3">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                                            </div>
                                            <input class="form-control border-0" placeholder="Confirm password" type="password" name="confirmed" required>
                                        </div>   
                                        <div class="form-group input-group my-3">     
                                            <input type="checkbox" name="terms" id="terms" class="" required> <label style="font-size: 0.9rem" for="terms" class="ms-1 terms_link"> I agree with the <a href="#">Terms & Conditions</a> of Infinity</label>                              
                                        </div>
                                        <div class="form-group p-2">
                                            <button type="submit" class="btn col-12 btn-signup"> Sign Up  </button>
                                        </div>      
                                         
                                        <p class="text-center">Already Registered ? <a href="{{ route('login-form') }}" class="signIn_link">Sign In</a> </p>                                                                 
                                    </form>
                                </article>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-employer" role="tabpanel" aria-labelledby="pills-employer-tab">...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection