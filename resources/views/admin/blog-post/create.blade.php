@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Blog Post</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Blog Post Create</h6>
            <div class="col">
                <a href="{{ route('blog-post.index') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-reply"></i>
                    </span>
                    <span class="text">Back</span>
                </a>
            </div>
            
        </div>
        <div class="card-body">
            <form action="{{ route('blog-post.store') }}" method="post" enctype="multipart/form-data">
                @csrf 
                
                <div class="col-4 form-group">
                    <label for="title">Blog Post Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Enter Blog Post Title" value="{{ old('title') }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-4 form-group">
                    <label for="category_id">Choose Blog Category Name <span class="text-danger">*</span> </label>
                    <select name="category_id" id="category_id" class="form-control select_2 @error('category_id') is-invalid @enderror">
                        <option value=""></option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if( old('category_id') == $category->id ) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-4 image-upload form-group">
                    
                    <div class="image-edit position-relative">
                        <span>Blog Post Image 
                            <div class="image-preview">
                                <label for="blog-image">
                                    <img src="https://via.placeholder.com/1920x600" alt="" id="imagePreview" class="w-100">
                                </label>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger blog-image-remove d-none ">
                                <i class="fa-solid fa-xmark text-white"></i>
                                </span>
                            </div>
                        </span>
                        
                        <input type="file" class="form-control blog-image invisible" name="image" id="blog-image" accept="image/*" />
                        <input type="hidden" name="image_base64">
                    </div>
                </div>
                <div class="col-4 form-group">
                    <label for="description" class="seeker_label">Description</label>
                    <textarea name="description" id="description" cols="30" rows="5" class="seeker_input summernote description form-control"></textarea>
                </div>
                
                <div class="col-4 form-group">
                    <label for="is_active">Active Status <span class="text-danger">*</span></label> <br>
                    <input type="radio" name="is_active" id="active" class="" value="1" checked required> <label for="active"> Active</label><br>
                    <input type="radio" name="is_active" id="in_active" class="" value="0"> <label for="in_active"> In Active</label>
                    @error('is_active')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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

<!-- upload blog image modal  -->
<div class="modal" id="upload_blog_image">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Crop Image And Upload</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="resizer_blog_image"></div>
                    <button class="btn btn-block btn-dark" id="upload_blog_image_submit" > 
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

        var el = document.getElementById('resizer_blog_image');
        $(".blog-image").on("change", function(event) {
            $("#upload_blog_image").modal('show');
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

        $("#upload_blog_image_submit").on("click", function() {
            croppie.result({
                type: 'blob',
                size: { 
                    width: 1920, height: 600 
                }
            }).then(function(blob) {
                $("#upload_blog_image").modal("hide"); 
                
                $('.blog-image-remove').removeClass('d-none');
                
                console.log(blob)
                const blobUrl = URL.createObjectURL(blob) // blob is the Blob object
                
                $('#imagePreview').attr('src', blobUrl);

                $(".blog-image").val(blob);
                
                croppie.destroy();
            });
        });

        $('.blog-image-remove').click(function() {
            $('#imagePreview').attr('src', 'https://via.placeholder.com/1920x600');
            $('.blog-image-remove').addClass('d-none');
            $('.blog-image').val('');
            $("input[name='image_base64']").val('');
        })
    });
</script>
@endpush