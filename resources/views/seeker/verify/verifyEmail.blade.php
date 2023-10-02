@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Account Activation') }}</div>

                <div class="card-body">
                    <p>Hi {{ $seeker->email }}</p>
                    <p>Welcome to Infinity Careers - Where Opportunities Await!</p>
                    <p>To start your job search journey, simply click the button below to activate your account:</p>
                    <a href="{{ route('seeker-verify',$seeker->email_verification_token) }}" class="btn btn-link p-0 m-0 align-baseline">
                    Activate Your Account
                    </a>
                    <p>With Infinity Careers, you'll discover exciting job opportunities and resources to boost your career. We're here to help you succeed.</p>
                    <p>If you have any questions, our support team is ready to assist you.</p>
                </div>
                <div class="card-footer">
                    <p>Thanks for choosing us!</p>
                    <p>Best Regards,</p>
                    <p>The Infinity Careers Team</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
