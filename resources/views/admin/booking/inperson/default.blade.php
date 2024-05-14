@extends('admin.layouts.app')
<style>
    
    .main-container 
    {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .radio-buttons 
    {
        width: 100%;
        margin: 0 auto;
        text-align: center;
    }

    .custom-radio input 
    {
        display: none;
    }

    .radio-btn 
    {
        margin: 10px;
        width: 220px;
        height: 50px;
        border: 3px solid transparent;
        display: inline-block;
        border-radius: 10px;
        position: relative;
        text-align: center;
        box-shadow: 0 0 20px #c3c3c367;
        cursor: pointer;
    }

    .radio-btn > i {
        color: #ffffff;
        background-color: #FFDAE9;
        font-size: 20px;
        position: absolute;
        top: -15px;
        left: 50%;
        transform: translateX(-50%) scale(2);
        border-radius: 50px;
        padding: 6px 7px;
        transition: 0.5s;
        pointer-events: none;
        opacity: 0;
    }

    .radio-btn .hobbies-icon 
    {
        width: 150px;
        height: 50px;
        position: absolute;
        top: 80%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    .radio-btn .hobbies-icon h3 
    {
        color: #555;
        font-size: 18px;
        font-weight: 300;
        text-transform: uppercase;
        letter-spacing:1px;
    }

    .custom-radio input:checked + .radio-btn 
    {
        border: 2px solid #476CDA;
    }

    .custom-radio input:checked + .radio-btn > i 
    {
        opacity: 1;
        transform: translateX(-50%) scale(1);
    }
</style>
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">In-Person Booking Default Time</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">In-Person Booking Default Time</h6>
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="main-container col-xl-8 col-12">
                <form action="{{ route('inperson-booking-time.store') }}" method="post">
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
                        <button type="submit" class="btn btn-secondary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection