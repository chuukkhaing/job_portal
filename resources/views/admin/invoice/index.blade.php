@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Invoices</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Invoices</h6>
            
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Invoice No.</th>
                            <th>Employer Name</th>
                            <th>Invoice Date</th>
                            <th>Status</th>
                            <th>Receipt</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $key => $invoice)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>
                            <a href="{{ route('employers.edit', $invoice->PointOrder->Employer->id) }}" class="text-decoration-none text-black">{{ $invoice->PointOrder->Employer->name }}</a>@if($invoice->PointOrder->Employer->is_verified == 1) <i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i> @endif
                            </td>
                            <td>{{ date('d-m-Y h:m:i', strtotime($invoice->created_at)) }}</td>
                            <td>
                                @if($invoice->status == 'Pending')
                                <span class="badge text-dark bg-warning">{{ $invoice->status }}</span>
                                @elseif($invoice->status == 'Paid')
                                <span class="badge text-light bg-success">{{ $invoice->status }}</span>
                                @elseif($invoice->status == 'Reject')
                                <span class="badge text-light bg-danger">{{ $invoice->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if(isset($invoice->receipt))
                                <a href="{{ getS3File('receipt',$invoice->receipt) }}" target="_blank" download data-bs-toggle="tooltip" data-bs-placement="top" title="Download Receipt" class="btn btn-success btn-circle btn-sm"><i class="fas fa-file-arrow-down"></i></a>
                                <a href="{{ route('send-receipt', $invoice->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Invoice" class="btn btn-success btn-circle btn-sm"><i class="fa-solid fa-paper-plane"></i></a>
                                @endif
                            </td>
                            <td>
                                @canany(['invoice-download', 'invoice-email-send'])
                                @can('invoice-download')
                                <a href="{{ getS3File('invoice',$invoice->file_name) }}" target="_blank" download data-bs-toggle="tooltip" data-bs-placement="top" title="Download Invoice" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-download"></i></a>
                                @endcan
                                @can('invoice-email-send')
                                <a href="{{ route('send-invoice', $invoice->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Invoice" class="btn btn-success btn-circle btn-sm"><i class="fa-solid fa-paper-plane"></i></a>
                                @endcan
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