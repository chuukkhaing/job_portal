<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;
use App\Models\Admin\Package;
use App\Models\Admin\PackageItem;

class EmployerProfileController extends Controller
{
    public function dashboard(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $lastJobPosts = JobPost::whereEmployerId($employer->id)->where('status','Online')->orderBy('updated_at','desc')->get()->take(5);
        return response()->json([
            'status' => 'success',
            'employer' => $employer,
            'lastJobPosts' => $lastJobPosts
        ], 200);
    }

    public function employerPackage(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $employer_package = Package::whereId($employer->package_id)->select('id','name')->get();
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->select('id','name','price')->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->select('id', 'name', 'point')->get();
        return response()->json([
            'status' => 'success',
            'employer_package' => $employer_package,
            'packages' => $packages,
            'packageItems' => $packageItems
        ], 200);
    }
}
