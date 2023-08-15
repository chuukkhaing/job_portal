<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\JobPost;
use App\Models\Admin\Package;
use DB;

class JobPostDetailController extends Controller
{
    public function jobPostDetail($slug)
    {
        $jobpost = JobPost::whereSlug($slug)->first();
        $jobposts = JobPost::whereIsActive(1)->whereNotIn('id',[$jobpost->id])->where('status','Online')->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')->get();
        $similar_jobs = JobPost::where('id','!=',$jobpost->id)->where('job_title','like','%'.$jobpost->job_title.'%')->where('is_active',1)->where('status','Online')->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')->get()->take(10);
        $packages = Package::whereNull('deleted_at')->get();
        return view ('frontend.jobpost.detail', compact('packages','jobpost', 'jobposts', 'similar_jobs'));
    }
}
