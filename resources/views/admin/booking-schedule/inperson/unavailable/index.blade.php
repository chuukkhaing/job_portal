@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">In-Person Booking Unavailable Time</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">In-Person Booking Unavailable Time</h6>
            
            <div class="col">
                <a href="{{ route('close-inperson-booking-time.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New</span>
                </a>
            </div>
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Remark</th>
                            {{--<th>Action</th>--}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inpersonBookings as $key => $inpersonBooking)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ date('Y-m-d', strtotime($inpersonBooking->date)) }}</td>
                            <td>{{ $inpersonBooking->InPersonBookingTime->time }}</td>
                            <td>{{ $inpersonBooking->remark }}</td>
                            {{--<td>
                                
                                <a href="{{ route('close-inperson-booking-time.edit', $inpersonBooking->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                                
                                <form method="POST" action="{{ route('close-inperson-booking-time.destroy', $inpersonBooking->id) }}" class="d-inline">
                                    @csrf 
                                    @method('DELETE') 
                                        <button class="btn btn-danger btn-circle btn-sm delete-confirm text-light" type="submit"><i class="fas fa-trash"></i></button>
                                </form>
                                
                            </td>--}}
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