@extends('frontend.layouts.app')
@section('content')

@php
    $route_name = Route::currentRouteName();
@endphp

<div class="container">
    <div class="py-3">
        <article class="mx-auto">
            @if($route_name == 'seeker-reset')
                <form action="{{ route('seeker-reset-post') }}" method="post">
                    <input type="hidden" name="id" value="{{ $id }}">
                    @csrf
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <div class="form-group input-group register-form-input p-2">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control border-0" placeholder="Create password" type="password" name="password" id="password" required><i style="cursor: pointer" id="seeker-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showPassword()"></i>
                    </div>
                    <label for="confirmPassword">Confirm Password <span class="text-danger">*</span></label>
                    <div class="form-group input-group register-form-input p-2">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                        </div>
                        <input class="form-control border-0" placeholder="Confirm password" type="password" name="confirmed" id="confirmPassword" required><i style="cursor: pointer" id="seeker-confirm-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showConfirmPassword()"></i>
                    </div> 

                    <div class="form-group p-2">
                        <button type="submit" class="btn col-12 btn-signup"> Reset Password  </button>
                    </div>                                                             
                </form>
            @else
                <form action="{{ route('employer-reset-post') }}" method="post">
                    <input type="hidden" name="id" value="{{ $id }}">
                    @csrf
                    <label for="company_password">Password <span class="text-danger">*</span></label>
                    <div class="form-group input-group register-form-input p-2">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control border-0" placeholder="Create password" type="password" name="company_password" id="company_password" required><i style="cursor: pointer" id="company-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showCompanyPassword()"></i>
                    </div>
                    <label for="company_confirm_password">Confirm Password <span class="text-danger">*</span></label>
                    <div class="form-group input-group register-form-input p-2">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                        </div>
                        <input class="form-control border-0" placeholder="Confirm password" type="password" name="company_confirmed" id="company_confirm_password" required><i style="cursor: pointer" id="company-confirm-password-eye" class="bi bi-eye-slash ms-5 mt-2" onclick="showCompanyConfirmPassword()"></i>
                    </div>

                    <div class="form-group p-2">
                        <button type="submit" class="btn col-12 btn-signup"> Reset Password  </button>
                    </div>                                                             
                </form>
            @endif
        </article>
    </div>
</div>
@endsection
@push('scripts')
<script>
    
    function showPassword() {
        var Password = document.getElementById("password");
        if (Password.type === "password") {
            Password.type = "text";
            $("#-password-eye").removeClass('bi-eye-slash');
            $("#-password-eye").addClass('bi-eye');
        } else {
            Password.type = "password";
            $("#-password-eye").addClass('bi-eye-slash');
            $("#-password-eye").removeClass('bi-eye');
        }
    }

    function showConfirmPassword() {
        var ConfirmPassword = document.getElementById("confirmPassword");
        if (ConfirmPassword.type === "password") {
            ConfirmPassword.type = "text";
            $("#-confirm-password-eye").removeClass('bi-eye-slash');
            $("#-confirm-password-eye").addClass('bi-eye');
        } else {
            ConfirmPassword.type = "password";
            $("#-confirm-password-eye").addClass('bi-eye-slash');
            $("#-confirm-password-eye").removeClass('bi-eye');
        }
    }

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