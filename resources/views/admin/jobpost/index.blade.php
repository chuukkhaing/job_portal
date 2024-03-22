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
                <table class="table table-bordered" id="job-post-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Job Title</th>
                            <th>Employer Name</th>
                            <th>Industry</th>
                            <th>Main Functional Area</th>
                            <th>Activation</th>
                            <th>Job Post Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection
@push('script')

<script>
    $(function() {
        new DataTable('#job-post-dataTable', {
            ajax: {
                url: "{{ route('job-posts.index') }}",
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex' },
                { data: 'job_title' },
                { data: 'employer_name' },
                { data: 'industry' },
                { data: 'main_functional_area' },
                { data: 'activation' },
                { data: 'job_post_status' },
                { data: 'action' }
            ],
            draw: 1,
            processing: true,
            serverSide: true
        });
    })
</script>
@endpush