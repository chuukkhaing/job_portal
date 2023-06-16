@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Functional Areas</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Sub Functional Area Edit</h6>
            <div class="col">
                <a href="{{ route('sub-functional-area.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('sub-functional-area.update', $functional_area->id) }}" method="post">
                @csrf 
                @method('PUT')
                <div class="form-group">
                    <label for="name">Sub Functional Area Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter sub functional area name" required value="{{ $functional_area->name }}">
                </div>
                <div class="form-group">
                    <label for="functional_area_id">Choose Main Functional Area <span class="text-danger">*</span></label>
                    <select name="functional_area_id" id="functional_area_id" class="select_2 form-control" required>
                        <option value=""></option>
                        @foreach($functional_areas as $main_functional_area)
                        <option value="{{ $main_functional_area->id }}" @if($main_functional_area->id == $functional_area->functional_area_id) selected @endif>{{ $main_functional_area->name }} @if(isset($main_functional_area->name)) ({{ $main_functional_area->name }} ) @endif</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="" value="1" @if($functional_area->is_active == 1) checked required @endif> <label for="active"> Active</label><br>
                    <input type="radio" name="is_active" id="in_active" class="" value="0" @if($functional_area->is_active == 0) checked required @endif> <label for="in_active"> In Active</label>
                </div>
                <button class="btn btn-primary btn-icon-split btn-sm" type="submit">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Update</span>
                </button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection