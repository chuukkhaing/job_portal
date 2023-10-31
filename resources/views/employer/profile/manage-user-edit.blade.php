@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    @include('employer.profile.employer-sub-header')
    <div class="container-fluid mt-1 py-5" id="edit-profile-header">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Member Create</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="row card-header py-3 m-0">
                @if(Auth::guard('employer')->user()->employer_id == Null)
                <div class="col">
                    <a href="{{ route('member-user.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                        <span class="icon text-white-50">
                            <i class="fas fa-reply"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                </div>
                @else
                <div class="col">
                    <a href="{{ route('employer-profile.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                        <span class="icon text-white-50">
                            <i class="fas fa-reply"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                </div>
                @endif
            </div>
            <div class="card-body">
                <form action="{{ route('member-user.update', $member->id) }}" method="post" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')
                    
                    <div class="row">

                        <div class="col-6 form-group">
                            <label for="email">Member Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter Member Email" value="{{ $member->email }}">
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Enter Password" value="">
                            @error('password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-6 form-group">
                            <label for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="datepicker form-control @error('confirm-password') is-invalid @enderror" name="confirm-password" id="confirm-password" placeholder="Enter Password" value="">
                            @error('confirm-password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        @if(Auth::guard('employer')->user()->employer_id == Null)
                        @if($member->employer_id)
                        <div class="col-6 form-group">
                            <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                            <input type="radio" name="is_active" id="active" class="" value="1" @if($member->is_active == 1) checked required @endif> <label for="active"> Active</label><br>
                            <input type="radio" name="is_active" id="in_active" class="" value="0" @if($member->is_active == 0) checked required @endif> <label for="in_active"> In Active</label>
                            @error('is_active')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="col-6 form-group">
                            <label for="permission">Permission Access <span class="text-danger">*</span></label> <br>
                            <div class="row">
                                <div class="col-6">
                                    <input type="checkbox" name="dashboard" id="dashboard" @if($member->MemberPermission->where('name','dashboard')->count() == 1) checked @endif>
                                    <label for="dashboard">Employer Dashboard</label>
                                </div>
                                <div class="col-6">
                                    <input type="checkbox" name="profile" id="profile" @if($member->MemberPermission->where('name','profile')->count() == 1) checked @endif>
                                    <label for="profile">Employer Profile</label>
                                </div>
                                <div class="col-6">
                                    <input type="checkbox" name="manage_job" id="manage_job" @if($member->MemberPermission->where('name','manage_job')->count() == 1) checked @endif>
                                    <label for="manage_job">Manage Job</label>
                                </div>
                                <div class="col-6">
                                    <input type="checkbox" name="application_tracking" id="application_tracking" @if($member->MemberPermission->where('name','application_tracking')->count() == 1) checked @endif>
                                    <label for="application_tracking">Application Tracking</label>
                                </div>
                                @if($errors->has('dashboard'))
                                    <small class="text-danger">{{ $errors->first('dashboard') }}</small>
                                @elseif($errors->has('profile'))
                                    <small class="text-danger">{{ $errors->first('profile') }}</small>
                                @elseif($errors->has('manage_job'))
                                    <small class="text-danger">{{ $errors->first('manage_job') }}</small>
                                @elseif($errors->has('application_tracking'))
                                    <small class="text-danger">{{ $errors->first('application_tracking') }}</small>
                            @endif
                            </div>
                        </div>
                        @endif
                        @endif
                    </div>
                    <button class="btn btn-primary btn-icon-split btn-sm" type="submit">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Save</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
@push('css')
    <style>
        .modal-dialog {
            max-width: 80%;
        }
    </style>
@endpush