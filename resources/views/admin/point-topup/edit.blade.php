@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Point Topup</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Point Topup Edit</h6>
            <div class="col">
                <a href="{{ route('point-topup.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('point-topup.update', $order->id) }}" method="post">
                @csrf 
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required value="{{$order->name}}" readonly>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone" required value="{{ $order->phone }}" readonly>
                </div>

                <div class="form-group">
                    <label for="employer">Employer <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="employer" id="employer" placeholder="Enter employer" required value="{{ $order->Employer->name }}" readonly>
                </div>

                <div class="form-group">
                    <label for="point_package_id">Point Package <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="point_package_id" id="point_package_id" placeholder="Enter Point Package" required value="{{ $order->PointPackage->point }} Points - {{ $order->PointPackage->price }} MMK" readonly>
                </div>
                
                <div class="col-12">
                    <button type="button" class="btn btn-approve @if($order->status == 'Approved') btn-success @else btn-outline-success @endif">Approve <i class="approve-icon fa-solid fa-check @if($order->status == 'Approved') @else d-none @endif"></i></button>
                    <button type="button" class="btn btn-reject @if($order->status == 'Reject') btn-danger @else btn-outline-danger @endif">Reject <i class="reject-icon fa-solid fa-check @if($order->status == 'Reject') @else d-none @endif"></i></button>
                </div>
                <input type="hidden" name="status" id="order_status" value="">
                <button type="submit" class="btn btn-primary d-none" id="update_submit">Update</button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
@push('script')
<script>
    $(".btn-approve").click(function(){
        $(this).removeClass('btn-outline-success');
        $(this).addClass('btn-success');
        $('.approve-icon').removeClass('d-none');
        $('.btn-reject').removeClass('btn-danger');
        $('.btn-reject').addClass('btn-outline-danger');
        $('.reject-icon').addClass('d-none');
        $('#order_status').val('Approved');
        updateStatus();
    })

    $(".btn-reject").click(function(){
        $(this).removeClass('btn-outline-danger');
        $(this).addClass('btn-danger');
        $('.reject-icon').removeClass('d-none');
        $('.btn-approve').removeClass('btn-success');
        $('.btn-approve').addClass('btn-outline-success');
        $('.approve-icon').addClass('d-none');
        $('#order_status').val('Reject');
        updateStatus();
    })

    function updateStatus()
    {
        $("#update_submit").click();
    }
</script>
@endpush