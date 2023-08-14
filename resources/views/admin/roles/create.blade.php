@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Manage User</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Role Create</h6>
            <div class="col">
                <a href="{{ route('roles.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="post">
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
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="permission">Permission <span class="text-danger">*</span></label>
                    <br/>
                    <div class="row">
                        @foreach($permission as $value)
                        <div class="col-3">
                            <input type="checkbox" name="permission[]" id="{{ $value->name }}" value="{{ $value->id }}">
                            <label for="{{ $value->name }}">{{ $value->name }}</label>
                        </div>
                        @endforeach
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
@push('script')
<script>
    // role 
    $("#role-list").change(function() {
        if($(this).is(":checked")) {
            $("#role-create").prop('checked',true);
            $("#role-edit").prop('checked',true);
            $("#role-delete").prop('checked',true);
        }
    });
    $("#role-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#role-create").prop('checked',false);
            $("#role-edit").prop('checked',false);
            $("#role-delete").prop('checked',false);
        }
    });
    $("#role-create").change(function() {
        if($(this).is(":checked")) {
            $("#role-list").prop('checked',true);
        }
    });
    $("#role-create").change(function() {
        if($("#role-create").is(":checked") == false && $("#role-edit").is(":checked") == false && $("#role-delete").is(":checked") == false) {
            $("#role-list").prop('checked',false);
        }
    });
    $("#role-edit").change(function() {
        if($(this).is(":checked")) {
            $("#role-list").prop('checked',true);
        }
    });
    $("#role-edit").change(function() {
        if($("#role-create").is(":checked") == false && $("#role-edit").is(":checked") == false && $("#role-delete").is(":checked") == false) {
            $("#role-list").prop('checked',false);
        }
    });
    $("#role-delete").change(function() {
        if($(this).is(":checked")) {
            $("#role-list").prop('checked',true);
        }
    });
    $("#role-delete").change(function() {
        if($("#role-create").is(":checked") == false && $("#role-edit").is(":checked") == false && $("#role-delete").is(":checked") == false) {
            $("#role-list").prop('checked',false);
        }
    });
    // user 
    $("#user-list").change(function() {
        if($(this).is(":checked")) {
            $("#user-create").prop('checked',true);
            $("#user-edit").prop('checked',true);
            $("#user-delete").prop('checked',true);
        }
    });
    $("#user-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#user-create").prop('checked',false);
            $("#user-edit").prop('checked',false);
            $("#user-delete").prop('checked',false);
        }
    });
    $("#user-create").change(function() {
        if($(this).is(":checked")) {
            $("#user-list").prop('checked',true);
        }
    });
    $("#user-create").change(function() {
        if($("#user-create").is(":checked") == false && $("#user-edit").is(":checked") == false && $("#user-delete").is(":checked") == false) {
            $("#user-list").prop('checked',false);
        }
    });
    $("#user-edit").change(function() {
        if($(this).is(":checked")) {
            $("#user-list").prop('checked',true);
        }
    });
    $("#user-edit").change(function() {
        if($("#user-create").is(":checked") == false && $("#user-edit").is(":checked") == false && $("#user-delete").is(":checked") == false) {
            $("#user-list").prop('checked',false);
        }
    });
    $("#user-delete").change(function() {
        if($(this).is(":checked")) {
            $("#user-list").prop('checked',true);
        }
    });
    $("#user-delete").change(function() {
        if($("#user-create").is(":checked") == false && $("#user-edit").is(":checked") == false && $("#user-delete").is(":checked") == false) {
            $("#user-list").prop('checked',false);
        }
    });

    // state 
    $("#state-list").change(function() {
        if($(this).is(":checked")) {
            $("#state-create").prop('checked',true);
            $("#state-edit").prop('checked',true);
            $("#state-delete").prop('checked',true);
        }
    });
    $("#state-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#state-create").prop('checked',false);
            $("#state-edit").prop('checked',false);
            $("#state-delete").prop('checked',false);
        }
    });
    $("#state-create").change(function() {
        if($(this).is(":checked")) {
            $("#state-list").prop('checked',true);
        }
    });
    $("#state-create").change(function() {
        if($("#state-create").is(":checked") == false && $("#state-edit").is(":checked") == false && $("#state-delete").is(":checked") == false) {
            $("#state-list").prop('checked',false);
        }
    });
    $("#state-edit").change(function() {
        if($(this).is(":checked")) {
            $("#state-list").prop('checked',true);
        }
    });
    $("#state-edit").change(function() {
        if($("#state-create").is(":checked") == false && $("#state-edit").is(":checked") == false && $("#state-delete").is(":checked") == false) {
            $("#state-list").prop('checked',false);
        }
    });
    $("#state-delete").change(function() {
        if($(this).is(":checked")) {
            $("#state-list").prop('checked',true);
        }
    });
    $("#state-delete").change(function() {
        if($("#state-create").is(":checked") == false && $("#state-edit").is(":checked") == false && $("#state-delete").is(":checked") == false) {
            $("#state-list").prop('checked',false);
        }
    });

    // township 
    $("#township-list").change(function() {
        if($(this).is(":checked")) {
            $("#township-create").prop('checked',true);
            $("#township-edit").prop('checked',true);
            $("#township-delete").prop('checked',true);
        }
    });
    $("#township-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#township-create").prop('checked',false);
            $("#township-edit").prop('checked',false);
            $("#township-delete").prop('checked',false);
        }
    });
    $("#township-create").change(function() {
        if($(this).is(":checked")) {
            $("#township-list").prop('checked',true);
        }
    });
    $("#township-create").change(function() {
        if($("#township-create").is(":checked") == false && $("#township-edit").is(":checked") == false && $("#township-delete").is(":checked") == false) {
            $("#township-list").prop('checked',false);
        }
    });
    $("#township-edit").change(function() {
        if($(this).is(":checked")) {
            $("#township-list").prop('checked',true);
        }
    });
    $("#township-edit").change(function() {
        if($("#township-create").is(":checked") == false && $("#township-edit").is(":checked") == false && $("#township-delete").is(":checked") == false) {
            $("#township-list").prop('checked',false);
        }
    });
    $("#township-delete").change(function() {
        if($(this).is(":checked")) {
            $("#township-list").prop('checked',true);
        }
    });
    $("#township-delete").change(function() {
        if($("#township-create").is(":checked") == false && $("#township-edit").is(":checked") == false && $("#township-delete").is(":checked") == false) {
            $("#township-list").prop('checked',false);
        }
    });

    // industry 
    $("#industry-list").change(function() {
        if($(this).is(":checked")) {
            $("#industry-create").prop('checked',true);
            $("#industry-edit").prop('checked',true);
            $("#industry-delete").prop('checked',true);
        }
    });
    $("#industry-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#industry-create").prop('checked',false);
            $("#industry-edit").prop('checked',false);
            $("#industry-delete").prop('checked',false);
        }
    });
    $("#industry-create").change(function() {
        if($(this).is(":checked")) {
            $("#industry-list").prop('checked',true);
        }
    });
    $("#industry-create").change(function() {
        if($("#industry-create").is(":checked") == false && $("#industry-edit").is(":checked") == false && $("#industry-delete").is(":checked") == false) {
            $("#industry-list").prop('checked',false);
        }
    });
    $("#industry-edit").change(function() {
        if($(this).is(":checked")) {
            $("#industry-list").prop('checked',true);
        }
    });
    $("#industry-edit").change(function() {
        if($("#industry-create").is(":checked") == false && $("#industry-edit").is(":checked") == false && $("#industry-delete").is(":checked") == false) {
            $("#industry-list").prop('checked',false);
        }
    });
    $("#industry-delete").change(function() {
        if($(this).is(":checked")) {
            $("#industry-list").prop('checked',true);
        }
    });
    $("#industry-delete").change(function() {
        if($("#industry-create").is(":checked") == false && $("#industry-edit").is(":checked") == false && $("#industry-delete").is(":checked") == false) {
            $("#industry-list").prop('checked',false);
        }
    });

    // ownership type 
    $("#ownership-type-list").change(function() {
        if($(this).is(":checked")) {
            $("#ownership-type-create").prop('checked',true);
            $("#ownership-type-edit").prop('checked',true);
            $("#ownership-type-delete").prop('checked',true);
        }
    });
    $("#ownership-type-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#ownership-type-create").prop('checked',false);
            $("#ownership-type-edit").prop('checked',false);
            $("#ownership-type-delete").prop('checked',false);
        }
    });
    $("#ownership-type-create").change(function() {
        if($(this).is(":checked")) {
            $("#ownership-type-list").prop('checked',true);
        }
    });
    $("#ownership-type-create").change(function() {
        if($("#ownership-type-create").is(":checked") == false && $("#ownership-type-edit").is(":checked") == false && $("#ownership-type-delete").is(":checked") == false) {
            $("#ownership-type-list").prop('checked',false);
        }
    });
    $("#ownership-type-edit").change(function() {
        if($(this).is(":checked")) {
            $("#ownership-type-list").prop('checked',true);
        }
    });
    $("#ownership-type-edit").change(function() {
        if($("#ownership-type-create").is(":checked") == false && $("#ownership-type-edit").is(":checked") == false && $("#ownership-type-delete").is(":checked") == false) {
            $("#ownership-type-list").prop('checked',false);
        }
    });
    $("#ownership-type-delete").change(function() {
        if($(this).is(":checked")) {
            $("#ownership-type-list").prop('checked',true);
        }
    });
    $("#ownership-type-delete").change(function() {
        if($("#ownership-type-create").is(":checked") == false && $("#ownership-type-edit").is(":checked") == false && $("#ownership-type-delete").is(":checked") == false) {
            $("#ownership-type-list").prop('checked',false);
        }
    });

    // skill 
    $("#skill-list").change(function() {
        if($(this).is(":checked")) {
            $("#skill-create").prop('checked',true);
            $("#skill-edit").prop('checked',true);
            $("#skill-delete").prop('checked',true);
        }
    });
    $("#skill-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#skill-create").prop('checked',false);
            $("#skill-edit").prop('checked',false);
            $("#skill-delete").prop('checked',false);
        }
    });
    $("#skill-create").change(function() {
        if($(this).is(":checked")) {
            $("#skill-list").prop('checked',true);
        }
    });
    $("#skill-create").change(function() {
        if($("#skill-create").is(":checked") == false && $("#skill-edit").is(":checked") == false && $("#skill-delete").is(":checked") == false) {
            $("#skill-list").prop('checked',false);
        }
    });
    $("#skill-edit").change(function() {
        if($(this).is(":checked")) {
            $("#skill-list").prop('checked',true);
        }
    });
    $("#skill-edit").change(function() {
        if($("#skill-create").is(":checked") == false && $("#skill-edit").is(":checked") == false && $("#skill-delete").is(":checked") == false) {
            $("#skill-list").prop('checked',false);
        }
    });
    $("#skill-delete").change(function() {
        if($(this).is(":checked")) {
            $("#skill-list").prop('checked',true);
        }
    });
    $("#skill-delete").change(function() {
        if($("#skill-create").is(":checked") == false && $("#skill-edit").is(":checked") == false && $("#skill-delete").is(":checked") == false) {
            $("#skill-list").prop('checked',false);
        }
    });

    // main functional area 
    $("#main-functional-area-list").change(function() {
        if($(this).is(":checked")) {
            $("#main-functional-area-create").prop('checked',true);
            $("#main-functional-area-edit").prop('checked',true);
            $("#main-functional-area-delete").prop('checked',true);
        }
    });
    $("#main-functional-area-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#main-functional-area-create").prop('checked',false);
            $("#main-functional-area-edit").prop('checked',false);
            $("#main-functional-area-delete").prop('checked',false);
        }
    });
    $("#main-functional-area-create").change(function() {
        if($(this).is(":checked")) {
            $("#main-functional-area-list").prop('checked',true);
        }
    });
    $("#main-functional-area-create").change(function() {
        if($("#main-functional-area-create").is(":checked") == false && $("#main-functional-area-edit").is(":checked") == false && $("#main-functional-area-delete").is(":checked") == false) {
            $("#main-functional-area-list").prop('checked',false);
        }
    });
    $("#main-functional-area-edit").change(function() {
        if($(this).is(":checked")) {
            $("#main-functional-area-list").prop('checked',true);
        }
    });
    $("#main-functional-area-edit").change(function() {
        if($("#main-functional-area-create").is(":checked") == false && $("#main-functional-area-edit").is(":checked") == false && $("#main-functional-area-delete").is(":checked") == false) {
            $("#main-functional-area-list").prop('checked',false);
        }
    });
    $("#main-functional-area-delete").change(function() {
        if($(this).is(":checked")) {
            $("#main-functional-area-list").prop('checked',true);
        }
    });
    $("#main-functional-area-delete").change(function() {
        if($("#main-functional-area-create").is(":checked") == false && $("#main-functional-area-edit").is(":checked") == false && $("#main-functional-area-delete").is(":checked") == false) {
            $("#main-functional-area-list").prop('checked',false);
        }
    });

    // sub functional area 
    $("#sub-functional-area-list").change(function() {
        if($(this).is(":checked")) {
            $("#sub-functional-area-create").prop('checked',true);
            $("#sub-functional-area-edit").prop('checked',true);
            $("#sub-functional-area-delete").prop('checked',true);
        }
    });
    $("#sub-functional-area-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#sub-functional-area-create").prop('checked',false);
            $("#sub-functional-area-edit").prop('checked',false);
            $("#sub-functional-area-delete").prop('checked',false);
        }
    });
    $("#sub-functional-area-create").change(function() {
        if($(this).is(":checked")) {
            $("#sub-functional-area-list").prop('checked',true);
        }
    });
    $("#sub-functional-area-create").change(function() {
        if($("#sub-functional-area-create").is(":checked") == false && $("#sub-functional-area-edit").is(":checked") == false && $("#sub-functional-area-delete").is(":checked") == false) {
            $("#sub-functional-area-list").prop('checked',false);
        }
    });
    $("#sub-functional-area-edit").change(function() {
        if($(this).is(":checked")) {
            $("#sub-functional-area-list").prop('checked',true);
        }
    });
    $("#sub-functional-area-edit").change(function() {
        if($("#sub-functional-area-create").is(":checked") == false && $("#sub-functional-area-edit").is(":checked") == false && $("#sub-functional-area-delete").is(":checked") == false) {
            $("#sub-functional-area-list").prop('checked',false);
        }
    });
    $("#sub-functional-area-delete").change(function() {
        if($(this).is(":checked")) {
            $("#sub-functional-area-list").prop('checked',true);
        }
    });
    $("#sub-functional-area-delete").change(function() {
        if($("#sub-functional-area-create").is(":checked") == false && $("#sub-functional-area-edit").is(":checked") == false && $("#sub-functional-area-delete").is(":checked") == false) {
            $("#sub-functional-area-list").prop('checked',false);
        }
    });

    // package item 
    $("#package-item-list").change(function() {
        if($(this).is(":checked")) {
            $("#package-item-create").prop('checked',true);
            $("#package-item-edit").prop('checked',true);
            $("#package-item-delete").prop('checked',true);
        }
    });
    $("#package-item-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#package-item-create").prop('checked',false);
            $("#package-item-edit").prop('checked',false);
            $("#package-item-delete").prop('checked',false);
        }
    });
    $("#package-item-create").change(function() {
        if($(this).is(":checked")) {
            $("#package-item-list").prop('checked',true);
        }
    });
    $("#package-item-create").change(function() {
        if($("#package-item-create").is(":checked") == false && $("#package-item-edit").is(":checked") == false && $("#package-item-delete").is(":checked") == false) {
            $("#package-item-list").prop('checked',false);
        }
    });
    $("#package-item-edit").change(function() {
        if($(this).is(":checked")) {
            $("#package-item-list").prop('checked',true);
        }
    });
    $("#package-item-edit").change(function() {
        if($("#package-item-create").is(":checked") == false && $("#package-item-edit").is(":checked") == false && $("#package-item-delete").is(":checked") == false) {
            $("#package-item-list").prop('checked',false);
        }
    });
    $("#package-item-delete").change(function() {
        if($(this).is(":checked")) {
            $("#package-item-list").prop('checked',true);
        }
    });
    $("#package-item-delete").change(function() {
        if($("#package-item-create").is(":checked") == false && $("#package-item-edit").is(":checked") == false && $("#package-item-delete").is(":checked") == false) {
            $("#package-item-list").prop('checked',false);
        }
    });

    // package type 
    $("#package-type-list").change(function() {
        if($(this).is(":checked")) {
            $("#package-type-create").prop('checked',true);
            $("#package-type-edit").prop('checked',true);
            $("#package-type-delete").prop('checked',true);
        }
    });
    $("#package-type-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#package-type-create").prop('checked',false);
            $("#package-type-edit").prop('checked',false);
            $("#package-type-delete").prop('checked',false);
        }
    });
    $("#package-type-create").change(function() {
        if($(this).is(":checked")) {
            $("#package-type-list").prop('checked',true);
        }
    });
    $("#package-type-create").change(function() {
        if($("#package-type-create").is(":checked") == false && $("#package-type-edit").is(":checked") == false && $("#package-type-delete").is(":checked") == false) {
            $("#package-type-list").prop('checked',false);
        }
    });
    $("#package-type-edit").change(function() {
        if($(this).is(":checked")) {
            $("#package-type-list").prop('checked',true);
        }
    });
    $("#package-type-edit").change(function() {
        if($("#package-type-create").is(":checked") == false && $("#package-type-edit").is(":checked") == false && $("#package-type-delete").is(":checked") == false) {
            $("#package-type-list").prop('checked',false);
        }
    });
    $("#package-type-delete").change(function() {
        if($(this).is(":checked")) {
            $("#package-type-list").prop('checked',true);
        }
    });
    $("#package-type-delete").change(function() {
        if($("#package-type-create").is(":checked") == false && $("#package-type-edit").is(":checked") == false && $("#package-type-delete").is(":checked") == false) {
            $("#package-type-list").prop('checked',false);
        }
    });

    // employer
    $("#employer-list").change(function() {
        if($(this).is(":checked")) {
            $("#employer-create").prop('checked',true);
            $("#employer-edit").prop('checked',true);
            $("#employer-delete").prop('checked',true);
        }
    });
    $("#employer-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#employer-create").prop('checked',false);
            $("#employer-edit").prop('checked',false);
            $("#employer-delete").prop('checked',false);
        }
    });
    $("#employer-create").change(function() {
        if($(this).is(":checked")) {
            $("#employer-list").prop('checked',true);
        }
    });
    $("#employer-create").change(function() {
        if($("#employer-create").is(":checked") == false && $("#employer-edit").is(":checked") == false && $("#employer-delete").is(":checked") == false) {
            $("#employer-list").prop('checked',false);
        }
    });
    $("#employer-edit").change(function() {
        if($(this).is(":checked")) {
            $("#employer-list").prop('checked',true);
        }
    });
    $("#employer-edit").change(function() {
        if($("#employer-create").is(":checked") == false && $("#employer-edit").is(":checked") == false && $("#employer-delete").is(":checked") == false) {
            $("#employer-list").prop('checked',false);
        }
    });
    $("#employer-delete").change(function() {
        if($(this).is(":checked")) {
            $("#employer-list").prop('checked',true);
        }
    });
    $("#employer-delete").change(function() {
        if($("#employer-create").is(":checked") == false && $("#employer-edit").is(":checked") == false && $("#employer-delete").is(":checked") == false) {
            $("#employer-list").prop('checked',false);
        }
    });

    // slider
    $("#slider-list").change(function() {
        if($(this).is(":checked")) {
            $("#slider-create").prop('checked',true);
            $("#slider-edit").prop('checked',true);
            $("#slider-delete").prop('checked',true);
        }
    });
    $("#slider-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#slider-create").prop('checked',false);
            $("#slider-edit").prop('checked',false);
            $("#slider-delete").prop('checked',false);
        }
    });
    $("#slider-create").change(function() {
        if($(this).is(":checked")) {
            $("#slider-list").prop('checked',true);
        }
    });
    $("#slider-create").change(function() {
        if($("#slider-create").is(":checked") == false && $("#slider-edit").is(":checked") == false && $("#slider-delete").is(":checked") == false) {
            $("#slider-list").prop('checked',false);
        }
    });
    $("#slider-edit").change(function() {
        if($(this).is(":checked")) {
            $("#slider-list").prop('checked',true);
        }
    });
    $("#slider-edit").change(function() {
        if($("#slider-create").is(":checked") == false && $("#slider-edit").is(":checked") == false && $("#slider-delete").is(":checked") == false) {
            $("#slider-list").prop('checked',false);
        }
    });
    $("#slider-delete").change(function() {
        if($(this).is(":checked")) {
            $("#slider-list").prop('checked',true);
        }
    });
    $("#slider-delete").change(function() {
        if($("#slider-create").is(":checked") == false && $("#slider-edit").is(":checked") == false && $("#slider-delete").is(":checked") == false) {
            $("#slider-list").prop('checked',false);
        }
    });

    // job post
    $("#job-post-list").change(function() {
        if($(this).is(":checked")) {
            $("#job-post-edit").prop('checked',true);
        }
    });
    $("#job-post-list").change(function() {
        if($(this).is(":checked") == false) {
            $("#job-post-edit").prop('checked',false);
        }
    });
    $("#job-post-edit").change(function() {
        if($(this).is(":checked")) {
            $("#job-post-list").prop('checked',true);
        }
    });
    $("#job-post-edit").change(function() {
        if($(this).is(":checked") == false) {
            $("#job-post-list").prop('checked',false);
        }
    });
    
</script>
@endpush