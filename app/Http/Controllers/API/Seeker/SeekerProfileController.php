<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;
use App\Models\Employer\JobPost;
use DB;

class SeekerProfileController extends Controller
{
    public function dashboard(Request $request)
    {
        $seeker = Seeker::with('SeekerPercentage:id,seeker_id,title,percentage')
                    ->whereId($request->user()->id)
                    ->select('id', 'first_name', 'last_name', 'email', 'email_verified_at as since_member_at', 'image', 'phone', 'is_immediate_available', 'percentage', 'state_id', 'number_of_profile_view')
                    ->withCount(['SeekerAttach as cv_list'])
                    ->first();
        
        $recommended_jobs = JobPost::where('job_title', 'like', '%' . $request->user()->job_title . '%')
                            ->where('main_functional_area_id', $request->user()->main_functional_area_id)
                            ->where('sub_functional_area_id', $request->user()->sub_functional_area_id)
                            ->where('career_level', $request->user()->career_level)
                            ->with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Employer' => function ($query) {
                        $query->with('Industry:id,name')->with('MainEmployer:id,logo,name,is_verified,slug,industry_id,summary,value,no_of_offices,website,no_of_employees')->select('id', 'logo', 'employer_id', 'name', 'industry_id', 'summary', 'value', 'no_of_offices', 'website', 'no_of_employees', 'slug', 'is_verified');
                    }, 'JobPostSkill' => function($skill) {
                        $skill->with('Skill:id,name')->select('skill_id', 'job_post_id');
                    }])
                            ->whereIsActive(1)
                            ->whereStatus('Online')
                            ->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')
                            ->select('id', 'employer_id', 'slug', 'job_title', 'main_functional_area_id', 'sub_functional_area_id', 'industry_id', 'career_level', 'job_type', 'experience_level', 'degree', 'gender', 'currency', 'salary_range', 'country', 'state_id', 'township_id', 'job_description', 'job_requirement', 'benefit', 'job_highlight', 'hide_salary', 'hide_company', 'no_of_candidate', 'job_post_type', 'updated_at as posted_at')
                            ->orderBy('posted_at','desc')
                            ->get()
                            ->take(16);
        if($recommended_jobs->count() == 0) {
            $recommended_jobs = JobPost::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Employer' => function ($query) {
                        $query->with('Industry:id,name')->with('MainEmployer:id,logo,name,is_verified,slug,industry_id,summary,value,no_of_offices,website,no_of_employees')->select('id', 'logo', 'employer_id', 'name', 'industry_id', 'summary', 'value', 'no_of_offices', 'website', 'no_of_employees', 'slug', 'is_verified');
                    }, 'JobPostSkill' => function($skill) {
                        $skill->with('Skill:id,name')->select('skill_id', 'job_post_id');
                    }])
                            ->whereIsActive(1)
                            ->whereStatus('Online')
                            ->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')
                            ->select('id', 'employer_id', 'slug', 'job_title', 'main_functional_area_id', 'sub_functional_area_id', 'industry_id', 'career_level', 'job_type', 'experience_level', 'degree', 'gender', 'currency', 'salary_range', 'country', 'state_id', 'township_id', 'job_description', 'job_requirement', 'benefit', 'job_highlight', 'hide_salary', 'hide_company', 'no_of_candidate', 'job_post_type', 'updated_at as posted_at')
                            ->orderBy('posted_at','desc')
                            ->get()
                            ->take(16);
        }
        return response()->json([
            'status' => 'success',
            'seeker' => $seeker,
            'recommended_jobs' => $recommended_jobs
        ]);
    }

    public function profile(Request $request)
    {
        $seeker = Seeker::with(['state:id,name','township:id,name'])
                    ->whereId($request->user()->id)
                    ->select('id', 'first_name', 'last_name', 'email', 'country', 'state_id', 'township_id', 'address_detail', 'nationality', 'nrc', 'id_card', 'date_of_birth', 'gender', 'marital_status', 'image', 'phone')
                    ->first();
        return response()->json([
            'status' => 'success',
            'seeker' => $seeker
        ]);
    }
}
