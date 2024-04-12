@extends('admin.layouts.app')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Manage Job Post</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row card-header py-3 m-0">
            <h6 class="col font-weight-bold text-primary">Job Post</h6>
            @can('job-post-create')
            <div class="col">
                <a href="{{ route('job-posts.create') }}" class="btn btn-primary btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Add New</span>
                </a>
            </div>
            @endcan
        </div>
        @include('sweetalert::alert')
        <div class="card-body">
            <div class="table-responsive">
                
                <div class="row">
                    <div class="col text-end py-2">
                        <label for="search_job_post" class="d-inline-block">Search:</label>
                        <input type="text" name="search_job_post" id="search_job_post" class="form-control form-control-sm d-inline-block col-2" value="{{ $_GET['search'] ?? '' }}">
                    </div>
                </div>
                <div class="data-fetch">
                @include('admin.jobpost.table')
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
@push('script')
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('#search_job_post').on('keyup', function() {
            $value = $(this).val();
            $.ajax({
                type : 'GET',
                url : '{{ route("job-posts.index") }}',
                data: {
                    'search' : $value
                },
                success:function(data){
                    $('.data-fetch').empty().html(data);
                }
            });
        })
    })
</script>
@endpush
