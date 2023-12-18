<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;
use App\Models\Admin\Package;
use App\Models\Admin\PackageItem;
use App\Models\Employer\PointRecord;
use App\Models\Admin\OwnershipType;
use App\Models\Admin\FunctionalArea;
use DB;

class EmployerProfileController extends Controller
{
    public function dashboard(Request $request)
    {
        $employer = Employer::with(['MainEmployer:id,package_point as point_balance,purchased_point'])->whereId($request->user()->id)->select('id','package_point as point_balance','purchased_point')->first();

        $member_ids = Employer::whereId($request->user()->id)->first()->Member->pluck('id')->toArray();
        $employer_id = [];
        foreach($member_ids as $member_id) {
            $employer_id[] = $member_id;
        }
        
        $employer_id[] = $employer->id;
        $employer_id[] = $employer->employer_id;
        
        $open_jobs = JobPost::where('is_active',1)->where('status','Online')->whereIn('employer_id', $employer_id)->count();
        $use_point_history = PointRecord::whereIn('employer_id', $employer_id)->where('status','Complete')->sum('point');
        $lastJobPosts = JobPost::with(['township:id,name'])->whereEmployerId($employer->id)->where('status','Online')->orderBy('posted_at','desc')->select('id','job_title','slug','township_id','updated_at as posted_at')->withCount(['JobApply'])->get()->take(5);
        return response()->json([
            'status' => 'success',
            'open_jobs' => $open_jobs,
            'use_point_history' => $use_point_history,
            'employer' => $employer,
            'lastJobPosts' => $lastJobPosts
        ], 200);
    }

    public function package(Request $request)
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

    public function profile(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        $account_info = Employer::whereId($request->user()->id)->select('email','is_active', DB::raw("(CASE WHEN (employer_id = NULL) THEN 'Admin' ELSE 'Member' End) as Access"))->first();
        if($employer->employer_id) {
            $employer = $employer->findOrFail($employer->employer_id);
        }
        $employer = Employer::with(['EmployerAddress:id,employer_id,country,state_id,township_id,address_detail', 'EmployerTestimonial:id,employer_id,name,title,remark,image','EmployerMedia:id,employer_id,name,type'])->whereId($employer->id)->select('id','logo','background','name','industry_id','ownership_type_id','type_of_employer','phone','website','no_of_offices','no_of_employees','legal_docs','summary','value')->first();
        $ownershipTypes = OwnershipType::whereNull('deleted_at')->get();
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'account_info' => $account_info,
            'employer' => $employer,
        ], 200);
    }
}
