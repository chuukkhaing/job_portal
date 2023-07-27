<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;

class CompanyDetailController extends Controller
{
    public function companyDetail($slug)
    {
        $employer = Employer::whereSlug($slug)->first();
        $jobPosts = JobPost::whereEmployerId($employer->id)->where('is_active',1)->where('status','Online')->orderBy('updated_at','desc')->get()->take(6);
        return view('frontend.company-detail', compact('employer', 'jobPosts'));
    }
}
