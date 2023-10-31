@extends('frontend.layouts.app')

@section('content')
    <div class="container-fluid bg-light">
        <div class="container p-5 rounded text-center">
            Before proceeding, please check your email for a verification link. If you did not receive the email,
            <a href="{{ route('employer-resend', $id) }}" class="email-resend-btn d-inline p-0">click here to request another.</a>
        </div>
    </div>
@endsection