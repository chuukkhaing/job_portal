<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;

class ManageJobController extends Controller
{
    public function manageJob(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);

        $member_ids = $employer->Member->pluck('id')->toArray();
        $employer_id = [];
        foreach($member_ids as $member_id) {
            $employer_id[] = $member_id;
        }
        
        $employer_id[] = $employer->id;
        $employer_id[] = $employer->employer_id;
        
        $pendingjobPosts = JobPost::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name'])->whereIn('employer_id', $employer_id)->where('status', 'Pending')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','main_functional_area_id', 'sub_functional_area_id', 'status','is_active', 'updated_at as date')->paginate(15);
        $onlinejobPosts = JobPost::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name'])->whereIn('employer_id', $employer_id)->where('status', 'Online')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','main_functional_area_id', 'sub_functional_area_id', 'status','is_active', 'updated_at as date')->paginate(15);
        $rejectjobPosts = JobPost::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name'])->whereIn('employer_id', $employer_id)->where('status', 'Reject')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','main_functional_area_id', 'sub_functional_area_id', 'status','is_active', 'updated_at as date')->paginate(15);
        $expirejobPosts = JobPost::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name'])->whereIn('employer_id', $employer_id)->where('status', 'Expire')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','main_functional_area_id', 'sub_functional_area_id', 'status','is_active', 'updated_at as date')->paginate(15);
        $draftjobPosts = JobPost::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name'])->whereIn('employer_id', $employer_id)->where('status', 'Draft')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','main_functional_area_id', 'sub_functional_area_id', 'status','is_active', 'updated_at as date')->paginate(15);
        $jobPostCount = JobPost::whereIn('employer_id', $employer_id)->orderBy('updated_at', 'desc')->count();

        return response()->json([
            'status' => 'success',
            'jobPostCount' => $jobPostCount,
            'pendingjobPosts' => $pendingjobPosts,
            'onlinejobPosts' => $onlinejobPosts,
            'rejectjobPosts' => $rejectjobPosts,
            'expirejobPosts' => $expirejobPosts,
            'draftjobPosts' => $draftjobPosts,
        ], 200);

    }

}
