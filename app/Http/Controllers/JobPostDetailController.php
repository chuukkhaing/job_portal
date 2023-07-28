<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer\JobPost;
use App\Models\Admin\Package;

class JobPostDetailController extends Controller
{
    public function jobPostDetail($slug)
    {
        $jobpost = JobPost::whereSlug($slug)->first();
        $jobposts = JobPost::whereIsActive(1)->whereNotIn('id',[$jobpost->id])->where('status','Online')->get();
        $packages = Package::whereNull('deleted_at')->get();
        return view ('frontend.jobpost.detail', compact('packages','jobpost', 'jobposts'));
    }
}
