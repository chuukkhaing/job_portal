@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    @include('employer.profile.employer-sub-header') 
    <div class="container-fluid mt-1 py-3" id="edit-profile-header">
    <h5>Used Point History</h5>
        <div class="table-responsive">
            <table class="table table-hover table-sm" id="dataTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Job Post Title</th>
                        <th>Job Apply Seeker</th>
                        <th>Package Item Name</th>
                        <th>Point</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($point_records as $key => $point_record)
                    <tr>
                        <td>{{ $key+1 }}</td>
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