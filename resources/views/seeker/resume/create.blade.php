@extends('frontend.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col py-5" id="resume-form">
            <div class="container-fluid m-auto">
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
                        <div class="row">
                            <div class="col">
                                <p><span class="gender_type">@if(Auth::guard('seeker')->user()->gender == "Male") Mr. @elseif(Auth::guard('seeker')->user()->gender == "Female") Ms. @endif</span><sapn class="first_name">{{ Auth::guard('seeker')->user()->first_name }}</sapn> <span class="last_name">{{ Auth::guard('seeker')->user()->last_name }}</span></p>
                                <p><span class="township"></span> <span class="state"></span> <span class="country">{{ Auth::guard('seeker')->user()->country }}</span></p>
                                <p><span class="phone">{{ Auth::guard('seeker')->user()->phone }}</span></p>
                                <p><span class="email">{{ Auth::guard('seeker')->user()->email }}</span></p>
                            </div>
                            <div class="col profile-img-preview @if(Auth::guard('seeker')->user()->image) @else d-none @endif">
                                @if(Auth::guard('seeker')->user()->image)
                                <img class="app_receive_pic resume_profile_img img-thumbnail" src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="profile_pic" width="130px" height="130px">
                                @else
                                <img src="https://placehold.jp/200x200.png" alt="Profile Image" class="img-thumbnail resume_profile_img">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 personal-info-preview @if(Auth::guard('seeker')->user()->SeekerPercentage->where('title','Personal Information')->percentage = 0) d-none @endif">
                        <h5 class="text-decoration-underline">Personal Information</h5>
                        
                        <div class="row my-3">
                            <div class="col">
                                <span>Name</span>
                                <span class="float-end">:</span>
                            </div>
                            <div class="col">
                                <span class="first_name">{{ Auth::guard('seeker')->user()->first_name }}</span> <span class="last_name">{{ Auth::guard('seeker')->user()->last_name }}</span>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <span>Date Of Birth</span>
                                <span class="float-end">:</span>
                            </div>
                            <div class="col">
                                <span class="date_of_birth">{{ date('d-m-Y', strtotime(Auth::guard('seeker')->user()->date_of_birth)) }}</span>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <span>NRC Number/ID</span>
                                <span class="float-end">:</span>
                            </div>
                            <div class="col">
                                <span class="nrc">{{ Auth::guard('seeker')->user()->nrc }}</span><span class="id_card">{{ Auth::guard('seeker')->user()->id_card }}</span>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <span>Nationality</span>
                                <span class="float-end">:</span>
                            </div>
                            <div class="col">
                                <span class="nationality">{{ Auth::guard('seeker')->user()->nationality }}</span>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <span>Gender</span>
                                <span class="float-end">:</span>
                            </div>
                            <div class="col">
                                <span class="gender">{{ Auth::guard('seeker')->user()->gender }}</span>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <span>Marital Status</span>
                                <span class="float-end">:</span>
                            </div>
                            <div class="col">
                                <span class="marital_status">{{ Auth::guard('seeker')->user()->marital_status }}</span>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <span>Address Detail</span>
                                <span class="float-end">:</span>
                            </div>
                            <div class="col">
                                <span class="address_detail">{{ Auth::guard('seeker')->user()->address_detail }}</span>
                            </div>
                        </div>
                        {{--<div class="row my-3">
                            <div class="col">
                                <span style="font-weight: bold">Notice Period</span>
                                <span style="font-weight: bold" class="float-end">:</span>
                            </div>
                            <div class="col">
                                <span style="font-weight: bold" class="notice_period"></span>
                            </div>
                        </div>--}}
                        <div class="row my-3">
                            <div class="col">
                                <span style="font-weight: bold">Expected Salary</span>
                                <span style="font-weight: bold" class="float-end">:</span>
                            </div>
                            <div class="col">
                                <span style="font-weight: bold" class="expected_salary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 career-description-preview @if(Auth::guard('seeker')->user()->summary) @else d-none @endif">
                        <h5 class="text-decoration-underline">Career Description</h5>
                        <p class="career-description">{{ Auth::guard('seeker')->user()->summary }}</p>
                    </div>
                    
                    <div class="mb-4 edu-resume @if(Auth::guard('seeker')->user()->SeekerEducation->count() > 0) @else d-none @endif">
                        <h5 class="text-decoration-underline">Education</h5>
                        <div class="app_receive_education">
                            @foreach(Auth::guard('seeker')->user()->SeekerEducation as $edu)
                            <p class="pdf-title">{{ $edu->location }}</p>
                            <p><span class="pdf-title">{{ $edu->degree }} </span> - {{ $edu->major_subject }}</p>
                            <p>{{ $edu->from }} to {{ $edu->to }}</p>
                            <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </page>
        </div>
    </div>
</div>

@endsection
