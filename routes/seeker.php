<?php

use App\Http\Controllers\Seeker\SeekerLoginController;
use App\Http\Controllers\Seeker\SeekerProfileController;
use App\Http\Controllers\Seeker\SeekerRegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seeker\SaveJobController;
use App\Http\Controllers\Seeker\SeekerJobAlertController;
use App\Http\Controllers\Seeker\ResumeController;

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
    Route::post('register', [SeekerRegisterController::class, 'register'])->name('seeker-register');

    Route::get('email/verify/{id}', [SeekerRegisterController::class, 'notice'])->name('seeker-verify-notice');
    Route::get('email/resend/{id}', [SeekerRegisterController::class, 'resend'])->name('seeker-resend');
    Route::get('verify/{id}', [SeekerLoginController::class, 'VerifyEmail'])->name('seeker-verify');
    Route::post('logout', [SeekerProfileController::class, 'logout'])->name('seeker.logout');
    Route::post('login', [SeekerLoginController::class, 'login'])->name('seeker-login');
    Route::get('forgot-password', [SeekerRegisterController::class, 'forgotPassword'])->name('seeker-forgot');
    Route::post('forgot-password', [SeekerRegisterController::class, 'getEmail'])->name('seeker-forgot.post');
    Route::get('{id}/reset-password', [SeekerRegisterController::class, 'getResetPassword'])->name('seeker-reset');
    Route::post('reset-password', [SeekerRegisterController::class, 'storeResetPassword'])->name('seeker-reset-post');

    Route::group(['middleware' => 'auth:seeker'], function () {
        Route::resource('profile', SeekerProfileController::class);
        Route::get('/get-township/{id}', [SeekerProfileController::class, 'getTownship']);
        Route::get('/get-sub-functional-area/{id}', [SeekerProfileController::class, 'getSubFunctionalArea']);
        Route::get('/get-skill/{id}', [SeekerProfileController::class, 'getSkill']);

        Route::post('/education/store', [SeekerProfileController::class, 'educationStore'])->name('education.store');
        Route::get('/education/edit/{id}', [SeekerProfileController::class, 'educationEdit'])->name('education.edit');
        Route::post('/education/update/{id}', [SeekerProfileController::class, 'educationUpdate'])->name('education.update');
        Route::post('/education/destory/{id}', [SeekerProfileController::class, 'educationDestory'])->name('education.destroy');

        Route::post('/experience/store', [SeekerProfileController::class, 'experienceStore'])->name('experience.store');
        Route::get('/experience/edit/{id}', [SeekerProfileController::class, 'experienceEdit'])->name('experience.edit');
        Route::post('/experience/update/{id}', [SeekerProfileController::class, 'experienceUpdate'])->name('experience.update');
        Route::post('/experience/destory/{id}', [SeekerProfileController::class, 'experienceDestory'])->name('experience.destroy');

        Route::post('/skill/store', [SeekerProfileController::class, 'skillStore'])->name('seeker-skill.store');
        Route::post('/skill/destory/{id}', [SeekerProfileController::class, 'skillDestory'])->name('seeker-skill.destroy');

        Route::post('/language/store', [SeekerProfileController::class, 'languageStore'])->name('language.store');
        Route::get('/language/edit/{id}', [SeekerProfileController::class, 'languageEdit'])->name('language.edit');
        Route::post('/language/update/{id}', [SeekerProfileController::class, 'languageUpdate'])->name('language.update');
        Route::post('/language/destory/{id}', [SeekerProfileController::class, 'languageDestory'])->name('language.destroy');

        Route::post('/reference/store', [SeekerProfileController::class, 'referenceStore'])->name('reference.store');
        Route::get('/reference/edit/{id}', [SeekerProfileController::class, 'referenceEdit'])->name('reference.edit');
        Route::post('/reference/update/{id}', [SeekerProfileController::class, 'referenceUpdate'])->name('reference.update');
        Route::post('/reference/destory/{id}', [SeekerProfileController::class, 'referenceDestory'])->name('reference.destroy');

        Route::post('/seekerAttach/store', [SeekerProfileController::class, 'seekerAttachStore'])->name('seekerAttach.store');
        Route::post('/seekerAttach/destory/{id}', [SeekerProfileController::class, 'seekerAttachDestory'])->name('seekerAttach.destroy');

        Route::post('/immediate-available/update/{id}', [SeekerProfileController::class, 'immediateAvailableUpdate'])->name('immediate-available.update');

        Route::get('/job-post-apply/{id}', [SeekerProfileController::class, 'jobPostApply'])->name('jobpost-apply');

        Route::get('save-job/{id}', [SaveJobController::class, 'create'])->name('save-job');

        Route::post('job-alert', [SeekerJobAlertController::class, 'store'])->name('job-alert.store');

        Route::get('resume-create', [ResumeController::class, 'create'])->name('resume.create');
    });
});
