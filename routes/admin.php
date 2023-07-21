<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\TownshipController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\OwnershipTypeController;
use App\Http\Controllers\Admin\PackageItemController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\EmployerController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\FunctionalAreaController;
use App\Http\Controllers\Admin\SubFunctionalAreaController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;

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

    // auth 
    Route::get('/', [LoginController::class, 'index']);
    Auth::routes(['register' => false, 'request' => false, 'reset' => false]);
	Route::group(['middleware' => 'auth:web'], function () {

        // dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // role
        Route::resource('roles', RoleController::class);

        // user
        Route::resource('users', UserController::class);

        // state
        Route::resource('state', StateController::class);

        // city 
        Route::resource('city', TownshipController::class);

        // industry 
        Route::resource('industry', IndustryController::class);

        // ownershiptype 
        Route::resource('ownership-type', OwnershipTypeController::class);

        // package items 
        Route::resource('package-item', PackageItemController::class);

        // packages
        Route::resource('package-type', PackageController::class);

        // employer 
        Route::resource('employers', EmployerController::class);
        Route::get('employers/get-township/{id}', [EmployerController::class, 'getTownship']);

        // function area
        Route::resource('main-functional-area', FunctionalAreaController::class);
        Route::resource('sub-functional-area', SubFunctionalAreaController::class);

        // slider 
        Route::resource('slider', SliderController::class);

        // skill 
        Route::resource('skill', SkillController::class);
        Route::get('/get-sub-functional-area/{id}', [SkillController::class, 'getSubFunctionalArea']);

        // feedback 
        Route::resource('feedback', FeedbackController::class);
    });
});