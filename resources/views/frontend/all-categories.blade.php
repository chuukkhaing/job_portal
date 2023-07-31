@extends('frontend.layouts.app')
@section('content')

<!-- Popular Job Category Start  -->
@if($industries->count() > 0)
<div class="container">
    <div class="popular-job-category">
        <div id="header-popular-job-category" class="text-center py-5">
            <h3 id="popular-job-category-title">Popular Job Categories</h3>
            <span id="popular-job-category-sub-title">{{ $live_job }} jobs live - {{ $today_job }} added today</span>
        </div>
        <div id="body-popular-job-category" class="row">
            @foreach($industries as $industry)
            <div class="col-lg-3 col-md-4 col-sm-2 p-2">
                @if($industry->JobPost->count() > 0)
                <a href="{{ route('industry-job',$industry->id) }}">
                @endif
                    <div id="job-category-box" class="text-center">
                        <div id="job-category-icon">
                        <i class="{{ $industry->icon }}"></i>
                        </div>
                        <div id="job-category-name">
                        <span id="job-category-name-title" class="d-block">{{ $industry->name }}</span>
                        <span id="job-category-name-position">{{ $industry->JobPost->where('is_active',1)->where('status','Online')->count() }} open positions</span>
                        </div>
                    </div>
                @if($industry->JobPost->count() > 0)
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
<!-- Popular Job Category End  -->
@endsection