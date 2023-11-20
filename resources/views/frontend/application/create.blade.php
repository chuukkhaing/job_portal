@extends('frontend.layouts.app')
@section('content')
<div class="container-fluid shadow">
    <div class="p-3">
        <nav>
            <div class="nav nav-tabs resume" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-cv-build-tab" data-bs-toggle="tab" data-bs-target="#nav-cv-build" type="button" role="tab" aria-controls="nav-cv-build" aria-selected="true">Step 1. Build Your CV </button>
                <button class="nav-link" id="nav-career-choice-tab" data-bs-toggle="tab" data-bs-target="#nav-career-choice" type="button" role="tab" aria-controls="nav-career-choice" aria-selected="false">Step 2. Career of Choice</button>
                <button class="nav-link" id="nav-cv-attach-tab" data-bs-toggle="tab" data-bs-target="#nav-cv-attach" type="button" role="tab" aria-controls="nav-cv-attach" aria-selected="false">Step 3. CV Attachment</button>
            </div>
        </nav>
        
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-cv-build" role="tabpanel" aria-labelledby="nav-cv-build-tab">
                
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12 col-lg-6 mx-0" id="resume-form">
                            <div class="container-fluid m-auto px-0">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingEmail">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEmail" aria-expanded="true" aria-controls="flush-collapseEmail">
                                            Email
                                        </button>
                                        </h2>
                                        <div id="flush-collapseEmail" class="accordion-collapse collapse show" aria-labelledby="flush-headingEmail" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                        @include('frontend.application.email')
                                        </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            Personal Information
                                        </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                        @include('frontend.application.personal_information')
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
                                        @include('frontend.application.experience')
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
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingSix">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                            References
                                        </button>
                                        </h2>
                                        <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingSeven">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                                            Profile Summary
                                        </button>
                                        </h2>
                                        <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <textarea name="summary" id="summary" class="form-control summernote_resume"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-none d-lg-block resume-template-background">
                            <page size="A4">
                                <div class="resume-border">
                                @include('frontend.application.personal_details')
                                </div>
                            </page>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-sm profile-save-btn m-2 d-inline d-lg-none" data-bs-toggle="modal" data-bs-target="#resume_preview" id="create-exp">
                                Preview
                            </button>
                            <a href="" class="btn btn-sm profile-save-btn">Download CV</a>
                            <button type="button" class="btn btn-sm profile-save-btn next-career-history">Next</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane px-0 px-md-3 fade" id="nav-career-choice" role="tabpanel" aria-labelledby="nav-career-choice-tab">
                
            </div>
            <div class="tab-pane px-0 px-md-3 fade" id="nav-cv-attach" role="tabpanel" aria-labelledby="nav-cv-attach-tab">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="resume_preview" tabindex="-1" aria-labelledby="resume_previewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resume_previewLabel">Resume Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="resume-border">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger close-btn" data-bs-dismiss="modal">Close</button>
                
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

    function checkEmail() {
        if($(this).val() == '' && $("#email").val() == '') {
            MSalert.principal({
                icon:'error',
                title:'Error',
                description: 'Please fill the Email and Phone first.',
            })
        }
    }
    
</script>
@endpush