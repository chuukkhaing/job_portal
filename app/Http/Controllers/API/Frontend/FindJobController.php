<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Industry;
use App\Models\Employer\JobPost;
use DB;

class FindJobController extends Controller
{
    public function findJob()
    {
        $jobPosts = JobPost::with(['Employer:id,logo,name,is_verified', 'MainFunctionalArea:id,name', 'Township:id,name'])->where('is_active', 1)->where('status', 'Online')->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')->select('job_title', 'job_post_type','hide_company', 'job_requirement', 'township_id', 'main_functional_area_id', 'employer_id', 'updated_at')->orderBy('updated_at','desc')->paginate(10);
        $jobPostsCount = JobPost::where('is_active', 1)->where('status', 'Online')->count();
        return response()->json([
            'status' => 'success',
            'jobPostsCount' => $jobPostsCount,
            'jobPosts' => $jobPosts
        ], 200);
    }

    public function getIndustry()
    {

    }
}
