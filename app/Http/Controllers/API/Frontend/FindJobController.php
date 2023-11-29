<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Industry;
use App\Models\Employer\JobPost;
use App\Models\Admin\State;
use App\Models\Admin\FunctionalArea;
use DB;

class FindJobController extends Controller
{
    public function findJob()
    {
        $jobPosts = JobPost::with(['Employer:id,logo,name,is_verified', 'MainFunctionalArea:id,name', 'Township:id,name'])->where('is_active', 1)->where('status', 'Online')->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')->select('job_title', 'job_post_type','hide_company', 'job_requirement', 'township_id', 'main_functional_area_id', 'employer_id', 'updated_at as posted_at')->orderBy('posted_at','desc')->paginate(10);
        return response()->json([
            'status' => 'success',
            'jobPosts' => $jobPosts
        ], 200);
    }

    public function getFindJobFilterData()
    {
        $industries = Industry::whereNull('deleted_at')->whereIsActive(1)->pluck('name','id')->toArray();
        $job_types = config('jobtype');
        $career_levels = config('careerlevel');
        $qualifications = config('seekerdegree');
        $job_sort_by = [ 7 => 'Last 7 Days', 30 => 'Last 30 Days'];
        return response()->json([
            'status' => 'success',
            'industries' => $industries,
            'job_types' => $job_types,
            'career_levels' => $career_levels,
            'qualifications' => $qualifications,
            'job_sort_by' => $job_sort_by
        ], 200);
    }

    public function searchJob(Request $request)
    {
        $jobPosts              = JobPost::with(['Employer:id,logo,name,is_verified', 'MainFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Industry:id,name'])->where('is_active', 1)->where('status','Online');
        
        if ($request->function_area) {
            $jobPosts = $jobPosts->whereIn('sub_functional_area_id', $request->function_area);
        }
        if ($request->location) {
            $jobPosts = $jobPosts->where('state_id', $request->location);
        }
        if ($request->job_title) {
            $jobPosts = $jobPosts->where('job_title', 'like', '%' . $request->job_title . '%')
                                ->orWhereHas('State', function ($query1) use ($request) {
                                    $query1->where('name', 'like', '%' . $request->job_title . '%')->where('is_active', 1)->where('status','Online');
                                })
                                ->orWhereHas('Employer', function ($query) use ($request) {
                                    $query->where('name', 'like', '%' . $request->job_title . '%')->where('is_active', 1)->where('status','Online');
                                });
        }
        if ($request->industry) {
            $jobPosts = $jobPosts->where('industry_id', $request->industry);
        }
        if ($request->job_type) {
            $jobPosts = $jobPosts->where('job_type', $request->job_type);
        }
        if ($request->career_level) {
            $jobPosts = $jobPosts->where('career_level', $request->career_level);
        }
        if ($request->qualification) {
            $jobPosts = $jobPosts->where('degree', $request->qualification);
        }
        if ($request->job_sorting) {
            $date = now()->subDays($request->job_sorting);
            $jobPosts = $jobPosts->where('updated_at','>=',$date);
        }
        $jobPosts = $jobPosts->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')->select('job_title', 'job_post_type','hide_company', 'job_requirement', 'state_id', 'township_id', 'main_functional_area_id', 'industry_id', 'employer_id', 'updated_at as posted_at')->orderBy('posted_at','desc')->paginate(10);
        return response()->json([
            'status' => 'success',
            'jobPosts' => $jobPosts
        ], 200);
    }
}
