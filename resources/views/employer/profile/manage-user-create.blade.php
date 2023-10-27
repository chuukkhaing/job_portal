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
                <div class="col">
                    <a href="{{ route('member-user.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                        <span class="icon text-white-50">
                            <i class="fas fa-reply"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                </div>
                
            </div>
            <div class="card-body">
                <form action="{{ route('member-user.store') }}" method="post" enctype="multipart/form-data">
                    @csrf 
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">

                        <div class="col-6 form-group">
                            <label for="email">Member Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Member Email" required value="{{ old('email') }}">
                        </div>

                        <div class="col-6 form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required value="">
                        </div>

                        <div class="col-6 form-group">
                            <label for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="datepicker form-control" name="confirm-password" id="confirm-password" placeholder="Enter Password" required value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                            <input type="radio" name="is_active" id="active" class="" value="1" checked required> <label for="active"> Active</label><br>
                            <input type="radio" name="is_active" id="in_active" class="" value="0"> <label for="in_active"> In Active</label>
                        </div>
                        <div class="col-6 form-group">
                            <label for="permission">Permission Access </label> <br>
                            <div class="row">
                                <div class="col-6">
                                    <input type="checkbox" name="dashboard" id="dashboard">
                                    <label for="dashboard">Employer Dashboard</label>
                                </div>
                                <div class="col-6">
                                    <input type="checkbox" name="profile" id="profile">
                                    <label for="profile">Employer Profile</label>
                                </div>
                                <div class="col-6">
                                    <input type="checkbox" name="manage_job" id="manage_job">
                                    <label for="manage_job">Manage Job</label>
                                </div>
                                <div class="col-6">
                                    <input type="checkbox" name="application_tracking" id="application_tracking">
                                    <label for="application_tracking">Application Tracking</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($packageItems as $packageItem)
                    @if($packageItem->name == 'Up to 10 User Accounts' || $packageItem->name == 'Up to 5 User Accounts')
                    <input type="hidden" name="package_item_id" value="{{ $packageItem->id }}">
                    <input type="hidden" name="package_item_point" value="{{ $packageItem->point }}">
                    @endif
                    @endforeach
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