@extends('frontend.layouts.app')
@section('content')

<div class="col-xl-10 col-lg-12 m-auto" style="">
    @include('seeker.profile.seeker-sub-header')
    <div class="tab-content" id="seekerTabContent">
        <div class="tab-pane fade p-0 show active edit-profile-header-border" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
            @include('seeker.resume.create')
        </div>
    </div>
    
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
    })

    $('.next-career-history').click(function() {
        $("#nav-cv-build-tab").removeClass('active');
        $("#nav-career-choice-tab").addClass('active');
        $("#nav-cv-attach-tab").removeClass('active');
        $("#nav-cv-build").removeClass('show active');
        $("#nav-career-choice").addClass('show active');
        $("#nav-cv-attach").removeClass('show active');
    })
</script>
@endpush