@extends('frontend.layouts.app')
@section('content')

@if ($message = Session::get('success'))
<div class="container-fluid alert-success m-0">
    <div class="container m-auto m-0 alert alert-success border-0 d-flex align-items-center" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </svg>
        <div>
        {{ $message }}
        </div>
    </div>
</div>

@endif

<div class="container-fluid login-page">
    <div class="row container m-auto p-0 m-0 d-flex justify-content-center">
        <div class="col-12 col-md-6 p-3 p-lg-5">
            <div class="register-header p-3">
                <h2 class="">Welcome Back!</h2>
                {{--<h5>Please sign in to continue your job search journey</h5>--}}
            </div>
            <div class="hr-speech p-3">
                <div class="open-quote d-inline-block my-3">
                    <i class="fa-solid fa-quote-left"></i>
                </div>
                <p class="py-3 fw-bold">
                "Embark on Your Career Odyssey with Infinity Careers. From Fresh Graduates Aiming to Spread Their Wings, Entry-Level Enthusiasts Seeking Their Niche, Experienced Professionals Looking to Elevate, to Visionary Executives Ready to Lead – Our Portal Offers a Diverse Tapestry of Opportunities. We Believe Every Career Story Deserves a Chance to Shine, and We're Here to Illuminate the Path Ahead. Join Infinity Careers Today and Unlock the Door to Your Next Chapter."
                </p>
                
            </div>
            {{--<div class="row">
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
            </div>--}}
        </div>
        <div class="col-12 col-md-6 col-lg-4 align-self-end p-2 p-xl-5">
            <div class="shadow p-0 my-5 bg-body register-box">
                <div class="p-3">
                    <ul class="nav register-btn mb-3 row">
                        <li class="nav-item col">
                            <a class="btn nav-link active col-12">JOB SEEKER</a>
                        </li>
                    </ul>
                    <div class="">
                        <div class="fade show active">
                            <article class="mx-auto">
                                <form action="{{ route('seeker-login') }}" method="post">
                                    @csrf
                                    @if ($message = Session::get('error'))
                                    <div class="container-fluid alert-danger m-0">
                                        <div class="container m-auto m-0 alert alert-danger border-0 alert-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
                                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                            </svg>
                                            {{ $message }}
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group input-group register-form-input p-1 my-2">
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
                                    <div class="form-group input-group register-form-input p-1 my-2">
                                        <div class="input-group-prepend d-flex">
                                            <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                                        </div>
                                        <input class="form-control border-0 @error('password') is-invalid @enderror" placeholder="Enter Password" type="password" name="password" id="password"><i style="cursor: pointer" id="seeker-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showSeekerPassword()"></i>
                                    </div>
                                    @error('password')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <div class="my-2">     
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="" > <label style="font-size: 0.9rem" for="remember" class="ms-1 terms_link"> Remember Me</label>   
                                        <div class="float-end"><a href="{{ route('seeker-forgot') }}" style="font-size: 0.9rem" class="ms-1 forger_password">Forgot Password? </a></div>          
                                    </div>
                                    <div class="form-group p-1">
                                        <button type="submit" class="btn col-12 btn-signup"> {{ __('message.Sign In') }}  </button>
                                    </div>      
                                        
                                    <p class="text-center">Don’t have an account yet ? <a href="{{ route('register-form') }}" class="signIn_link">{{ __('message.Sign Up') }}</a> </p>                                                                 
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
</script>
@endpush