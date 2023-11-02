<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;
use App\Models\Admin\Package;
use DB;

class CompanyDetailController extends Controller
{
    public function companyDetail($slug)
    {
        $employer = Employer::whereSlug($slug)->first();
        $jobPosts = JobPost::whereEmployerId($employer->id)->where('is_active',1)->where('status','Online')->where('hide_company', 0)->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')->get()->take(6);
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        if($employer->EmployerMedia->where('type','Video Link')->count() > 0) {
            $videourl = $employer->EmployerMedia->where('type','Video Link')->first()->name;
        }else {
            $videourl = "";
        }
        
        return view('frontend.company-detail', compact('packages','employer', 'jobPosts', 'videourl'));
    }
}
