@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sliders</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Slider Create</h6>
            <div class="col">
                <a href="{{ route('slider.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('slider.store') }}" method="post" enctype="multipart/form-data">
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
                    <label for="employer_id">Choose Employer <span class="text-danger">*</span></label>
                    <select name="employer_id" id="employer_id" class="select_2 form-control" required>
                        <option value=""></option>
                        @foreach($employers as $employer)
                        <option value="{{ $employer->id }}" @if( old('employer_id') == $employer->id) selected @endif>{{ $employer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="serial_no">Serial No. <span class="text-danger">*</span></label>
                    <select name="serial_no" id="serial_no" class="form-control" required>
                        <option value="">Choose Serial No.</option>
                        <option value="1" @if( old('serial_no') == 1) selected @endif>1</option>
                        <option value="2" @if( old('serial_no') == 2) selected @endif>2</option>
                        <option value="3" @if( old('serial_no') == 3) selected @endif>3</option>
                        <option value="4" @if( old('serial_no') == 4) selected @endif>4</option>
                        <option value="5" @if( old('serial_no') == 5) selected @endif>5</option>
                        <option value="6" @if( old('serial_no') == 6) selected @endif>6</option>
                    </select>
                </div>

                <div class="image-upload form-group">
                    
                    <div class="image-edit">
                        <label for="slider-image">Slider Image <span class="text-danger">*</span>
                            <div class="image-preview">
                                <div id="imagePreview" style="background-image: url(https://via.placeholder.com/1920x600);">
                                </div>
                            </div>
                        </label>
                        <input type="file" class="form-control slider-image" name="image" id="slider-image" accept="image/*" />
                        <input type="hidden" name="image_base64">
                        <span class="slider-remove btn-sm btn-danger d-none">x</span>
                    </div>
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
    <!-- upload slider modal  -->
    <div class="modal" id="upload_slider">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Crop Image And Upload</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="resizer_slider"></div>
                    <button class="btn btn-block btn-dark" id="upload_slider_submit" > 
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

        var el = document.getElementById('resizer_slider');
        $(".slider-image").on("change", function(event) {
            $("#upload_slider").modal('show');
            croppie = new Croppie(el, {
                
                viewport: {
                    width: 400,
                    height: 125,
                    type: 'square'
                },
                boundary: {
                    width: 450,
                    height: 175,
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

        $("#upload_slider_submit").on("click", function() {
            croppie.result({
                typ: 'base64',
                size: { 
                    width: 1920, height: 600 
                }
            }).then(function(base64) {
                $("#upload_slider").modal("hide"); 
                
                $('.slider-remove').removeClass('d-none');
                
                $('#imagePreview').attr('style', 'background-image: url('+base64+')');

                $("input[name='image_base64']").val(base64);
                
                croppie.destroy();
            });
        });

        $('.slider-remove').click(function() {
            $('#imagePreview').attr('style', 'background-image: url(https://via.placeholder.com/1920x600)');
            $('.slider-remove').addClass('d-none');
            $('.slider-image').val('');
            $("input[name='image_base64']").val('');
        })
    });
</script>
@endpush