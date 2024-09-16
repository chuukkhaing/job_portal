@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Online Booking Unavailable Time</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Online Booking Unavailable Time Create</h6>
            <div class="col">
                <a href="{{ route('close-online-booking-time.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('close-online-booking-time.store') }}" method="post" enctype="multipart/form-data">
                @csrf 
                
                <div class="row">
                    <div class="col-4 form-group">
                        <label for="date">Date <span class="text-danger">*</span></label>
                        <div class="datepicker date input-group" id="date">
                            <input type="text" name="date" id="date" class="form-control seeker_input" value="{{ date('d-m-Y',strtotime(now())) }}" placeholder="Date">
                            <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        @error('date')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 form-group">
                        <label for="remark">Remark </label>
                        <input type="text" class="form-control @error('remark') is-invalid @enderror" name="remark" id="remark" placeholder="Enter Remark" value="{{ old('remark') }}">
                        @error('remark')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="radio-buttons row">
                    @foreach($times as $time)
                    <label class="col-xl-4 col-md-6 col-12 custom-radio">
                    <input type="checkbox" name="time_id[]" value="{{ $time->id }}" id="check_{{ $time->id }}" >
                    <span class="radio-btn">
                        <div class="hobbies-icon">
                        
                        <h3 class="">{{ $time->time }}</h3>
                        </div>
                    </span>
                    </label>
                    @endforeach
                    @error('time_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="text-center">
                    <button class="btn btn-primary btn-icon-split btn-sm" type="submit">
                        <span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('#date').datepicker({
            language: "es",
            autoclose: true,
            format: "dd-mm-yyyy"
        });
    });
</script>
@endpush