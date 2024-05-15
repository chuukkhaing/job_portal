@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Online Booking</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Online Booking</h6>
            
            
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>description</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Remark</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $key => $booking)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $booking->name }}</td>
                            <th>{{ $booking->company_name ?? '-' }}</th>
                            <td><a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a></td>
                            <td><a href="tel:+{{ $booking->phone }}">{{ $booking->phone }}</a></td>
                            <td>{{ $booking->remark ?? '-' }}</td>
                            <td>{{ date('Y-m-d', strtotime($booking->date)) }}</td>
                            <td>{{ $booking->OnlineBookingTime->time }}</td>
                            <td>{{ $booking->remark }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection