@extends('admin.layouts.app')
<style>
    
    .main-container 
    {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .main-container h2 
    {
        margin: 0 0 80px 0;
        color: #555;
        font-size: 30px;
        font-weight: 300;
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
        height: 240px;
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
        height: 150px;
        position: absolute;
        top: 40%;
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
        border: 2px solid #FFDAE9;
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
    <h1 class="h3 mb-2 text-gray-800">Online Booking Time</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Online Booking Time</h6>
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="main-container">
                <div class="radio-buttons">
                    <label class="custom-radio">
                    <input type="radio" name="radio" checked>
                    <span class="radio-btn">
                        <div class="hobbies-icon">
                        
                        <h3 class="">Biking</h3>
                        </div>
                    </span>
                    </label>
                    <label class="custom-radio">
                    <input type="radio" name="radio" >
                    <span class="radio-btn">
                        <div class="hobbies-icon">
                                    
                        <h3 class="">Litterature</h3>
                        </div>
                    </span>
                    </label>
                    <label class="custom-radio">
                    <input type="radio" name="radio" >
                    <span class="radio-btn">
                        <div class="hobbies-icon">
                        
                        <h3 class="">Music</h3>
                        </div>
                    </span>
                    </label>
                    <label class="custom-radio">
                    <input type="radio" name="radio" >
                    <span class="radio-btn">
                        <div class="hobbies-icon">
                        
                        <h3 class="">Science</h3>
                        </div>
                    </span>
                    </label>
                    
                </div>
            
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection