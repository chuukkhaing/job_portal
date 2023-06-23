@extends('frontend.layouts.app')

@section('content')
    <div class="container-fluid bg-light">
        <div class="container p-5 rounded text-center">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif

            Before proceeding, please check your email for a verification link. If you did not receive the email,
            <form action="{{ route('seeker-resend') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="email-resend-btn d-inline btn btn-link p-0">
                    click here to request another
                </button>.
            </form>
        </div>
    </div>
@endsection