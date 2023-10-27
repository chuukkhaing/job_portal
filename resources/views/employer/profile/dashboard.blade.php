@extends('frontend.layouts.app')
@section('content')

<div class="container employer-dashboard mt-3">
    @include('employer.profile.employer-sub-header')
    <div class="tab-content" id="employerTabContent">
        @if(Auth::guard('employer')->user()->employer_id == Null || (Auth::guard('employer')->user()->employer_id && Auth::guard('employer')->user()->MemberPermission->where('name','dashboard')->count() > 0))
        <div class="tab-pane fade p-0 show active" id="employer-dashboard">@include('employer.profile.employer-dashboard')</div>
        @endif
    </div>
    
</div>

@endsection