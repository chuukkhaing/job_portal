@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Packages</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Package Type Create</h6>
            <div class="col">
                <a href="{{ route('package-type.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('package-type.store') }}" method="post">
                @csrf 
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="name">Package Name <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="name" id="name" placeholder="Enter Package Name" required value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="package-item-name">Package Item Name <span class="text-danger">*</span></label><br>
                    <div class="row">
                    @foreach($package_items as $package_item)
                        <div class="col-4">
                            <input type="checkbox" name="package_item_id[]" id="package_item_id_{{ $package_item->id }}" value="{{ $package_item->id }}" class=""> <label for="package_item_id_{{ $package_item->id }}"> {{ $package_item->name }}</label><br>
                        </div>
                    @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="point">Point <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="point" id="point" placeholder="Enter Point" required value="{{ old('point') }}">
                </div>
                <div class="form-group">
                    <label for="price">Price - MMK <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price" required value="{{ old('price') }}">
                </div>
                <div class="form-group">
                    <label for="number_of_users">Number of Multi Users <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="number_of_users" id="number_of_users" placeholder="Enter Number of Multi Users" required value="{{ old('number_of_users') }}">
                </div>
                <div class="form-group">
                    <label for="number_of_days">Number of Days <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="number_of_days" id="number_of_days" placeholder="Enter Number of Days" required value="{{ old('number_of_days') }}">
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