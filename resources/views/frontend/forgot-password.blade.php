@extends('frontend.layouts.app')
@section('content')

@php
    $route_name = Route::currentRouteName();
@endphp
@include('frontend.layouts.alert')
@if ($message = Session::get('error'))
<div class="container-fluid alert-danger m-0">
    <div class="container m-auto m-0 alert alert-danger border-0 alert-block">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
        {{ $message }}
    </div>
</div>
@endif
<div class="container">
    <div class="py-3">
        <article class="mx-auto">
            <div class="m-auto col-md-6 col-lg-4 col-12">
            @if($route_name == 'seeker-forgot')
                <form action="{{ route('seeker-forgot.post') }}" method="post">
                    @csrf
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <div class="form-group input-group register-form-input p-1 my-1">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email" class="bg-transparent form-control border-0 @error('email') is-invalid @enderror" placeholder="Enter Email" type="email" id="email" value="{{ old('email') }}" >
                        
                    </div>
                    @error('email')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <div class="form-group p-1 text-center">
                        <button type="submit" style="width: 200px; padding: 10px" class="btn btn-sm col-12 btn-signup"> Reset Password  </button>
                    </div>                                                             
                </form>
            @else
                <form action="{{ route('employer-forgot.post') }}" method="post">
                    @csrf
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <div class="form-group input-group register-form-input p-1 my-1">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="company_email" class="bg-transparent form-control border-0 @error('company_email') is-invalid @enderror" placeholder="Enter Email" type="email" value="{{ old('company_email') }}" >
                    </div>
                    @error('company_email')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                    <div class="form-group p-1 text-center">
                        <button type="submit" style="width: 200px; padding: 10px" class="btn btn-sm col-12 btn-signup"> Reset Password  </button>
                    </div>                                                              
                </form>
            @endif
            </div>
        </article>
    </div>
</div>
@endsection