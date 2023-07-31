@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    <p>Someone requested that the password be reset for the following account:</p>
                    <a href="http://infinitycareers.com.mm/">infinitycareers.com.mm</a>
                    <p>
                        Username: {{ $first_name }} {{ $last_name }}<br>
                        If this was a mistake, just ignore this email and nothing will happen.<br>
                        To reset your password, visit the following address:<br>
                    </p>

                    <a href="{{ $reseturl }}">{{ $reseturl }}</a>

                </div>
                <div class="card-footer">
                    <p>Thanks</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection