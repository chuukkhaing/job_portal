@extends('frontend.layouts.app')
@section('content')

@php
    $route_name = Route::currentRouteName();
@endphp

<div class="container">
    <div class="py-3">
        <article class="mx-auto">
            @if($route_name == 'seeker-reset')
                <form action="{{ route('seeker-reset-post') }}" method="post">
                    <input type="hidden" name="id" value="{{ $id }}">
                    @csrf
                    <div class="form-group input-group register-form-input p-2 my-3">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control border-0" placeholder="Create password" type="password" name="password">
                    </div>

                    <div class="form-group input-group register-form-input p-2 my-3">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                        </div>
                        <input class="form-control border-0" placeholder="Confirm password" type="password" name="confirmed">
                    </div> 

                    <div class="form-group p-2">
                        <button type="submit" class="btn col-12 btn-signup"> Reset Password  </button>
                    </div>                                                             
                </form>
            @else
                <form action="{{ route('employer-reset-post') }}" method="post">
                    <input type="hidden" name="id" value="{{ $id }}">
                    @csrf
                    <div class="form-group input-group register-form-input p-2 my-3">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input class="form-control border-0" placeholder="Create password" type="password" name="company_password">
                    </div>

                    <div class="form-group input-group register-form-input p-2 my-3">
                        <div class="input-group-prepend d-flex">
                            <span class="input-group-text border-0 bg-transparent"> <i class="fa-solid fa-key"></i> </span>
                        </div>
                        <input class="form-control border-0" placeholder="Confirm password" type="password" name="company_confirmed">
                    </div>

                    <div class="form-group p-2">
                        <button type="submit" class="btn col-12 btn-signup"> Reset Password  </button>
                    </div>                                                             
                </form>
            @endif
        </article>
    </div>
</div>
@endsection