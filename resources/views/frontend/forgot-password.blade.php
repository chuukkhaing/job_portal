@extends('frontend.layouts.app')
@section('content')

@php
    $route_name = Route::currentRouteName();
@endphp

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