
<div class="container-fluid p-0">
    <div class="row" style="background-color: #0355d06b;">
        <div class="col my-5 mx-0" id="resume-form">
            <div class="container-fluid m-auto px-0">
                <div class="accordion accordion-flush" id="accordionFlushExample">
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
                            Education
                        </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            @include('seeker.resume.education')
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            Career History
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
                        <h2 class="accordion-header" id="flush-headingSive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSive" aria-expanded="false" aria-controls="flush-collapseSive">
                            References
                        </button>
                        </h2>
                        <div id="flush-collapseSive" class="accordion-collapse collapse" aria-labelledby="flush-headingSive" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                
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
                        @include('seeker.resume.edu_details')
                    </div>
                </div>
            </page>
        </div>
    </div>
</div>

