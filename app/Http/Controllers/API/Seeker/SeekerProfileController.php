<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;
use App\Models\Employer\JobPost;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;
use App\Models\Admin\Skill;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Seeker\SeekerSkill;
use Illuminate\Support\Facades\Validator;
use Storage;
use Auth;
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
        ], 200);
    }

    public function profile(Request $request)
    {
        $seeker               = Seeker::with(['state:id,name','township:id,name', 'SeekerEducation:id,seeker_id,degree,major_subject,location,from,to,school,is_current', 'SeekerExperience' => function($exp) {
            $exp->with('MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name')->select('id','seeker_id','job_title','company','main_functional_area_id','sub_functional_area_id','career_level','job_responsibility','industry_id','country','is_current_job','is_experience','start_date','end_date');
        },'SeekerSkill' => function($skill) {
            $skill->with('Skill:id,name')->select('id','seeker_id','skill_id');
        },'SeekerLanguage:id,seeker_id,name,level', 'SeekerReference:id,seeker_id,name,position,company,contact'])
                                ->whereId($request->user()->id)
                                ->select('id', 'first_name', 'last_name', 'email', 'country', 'state_id', 'township_id', 'address_detail', 'nationality', 'nrc', 'id_card', 'date_of_birth', 'gender', 'marital_status', 'image', 'phone')
                                ->first();
        $states               = State::whereNull('deleted_at')->whereIsActive(1)->select('id','name')->get();
        $townships            = Township::whereNull('deleted_at')->whereIsActive(1)->select('id','name','state_id')->get();
        $main_functional_areas     = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->select('id','name')->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', '!=', 0)->whereIsActive(1)->select('id','name','functional_area_id')->get();
        $industries           = Industry::whereNull('deleted_at')->select('id','name')->get();
        return response()->json([
            'status' => 'success',
            'seeker' => $seeker,
            'states' => $states,
            'townships' => $townships,
            'main_functional_areas' => $main_functional_areas,
            'sub_functional_areas' => $sub_functional_areas,
            'industries' => $industries
        ], 200);
    }

    public function getTowhship(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'state_id'    => ['required']
        ], $messages = [
            'required' => ['The :attribute is required.']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            $townships = Township::whereStateId($request->state_id)->whereNull('deleted_at')->orderBy('name')->whereIsActive(1)->select('id','name','state_id')->get();
            return response()->json([
                'status' => 'success',
                'data'   => $townships,
            ], 200);
        }
    }

    public function getSubFunctionalArea(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'main_functional_area_id'    => ['required']
        ], $messages = [
            'required' => ['The :attribute is required.']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', $request->main_functional_area_id)->whereIsActive(1)->select('id','name')->get();
            return response()->json([
                'status' => 'success',
                'data'   => $sub_functional_areas,
            ], 200);
        }
    }

    public function getSkill(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'main_functional_area_id'    => ['required']
        ], $messages = [
            'required' => ['The :attribute is required.']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            $seeker_skills = SeekerSkill::whereSeekerId($request->user()->id)->pluck('skill_id')->toArray();
            $skills        = Skill::whereNull('deleted_at')->where('main_functional_area_id', $request->main_functional_area_id)->whereNotIn('id', $seeker_skills)->whereIsActive(1)->select('id','name','main_functional_area_id')->get();
            return response()->json([
                'status' => 'success',
                'data'   => $skills,
            ]);
        }
    }

    public function profileImageStore(Request $request)
    {
        if ($request->file('profile_image')) {
            $seeker = Seeker::findOrFail($request->user()->id);
            
            $image  = $seeker->image;
            Storage::disk('s3')->delete('seeker/profile/'. $request->user()->id . '/' . $image);
            $image        = null;
            
            $seeker_update = $seeker->update([
                'image'    => $image,
            ]);
            
            $file  = $request->file('profile_image');
            $image = date('YmdHi') . $file->getClientOriginalName();
            
            $path     = 'seeker/profile/'. $request->user()->id . '/' . $image;
            Storage::disk('s3')->makeDirectory($path);
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);

            $seeker->update([
                'image'    => $image,
            ]);

            return response()->json([
                'status' => 'success',
                'image' => $image
            ], 200);
        }
    }

    public function profileImageDestory(Request $request)
    {
        $seeker = Seeker::findOrFail($request->user()->id);
        $image  = $seeker->image;
        Storage::disk('s3')->delete('seeker/profile/'. $request->user()->id . '/' . $image);
        $image        = null;
        
        $seeker->update([
            'image' => $image,
        ]);
        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
