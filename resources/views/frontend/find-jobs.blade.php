@extends('frontend.layouts.app')
@section('content')

<!-- Search Start -->
<section class="find-jobs-search p-5">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 p-0">
                    <div class="form-group has-search">
                        <span class="form-control-feedback"><i class="fa fa-search fa-md"></i></span>
                        <input type="text" class="form-control search-slt job-title" placeholder="Job title or keyword">
                    </div>
                </div>

                <div class="col-lg-4 col-md-3 p-0">
                    <div class="form-group has-search search-slt function-area">
                        <span class="form-control-feedback"><i class="fa fa-shopping-bag fa-md" aria-hidden="true"></i></span>
                        <select class="form-control" id="function-area" multiple="multiple">
                            <optgroup label="Group 1">
                                <option value="1-1">Option 1.1</option>
                                <option value="1-2">Option 1.2</option>
                                <option value="1-3">Option 1.3</option>
                            </optgroup>
                            <optgroup label="Group 2">
                                <option value="2-1">Option 2.1</option>
                                <option value="2-2">Option 2.2</option>
                                <option value="2-3">Option 2.3</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 p-0">
                    <div class="form-group has-search">
                        <span class="form-control-feedback"><i class="fa fa-map-marker fa-md"></i></span>
                        <input type="text" class="form-control search-slt location" placeholder="location">
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 p-0">
                    <button type="button" class="btn pull-right search-job-btn">Search Jobs</button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Search End -->

<div class="container my-5">
    <div class="row my-5">
        <div class="find-jobs-header py-3">
            <h3 class="find-jobs-title">Explore Job Near for you</h3>
            <span class="find-jobs-sub-title">Suggestions tailored to your profile, career preferences, and engagement history on our platform are provided to guide you towards the most relevant job opportunities.</span>
        </div>
    </div>

    <div class="row my-5">
        <!-- Left Sidebar Start -->
        <div class="col-lg-8 col-12 find-jobs-left-sidebar">
            <div class="row job-content mb-3">
                <!-- Job List Start -->
                <div class="col-lg-10 col-md-10 py-4">
                    <div class="row">
                        <div class="col-md-2 job-image">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" class="img-responsive center-block d-block mx-auto" alt="Job Profile">
                        </div>    
                        <div class="col-md-10">
                            <div class="job-company">eBay</div>
                            <div class="job-title">Senior Java Developer</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                            <div class="">
                                <a href="" class="btn job-btn">Sale and Marketing</a>
                                <a href="" class="btn job-btn">Attractive Salary</a>
                                <a href="" class="btn job-btn">Benefits</a>
                            </div>
                        </div>
                    </div>                    
                </div>
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4">
                    <div class="row col-12 m-0 p-0">
                        <div class="text-end p-0">
                            <i class="fa-regular fa-heart"></i>
                        </div>

                        <div class="text-end mt-auto p-1">
                            <span>1 d</span>
                        </div>
                    </div>
                </div>
                <!-- Wishlist End -->
            </div>

            <div class="row job-content mb-3">
                <!-- Job List Start -->
                <div class="col-lg-10 col-md-10 py-4">
                    <div class="row">
                        <div class="col-md-2 job-image">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" class="img-responsive center-block d-block mx-auto" alt="Job Profile">
                        </div>    
                        <div class="col-md-10">
                            <div class="job-company">General Electric</div>
                            <div class="job-title">President of Sales</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                            <div class="">
                                <a href="" class="btn job-btn">Sale and Marketing</a>
                                <a href="" class="btn job-btn">Attractive Salary</a>
                                <a href="" class="btn job-btn">Benefits</a>
                            </div>
                        </div>
                    </div>                    
                </div>
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4">
                    <div class="row col-12 m-0 p-0">
                        <div class="text-end p-0">
                            <i class="fa-regular fa-heart"></i>
                        </div>

                        <div class="text-end mt-auto p-1">
                            <span>1 d</span>
                        </div>
                    </div>
                </div>
                <!-- Wishlist End -->
            </div>

            <div class="row job-content mb-3">
                <!-- Job List Start -->
                <div class="col-lg-10 col-md-10 py-4">
                    <div class="row">
                        <div class="col-md-2 job-image">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" class="img-responsive center-block d-block mx-auto" alt="Job Profile">
                        </div>    
                        <div class="col-md-10">
                            <div class="job-company">Louis Vuitton</div>
                            <div class="job-title">Web Designer</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                            <div class="">
                                <a href="" class="btn job-btn">Sale and Marketing</a>
                                <a href="" class="btn job-btn">Attractive Salary</a>
                                <a href="" class="btn job-btn">Benefits</a>
                            </div>
                        </div>
                    </div>                    
                </div>
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4">
                    <div class="row col-12 m-0 p-0">
                        <div class="text-end p-0">
                            <i class="fa-regular fa-heart"></i>
                        </div>

                        <div class="text-end mt-auto p-1">
                            <span>1 d</span>
                        </div>
                    </div>
                </div>
                <!-- Wishlist End -->
            </div>

            <div class="row job-content mb-3">
                <!-- Job List Start -->
                <div class="col-lg-10 col-md-10 py-4">
                    <div class="row">
                        <div class="col-md-2 job-image">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" class="img-responsive center-block d-block mx-auto" alt="Job Profile">
                        </div>    
                        <div class="col-md-10">
                            <div class="job-company">MasterCard</div>
                            <div class="job-title">Medical Assistant</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                            <div class="">
                                <a href="" class="btn job-btn">Sale and Marketing</a>
                                <a href="" class="btn job-btn">Attractive Salary</a>
                                <a href="" class="btn job-btn">Benefits</a>
                            </div>
                        </div>
                    </div>                    
                </div>
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4">
                    <div class="row col-12 m-0 p-0">
                        <div class="text-end p-0">
                            <i class="fa-regular fa-heart"></i>
                        </div>

                        <div class="text-end mt-auto p-1">
                            <span>1 d</span>
                        </div>
                    </div>
                </div>
                <!-- Wishlist End -->
            </div>

            <div class="row job-content mb-3">
                <!-- Job List Start -->
                <div class="col-lg-10 col-md-10 py-4">
                    <div class="row">
                        <div class="col-md-2 job-image">
                            <img src="{{ asset('frontend/img/trending/aya.png') }}" class="img-responsive center-block d-block mx-auto" alt="Job Profile">
                        </div>    
                        <div class="col-md-10">
                            <div class="job-company">IBM</div>
                            <div class="job-title">Medical Assistant</div>
                            <div class="job-location">Yangon</div>
                            <div class="job-salary my-3">1 Lakhs - 10 Lakhs</div>
                            <div class="">
                                <a href="" class="btn job-btn">Sale and Marketing</a>
                                <a href="" class="btn job-btn">Attractive Salary</a>
                                <a href="" class="btn job-btn">Benefits</a>
                            </div>
                        </div>
                    </div>                    
                </div>
                <!-- Job List End -->

                <!-- Wishlist Start -->
                <div class="col-lg-2 col-md-2 d-flex align-items-end flex-column bd-highlight py-4">
                    <div class="row col-12 m-0 p-0">
                        <div class="text-end p-0">
                            <i class="fa-regular fa-heart"></i>
                        </div>

                        <div class="text-end mt-auto p-1">
                            <span>1 d</span>
                        </div>
                    </div>
                </div>
                <!-- Wishlist End -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- Right Sidebar Start -->
        <div class="col-lg-4 col-12 px-5 find-jobs-right-sidebar">
            <!-- Trending Jobs Start -->
            <div class="row mb-5">
                <div class="right-trending-title">
                    <h5 class="text-white py-2">Trending Jobs</h5>
                </div>

                <div class="job-trending-scroll p-2">
                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Trending Jobs End -->

            <!-- Featured Jobs Start -->
            <div class="row mb-5">
                <div class="right-trending-title">
                    <h5 class="text-white py-2">Features Jobs</h5>
                </div>

                <div class="job-trending-scroll p-2">
                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 border-bottom p-0">
                        <div class="m-0 my-2 p-2 trending-job-list rounded">
                            <div class="row m-0">
                                <div class="col-lg-3 col-12 text-center">
                                    <img src="http://localhost:93/frontend/img/trending/aya.png" alt="Trending Job Image" class="center-block d-block mx-auto trending-image">
                                </div>
                                <div class="col-lg-9 col-12 p-0">
                                    <div>
                                        <h3 id="trending-job-title">Paralegal and Legal Assistant</h3>
                                        <span id="trending-job-sub-title">AYA Bank</span>
                                    </div>

                                    <div class="fz13">
                                        <span class="me-2"><i class="fa fa-briefcase me-2"></i>Design, Development</span>
                                        <span><i class="fa fa-map-marker me-1" aria-hidden="true"></i> Sanchaung</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Featured Jobs End -->
            
        </div>
        <!-- Right Sidebar End -->
    </div>
</div>

@endsection