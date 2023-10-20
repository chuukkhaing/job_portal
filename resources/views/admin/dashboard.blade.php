@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
@include('sweetalert::alert')
    <!-- Content Row -->
    <div class="row">

        <!-- Pending Job Post Request -->
        <a href="{{ route('job-posts.index', ['status' => 'Pending']) }}" class="text-decoration-none col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Pending Job Post Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jobpostpending }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <!-- Online Job Post -->
        <a href="{{ route('job-posts.index', ['status' => 'Online']) }}" class="text-decoration-none col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Online Job Post</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jobposts }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <!-- Active Seeker -->
        <a href="{{ route('seeker.index', ['is_active' => 1]) }}" class="text-decoration-none col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Seeker</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $seekers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users-gear fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <!-- Active Employer -->
        
        <a href="{{ route('employers.index', ['is_active' => 1]) }}" class="text-decoration-none col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 dashboard-card">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Active Employer</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $employers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>

    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ $chart1->options['chart_title'] }}</div>

                <div class="card-body">

                    {!! $chart1->renderHtml() !!}

                </div>

            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ $chart2->options['chart_title'] }}</div>

                <div class="card-body">

                    {!! $chart2->renderHtml() !!}

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
{!! $chart2->renderJs() !!}
@endpush