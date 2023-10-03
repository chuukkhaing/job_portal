@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Account Activation') }}</div>

                <div class="card-body">
                    <p>Dear {{ $employer->name }},</p>
                    <p>Welcome to Infinity Careers – Your Gateway to Top Talent!</p>
                    <p>We're delighted to have you join our platform as an employer. To start connecting with top-tier talent and unlocking the full potential of your account, all you need to do is activate it.</p>
                    <p>Click the button below to activate your employer account:</p>

                    <a href="{{ route('employer-verify',$employer->email_verification_token) }}" style="text-decoration: none; padding: 10px 20px; background: #0355D0; color: #fff; border-radius: 8px; box-shadow: 5px 5px 10px 0px rgba(0,0,0,0.2); margin: 5px 0;">Activate Your Account</a>

                    <p>At Infinity Careers, we're committed to helping your business thrive by connecting you with exceptional talent. Whether you're a small startup or a large corporation, we have the tools and resources to meet your recruitment needs.</p>

                    <p>Should you have any questions or require assistance, our dedicated support team is here to assist you. Feel free to reach out to us at <a style="text-decoration: none" href="mailto:support@infinitycareers.com.mm">support@infinitycareers.com.mm</a>.</p>

                    <p>Thank you for choosing Infinity Careers. We're excited to support your hiring endeavors!</p>
                </div>
                <div class="card-footer">
                    <p>Best Regards,</p>
                    <p>The Infinity Careers Team</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
