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
                <a href="{{ route('employers.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('employers.store') }}" method="post" enctype="multipart/form-data">
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
                <div class="logo-upload form-group my-3">
                    <div class="logo-edit">
                        <input type="file" class="form-control employer-logo-upload" name="logo" id="employer-logo" accept="image/*" />
                        <label for="employer-logo"></label>
                        <input type="hidden" name="image_base64">
                    </div>
                    <div class="logo-remove d-none">
                        <label for="imageRemove"></label>
                    </div>
                    <div class="logo-preview">
                        <div id="imagePreview" style="background-image: url(https://placehold.jp/200x200.png);">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6 form-group">
                        <label for="name">Employer Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Employer name" required value="{{ old('name') }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="email">Employer Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Employer Email" required value="{{ old('email') }}">
                    </div>

                    <div class="col-6 form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" required value="">
                    </div>

                    <div class="col-6 form-group">
                        <label for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="datepicker form-control" name="confirm-password" id="confirm-password" placeholder="Enter Password" required value="">
                    </div>

                    <div class="col-4 form-group">
                        <label for="package_id">Choose Package <span class="text-danger">*</span> </label>
                        <select name="package_id" id="package_id" class="form-control select_2" required>
                            <option value=""></option>
                            @foreach ($packages as $package)
                            <option value="{{ $package->id }}" @if( old('package_id') == $package->id ) selected @endif>{{ $package->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-4 form-group">
                        <label for="package_id">Package Effective Date </label>
                        <div class="datepicker date input-group" id="package_start_date">
                            <input type="text" name="package_start_date" id="package_start_date" class="form-control seeker_input" value="{{ date('d-m-Y',strtotime(now())) }}" placeholder="Package Effective Date">
                            <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-6 form-group">
                        <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                        <input type="radio" name="is_active" id="active" class="" value="1" checked required> <label for="active"> Active</label><br>
                        <input type="radio" name="is_active" id="in_active" class="" value="0"> <label for="in_active"> In Active</label>
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
    <!-- upload logo modal  -->
    <div class="modal" id="upload_logo">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Crop Image And Upload</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="resizer_logo"></div>
                    <button class="btn btn-block btn-dark" id="upload_logo_submit" > 
                    Crop And Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

        var el = document.getElementById('resizer_logo');
        $(".employer-logo-upload").on("change", function(event) {
            $("#upload_logo").modal('show');
            croppie = new Croppie(el, {
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'square'
                },
                boundary: {
                    width: 250,
                    height: 250
                }
            });
            getImage(event.target, croppie); 
        });
        
        $(".close").click(function() {
            croppie.destroy();
        })
        
        function getImage(input, croppie) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {  
                    croppie.bind({
                        url: e.target.result,
                    });
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#upload_logo_submit").on("click", function() {
            croppie.result('base64').then(function(base64) {

                $("#upload_logo").modal("hide"); 
                
                $('.logo-remove').removeClass('d-none');
                
                $('#imagePreview').attr('style', 'background-image: url('+base64+')');

                $("input[name='image_base64']").val(base64);
                
                croppie.destroy();
            });
        });

        $('.logo-remove').click(function() {
            $('#imagePreview').attr('style', 'background-image: url(https://placehold.jp/200x200.png)');
            $('.logo-remove').addClass('d-none');
            $('.employer-logo-upload').val('');
            $("input[name='image_base64']").val('');
        })
    });
</script>
@endpush