@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Point Package</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Point Package Edit</h6>
            <div class="col">
                <a href="{{ route('point-package.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('point-package.update', $package->id) }}" method="post">
                @csrf 
                @method('PUT')
                
                <div class="form-group">
                    <label for="point">Point <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="point" id="point" placeholder="Enter Point" required value="{{ $package->point }}">
                </div>
                <div class="form-group">
                    <label for="price">Price - MMK <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price" required value="{{ $package->price }}">
                </div>
                
                <div class="form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="" value="1" @if($package->is_active == 1) checked required @endif> <label for="active"> Active</label><br>
                    <input type="radio" name="is_active" id="in_active" class="" value="0" @if($package->is_active == 0) checked required @endif> <label for="in_active"> In Active</label>
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