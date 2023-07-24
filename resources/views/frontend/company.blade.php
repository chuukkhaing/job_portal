@extends('frontend.layouts.app')
@section('content')

<!-- Search Start -->
<section class="company-banner p-5">
    <div class="container p-0">
        <div class="row company-banner-search py-1">
            <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                <div class="form-group has-search">
                    <span class="form-control-feedback company-icon"><i class="fa fa-search fa-md"></i></span>
                    <input type="text" class="form-control search-slt company-search" placeholder="Search Companies">
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-12 pe-1">
                <button type="button" class="btn company-search-btn pull-right">Search Jobs</button>
            </div>
        </div>
    </div>
</section>
<!-- Search End -->

<!-- Show Data Start -->
<div class="container my-5">
    <div class="row my-5">
        <div class="company-header py-3 text-center">
            <h3 class="company-header-title text-center">Discover Your Dream Job with Top Companies</h3>
            <span class="company-header-sub-title justify-content-center">Find endless career opportunities with our customizable search filters and user-friendly interface</span>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-12 pb-3">
            <div class="company-content p-4">
                <div class="company-image">
                    <img src="{{ asset('/frontend/img/company/image.jpg') }}" class="w-100" alt="">
                </div>
    
                <div class="company-name pt-4 pb-2">
                    <h3>Globex Corporation</h3>
                </div>
    
                <div class="company-address">
                    <p>5781 Spring St. Portsmouth, OH, 45662 | Scioto County</p>
                </div>
    
                <div class="company-rating">
                    <span class="company-rating-icon">
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star-half-o fa-lg" aria-hidden="true"></i>
                    </span>
                    <span class="company-rating-count ps-3">
                        993 ratings
                    </span>
                </div>
    
                <div class="company-job-count mt-4 py-2">
                    Opening Jobs - 2000
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 pb-3">
            <div class="company-content p-4">
                <div class="company-image">
                    <img src="{{ asset('/frontend/img/company/hooli.jpg') }}" class="w-100" alt="">
                </div>
    
                <div class="company-name pt-4 pb-2">
                    <h3>Hooli</h3>
                </div>
    
                <div class="company-address">
                    <p>5781 Spring St. Portsmouth, OH, 45662 | Scioto County</p>
                </div>
    
                <div class="company-rating">
                    <span class="company-rating-icon">
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star-half-o fa-lg" aria-hidden="true"></i>
                    </span>
                    <span class="company-rating-count ps-3">
                        993 ratings
                    </span>
                </div>
    
                <div class="company-job-count mt-4 py-2">
                    Opening Jobs - 2000
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 pb-3">
            <div class="company-content p-4">
                <div class="company-image">
                    <img src="{{ asset('/frontend/img/company/capital.jpg') }}" class="w-100" alt="">
                </div>
    
                <div class="company-name pt-4 pb-2">
                    <h3>Vehement Capital Partners</h3>
                </div>
    
                <div class="company-address">
                    <p>5781 Spring St. Portsmouth, OH, 45662 | Scioto County</p>
                </div>
    
                <div class="company-rating">
                    <span class="company-rating-icon">
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star-half-o fa-lg" aria-hidden="true"></i>
                    </span>
                    <span class="company-rating-count ps-3">
                        993 ratings
                    </span>
                </div>
    
                <div class="company-job-count mt-4 py-2">
                    Opening Jobs - 2000
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 pb-3">
            <div class="company-content p-4">
                <div class="company-image">
                    <img src="{{ asset('/frontend/img/company/hooli.jpg') }}" class="w-100" alt="">
                </div>
    
                <div class="company-name pt-4 pb-2">
                    <h3>Hooli</h3>
                </div>
    
                <div class="company-address">
                    <p>5781 Spring St. Portsmouth, OH, 45662 | Scioto County</p>
                </div>
    
                <div class="company-rating">
                    <span class="company-rating-icon">
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star-half-o fa-lg" aria-hidden="true"></i>
                    </span>
                    <span class="company-rating-count ps-3">
                        993 ratings
                    </span>
                </div>
    
                <div class="company-job-count mt-4 py-2">
                    Opening Jobs - 2000
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 pb-3">
            <div class="company-content p-4">
                <div class="company-image">
                    <img src="{{ asset('/frontend/img/company/capital.jpg') }}" class="w-100" alt="">
                </div>
    
                <div class="company-name pt-4 pb-2">
                    <h3>Vehement Capital Partners</h3>
                </div>
    
                <div class="company-address">
                    <p>5781 Spring St. Portsmouth, OH, 45662 | Scioto County</p>
                </div>
    
                <div class="company-rating">
                    <span class="company-rating-icon">
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star-half-o fa-lg" aria-hidden="true"></i>
                    </span>
                    <span class="company-rating-count ps-3">
                        993 ratings
                    </span>
                </div>
    
                <div class="company-job-count mt-4 py-2">
                    Opening Jobs - 2000
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-12 pb-3">
            <div class="company-content p-4">
                <div class="company-image">
                    <img src="{{ asset('/frontend/img/company/image.jpg') }}" class="w-100" alt="">
                </div>
    
                <div class="company-name pt-4 pb-2">
                    <h3>Globex Corporation</h3>
                </div>
    
                <div class="company-address">
                    <p>5781 Spring St. Portsmouth, OH, 45662 | Scioto County</p>
                </div>
    
                <div class="company-rating">
                    <span class="company-rating-icon">
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star fa-lg" aria-hidden="true"></i>
                        <i class="fa fa-star-half-o fa-lg" aria-hidden="true"></i>
                    </span>
                    <span class="company-rating-count ps-3">
                        993 ratings
                    </span>
                </div>
    
                <div class="company-job-count mt-4 py-2">
                    Opening Jobs - 2000
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination Start -->
    <div class="row py-5">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true"><i class="fas fa-arrow-left"></i></span>
                </a>
              </li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                </a>
              </li>
            </ul>
          </nav>
    </div>
    <!-- Pagination End -->
</div>
<!-- Show Data End -->

<!-- Join Our Community Start -->
<div class="container my-5">
    <div class="row my-5">
        <div class="community-header py-3">
            <h3 class="community-header-title text-center">Join Our Community</h3>
        </div>

        <div class="community-text">
            <p>
                By joining our community, you will have access to a pool of qualified and motivated job seekers who are eager to contribute their skills and expertise to your company.
                Our job seeker website is dedicated to connecting employers with top talent, making the hiring process easier and more efficient than ever before.
                Whether you're looking for entry-level candidates or seasoned professionals, our platform has something to offer for everyone.
            </p>

            <p>
                As a member of our community, you will have the opportunity to showcase your company and job openings to a wide audience of job seekers.
                Our platform is user-friendly and easy to navigate, allowing you to quickly and easily post job listings and browse through resumes to find the perfect fit for your company.
                Join our job seeker community today and take the first step towards improving your company and finding the right talent to help your business grow and thrive!
            </p>
        </div>
    </div>

    <div class="row py-5">
        <div class="col-lg-5 col-md-8 community-form p-0">
            <div class="row col-12 m-0 p-0">
                <div class="col-lg-9 col-md-8 p-2">
                    <input type="text" class="form-control search-slt community-search" placeholder="Enter your mail address">
                </div>

                <div class="col-lg-3 col-md-4 p-2">
                    <button type="button" class="btn community-form-btn pull-right">Join Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Join Our Community End -->

@endsection