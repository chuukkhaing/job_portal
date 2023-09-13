@extends('frontend.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="container m-auto" >
                <form action="">
                    <div class="col-12 col-md-6">
                        @if(Auth::guard('seeker')->user()->image)
                        <img src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                        @else
                        <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Profile Image" class="seeker-profile rounded-circle" id="ProfilePreview">
                        @endif
                        <button type="button" class="position-absolute btn btn-danger btn-sm rounded-circle @if(Auth::guard('seeker')->user()->image) @else d-none @endif  profile-remove"><i class="fa-solid fa-xmark"></i></button>
                        <input type="file" name="image" id="seeker_profile_upload" accept="image/*" class="seeker_image_input">
                        <label for="seeker_profile_upload" class="seeker_image_input_label mx-5 border">Upload profile image</label>
                        <input type="hidden" name="imageStatus" id="imageStatus" value="">
                    </div>
                </form>
            </div>
        </div>
        <div class="col">

        </div>
    </div>
</div>
@endsection