@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Employers</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Employer Edit</h6>
            <div class="col">
                <a href="{{ route('employers.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('employers.update', $employer->id) }}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('put')
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
                        <input type="file" class="form-control" name="logo" id="imageUpload" accept="image/*" />
                        <label for="imageUpload"></label>
                    </div>
                    <div class="logo-remove">
                        <label for="imageRemove"></label>
                    </div>
                    <div class="logo-preview">
                        @if($employer->logo)
                        <div id="imagePreview" style="background-image: url({{url('storage/employer_logo/'.$employer->logo)}});">
                        @else
                        <div id="imagePreview" style="background-image: url(https://placehold.jp/150x150.png);">
                        @endif
                        </div>
                    </div>
                    <input type="hidden" name="imageRemove" value="" id="imageRemove">
                </div>
                
                <div class="row">
                    <div class="col-6 form-group">
                        <label for="name">Employer Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Employer name" required value="{{ $employer->name }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="email">Employer Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Employer Email" required value="{{ $employer->email }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="">
                    </div>

                    <div class="col-6 form-group">
                        <label for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="datepicker form-control" name="confirm-password" id="confirm-password" placeholder="Enter Password" value="">
                    </div>

                    <div class="col-4 form-group">
                        <label for="package_id">Choose Package </label>
                        <select name="package_id" id="package_id" class="form-control select_2">
                            <option value=""></option>
                            @foreach ($packages as $package)
                            <option value="{{ $package->id }}" @if($package->id == $employer->package_id) selected @endif>{{ $package->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4 form-group">
                        <label for="package_id">Package Effective Date </label>
                        <div class="datepicker date input-group" id="package_start_date">
                            @if($employer->package_start_date)
                            <input type="text" name="package_start_date" id="package_start_date" class="form-control seeker_input" value="{{ date('d-m-Y', strtotime($employer->package_start_date)) }}" placeholder="Package Effective Date">
                            @else
                            <input type="text" name="package_start_date" id="package_start_date" class="form-control seeker_input" value="" placeholder="Package Effective Date">
                            @endif
                            <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                        <input type="radio" name="is_active" id="active" class="" value="1" @if($employer->is_active == 1) checked required @endif> <label for="active"> Active</label><br>
                        <input type="radio" name="is_active" id="in_active" class="" value="0" @if($employer->is_active == 0) checked required @endif> <label for="in_active"> In Active</label>
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
    $(document).ready(function() {
        $('#package_start_date').datepicker({
            language: "es",
            autoclose: true,
            format: "dd-mm-yyyy"
        });

        $("#package_id").change(function() {
            if($(this).val() != "") {
                $(".package_start_date_required").removeClass("d-none");
                $("#package_start_date").prop("required", true);
            }else {
                $(".package_start_date_required").addClass("d-none");
                $("#package_start_date").prop("required", false);
            }
        });

        $(".logo-remove").click(function(){
            $("#imageUpload").val('');
            $('#imagePreview').css('background-image', 'url(https://placehold.jp/150x150.png)');
            $("#imageRemove").val('empty');
        })
    });
</script>
@endpush