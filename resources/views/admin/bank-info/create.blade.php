@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Bank Information</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Bank Information Create</h6>
            <div class="col">
                <a href="{{ route('bank-info.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('bank-info.store') }}" method="post" enctype="multipart/form-data">
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
                    <label for="bank_name">Bank Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Enter Bank Name" required value="{{ old('bank_name') }}">
                </div>
                <div class="form-group">
                    <label for="account_no">Account No. <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="account_no" id="account_no" placeholder="Enter Bank Name" required value="{{ old('account_no') }}">
                </div>
                <div class="form-group">
                    <label for="account_name">Account Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="account_name" id="account_name" placeholder="Enter Bank Name" required value="{{ old('account_name') }}">
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