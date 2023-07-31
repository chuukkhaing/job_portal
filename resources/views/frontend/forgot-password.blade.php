@extends('frontend.layouts.app')
@section('content')

@php
    $route_name = Route::currentRouteName();
@endphp

<div class="container">
    <div class="py-3">
        <article class="mx-auto">
            <div class="m-auto col-6">
            @if($route_name == 'seeker-forgot')
                <form action="{{ route('seeker-forgot.post') }}" method="post">
                    @csrf
                    <div class="form-group input-group register-form-input p-2 my-3">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="email" class="bg-transparent form-control border-0" placeholder="Enter Email" type="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group p-2 text-center">
                        <button type="submit" style="width: 200px; padding: 10px" class="btn btn-sm col-12 btn-signup"> Reset Password  </button>
                    </div>                                                             
                </form>
            @else
                <form action="{{ route('employer-forgot.post') }}" method="post">
                    @csrf
                    <div class="form-group input-group register-form-input p-2 my-3">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-envelope"></i> </span>
                        </div>
                        <input name="company_email" class="bg-transparent form-control border-0" placeholder="Enter Email" type="email" value="{{ old('company_email') }}" required>
                    </div>
                    <div class="form-group p-2 text-center">
                        <button type="submit" style="width: 200px; padding: 10px" class="btn btn-sm col-12 btn-signup"> Reset Password  </button>
                    </div>                                                              
                </form>
            @endif
            </div>
        </article>
    </div>
</div>
@endsection