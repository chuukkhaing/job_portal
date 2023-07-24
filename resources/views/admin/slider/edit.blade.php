@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sliders</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Slider Edit</h6>
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
            <form action="{{ route('slider.update',$slider->id) }}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                <div class="form-group">
                    <label for="employer_id">Choose Employer <span class="text-danger">*</span></label>
                    <select name="employer_id" id="employer_id" class="select_2 form-control" required>
                        <option value=""></option>
                        @foreach($employers as $employer)
                        <option value="{{ $employer->id }}" @if($slider->employer_id == $employer->id) selected @endif>{{ $employer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="serial_no">Serial No. <span class="text-danger">*</span></label>
                    <select name="serial_no" id="serial_no" class="form-control">
                        <option value="">Choose Serial No.</option>
                        <option value="1" @if($slider->serial_no == 1) selected @endif>1</option>
                        <option value="2" @if($slider->serial_no == 2) selected @endif>2</option>
                        <option value="3" @if($slider->serial_no == 3) selected @endif>3</option>
                        <option value="4" @if($slider->serial_no == 4) selected @endif>4</option>
                        <option value="5" @if($slider->serial_no == 5) selected @endif>5</option>
                        <option value="6" @if($slider->serial_no == 6) selected @endif>6</option>
                    </select>
                </div>

                <div class="image-upload form-group">
                    <div class="image-preview">
                        @if($slider->image)
                        <div id="imagePreview" style="background-image: url({{ asset('storage/slider/'.$slider->image) }});">
                        @else
                        <div id="imagePreview" style="background-image: url(https://placehold.jp/1080x528.png);">
                        @endif
                        </div>
                    </div>
                    <div class="image-edit">
                    <label for="imageUpload">Slider Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="image" id="imageUpload" accept="image/*" required />
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="" value="1" checked required> <label for="active"> Active</label><br>
                    <input type="radio" name="is_active" id="in_active" class="" value="0"> <label for="in_active"> In Active</label>
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