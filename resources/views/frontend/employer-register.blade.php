@extends('frontend.layouts.app')
@section('content')

<div class="container-fluid employer-login-page">
    <div class="row container m-auto p-0 m-0 d-flex justify-content-center">
        <div class="col-12 col-md-6 p-3 p-lg-5">
            {{--<div class="register-header py-3">
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
            </div>--}}
        </div>
        <div class="col-12 col-md-6 col-lg-4 align-self-end p-2 p-xl-5">
            <div class="shadow p-0 my-5 bg-body register-box">
                <div class="p-3">
                    <ul class="nav register-btn mb-3 row">
                        <li class="nav-item col">
                            <a class="btn nav-link active col-12">Employer</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active">
                            <article class="mx-auto">
                                <form action="{{ route('employer-register') }}" method="post">
                                    @csrf
                                    <div class="form-group input-group register-form-input p-1 my-2">
                                        <input name="company_name" class="form-control border-0 @error('company_name') is-invalid @enderror" placeholder="Company Name" type="text" value="{{ old('company_name') }}" >
                                    </div>
                                    @error('company_name')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <div class="form-group input-group my-2 industry_id">
                                        <select name="industry_id" id="industry_id" class="border-0 @error('industry_id') is-invalid @enderror industry_id" style="width: 100%" >
                                            <option value="">Select Industry</option>
                                            @foreach($industries as $industry)
                                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('industry_id')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <div class="form-group input-group register-form-input p-1 my-2">
                                        <input name="company_email" class="form-control border-0 @error('company_email') is-invalid @enderror" placeholder="Company Email" type="email" value="{{ old('company_email') }}" >
                                    </div>
                                    @error('company_email')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <div class="form-group input-group register-form-input p-1 my-2">
                                        <input name="company_phone" class="form-control border-0 @error('company_phone') is-invalid @enderror" placeholder="Eg., 09xxxxxxxxx" type="number" value="{{ old('company_phone') }}">
                                    </div>
                                    @error('company_phone')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <div class="form-group input-group register-form-input p-1 my-2">
                                        <input class="form-control border-0 @error('company_password') is-invalid @enderror" placeholder="Create password" type="password" name="company_password" id="company_password"><i style="cursor: pointer" id="company-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showCompanyPassword()"></i>
                                    </div>
                                    @error('company_password')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <div class="form-group input-group register-form-input p-1 my-2">
                                        <input class="form-control border-0 @error('company_confirmed') is-invalid @enderror" placeholder="Confirm password" type="password" name="company_confirmed" id="company_confirm_password"><i style="cursor: pointer" id="company-confirm-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showCompanyConfirmPassword()"></i>
                                    </div>   
                                    @error('company_confirmed')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                    <div class="form-group input-group input-group my-2">     
                                        <input type="checkbox" name="employer_terms" id="employer_terms" class="" style="width: 15px" required> <label style="font-size: 0.9rem" for="employer_terms" class="mt-2 ms-1 terms_link"> I agree with the <a href="{{ route('terms-of-use') }}">Terms & Conditions</a> of Infinity Careers</label>                              
                                    </div>
                                    <div class="form-group p-1">
                                        <button type="submit" class="btn col-12 btn-signup"> {{ __('message.Sign Up') }}  </button>
                                    </div>      
                                        
                                    <p class="text-center">Already Sign Up ? <a href="{{ route('employer-login-form') }}" class="signIn_link">{{ __('message.Sign In') }}</a> </p>                                                                 
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

    function showCompanyConfirmPassword() {
        var companyConfirmPassword = document.getElementById("company_confirm_password");
        if (companyConfirmPassword.type === "password") {
            companyConfirmPassword.type = "text";
            $("#company-confirm-password-eye").removeClass('bi-eye-slash');
            $("#company-confirm-password-eye").addClass('bi-eye');
        } else {
            companyConfirmPassword.type = "password";
            $("#company-confirm-password-eye").addClass('bi-eye-slash');
            $("#company-confirm-password-eye").removeClass('bi-eye');
        }
    }
</script>
@endpush