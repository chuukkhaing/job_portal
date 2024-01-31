@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Site Setting</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Site Setting Update</h6>
            
        </div>
        <div class="card-body">
        @include('sweetalert::alert')
            
            <form action="{{ route('site-setting.update', $site_setting->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="site_title">Site Title</label>
                        <input type="text" class="form-control" id="site_title" name="site_title" value="{{ $site_setting->site_title }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="site_tag">Site Tag</label>
                        <input type="text" class="form-control" id="site_tag" name="site_tag" value="{{ $site_setting->site_tag }}">
                    </div>
                </div>
                {{--<div class="row">
                    <div class="form-group col-md-4">
                        <label for="site_logo">Site Logo</label> <br>
                        <div class="dropzone dropzone-file-area">
                            <div class="@if(isset($site_setting->site_logo)) edit-dropzone-site-logo-text @else dropzone-site-logo-text @endif">
                                <h3 class="">Single File Upload.</h3>
                                <i class="flaticon-note-2 d-block mt-3 mb-3"></i>
                            </div>
                            <input type="hidden" name="sitelogo_empty" class="sitelogo_empty">
                            <input type="file" name="site_logo" id="site_logo" accept="image/*" class="dropzone-site-logo">
                            <button type="button" class="btn btn-danger remove_site_logo @if(!isset($site_setting->site_logo)) d-none @endif">x</button>
                            <div class="sitelogoPreview">@if(isset($site_setting->site_logo))<img class="image-preview" src="{{ asset('/storage/site_logo').'/'.$site_setting->site_logo }}" alt="{{ $site_setting->site_title }}">@endif</div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="favicon">Favicon</label> <br>
                        <div class="dropzone dropzone-file-area">
                            <div class="@if(isset($site_setting->favicon)) edit-dropzone-favicon-text @else dropzone-favicon-text @endif">
                                <h3 class="">Single File Upload.</h3>
                                <i class="flaticon-note-2 d-block mt-3 mb-3"></i>
                            </div>
                            <input type="hidden" name="favicon_empty" class="favicon_empty">
                            <input type="file" name="favicon" id="favicon" accept="image/*" class="dropzone-favicon">
                            <button type="button" class="btn btn-danger remove_favicon @if(!isset($site_setting->favicon)) d-none @endif">x</button>
                            <div class="faviconPreview">@if(isset($site_setting->favicon))<img class="image-preview" src="{{ asset('/storage/favicon').'/'.$site_setting->favicon }}" alt="{{ $site_setting->site_title }}">@endif</div>
                        </div>
                    </div>
                </div>--}}
                <hr>
                <h3>SEO</h3>
                {{--<div class="row">
                    <div class="form-group col-md-4">
                        <label for="image">Feature Image</label> <br>
                        <div class="dropzone dropzone-file-area">
                            <div class="@if(isset($site_setting->feature_image)) edit-dropzone-file-text @else dropzone-file-text @endif">
                                <h3 class="">Single File Upload.</h3>
                                <i class="flaticon-note-2 d-block mt-3 mb-3"></i>
                            </div>
                            <input type="hidden" name="image_empty" class="image_empty">
                            <input type="file" name="image" id="image" accept="image/*" class="dropzone-input-file">
                            <button type="button" class="btn btn-danger remove_image @if(!isset($site_setting->feature_image)) d-none @endif">x</button>
                            <div class="imagePreview">@if(isset($site_setting->feature_image))<img class="image-preview" src="{{ asset('/storage/feature_image').'/'.$site_setting->feature_image }}" alt="{{ $site_setting->site_title }}">@endif</div>
                        </div>
                    </div>
                </div>--}}
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="seo_keyword">SEO Keywords </label>
                        <input type="text" name="seo_keyword" id="seo_keyword" class="form-control" value="{{ $site_setting->seo_keyword }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="seo_description">SEO Description </label>
                        <textarea name="seo_description" id="seo_description" cols="30" rows="10" name="seo_description" class="form-control">{{ $site_setting->seo_description }}</textarea>
                    </div>
                </div>
                <button class="btn btn-primary btn-icon-split btn-sm" type="submit">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Save</span>
                </button>
                <a class="btn btn-warning btn-icon-split btn-sm" href="{{ route('site-setting.reset', $site_setting->id) }}">
                    <span class="icon text-white-50">
                        <i class="fas fa-power-off"></i>
                    </span>
                    <span class="text">Reset</span>
                </a>
            </form>
            
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection