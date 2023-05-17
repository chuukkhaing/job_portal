@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Locations</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">State or Region Edit</h6>
            <div class="col">
                <a href="{{ route('state.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('state.update', $state->id) }}" method="post">
                @csrf 
                @method('PUT')
                <div class="form-group">
                    <label for="state">State or Region Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="state" placeholder="Enter state or region name" required value="{{ $state->name }}">
                </div>
                
                <div class="form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="from-control" value="1" @if($state->is_active == 1) checked required @endif> <label for="active"> Active</label><br>
                                <input type="radio" name="is_active" id="in_active" class="from-control" value="0" @if($state->is_active == 0) checked required @endif> <label for="in_active"> In Active</label>
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