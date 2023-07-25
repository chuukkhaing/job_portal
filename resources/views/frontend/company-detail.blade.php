@extends('frontend.layouts.app')
@section('content')

<!-- Banner Start -->
<div class="container-fluid p-0">
    <div class="row company-detail-banner">
        <img src="{{ asset('/frontend/img/company/company-banner-image.png') }}" class="w-100" alt="">
    </div>
</div>
<!-- Banner End -->

<!-- Company Profile Start -->
<div class="container company-profile my-5">
    <div class="row pt-3 px-3">
        <div class="col-lg-6 col-md-6 col-6">
            <img src="{{ asset('frontend/img/company/profile-image.png') }}" class="" alt="">
        </div>

        <div class="col-lg-6 col-md-6 col-6">
            <img src="{{ asset('frontend/img/company/qr-image.png') }}" class="profile-qr pull-right mt-2" alt="">
        </div>
    </div>

    <div class="row px-3">
        <div class="col-lg-6 col-md-6 col-12">
            <div class="company-name pt-4 pb-2">
                <h3>Globex Corporation</h3>
            </div>

            <div class="company-address">
                <p>5781 Spring St. Portsmouth, OH, 45662 | Scioto County</p>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12 p-0">
            <div class="send-message mt-4">
                <button type="button" class="btn see-all-btn pull-right mt-4"> 
                    <i class="fa-regular fa-envelope"></i>
                    <span class="p-1">Send Message</span> 
                </button>
            </div>
            
            <div class="favourite mt-4">
                <button type="button" class="btn favourite-btn pull-right mt-4 me-2"> 
                    <i class="fa fa-heart-o p-1"></i>
                    <span class="p-1">Add to Favourite</span> 
                </button>
            </div>
        </div>
    </div>

    <div class="row pb-3 pt-4">
        <div class="col-lg-4 col-md-4 py-3 bdr2 company-profile-deatil">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-3 p-0">
                    <img src="{{ asset('frontend/img/company/industry.png') }}" class="pull-right" alt="">
                </div>    
                <div class="col-lg-9 col-md-9 col-9">
                    <h3>Industry</h3>
                    <p>Telecommunication</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 py-3 bdr2 company-profile-deatil">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-3 p-0">
                    <img src="{{ asset('frontend/img/company/employee.png') }}" class="pull-right" alt="">
                </div>    
                <div class="col-lg-9 col-md-9 col-9">
                    <h3>No Employees</h3>
                    <p>101-200</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 py-3 company-profile-deatil">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-3 p-0">
                    <img src="{{ asset('frontend/img/company/apartment.png') }}" class="pull-right" alt="">
                </div>    
                <div class="col-lg-9 col-md-9 col-9">
                    <h3>Established In</h3>
                    <p>Building Since 200</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Company Profile End -->

<!-- Vision, Mission and Value Start -->
<div class="container my-5">
    <div class="row py-2">
        <div class="col-lg-12 company-vision">
            <h3 class="vision-title">
                Vision
            </h3>
            
            <p>
                In its bid to constantly improve its operational efficiency and ability to deliver value to its clients and stakeholders, Riverbank Group has made strategic investments to expand its infrastructure. This enables them to deliver storage solution to its clients as well as providing a wide-range of services such as drumming, blending and contract manufacturing.
            </p>
        </div>
    </div>

    <div class="row py-2">
        <div class="col-lg-12 company-vision">
            <h3 class="vision-title">
                Mission
            </h3>
            
            <p>
                In its bid to constantly improve its operational efficiency and ability to deliver value to its clients and stakeholders, Riverbank Group has made strategic investments to expand its infrastructure. This enables them to deliver storage solution to its clients as well as providing a wide-range of services such as drumming, blending and contract manufacturing.
            </p>
        </div>
    </div>

    <div class="row py-2">
        <div class="col-lg-12 company-vision">
            <h3 class="vision-title">
                Value
            </h3>
            
            <p>
                In its bid to constantly improve its operational efficiency and ability to deliver value to its clients and stakeholders, Riverbank Group has made strategic investments to expand its infrastructure. This enables them to deliver storage solution to its clients as well as providing a wide-range of services such as drumming, blending and contract manufacturing.
            </p>
        </div>
    </div>

    <div class="row py-3">
        <div class="col-lg-12">
            <div class="pull-right">
                <div class="bg-light d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/twitter.png') }}" alt="" width='32px' height='32px'></a>
                </div>
                <div class="bg-light d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/facebook.png') }}" alt="" width='32px' height='32px'></a>
                </div>
                <div class="bg-light d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/icon_Linkedin.png') }}" alt="" width='32px' height='32px'></a>
                </div>
                <div class="bg-light d-inline-block mx-1">
                    <a href="#"><img src="{{ asset('img/icon/icon_Google.png') }}" alt="" width='32px' height='32px'></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vision, Mission and Value End -->

<!-- About Company Start -->
<div class="container my-3">
    <div class="row py-3">
        <div class="about-company-header py-3">
            <h3 class="about-company-title mt-3">About Company</h3>
        </div>
    </div>

    <div class="row py-3">
        <div class="col-lg-12 about-company">
            <p>
                Riverbank Group is a distributor, storage tank and service provider of industrial chemicals, lubricant additive, thinner, speciality and fine chemicals in South-East Asia. Established in 1984, Riverbank Chemicals has become a well-known name in the chemical industry with its philosophy and commitment of providing exceptional standards of service with a multi-disciplinary team of professional staff and clear business strategy.
            </p>

            <p>
                In its bid to constantly improve its operational efficiency and ability to deliver value to its clients and stakeholders, Riverbank Group has made strategic investments to expand its infrastructure. This enables them to deliver storage solution to its clients as well as providing a wide-range of services such as drumming, blending and contract manufacturing.
            </p>
        </div>
    </div>
</div>
<!-- About Company End -->

<!-- Company Photo Start -->
<div class="container my-3">
    <div class="row py-3">
        <div class="about-company-header py-3">
            <h3 class="about-company-title mt-3">Company Photos</h3>
        </div>
    </div>

    <div class="row pb-3">
        <div class="col-lg-3 col-md-3 p-0 company-photo">
            <img src="{{ asset('/frontend/img/company/company-photo1.jpg') }}" class="w-100 py-1 pe-2" alt="">
        </div>
        
        <div class="col-lg-3 col-md-3 p-0 company-photo">
            <img src="{{ asset('/frontend/img/company/company-photo2.jpg') }}" class="w-100 py-1 pe-2" alt="">
        </div>
        
        <div class="col-lg-3 col-md-3 p-0 company-photo">
            <img src="{{ asset('/frontend/img/company/company-photo3.jpg') }}" class="w-100 py-1 pe-2" alt="">
        </div>
        
        <div class="col-lg-3 col-md-3 p-0 company-photo">
            <img src="{{ asset('/frontend/img/company/company-photo-4.jpg') }}" class="w-100 py-1 pe-2" alt="">
        </div>
        
        <div class="col-lg-3 col-md-3 p-0 company-photo">
            <img src="{{ asset('/frontend/img/company/company-photo1.jpg') }}" class="w-100 py-1 pe-2" alt="">
        </div>
        
        <div class="col-lg-3 col-md-3 p-0 company-photo">
            <img src="{{ asset('/frontend/img/company/company-photo2.jpg') }}" class="w-100 py-1 pe-2" alt="">
        </div>
        
        <div class="col-lg-3 col-md-3 p-0 company-photo">
            <img src="{{ asset('/frontend/img/company/company-photo3.jpg') }}" class="w-100 py-1 pe-2" alt="">
        </div>
        
        <div class="col-lg-3 col-md-3 p-0 company-photo">
            <img src="{{ asset('/frontend/img/company/company-photo-4.jpg') }}" class="w-100 py-1 pe-2" alt="">
        </div>
    </div>
</div>
<!-- Company Photo End -->

<!-- Job Openings Start -->
<div class="container my-3">
    <div class="row py-3">
        <div class="about-company-header py-3">
            <h3 class="about-company-title mt-3">Job Openings</h3>
        </div>
    </div>

    <div class="row" style="">
        <div class="col-lg-6 col-md-6 col-12 pb-2">
            <div class="row job-opening me-1 p-2">
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="">
                        </div>

                        <div class="col-lg-10 col-md-10">
                            <div class="job-company">eBay</div>
                            <div class="job-title">Senior Java Developer</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 p-0">
                    <button type="button" class="btn view-detail-btn pull-right">View Details</button>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12 pb-2">
            <div class="row job-opening me-1 p-2">
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="">
                        </div>

                        <div class="col-lg-10 col-md-10">
                            <div class="job-company">eBay</div>
                            <div class="job-title">Senior Java Developer</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 p-0">
                    <button type="button" class="btn view-detail-btn pull-right">View Details</button>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12 pb-2">
            <div class="row job-opening me-1 p-2">
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="">
                        </div>

                        <div class="col-lg-10 col-md-10">
                            <div class="job-company">eBay</div>
                            <div class="job-title">Senior Java Developer</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 p-0">
                    <button type="button" class="btn view-detail-btn pull-right">View Details</button>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12 pb-2">
            <div class="row job-opening me-1 p-2">
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="">
                        </div>

                        <div class="col-lg-10 col-md-10">
                            <div class="job-company">eBay</div>
                            <div class="job-title">Senior Java Developer</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 p-0">
                    <button type="button" class="btn view-detail-btn pull-right">View Details</button>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12 pb-2">
            <div class="row job-opening me-1 p-2">
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="">
                        </div>

                        <div class="col-lg-10 col-md-10">
                            <div class="job-company">eBay</div>
                            <div class="job-title">Senior Java Developer</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 p-0">
                    <button type="button" class="btn view-detail-btn pull-right">View Details</button>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-12 pb-2">
            <div class="row job-opening me-1 p-2">
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" alt="">
                        </div>

                        <div class="col-lg-10 col-md-10">
                            <div class="job-company">eBay</div>
                            <div class="job-title">Senior Java Developer</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 p-0">
                    <button type="button" class="btn view-detail-btn pull-right">View Details</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-3">
        <div>
            <button type="button" class="btn see-all-btn pull-right">See All Jobs</button>
        </div>
    </div>
</div>
<!-- Job Openings End -->



@endsection