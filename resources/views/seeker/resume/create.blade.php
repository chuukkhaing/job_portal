@extends('frontend.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col py-5" id="resume-form">
            <div class="container m-auto">
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            Personal Information
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                @include('seeker.resume.personal_information')
                            </div>
                        </div>
                    </div>
                    {{--<div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                            Education
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                            Accordion Item #3
                        </button>
                        </h2>
                        <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                        </div>
                    </div>--}}
                </div>
            </div>
        </div>
        <div class="col resume-template-background">
            <page size="A4">
                <div class="mt-4">
                    <div class="mb-4">
                        <div class="row">
                            <div class="col">
                                <p><span class="gender_type">@if(Auth::guard('seeker')->user()->gender == "Male") Mr. @else Ms. @endif</span><sapn class="first_name">{{ Auth::guard('seeker')->user()->first_name }}</sapn> <span class="last_name">{{ Auth::guard('seeker')->user()->last_name }}</span></p>
                                <p><span class="township"></span> <span class="state"></span> <span class="country">{{ Auth::guard('seeker')->user()->country }}</span></p>
                                <p><span class="phone">{{ Auth::guard('seeker')->user()->phone }}</span></p>
                                <p><span class="email">{{ Auth::guard('seeker')->user()->email }}</span></p>
                            </div>
                            <div class="col profile-img-preview @if(Auth::guard('seeker')->user()->image) @else d-none @endif">
                                @if(Auth::guard('seeker')->user()->image)
                                <img class="app_receive_pic resume_profile_img img-thumbnail" src="{{ asset('storage/seeker/profile/'.(Auth::guard('seeker')->user()->id).'/'.Auth::guard('seeker')->user()->image) }}" alt="profile_pic" width="130px" height="130px">
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
                </div>
            </page>
        </div>
    </div>
</div>

@endsection
