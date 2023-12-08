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
        $jobPosts = JobPost::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Employer' => function ($query) {
                        $query->with('Industry:id,name')->with('MainEmployer:id,logo,name,is_verified,slug,industry_id,summary,value,no_of_offices,website,no_of_employees')->select('id', 'logo', 'employer_id', 'name', 'industry_id', 'summary', 'value', 'no_of_offices', 'website', 'no_of_employees', 'slug', 'is_verified');
                    }, 'JobPostSkill' => function($skill) {
                        $skill->with('Skill:id,name')->select('skill_id', 'job_post_id');
                    }])
                            ->whereIsActive(1)->whereStatus('Online')
                            ->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')
                            ->select('id', 'employer_id', 'slug', 'job_title', 'main_functional_area_id', 'sub_functional_area_id', 'industry_id', 'career_level', 'job_type', 'experience_level', 'degree', 'gender', 'currency', 'salary_range', 'country', 'state_id', 'township_id', 'job_description', 'job_requirement', 'benefit', 'job_highlight', 'hide_salary', 'hide_company', 'no_of_candidate', 'job_post_type', 'updated_at as posted_at')
                            ->orderBy('posted_at','desc')
                            ->paginate(10);
        return response()->json([
            'status' => 'success',
            'jobPosts' => $jobPosts
        ], 200);
    }

    public function getFindJobFilterData()
    {
        $industries = Industry::whereNull('deleted_at')->whereIsActive(1)->select('name','id')->get();
        $job_types = config('jobtype');
        $career_levels = config('careerlevel');
        $qualifications = config('seekerdegree');
        $job_sort_by = array(
            [ 
                'value' => 7,
                'label' => 'Last 7 Days'
            ],
            [ 
                'value' => 30,
                'label' => 'Last 30 Days'
            ]
        );
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
        $jobPosts = JobPost::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Employer' => function ($query) {
            $query->with('Industry:id,name')->with('MainEmployer:id,logo,name,is_verified,slug,industry_id,summary,value,no_of_offices,website,no_of_employees')->select('id', 'logo', 'employer_id', 'name', 'industry_id', 'summary', 'value', 'no_of_offices', 'website', 'no_of_employees', 'slug', 'is_verified');
        }, 'JobPostSkill' => function($skill) {
            $skill->with('Skill:id,name')->select('skill_id', 'job_post_id');
        }])
                ->whereIsActive(1)->whereStatus('Online');
        
        if ($request->function_area) {
            $jobPosts = $jobPosts->whereIn('sub_functional_area_id', $request->function_area)->orWhereIn('main_functional_area_id', $request->function_area);
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
        $jobPosts = $jobPosts->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')
                    ->select('id', 'employer_id', 'slug', 'job_title', 'main_functional_area_id', 'sub_functional_area_id', 'industry_id', 'career_level', 'job_type', 'experience_level', 'degree', 'gender', 'currency', 'salary_range', 'country', 'state_id', 'township_id', 'job_description', 'job_requirement', 'benefit', 'job_highlight', 'hide_salary', 'hide_company', 'no_of_candidate', 'job_post_type', 'updated_at as posted_at')
                    ->orderBy('posted_at','desc')
                    ->paginate(10);
        return response()->json([
            'status' => 'success',
            'jobPosts' => $jobPosts
        ], 200);
    }

    public function getJobTitle()
    {
        $jobTitles = JobPost::where('is_active', 1)->where('status', 'Online')->pluck('job_title')->toArray();
        return response()->json([
            'status' => 'success',
            'jobTitles' => $jobTitles
        ], 200);
    }

    
}
