<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\JobApply;
use App\Models\Employer\JobPost;

class JobApplyController extends Controller
{
    public function index()
    {
        $job_applies = JobApply::groupBy('job_post_id')->orderBy('updated_at','desc')->get();
        return view('admin.job_apply.index', compact('job_applies'));
    }

    public function jobApplySeeker($id)
    {
        $job_post = JobPost::findOrFail($id);
        $job_apply_seekers = JobApply::whereJobPostId($id)->orderBy('updated_at','desc')->get();
        return view('admin.job_apply.seeker', compact('job_post', 'job_apply_seekers'));
    }
}
