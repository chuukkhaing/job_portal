@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard my-3">
    @include('employer.profile.employer-sub-header')
    <div class="p-3">
        <form action="{{ route('buy-point.create') }}">
            <div class="col-12 col-md-6 m-auto">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="name" class="seeker_label my-2">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control seeker_input @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}">
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="name" class="seeker_label my-2">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="form-control seeker_input @error('phone') is-invalid @enderror" placeholder="Phone" value="{{ old('phone') }}">
                        @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
</div>
@endsection