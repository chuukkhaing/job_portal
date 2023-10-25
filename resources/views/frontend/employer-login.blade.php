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

<div class="container-fluid employer-login-page">
    <div class="row container m-auto p-0 m-0 d-flex justify-content-center">
        <div class="col-12 col-md-6 p-3 p-lg-5">
            {{--<div class="register-header py-3">
                <h2 class="">Welcome Back!</h2>
                <h5>Please sign in to continue your job search journey</h5>
            </div>
            <div class="hr-speech py-3">
                <div class="open-quote d-inline-block my-3">
                    <i class="fa-solid fa-quote-left"></i>
                </div>
                <p class="py-3">
                "Compose a text review on the sign-in form for job seekers website to provide feedback on the recommended tips to increase the chances of getting good job offers."<br><br>

                "Include relevant skills, keep your profile up-to-date, and use keywords to increase your chances of being noticed by potential employers on the job seeker website."
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
            </div>--}}
        </div>
        <div class="col-12 col-md-6 col-lg-4 align-self-end p-2 p-xl-5">
            <div class="shadow p-0 my-5 bg-body register-box">
                <div class="p-3">
                    <ul class="nav register-btn mb-3 row">
                        <li class="nav-item col">
                            <a class="btn nav-link active col-12">EMPLOYER</a>
                        </li>
                    </ul>
                    <div class="">
                        <div class="fade show active">
                            <article class="mx-auto">
                                <form action="{{ route('employer-login') }}" method="post">
                                    @csrf
                                    
                                    <div class="form-group input-group register-form-input p-1 my-2">
                                        <div class="input-group-prepend d-flex">
                                            <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                                        </div>
                                        <input name="company_email" class="form-control border-0 @error('company_email') is-invalid @enderror" placeholder="Enter Email" type="email" value="{{ old('company_email') }}">
                                    </div>
                                    @error('company_email')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <div class="form-group input-group register-form-input p-1 my-2">
                                        <div class="input-group-prepend d-flex">
                                            <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                                        </div>
                                        <input class="form-control border-0 @error('company_password') is-invalid @enderror" placeholder="Enter Password" type="password" name="company_password" id="company_password"><i style="cursor: pointer" id="company-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showCompanyPassword()"></i>
                                    </div>
                                    @error('company_password')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <div class="my-2">     
                                        <input type="checkbox" name="company_remember" id="company_remember" {{ old('remember') ? 'checked' : '' }} class="" > <label style="font-size: 0.9rem" for="company_remember" class="ms-1 terms_link"> Remember Me</label>   
                                        <div class="float-end"><a href="{{ route('employer-forgot') }}" style="font-size: 0.9rem" class="ms-1 forger_password">Forgot Password? </a></div>          
                                    </div>
                                    <div class="form-group p-1">
                                        <button type="submit" class="btn col-12 btn-signup"> Sign In  </button>
                                    </div>      
                                        
                                    <p class="text-center">Don’t have an account yet ? Free <a href="{{ route('employer-register-form') }}" class="signIn_link">Sign Up</a></p>                                                                 
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

    function showCompanyPassword() {
        var companyPassword = document.getElementById("company_password");
        if (companyPassword.type === "password") {
            companyPassword.type = "text";
            $("#company-password-eye").removeClass('bi-eye-slash');
            $("#company-password-eye").addClass('bi-eye');
        } else {
            companyPassword.type = "password";
            $("#company-password-eye").addClass('bi-eye-slash');
            $("#company-password-eye").removeClass('bi-eye');
        }
    }
</script>
@endpush