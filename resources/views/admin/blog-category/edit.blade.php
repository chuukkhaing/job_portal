@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Blog Category</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Blog Category Edit</h6>
            <div class="col">
                <a href="{{ route('blog-category.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('blog-category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Blog Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Blog Category Name" value="{{ $category->name }}">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="" value="1" @if($category->is_active == 1) checked required @endif> <label for="active"> Active</label><br>
                    <input type="radio" name="is_active" id="in_active" class="" value="0" @if($category->is_active == 0) checked required @endif> <label for="in_active"> In Active</label>
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