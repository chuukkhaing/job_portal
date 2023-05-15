<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function(){

    // auth 
    Route::get('/', [LoginController::class, 'index']);
    Auth::routes(['register' => false, 'request' => false, 'reset' => false]);
	Route::group(['middleware' => 'auth:web'], function () {

        // dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // user
        Route::resource('user', UserController::class);
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
