<?php

use App\Http\Controllers\Employer\EmployerJobPostController;
use App\Http\Controllers\Employer\EmployerLoginController;
use App\Http\Controllers\Employer\EmployerProfileController;
use App\Http\Controllers\Employer\EmployerRegisterController;
use App\Http\Controllers\Employer\MemberUserController;
use App\Http\Controllers\Employer\PointHistoryController;
use Illuminate\Support\Facades\Route;

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

Route::group([], function () {
    Route::get('login-form', [EmployerLoginController::class, 'frontendEmployerLogin'])->name('employer-login-form');
    Route::get('register-form', [EmployerRegisterController::class, 'frontendEmployerRegister'])->name('employer-register-form');
    Route::post('register', [EmployerRegisterController::class, 'register'])->name('employer-register');

    Route::get('email/verify/{id}', [EmployerRegisterController::class, 'notice'])->name('employer-verify-notice');
    Route::get('email/resend/{id}', [EmployerRegisterController::class, 'resend'])->name('employer-resend');
    Route::get('verify/{id}', [EmployerLoginController::class, 'VerifyEmail'])->name('employer-verify');
    Route::post('logout', [EmployerProfileController::class, 'logout'])->name('employer.logout');
    Route::post('login', [EmployerLoginController::class, 'login'])->name('employer-login');
    Route::get('forgot-password', [EmployerRegisterController::class, 'forgotPassword'])->name('employer-forgot');
    Route::post('forgot-password', [EmployerRegisterController::class, 'getEmail'])->name('employer-forgot.post');
    Route::get('{id}/reset-password', [EmployerRegisterController::class, 'getResetPassword'])->name('employer-reset');
    Route::post('reset-password', [EmployerRegisterController::class, 'storeResetPassword'])->name('employer-reset-post');

    Route::group(['middleware' => 'auth:employer'], function () {
        Route::resource('employer-profile', EmployerProfileController::class);
        Route::get('/get-township/{id}', [EmployerProfileController::class, 'getTownship']);
        Route::get('/get-sub-functional-area/{id}', [EmployerProfileController::class, 'getSubFunctionalArea']);
        Route::post('/employer-address', [EmployerProfileController::class, 'employerAddressStore'])->name('employer-address.store');
        Route::post('employer-address/destory/{id}', [EmployerProfileController::class, 'employerAddressDestroy']);
        Route::post('/employer-testimonial', [EmployerProfileController::class, 'employerTestimonialStore'])->name('employer-testimonial.store');
        Route::post('employer-testimonial/destory/{id}', [EmployerProfileController::class, 'employerTestimonialDestroy']);
        Route::post('/employer-media', [EmployerProfileController::class, 'employerMediaStore'])->name('employer-media.store');
        Route::post('employer-media/destory/{id}', [EmployerProfileController::class, 'employerMediaDestroy']);
        Route::post('/employer-logo', [EmployerProfileController::class, 'uploadLogo'])->name('employer-logo.store');
        Route::post('/employer-logo-remove', [EmployerProfileController::class, 'removeLogo'])->name('employer-logo.remove');
        Route::post('/employer-background', [EmployerProfileController::class, 'uploadBackground'])->name('employer-background.store');
        Route::post('/employer-background-remove', [EmployerProfileController::class, 'removeBackground'])->name('employer-background.remove');

        Route::resource('employer-job-post', EmployerJobPostController::class);
        Route::post('employer-job-post/question', [EmployerJobPostController::class, 'jobPostQuestion'])->name('job-post.question');
        Route::get('/get-skill/{id}', [EmployerJobPostController::class, 'getSkill']);
        Route::post('job-post-status', [EmployerJobPostController::class, 'changeJobPostStatus'])->name('job-post.status');
        Route::post('unlock-application', [EmployerJobPostController::class, 'unlockApplication'])->name('unlock.application');

        Route::get('get-jobpost/{id}/{status}', [EmployerJobPostController::class, 'getJobPost']);
        Route::get('get-jobpost-info/{id}/{jobPostId}/{status}', [EmployerJobPostController::class, 'getJobPostInfo']);
        Route::get('download-ic-cv/{id}', [EmployerJobPostController::class, 'icFormatCVDownload']);
        Route::get('change-status/{jobPostId}/{seekerId}/{status}', [EmployerJobPostController::class, 'changeStatus']);

        Route::resource('point-history', PointHistoryController::class);
        Route::resource('member-user', MemberUserController::class);
    });
});
