<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Employer\EmployerRegisterController;
use App\Http\Controllers\Employer\EmployerLoginController;
use App\Http\Controllers\Employer\EmployerProfileController;
use App\Http\Controllers\Employer\EmployerJobPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function(){
    Route::post('register', [EmployerRegisterController::class, 'register'])->name('employer-register');

    Route::get('email/verify/{id}', [EmployerRegisterController::class, 'notice'])->name('employer-verify-notice');
    Route::get('email/resend/{id}', [EmployerRegisterController::class, 'resend'])->name('employer-resend');
    Route::get('verify/{id}', [EmployerLoginController::class,'VerifyEmail'])->name('employer-verify');
    Route::post('logout', [EmployerProfileController::class,'logout'])->name('employer.logout');
    Route::post('login', [EmployerLoginController::class,'login'])->name('employer-login');
    
	Route::group(['middleware' => 'auth:employer'], function () {
        Route::resource('employer-profile', EmployerProfileController::class);
        Route::get('/get-township/{id}', [EmployerProfileController::class, 'getTownship']);
        Route::get('/get-sub-functional-area/{id}', [EmployerProfileController::class, 'getSubFunctionalArea']);
        Route::post('/employer-address',[EmployerProfileController::class, 'employerAddressStore'])->name('employer-address.store');
        Route::post('employer-address/destory/{id}', [EmployerProfileController::class, 'employerAddressDestroy']);
        Route::post('/employer-testimonial',[EmployerProfileController::class, 'employerTestimonialStore'])->name('employer-testimonial.store');
        Route::post('employer-testimonial/destory/{id}', [EmployerProfileController::class, 'employerTestimonialDestroy']);
        Route::post('/employer-media',[EmployerProfileController::class, 'employerMediaStore'])->name('employer-media.store');
        Route::post('employer-media/destory/{id}', [EmployerProfileController::class, 'employerMediaDestroy']);
        
        Route::resource('employer-job-post', EmployerJobPostController::class);
        Route::post('employer-job-post/question', [EmployerJobPostController::class, 'jobPostQuestion'])->name('job-post.question');
        Route::get('/get-skill/{id}', [EmployerJobPostController::class, 'getSkill']);
        Route::post('job-post-status', [EmployerJobPostController::class, 'changeJobPostStatus'])->name('job-post.status');
        Route::post('unlock-application', [EmployerJobPostController::class, 'unlockApplication'])->name('unlock.application');

        Route::get('get-jobpost/{id}/{status}', [EmployerJobPostController::class, 'getJobPost']);
        Route::get('get-jobpost-info/{id}/{jobPostId}/{status}', [EmployerJobPostController::class, 'getJobPostInfo']);
        Route::get('download-ic-cv/{id}',[EmployerJobPostController::class, 'icFormatCVDownload']);
        Route::get('change-status/{jobPostId}/{seekerId}/{status}', [EmployerJobPostController::class, 'changeStatus']);
    });
});