@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sliders</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Slider Create</h6>
            <div class="col">
                <a href="{{ route('slider.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('slider.store') }}" method="post" enctype="multipart/form-data">
                @csrf 
                <div class="form-group">
                    <label for="employer_id">Choose Employer <span class="text-danger">*</span></label>
                    <select name="employer_id" id="employer_id" class="select_2 form-control" required>
                        <option value=""></option>
                        @foreach($employers as $employer)
                        <option value="{{ $employer->id }}">{{ $employer->name }} @if(isset($employer->name)) ({{ $employer->name }} ) @endif</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="serial_no">Serial No. <span class="text-danger">*</span></label>
                    <select name="serial_no" id="serial_no" class="form-control">
                        <option value="">Choose Serial No.</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>

                <div class="image-upload form-group">
                    <div class="image-preview">
                        <div id="imagePreview" style="background-image: url(https://placehold.jp/1080x528.png);">
                        </div>
                    </div>
                    <div class="image-edit">
                    <label for="imageUpload">Slider Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="image" id="imageUpload" accept="image/*" required />
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="from-control" value="1" checked required> <label for="active"> Active</label><br>
                    <input type="radio" name="is_active" id="in_active" class="from-control" value="0"> <label for="in_active"> In Active</label>
                </div>
                <button class="btn btn-primary btn-icon-split btn-sm" type="submit">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Save</span>
                </button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection