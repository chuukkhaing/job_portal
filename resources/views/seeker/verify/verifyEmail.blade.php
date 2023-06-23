@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    <p>Your account has been created, please activate your account by clicking this link</p>
                    <a href="{{ route('seeker-verify',$seeker->email_verification_token) }}" class="btn btn-link p-0 m-0 align-baseline">
                    Activate Your Account
                    </a>
                </div>
                <div class="card-footer">
                    <p>Thanks</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
