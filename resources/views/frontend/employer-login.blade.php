@extends('frontend.layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 p-3 p-lg-5">
            <div class="register-header py-3">
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
            </div>
        </div>
        <div class="col-12 col-md-6 p-3 p-lg-5">
            <div class="shadow-lg p-0 p-lg-3 mb-5 bg-body register-box">
                <div class="p-3">
                    <ul class="nav register-btn mb-3 row">
                        <li class="nav-item col">
                            <a class="btn nav-link active col-12">EMPLOYER</a>
                        </li>
                    </ul>
                    <div class="">
                        <div class="fade show active">
                            <div class="py-3">
                                <article class="mx-auto">
                                    <form action="{{ route('employer-login') }}" method="post">
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
                                        <div class="form-group input-group register-form-input p-2 my-3">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                                            </div>
                                            <input name="company_email" class="form-control border-0 @error('company_email') is-invalid @enderror" placeholder="Enter Email" type="email" value="{{ old('company_email') }}">
                                        </div>
                                        @error('company_email')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="form-group input-group register-form-input p-2 my-3">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                                            </div>
                                            <input class="form-control border-0 @error('company_password') is-invalid @enderror" placeholder="Enter Password" type="password" name="company_password" id="company_password"><i style="cursor: pointer" id="company-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showCompanyPassword()"></i>
                                        </div>
                                        @error('company_password')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="my-3">     
                                            <input type="checkbox" name="company_remember" id="company_remember" {{ old('remember') ? 'checked' : '' }} class=""> <label style="font-size: 0.9rem" for="company_remember" class="ms-1 terms_link"> Remember Me</label>   
                                            <div class="float-end"><a href="{{ route('employer-forgot') }}" style="font-size: 0.9rem" class="ms-1 forger_password">Forgot Password? </a></div>          
                                        </div>
                                        <div class="form-group p-2">
                                            <button type="submit" class="btn col-12 btn-signup"> Sign In  </button>
                                        </div>      
                                         
                                        <p class="text-center">Don’t have an account yet ? <a href="{{ route('register-form') }}" class="signIn_link">Sign Up</a> </p>                                                                 
                                    </form>
                                </article>
                            </div>
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