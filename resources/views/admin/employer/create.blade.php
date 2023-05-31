@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Employers</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Employer Create</h6>
            <div class="col">
                <a href="{{ route('employer.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('employer.store') }}" method="post" enctype="multipart/form-data">
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
                <div class="logo-upload form-group">
                    <div class="logo-edit">
                        <input type="file" class="form-control" name="logo" id="imageUpload" accept="image/*" required />
                        <label for="imageUpload"></label>
                    </div>
                    <div class="logo-preview">
                        <div id="imagePreview" style="background-image: url(https://placehold.jp/150x150.png);">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6 form-group">
                        <label for="name">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Company name" required value="{{ old('name') }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="email">Company Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Company Email" required value="{{ old('email') }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required value="{{ old('password') }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="ceo">CEO Name </label>
                        <input type="ceo" class="form-control" name="ceo" id="ceo" placeholder="Enter CEO Name" value="{{ old('ceo') }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="industry_id">Choose Industry <span class="text-danger">*</span></label>
                        <select name="industry_id" id="industry_id" class="form-control select_2" required>
                            <option value=""></option>
                            @foreach ($industries as $industry)
                            <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label for="ownership_type_id">Choose Ownership Type <span class="text-danger">*</span></label>
                        <select name="ownership_type_id" id="ownership_type_id" class="form-control select_2" required>
                            <option value=""></option>
                            @foreach ($ownershipTypes as $ownershipType)
                            <option value="{{ $ownershipType->id }}">{{ $ownershipType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label for="type_of_employer">Choose Type of Employer <span class="text-danger">*</span></label>
                        <select name="type_of_employer" id="type_of_employer" class="form-control select_2" required>
                            <option value=""></option>
                            @foreach (config('typeOfEmployer.value') as $typeofemployer)
                            <option value="{{ $typeofemployer }}">{{ $typeofemployer }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                        <input type="radio" name="is_active" id="active" class="from-control" value="1" checked required> <label for="active"> Active</label><br>
                        <input type="radio" name="is_active" id="in_active" class="from-control" value="0"> <label for="in_active"> In Active</label>
                    </div>
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