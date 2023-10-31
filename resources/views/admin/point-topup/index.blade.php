@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Point Topup</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Point Topup</h6>
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Employer</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Point Package</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $key => $order)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><a href="{{ route('employers.edit', $order->Employer->id) }}" class="text-decoration-none text-black">{{ $order->Employer->name }}</a>@if($order->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif</td>
                            <td>{{ $order->name }}</td>
                            <td><a href="tel:+{{ $order->phone }}" class="text-decoration-none text-black">{{ $order->phone }}</a></td>
                            <td>{{ $order->PointPackage->point }} Points - {{ $order->PointPackage->price }} MMK</td>
                            <td>
                                @if($order->status == 'Pending')
                                <span class="badge text-dark bg-warning">{{ $order->status }}</span>
                                @elseif($order->status == 'Approved')
                                <span class="badge text-light bg-success">{{ $order->status }}</span>
                                @elseif($order->status == 'Reject')
                                <span class="badge text-light bg-danger">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td>
                                @can('point-topup-edit')
                                <a href="{{ route('point-topup.edit', $order->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                                @endcan
                                
                            </td>
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