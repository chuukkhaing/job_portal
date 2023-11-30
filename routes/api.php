<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Frontend\HomeController;
use App\Http\Controllers\API\Frontend\FindJobController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// home 
Route::get('/get-slider', [HomeController::class, 'getSlider']);
Route::get('/get-popular-category', [HomeController::class, 'getPopularCategory']);
Route::get('/get-top-employer', [HomeController::class, 'getTopEmployer']);
Route::get('/get-trending-jobs', [HomeController::class, 'getTrendingJob']);
Route::get('/get-featured-jobs', [HomeController::class, 'getFeaturedJob']);

Route::get('/get-states', [HomeController::class, 'getState']);
Route::get('/get-functional-areas', [HomeController::class, 'getFunctionalArea']);

// findjobs 
Route::get('/find-jobs', [FindJobController::class, 'findJob']);
Route::get('/get-find-job-filter-data', [FindJobController::class, 'getFindJobFilterData']);
Route::post('/search-job', [FindJobController::class, 'searchJob']);
Route::get('/get-job-title', [FindJobController::class, 'getJobTitle']);

// job category 
Route::get('/get-all-category', [HomeController::class, 'getAllCategory']);
Route::get('/get-all-employer', [HomeController::class, 'getAllEmployer']);