<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer\JobPost;

class JobPostDetailController extends Controller
{
    public function jobPostDetail($slug)
    {
        $jobpost = JobPost::whereSlug($slug)->first();
        $jobposts = JobPost::whereIsActive(1)->where('id','!=', $jobpost->id)->get();
        return view ('frontend.jobpost.detail', compact('jobpost', 'jobposts'));
    }
}
