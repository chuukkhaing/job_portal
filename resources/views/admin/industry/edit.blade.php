@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Company Attributes</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Industrial Edit</h6>
            <div class="col">
                <a href="{{ route('industry.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('industry.update', $industry->id) }}" method="post">
                @csrf 
                @method('PUT')
                <div class="form-group">
                    <label for="name">Industrial Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Industrial name" required value="{{ $industry->name }}">
                </div>
                <div class="form-group">
                    <label for="icon">Choose Icon <span class="text-danger">*</span></label><br>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary iconpicker-component"><i
                                class="{{ $industry->icon }}"></i></button>
                        <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                                data-selected="fa-car" data-toggle="dropdown">
                        </button>
                        <div class="dropdown-menu"></div>
                    </div>
                    <input type="hidden" name="icon" value="{{ $industry->icon }}" id="icon">
                </div>
                <div class="form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="" value="1" @if($industry->is_active == 1) checked required @endif> <label for="active"> Active</label><br>
                    <input type="radio" name="is_active" id="in_active" class="" value="0" @if($industry->is_active == 0) checked required @endif> <label for="in_active"> In Active</label>
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