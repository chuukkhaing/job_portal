@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard my-3">
    @include('employer.profile.employer-sub-header')
    <div class="p-3">
        <h2 class="m-auto text-center">Buy Point Form</h2>
        <form action="{{ route('buy-point.store') }}" method="POST">
            @csrf
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
                    <div class="form-group col-12">
                        <div class="card h-100">
                            <div class="card-body">
                                @foreach($pointPackages as $pointPackage)
                                <label class="card-radio-btn" for="pointPackage-{{ $pointPackage->id }}">
                                    <input type="radio" name="point_package_id" class="card-input-element d-none" id="pointPackage-{{ $pointPackage->id }}" @if($loop->first || (old('point_package_id') == $pointPackage->id)) checked @endif value="{{ $pointPackage->id }}">
                                    <div class="card card-body">
                                        <div class="content_head">{{ number_format($pointPackage->point) }} Points</div>
                                        <div class="content_sub">{{ number_format($pointPackage->price) }} MMK</div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn profile-save-btn btn-sm">Confirm</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection