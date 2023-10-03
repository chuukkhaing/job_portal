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
        <div class="col-12 col-md-6 p-lg-5">
            <div class="shadow-lg p-0 p-lg-3 mb-5 bg-body register-box">
                <div class="p-3">
                    <ul class="nav register-btn mb-3 row">
                        <li class="nav-item col">
                            <a class="btn nav-link active col-12">JOB SEEKER</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active">
                            <article class="mx-auto">
                                <form action="{{ route('seeker-register') }}" method="post">
                                    @csrf
                                    <div class="my-2">
                                        <div class="form-group input-group register-form-input p-1 mb-0">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                                            </div>
                                            <input name="email" class="form-control border-0 @error('email') is-invalid @enderror" placeholder="Enter Email" type="email" value="{{ old('email') }}">
                                        </div>

                                        @error('email')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                    
                                    <div class="my-2">
                                        <div class="form-group input-group register-form-input p-1 mb-0">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-phone"></i> </span>
                                            </div>
                                            <input name="phone" class="form-control border-0 @error('phone') is-invalid @enderror" placeholder="Eg., 09xxxxxxxxx" type="number" value="{{ old('phone') }}">
                                        </div>
                                        @error('phone')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                    
                                    <div class="my-2">
                                        <div class="form-group input-group register-form-input p-1 mb-0">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-lock"></i> </span>
                                            </div>
                                            <input class="form-control border-0  @error('password') is-invalid @enderror" placeholder="Create password" type="password" name="password" id="password"><i style="cursor: pointer" id="seeker-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showSeekerPassword()"></i>
                                        </div>

                                        @error('password')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>

                                    <div class="my-2">
                                        <div class="form-group input-group register-form-input p-1 mb-0">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                                            </div>
                                            <input class="form-control border-0 @error('confirmed') is-invalid @enderror" placeholder="Confirm password" type="password" name="confirmed" id="confirmPassword"><i style="cursor: pointer" id="seeker-confirm-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showSeekerConfirmPassword()"></i>
                                        </div>  
                                        @error('confirmed')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                    <div class="my-2">
                                        <div class="form-group input-group">     
                                            <input type="checkbox" name="terms" id="terms" class="" style="width: 15px" required> <label style="font-size: 0.9rem" for="terms" class="mt-2 ms-1 terms_link"> I agree with the <a href="{{ route('terms-of-use') }}">Terms & Conditions</a> of Infinity Careers </label>                              
                                        </div>
                                        <div class="form-group p-1">
                                            <button type="submit" class="btn col-12 btn-signup"> Sign Up  </button>
                                        </div>
                                    </div>    
                                        
                                    <p class="text-center">Already Sign Up ? <a href="{{ route('login-form') }}" class="signIn_link">Sign In</a> </p>                                                                 
                                </form>
                            </article>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    
    function showSeekerPassword() {
        var seekerPassword = document.getElementById("password");
        if (seekerPassword.type === "password") {
            seekerPassword.type = "text";
            $("#seeker-password-eye").removeClass('bi-eye-slash');
            $("#seeker-password-eye").addClass('bi-eye');
        } else {
            seekerPassword.type = "password";
            $("#seeker-password-eye").addClass('bi-eye-slash');
            $("#seeker-password-eye").removeClass('bi-eye');
        }
    }

    function showSeekerConfirmPassword() {
        var seekerConfirmPassword = document.getElementById("confirmPassword");
        if (seekerConfirmPassword.type === "password") {
            seekerConfirmPassword.type = "text";
            $("#seeker-confirm-password-eye").removeClass('bi-eye-slash');
            $("#seeker-confirm-password-eye").addClass('bi-eye');
        } else {
            seekerConfirmPassword.type = "password";
            $("#seeker-confirm-password-eye").addClass('bi-eye-slash');
            $("#seeker-confirm-password-eye").removeClass('bi-eye');
        }
    }
</script>
@endpush