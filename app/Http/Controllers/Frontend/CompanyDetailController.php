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
        $member_ids = $employer->Member->pluck('id')->toArray();
        $employer_id = [];
        foreach($member_ids as $member_id) {
            $employer_id[] = $member_id;
        }
        
        $employer_id[] = $employer->id;
        $employer_id[] = $employer->employer_id;
        $jobPosts = JobPost::whereIn('employer_id', $employer_id)->where('is_active',1)->where('status','Online')->where('hide_company', 0)->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')->get()->take(6);
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        if($employer->EmployerMedia->where('type','Video Link')->count() > 0) {
            $videourl = $employer->EmployerMedia->where('type','Video Link')->first()->name;
        }else {
            $videourl = "";
        }
        
        return view('frontend.company-detail', compact('packages','employer', 'jobPosts', 'videourl'));
    }
}
