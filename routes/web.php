<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
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
// Home 
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register-form', [SeekerRegisterController::class, 'frontendRegister'])->name('register-form');

Route::post('/seeker-register', [SeekerRegisterController::class, 'register'])->name('seeker-register');

Route::get('/seeker/verify/{token}', [SeekerVerifyController::class,'VerifyEmail'])->name('seeker-verify');