@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    <div class="row employer-dashboard-header bg-light m-0">
        <div class="col-2 p-3">
            <a href="{{ route('employer-profile.index') }}">
            @if($employer->logo)
            <img src="{{ asset('storage/employer_logo/'.$employer->logo) }}" alt="Company Logo" class="employer-header-logo">
            @else
            <img src="{{ asset('img/employer/Vertical Logo.svg') }}" alt="Company Logo" class="employer-header-logo">
            @endif
            </a>
        </div>
        <div class="col-10 p-3">
            <div class="mb-4">
                <h4 class="fw-bold d-inline-block">Upgrade Your Package</h4>
                <div class="float-end">
                    {{--<a href="http://" class="btn btn-outline-primary">Add-on Features</a>--}}
                    <a data-bs-toggle="modal" data-bs-target="#cardModal" class="btn profile-save-btn text-light">Package Details</a>
                </div>
            </div>
            <p>Our packing pricing design allows you to choose the right package that best fits your business needs. We offer a variety of options, each with different features, points, and pricing. Simply select the package that works best for you, and our team will take care of the rest.</p>
            <div class="row">
                <div class="col-4 p-1">
                    <div class="economy p-3" @if($employer->Package && $employer->Package->name == "Economy Package") style="border: 1px solid #0565FF" @endif>
                        Economy
                        @if($employer->Package && $employer->Package->name == "Economy Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
                <div class="col-4 p-1">
                    <div class="standard p-3" @if($employer->Package && $employer->Package->name == "Standard Package") style="border: 1px solid #C72C91" @endif>
                        Standard
                        @if($employer->Package && $employer->Package->name == "Standard Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
                <div class="col-4 p-1">
                    <div class="premium p-3" @if($employer->Package && $employer->Package->name == "Premium Package") style="border: 1px solid #F58220" @endif>
                        Premium
                        @if($employer->Package && $employer->Package->name == "Premium Package")
                        <span class="float-end"><i class="fa-solid fa-check"></i></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-light mt-1 py-5" id="edit-profile-header">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Job Post Title</th>
                        <th>Job Apply Seeker</th>
                        <th>Package Item Name</th>
                        <th>Point</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($point_records as $point_record)
                    <tr>
                        <td>@if($point_record->job_post_id) {{ $point_record->JobPost->job_title }} @else - @endif</td>
                        <td>@if($point_record->job_apply_id) {{ $point_record->JobApply->Seeker->first_name }} {{ $point_record->JobApply->Seeker->last_name }} @else - @endif</td>
                        <td>{{ $point_record->PackageItem->name }}</td>
                        <td>{{ $point_record->point }}</td>
                        <td>{{ date('d-m-Y', strtotime($point_record->created_at)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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