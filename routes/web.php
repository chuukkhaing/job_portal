<?php

use App\Http\Controllers\Frontend\CompanyDetailController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\JobPostDetailController;
use App\Http\Controllers\Seeker\SeekerLoginController;
use App\Http\Controllers\Seeker\SeekerRegisterController;
use App\Http\Controllers\LangController;
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
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/find-jobs', [HomeController::class, 'findJobs'])->name('find-jobs');

Route::get('/company', [HomeController::class, 'companies'])->name('companies');
Route::get('/company/{slug}', [CompanyDetailController::class, 'companyDetail'])->name('company-detail');

Route::get('/register-form', [SeekerRegisterController::class, 'frontendRegister'])->name('register-form');
Route::get('/login-form', [SeekerLoginController::class, 'frontendLogin'])->name('login-form');

Route::get('/job-post/{slug}', [JobPostDetailController::class, 'jobPostDetail'])->name('jobpost-detail');

Route::get('/job-categories', [HomeController::class, 'jobCategory'])->name('job-categories');

Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::post('/contact-us', [HomeController::class, 'contactUsCreate'])->name('contact-us');
Route::get('/search-job', [HomeController::class, 'searchJob'])->name('search-job');
Route::get('/search-main-function/{id}', [HomeController::class, 'searchMainFunction'])->name('search-main-function');
Route::get('/industry-job/{id}', [HomeController::class, 'industryJob'])->name('industry-job');
Route::get('/find-company', [HomeController::class, 'findCompany'])->name('search-company');
Route::get('/company-jobs/{id}', [HomeController::class, 'companyJob'])->name('company-jobs');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about-us');
Route::get('/terms-of-use', [HomeController::class, 'termsOfUse'])->name('terms-of-use');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/seeker-application-create', [SeekerRegisterController::class, 'applicationCreate'])->name('application-create');
Route::post('/seeker-application-register', [SeekerRegisterController::class, 'applicationRegister'])->name('application-register');
Route::get('/get-township/{id}', [SeekerRegisterController::class, 'getTownship']);