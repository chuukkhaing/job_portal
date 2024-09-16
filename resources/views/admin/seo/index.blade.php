@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Page SEO</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Page SEO</h6>
            
            <div class="col">
                <a href="{{ route('seo.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New</span>
                </a>
            </div>
            
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Page Name</th>
                            <th>SEO Keyword</th>
                            <th>SEO Descripition</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seos as $key => $seo)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $seo->page_name }}</td>
                            <td>{{ $seo->seo_keyword ?? '-' }}</td>
                            <td>{!! \Illuminate\Support\Str::words(strip_tags($seo->seo_description), 25, $end = '...') !!}</td>
                            <td>
                                
                                <a href="{{ route('seo.edit', $seo->id) }}" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                                
                                <form method="POST" action="{{ route('seo.destroy', $seo->id) }}" class="d-inline">
                                    @csrf 
                                    @method('DELETE') 
                                        <button class="btn btn-danger btn-circle btn-sm delete-confirm text-light" type="submit"><i class="fas fa-trash"></i></button>
                                </form>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection