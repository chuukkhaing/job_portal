@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <p>Hi {{ $first_name }} {{ $last_name }},</p>
                    <p>Forgot your password? No worries! We're here to help you get back on track with your Infinity Careers account.</p>
                    <p>To reset your password, simply click the link below:</p>

                    <a href="{{ $reseturl }}" style="text-decoration: none; padding: 10px 20px; background: #0355D0; color: #fff; border-radius: 8px; box-shadow: 5px 5px 10px 0px rgba(0,0,0,0.2); margin: 5px 0;">Reset Password</a>

                    <p>If you run into any issues or need further assistance, don't hesitate to reach out to our support team at <a href="mailto:support@infinitycareers.com.mm" style="text-decoration: none">support@infinitycareers.com.mm</a>.</p>
                    <p>We're here to make your job search journey as smooth as possible.</p>
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