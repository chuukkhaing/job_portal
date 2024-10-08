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
use App\Http\Controllers\Admin\JobPostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SeekerController;
use App\Http\Controllers\Admin\EmployerInfoController;
use App\Http\Controllers\Admin\PointPackageController;
use App\Http\Controllers\Admin\PointOrderController;
use App\Http\Controllers\Admin\BankInfoController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Seeker\SeekerLoginController;
use App\Http\Controllers\Employer\EmployerLoginController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SEOController;
use App\Http\Controllers\Admin\JobApplyController;
use App\Http\Controllers\Admin\OnlineBookingTimeController;
use App\Http\Controllers\Admin\InPersonBookingTimeController;
use App\Http\Controllers\Admin\CloseOnlineBookingTimeController;
use App\Http\Controllers\Admin\CloseInPersonBookingTimeController;
use App\Http\Controllers\Admin\OnlineBookingController;
use App\Http\Controllers\Admin\InPersonBookingController;

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
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::get('verify/{id}', [SeekerLoginController::class, 'VerifyEmail'])->name('seeker-verify');
    Route::get('verify/{id}', [EmployerLoginController::class, 'VerifyEmail'])->name('employer-verify');
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
        Route::post('/employer-admin-logo', [EmployerController::class, 'uploadLogo'])->name('employer-admin-logo.store');
        Route::post('/employer-admin-logo-remove', [EmployerController::class, 'removeLogo'])->name('employer-admin-logo.remove');

        // function area
        Route::resource('main-functional-area', FunctionalAreaController::class);
        Route::resource('sub-functional-area', SubFunctionalAreaController::class);

        // slider 
        Route::resource('slider', SliderController::class);
        Route::post('/slider-image', [SliderController::class, 'uploadImage'])->name('slider-image.store');
        Route::post('/slider-remove', [SliderController::class, 'removeImage'])->name('slider.remove');

        // skill 
        Route::resource('skill', SkillController::class);
        Route::get('/get-sub-functional-area/{id}', [SkillController::class, 'getSubFunctionalArea']);

        // feedback 
        Route::resource('feedback', FeedbackController::class);

        // jobpost 
        Route::get('job-posts/search', [JobPostController::class, 'search'])->name('job-posts.search');
        Route::resource('job-posts', JobPostController::class);
        
        // profile 
        Route::resource('admin-profile', ProfileController::class);

        // seeker 
        Route::resource('seeker', SeekerController::class);
        Route::get('download-ic-cv/{id}', [SeekerController::class, 'icFormatCVDownload'])->name('ic-format-cv');

        // employer info 
        Route::resource('employer-info', EmployerInfoController::class);
        Route::post('/employer-info-address', [EmployerInfoController::class, 'employerAddressStore'])->name('employer-info-address.store');
        Route::post('employer-info-address/destory/{id}', [EmployerInfoController::class, 'employerAddressDestroy']);
        Route::post('/employer-info-testimonial', [EmployerInfoController::class, 'employerTestimonialStore'])->name('employer-info-testimonial.store');
        Route::post('employer-info-testimonial/destory/{id}', [EmployerInfoController::class, 'employerTestimonialDestroy']);
        Route::post('/employer-info-media', [EmployerInfoController::class, 'employerMediaStore'])->name('employer-info-media.store');
        Route::post('employer-info-media/destory/{id}', [EmployerInfoController::class, 'employerMediaDestroy']);

        // point package 
        Route::resource('point-package', PointPackageController::class);

        // point order 
        Route::resource('point-topup', PointOrderController::class);

        // bank info
        Route::resource('bank-info', BankInfoController::class);

        // tax 
        Route::resource('tax', TaxController::class);

        // invoice 
        Route::resource('invoice', InvoiceController::class);
        Route::get('invoice-send/{id}', [InvoiceController::class, 'sendInvoice'])->name('send-invoice');
        Route::get('receipt-send/{id}', [InvoiceController::class, 'sendReceipt'])->name('send-receipt');

        // permission 
        Route::resource('permission', PermissionController::class);

        // blog ctegory 
        Route::resource('blog-category', BlogCategoryController::class);

        // blog post 
        Route::resource('blog-post', BlogPostController::class);

        // site setting 
        Route::resource('site-setting', SiteSettingController::class);
        Route::get('site-setting/reset/{id}', [SiteSettingController::class, 'reset'])->name('site-setting.reset');

        // job apply 
        Route::get('job-apply', [JobApplyController::class, 'index'])->name('job-apply.index');
        Route::get('job-apply-seeker/{id}', [JobApplyController::class, 'jobApplySeeker'])->name('job-apply.seeker');

        // seo
        Route::resource('seo', SEOController::class);

        // online booking time 
        Route::resource('online-booking-time', OnlineBookingTimeController::class);

        // online booking 
        Route::resource('onlinebooking', OnlineBookingController::class);

        // inperson booking time 
        Route::resource('inperson-booking-time', InPersonBookingTimeController::class);

        // inperson booking 
        Route::resource('inpersonbooking', InPersonBookingController::class);

        // close online booking time 
        Route::resource('close-online-booking-time', CloseOnlineBookingTimeController::class);

        // close inperson booking time 
        Route::resource('close-inperson-booking-time', CloseInPersonBookingTimeController::class);
    });
});