<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Frontend\HomeController;
use App\Http\Controllers\API\Frontend\FindJobController;

// seeker
use App\Http\Controllers\API\Seeker\SeekerRegisterController;
use App\Http\Controllers\API\Seeker\SeekerLoginController;
use App\Http\Controllers\API\Seeker\SeekerProfileController;
use App\Http\Controllers\API\Seeker\SeekerExperienceController;
use App\Http\Controllers\API\Seeker\SeekerEducationController;
use App\Http\Controllers\API\Seeker\SeekerSkillController;
use App\Http\Controllers\API\Seeker\SeekerLanguageController;
use App\Http\Controllers\API\Seeker\SeekerReferenceController;
use App\Http\Controllers\API\Seeker\CareerOfChoiceController;
use App\Http\Controllers\API\Seeker\SeekerCVAttachController;
use App\Http\Controllers\API\Seeker\SeekerSaveJobController;
use App\Http\Controllers\API\Seeker\SeekerJobAlertController;

// employer 
use App\Http\Controllers\API\Employer\EmployerRegisterController;
use App\Http\Controllers\API\Employer\EmployerLoginController;
use App\Http\Controllers\API\Employer\EmployerProfileController;
use App\Http\Controllers\API\Employer\ManageJobController;
use App\Http\Controllers\API\Employer\ApplicantTrackingController;
use App\Http\Controllers\API\Employer\BuyPointController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// home 
Route::get('get-slider', [HomeController::class, 'getSlider']);
Route::get('get-popular-category', [HomeController::class, 'getPopularCategory']);
Route::get('get-top-employer', [HomeController::class, 'getTopEmployer']);
Route::get('get-trending-jobs', [HomeController::class, 'getTrendingJob']);
Route::get('get-featured-jobs', [HomeController::class, 'getFeaturedJob']);

Route::get('get-states', [HomeController::class, 'getState']);
Route::get('get-functional-areas', [HomeController::class, 'getFunctionalArea']);

// findjobs 
Route::get('find-jobs', [FindJobController::class, 'findJob']);
Route::get('get-find-job-filter-data', [FindJobController::class, 'getFindJobFilterData']);
Route::post('search-job', [FindJobController::class, 'searchJob']);
Route::get('get-job-title', [FindJobController::class, 'getJobTitle']);

// job category 
Route::get('get-all-category', [HomeController::class, 'getAllCategory']);
Route::get('get-all-employer', [HomeController::class, 'getAllEmployer']);
Route::post('job-post-detail', [HomeController::class, 'jobPostDetail']);

// company job 
Route::post('company-job', [HomeController::class, 'companyJob']);
Route::post('company-detail', [HomeController::class, 'companyDetail']);
Route::post('search-company', [HomeController::class, 'searchCompany']);

// contact us 
Route::post('contact-us', [HomeController::class, 'contactUs']);

// get township 
Route::post('get-township', [SeekerProfileController::class, 'getTowhship']);

// get sub functional area 
Route::post('get-sub-functional-area', [SeekerProfileController::class, 'getSubFunctionalArea']);

// seeker 
Route::group(['prefix' => 'seeker'], function () {
    // seeker register 
    Route::post('register', [SeekerRegisterController::class, 'register']);
    Route::post('verify-resend', [SeekerRegisterController::class, 'seekerVerifyResend']);

    // seeker login 
    Route::post('login', [SeekerLoginController::class, 'login']);

    // seeker forget password 
    Route::post('forget-password', [SeekerRegisterController::class, 'getEmail']);

    // seeker reset password 
    Route::post('reset-password', [SeekerRegisterController::class, 'storeResetPassword']);

    // seeker profile 
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('dashboard', [SeekerProfileController::class, 'dashboard']);
        // recommend job
        Route::post('recommend-job', [SeekerProfileController::class, 'recommendJob']);
        Route::post('/profile', [SeekerProfileController::class, 'profile']);
        Route::post('/change-password', [SeekerProfileController::class, 'changePassword']);

        // get skill 
        Route::post('/get-skill', [SeekerProfileController::class, 'getSkill']);

        // seeker profile img
        Route::post('profile-img-store',[SeekerProfileController::class, 'profileImageStore']);
        Route::post('profile-img-delete',[SeekerProfileController::class, 'profileImageDestory']);

        // seeker personal information 
        Route::post('personal-information',[SeekerProfileController::class, 'personalInformation']);
        Route::post('summary-ai-generate', [SeekerProfileController::class, 'summaryGenerate']);

        // seeker application 
        Route::get('get-application', [SeekerProfileController::class, 'getApplication']);

        // seeker career history 
        Route::resource('career-history',SeekerExperienceController::class);

        // seeker education 
        Route::resource('education',SeekerEducationController::class);

        // seeker skill 
        Route::resource('skill',SeekerSkillController::class);

        // seeker language 
        Route::resource('language',SeekerLanguageController::class);

        // seeker reference 
        Route::resource('reference',SeekerReferenceController::class);

        // career of choice 
        Route::resource('career-of-choice',CareerOfChoiceController::class);

        // seeker cv 
        Route::resource('seeker-cv',SeekerCVAttachController::class);

        // seeker save job 
        Route::resource('save-job', SeekerSaveJobController::class);
        Route::get('save-job-list', [SeekerSaveJobController::class, 'saveJobList']);

        // seeker job alert
        Route::resource('job-alert', SeekerJobAlertController::class);

        // job post apply
        Route::post('job-post-apply/{id}', [SeekerProfileController::class , 'jobPostApply']);

        // applied jobs 
        Route::get('applied-jobs' , [SeekerProfileController::class, 'applyJob']);

        // logout 
        Route::post('logout', [SeekerProfileController::class, 'logout']);
    });
});

// employer 
Route::group(['prefix' => 'employer'], function () {

    // register 
    Route::post('register', [EmployerRegisterController::class, 'register']);
    Route::post('verify-resend', [EmployerRegisterController::class, 'employerVerifyResend']);

    // employer login 
    Route::post('login', [EmployerLoginController::class, 'login']);

    // employer forget password 
    Route::post('forget-password', [EmployerRegisterController::class, 'getEmail']);

    // employer reset password 
    Route::post('reset-password', [EmployerRegisterController::class, 'storeResetPassword']);

    // employer profile 
    Route::group(['middleware' => 'auth:sanctum'], function() {
        // dashboard 
        Route::get('dashboard', [EmployerProfileController::class, 'dashboard']);

        // package 
        Route::get('package', [EmployerProfileController::class, 'package']);

        // profile 
        Route::get('profile', [EmployerProfileController::class, 'profile']);
        Route::post('profile-update', [EmployerProfileController::class, 'profileUpdate']);

        // logo 
        Route::post('upload-logo', [EmployerProfileController::class, 'uploadLogo']);
        Route::post('remove-logo', [EmployerProfileController::class, 'removeLogo']);

        // background 
        Route::post('upload-background', [EmployerProfileController::class, 'uploadBackground']);
        Route::post('remove-background', [EmployerProfileController::class, 'removeBackground']);

        // address 
        Route::post('address-store', [EmployerProfileController::class, 'addressStore']);
        Route::delete('address-destroy/{id}', [EmployerProfileController::class, 'addressDestroy']);

        // testimonial 
        Route::post('testimonial-store', [EmployerProfileController::class, 'testimonialStore']);
        Route::delete('testimonial-destroy/{id}', [EmployerProfileController::class, 'testimonialDestroy']);

        // media 
        Route::post('media-store', [EmployerProfileController::class, 'mediaStore']);
        Route::delete('media-destroy/{id}', [EmployerProfileController::class, 'mediaDestroy']);

        // manage job 
        Route::get('manage-job', [ManageJobController::class, 'manageJob']);
        Route::post('job-post-activation', [ManageJobController::class, 'changeJobPostStatus']);
        Route::get('get-experience-level', [ManageJobController::class, 'getExperienceLevel']);

        // job post 
        Route::post('job-post', [ManageJobController::class, 'store']);
        Route::get('job-post/{id}', [ManageJobController::class, 'show']);
        Route::put('job-post/{id}', [ManageJobController::class, 'update']);

        // applicant tracking 
        Route::get('applicant-tracking', [ApplicantTrackingController::class, 'index']);

        // buy point 
        Route::resource('buy-point', BuyPointController::class);
    });
});