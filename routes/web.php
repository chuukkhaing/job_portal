<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\FrontendRegisterController;

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

Route::get('/register', [FrontendRegisterController::class, 'index'])->name('register');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
