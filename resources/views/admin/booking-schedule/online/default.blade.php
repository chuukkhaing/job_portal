@extends('admin.layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Online Booking Default Time</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Online Booking Default Time</h6>
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="main-container col-xl-8 col-12">
                <form action="{{ route('online-booking-time.store') }}" method="post">
                    @csrf
                    <div class="radio-buttons row">
                        @foreach($times as $time)
                        <label class="col-xl-4 col-md-6 col-12 custom-radio">
                        <input type="checkbox" name="{{ $time->id }}" value="{{ $time->id }}" id="check_{{ $time->id }}" {{ $time->is_active == 1 ? 'checked' : ''}} >
                        <span class="radio-btn">
                            <div class="hobbies-icon">
                            
                            <h3 class="">{{ $time->time }}</h3>
                            </div>
                        </span>
                        </label>
                        @endforeach
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

</div>
<!-- /.container-fluid -->
@endsection