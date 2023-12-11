<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Frontend\HomeController;
use App\Http\Controllers\API\Frontend\FindJobController;
use App\Http\Controllers\API\Seeker\SeekerRegisterController;
use App\Http\Controllers\API\Seeker\SeekerLoginController;
use App\Http\Controllers\API\Seeker\SeekerProfileController;
use App\Http\Controllers\API\Employer\EmployerLoginController;
use App\Http\Controllers\API\Employer\EmployerProfileController;

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
Route::get('/get-slider', [HomeController::class, 'getSlider']);
Route::get('/get-popular-category', [HomeController::class, 'getPopularCategory']);
Route::get('/get-top-employer', [HomeController::class, 'getTopEmployer']);
Route::get('/get-trending-jobs', [HomeController::class, 'getTrendingJob']);
Route::get('/get-featured-jobs', [HomeController::class, 'getFeaturedJob']);

Route::get('/get-states', [HomeController::class, 'getState']);
Route::get('/get-functional-areas', [HomeController::class, 'getFunctionalArea']);

// findjobs 
Route::get('/find-jobs', [FindJobController::class, 'findJob']);
Route::get('/get-find-job-filter-data', [FindJobController::class, 'getFindJobFilterData']);
Route::post('/search-job', [FindJobController::class, 'searchJob']);
Route::get('/get-job-title', [FindJobController::class, 'getJobTitle']);

// job category 
Route::get('/get-all-category', [HomeController::class, 'getAllCategory']);
Route::get('/get-all-employer', [HomeController::class, 'getAllEmployer']);
Route::post('/job-post-detail', [HomeController::class, 'jobPostDetail']);

// company job 
Route::post('/company-job', [HomeController::class, 'companyJob']);
Route::post('/company-detail', [HomeController::class, 'companyDetail']);
Route::post('/search-company', [HomeController::class, 'searchCompany']);

// contact us 
Route::post('/contact-us', [HomeController::class, 'contactUs']);

// get township 
Route::post('/get-township', [SeekerProfileController::class, 'getTowhship']);

// get sub functional area 
Route::post('/get-sub-functional-area', [SeekerProfileController::class, 'getSubFunctionalArea']);

// seeker 
Route::group(['prefix' => 'seeker'], function () {
    // seeker register 
    Route::post('/register', [SeekerRegisterController::class, 'register']);
    Route::post('/verify-resend', [SeekerRegisterController::class, 'seekerVerifyResend']);

    // seeker login 
    Route::post('/login', [SeekerLoginController::class, 'login']);

    // seeker profile 
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('/dashboard', [SeekerProfileController::class, 'dashboard']);
        Route::post('/profile', [SeekerProfileController::class, 'profile']);

        // get skill 
        Route::post('/get-skill', [SeekerProfileController::class, 'getSkill']);
    });
});

// employer login 
Route::post('/employer-login', [EmployerLoginController::class, 'login']);

// seeker profile 
Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('/employer-profile', [EmployerProfileController::class, 'index']);
});