<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Seeker\SeekerRegisterController;
use App\Http\Controllers\Seeker\SeekerVerifyController;

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

    Route::get('email/verify', [SeekerVerifyController::class, 'notice'])->name('seeker-verify-notice');
    Route::get('email/resend', [SeekerVerifyController::class, 'resend'])->name('seeker-resend');
    Route::get('verify/{id}', [SeekerVerifyController::class,'VerifyEmail'])->name('seeker-verify');

    
	Route::group(['middleware' => 'auth:seeker'], function () {

    });
});