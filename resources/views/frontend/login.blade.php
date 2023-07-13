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
                                    <form action="{{ route('seeker-login') }}" method="post">
                                        @csrf
                                        <div class="form-group input-group register-form-input p-2 my-3">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                                            </div>
                                            <input name="email" class="form-control border-0" placeholder="Enter Email" type="email" value="{{ old('email') }}" required>
                                        </div>
                                        
                                        <div class="form-group input-group register-form-input p-2 my-3">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                                            </div>
                                            <input class="form-control border-0" placeholder="Create password" type="password" name="password" required>
                                        </div>
                                        
                                        <div class="my-3">     
                                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class=""> <label style="font-size: 0.9rem" for="remember" class="ms-1 terms_link"> Remember Me</label>   
                                            <div class="float-end"><a href="{{ route('seeker-forgot') }}" style="font-size: 0.9rem" class="ms-1 forger_password">Forgot Password? </a></div>          
                                        </div>
                                        <div class="form-group p-2">
                                            <button type="submit" class="btn col-12 btn-signup"> Sign In  </button>
                                        </div>      
                                         
                                        <p class="text-center">Don’t have an account yet ? <a href="{{ route('register-form') }}" class="signIn_link">Sign Up</a> </p>                                                                 
                                    </form>
                                </article>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-employer" role="tabpanel" aria-labelledby="pills-employer-tab">
                            <div class="py-3">
                                <article class="mx-auto">
                                    <form action="{{ route('employer-login') }}" method="post">
                                        @csrf
                                        <div class="form-group input-group register-form-input p-2 my-3">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                                            </div>
                                            <input name="company_email" class="form-control border-0" placeholder="Enter Email" type="email" value="{{ old('company_email') }}" required>
                                        </div>
                                        
                                        <div class="form-group input-group register-form-input p-2 my-3">
                                            <div class="input-group-prepend d-flex">
                                                <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                                            </div>
                                            <input class="form-control border-0" placeholder="Create password" type="password" name="company_password" required>
                                        </div>
                                        
                                        <div class="my-3">     
                                            <input type="checkbox" name="company_remember" id="remember" {{ old('remember') ? 'checked' : '' }} class=""> <label style="font-size: 0.9rem" for="remember" class="ms-1 terms_link"> Remember Me</label>   
                                            <div class="float-end"><a href="#" style="font-size: 0.9rem" class="ms-1 forger_password">Forgot Password? </a></div>          
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