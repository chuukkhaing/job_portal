<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Frontend\HomeController;

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