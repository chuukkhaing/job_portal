@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Page SEO</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Page SEO Create</h6>
            <div class="col">
                <a href="{{ route('seo.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('seo.store') }}" method="post" enctype="multipart/form-data">
                @csrf 
                
                <div class="row">
                    
                    <div class="col-4 form-group">
                        <label for="page">Choose Page <span class="text-danger">*</span> </label>
                        <select name="page" id="page" class="form-control select_2 @error('page') is-invalid @enderror">
                            <option value=""></option>
                            @foreach ($pages as $page)
                            <option value="{{ $page }}" @if( old('page') == $page ) selected @endif>{{ $page }}</option>
                            @endforeach
                        </select>
                        @error('page')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 image-upload form-group">
                        
                        <div class="image-edit position-relative">
                            <span>Feature Image
                                <div class="image-preview">
                                    <label for="feature-image">
                                        <img src="https://via.placeholder.com/400x125" alt="" id="imagePreview" class="w-100">
                                    </label>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger feature-image-remove d-none ">
                                    <i class="fa-solid fa-xmark text-white"></i>
                                    </span>
                                </div>
                            </span>
                            
                            <input type="file" class="form-control feature-image invisible" name="feature_image" id="feature-image" accept="image/*" />
                            
                        </div>
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-4 form-group">
                        <label for="seo_keyword" class="seeker_label">SEO Keywords</label>
                        <input type="text" name="seo_keyword" id="seo_keyword" class="form-control" value="{{ old('seo_keyword') }}">
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-4 form-group">
                        <label for="seo_description" class="seeker_label">SEO Description</label>
                        <textarea name="seo_description" id="seo_description" cols="30" rows="10" class="form-control">{{ old('seo_description') }}</textarea>
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

<!-- upload feature image modal  -->
<div class="modal" id="upload_feature_image">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Crop Image And Upload</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="resizer_feature_image"></div>
                    <button class="btn btn-block btn-dark" id="upload_feature_image_submit" > 
                    Crop And Upload</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {

        var el = document.getElementById('resizer_feature_image');
        $(".feature-image").on("change", function(event) {
            $("#upload_feature_image").modal('show');
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

        $("#upload_feature_image_submit").on("click", function() {
            croppie.result({
                type: 'blob',
                size: { 
                    width: 1920, height: 600 
                }
            }).then(function(blob) {
                $("#upload_feature_image").modal("hide"); 
                
                $('.feature-image-remove').removeClass('d-none');
                
                const blobUrl = URL.createObjectURL(blob)
                
                $('#imagePreview').attr('src', blobUrl);

                let file = new File([blob], "img.jpg",{type:"image/jpeg", lastModified:new Date().getTime()});
                let container = new DataTransfer();
                container.items.add(file);

                const fileInput = document.querySelector('input[name="feature_image"]');

                fileInput.files = container.files;
                
                croppie.destroy();
            });
        });

        $('.feature-image-remove').click(function() {
            $('#imagePreview').attr('src', 'https://via.placeholder.com/400x125');
            $('.feature-image-remove').addClass('d-none');
            $('.feature-image').val('');
        })
    });
</script>
@endpush