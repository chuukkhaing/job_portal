<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Seeker\SeekerRegisterController;
use App\Http\Controllers\Seeker\SeekerLoginController;
use App\Http\Controllers\JobPostDetailController;

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
// Home 
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register-form', [SeekerRegisterController::class, 'frontendRegister'])->name('register-form');
Route::get('/login-form', [SeekerLoginController::class, 'frontendLogin'])->name('login-form');

Route::get('/job-post/{slug}', [JobPostDetailController::class, 'jobPostDetail'])->name('jobpost-detail');