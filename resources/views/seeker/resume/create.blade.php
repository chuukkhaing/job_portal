@extends('frontend.layouts.app')
@section('content')
<div class="text-end pt-5 pr-5">
    <a href="{{ route('profile.edit', Auth::guard('seeker')->user()->id) }}" class="btn btn-sm profile-save-btn">Back</a>
</div>
<div class="container-fluid my-2" id="edit-profile-body">
    <div class="m-0 pb-0 pt-3">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="p-3 job-post-detail nav-link active" id="nav-cv-build-tab" data-bs-toggle="tab" data-bs-target="#nav-cv-build" type="button" role="tab" aria-controls="nav-cv-build" aria-selected="true">Build Your CV </button>
                <button class="p-3 job-post-detail nav-link" id="nav-career-choice-tab" data-bs-toggle="tab" data-bs-target="#nav-career-choice" type="button" role="tab" aria-controls="nav-career-choice" aria-selected="false">Career of Choice</button>
                <button class="p-3 job-post-detail nav-link" id="nav-cv-attach-tab" data-bs-toggle="tab" data-bs-target="#nav-cv-attach" type="button" role="tab" aria-controls="nav-cv-attach" aria-selected="false">CV Attachment</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane p-3 fade show active" id="nav-cv-build" role="tabpanel" aria-labelledby="nav-cv-build-tab">
                
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col my-5 mx-0" id="resume-form">
                            <div class="container-fluid m-auto px-0">
                                <div class="accordion accordion-flush" id="accordionFlushExample" style="border: 1px solid black">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                                            Personal Information
                                        </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            @include('seeker.resume.personal_information')
                                        </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                        Career History
                                        </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            @include('seeker.resume.experience')
                                        </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                            Education
                                        </button>
                                        </h2>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                @include('seeker.resume.education')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                            Skills
                                        </button>
                                        </h2>
                                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                @include('seeker.resume.skill')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingFive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                            Languages
                                        </button>
                                        </h2>
                                        <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                @include('seeker.resume.language')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingSive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSive" aria-expanded="false" aria-controls="flush-collapseSive">
                                            References
                                        </button>
                                        </h2>
                                        <div id="flush-collapseSive" class="accordion-collapse collapse" aria-labelledby="flush-headingSive" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                @include('seeker.resume.reference')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col resume-template-background">
                            <page size="A4">
                                <div class="mt-4">
                                    <div class="mb-4">
                                        <h3 class="text-center">Resume</h3>
                                        @include('seeker.resume.personal_details')
                                        <div class="row resume-section mb-3 summary_label @if(Auth::guard('seeker')->user()->summary) @else d-none @endif">
                                            <h5 class="text-white resume-header py-2">Profile Summary</h5>
                                            <div class="col py-2">
                                                <span class="summary">{!! Auth::guard('seeker')->user()->summary !!}</span>
                                            </div>
                                        </div>
                                        @include('seeker.resume.exp_details')
                                        @include('seeker.resume.edu_details')
                                        @include('seeker.resume.skill_details')
                                        @include('seeker.resume.language_details')
                                        @include('seeker.resume.reference_details')
                                    </div>
                                </div>
                            </page>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-12 text-end">
                            <a href="{{ url('/seeker/download-ic-cv/'. Auth::guard('seeker')->user()->id) }}" class="btn btn-sm profile-save-btn">Download CV</a>
                            <button type="button" class="btn btn-sm profile-save-btn next-career-history">Next</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-3 fade" id="nav-career-choice" role="tabpanel" aria-labelledby="nav-career-choice-tab">
                @include('seeker.resume.career-of-choice')
            </div>
            <div class="tab-pane p-3 fade" id="nav-cv-attach" role="tabpanel" aria-labelledby="nav-cv-attach-tab">
                @include('seeker.resume.cv-attach')
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
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