<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\JobPost;
use App\Models\Admin\Package;

class JobPostDetailController extends Controller
{
    public function jobPostDetail($slug)
    {
        $jobpost = JobPost::whereSlug($slug)->first();
        $jobposts = JobPost::whereIsActive(1)->whereNotIn('id',[$jobpost->id])->where('status','Online')->get();
        $similar_jobs = JobPost::where('id','!=',$jobpost->id)->where('job_title','like','%'.$jobpost->job_title.'%')->orderBy('updated_at','desc')->get()->take(10);
        $packages = Package::whereNull('deleted_at')->get();
        return view ('frontend.jobpost.detail', compact('packages','jobpost', 'jobposts', 'similar_jobs'));
    }
}
