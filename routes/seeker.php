<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Seeker\SeekerRegisterController;
use App\Http\Controllers\Seeker\SeekerLoginController;
use App\Http\Controllers\Seeker\SeekerProfileController;

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

    Route::post('register', [SeekerRegisterController::class, 'register'])->name('seeker-register');

    Route::get('email/verify/{id}', [SeekerRegisterController::class, 'notice'])->name('seeker-verify-notice');
    Route::get('email/resend/{id}', [SeekerRegisterController::class, 'resend'])->name('seeker-resend');
    Route::get('verify/{id}', [SeekerLoginController::class,'VerifyEmail'])->name('seeker-verify');
    Route::post('logout', [SeekerProfileController::class,'logout'])->name('seeker.logout');
    Route::post('login', [SeekerLoginController::class,'login'])->name('seeker-login');
    
	Route::group(['middleware' => 'auth:seeker'], function () {
        Route::get('profile', [SeekerProfileController::class,'index'])->name('seeker.profile');
    });
});