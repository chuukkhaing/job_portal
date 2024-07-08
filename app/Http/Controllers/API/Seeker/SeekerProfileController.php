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
use App\Models\Seeker\SeekerEducation;
use App\Models\Seeker\SeekerExperience;
use App\Models\Seeker\SeekerLanguage;
use App\Models\Seeker\SeekerReference;
use App\Models\Seeker\SeekerSkill;
use Illuminate\Support\Facades\Validator;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Seeker\SeekerJobPostAnswer;
use App\Models\Seeker\SeekerPercentage;
use App\Mail\JobApplyNotiToRecruiter;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Seeker\JobApply;
use App\Mail\JobApplyMail;
use Storage;
use Hash;
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
                    }, 'JobPostQuestion:id,job_post_id,question,answer'])
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
                    }, 'JobPostQuestion:id,job_post_id,question,answer'])
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

    public function recommendJob(Request $request)
    {
        $recommended_jobs = JobPost::where('job_title', 'like', '%' . $request->user()->job_title . '%')
                            ->where('main_functional_area_id', $request->user()->main_functional_area_id)
                            ->where('sub_functional_area_id', $request->user()->sub_functional_area_id)
                            ->where('career_level', $request->user()->career_level)
                            ->with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Employer' => function ($query) {
                        $query->with('Industry:id,name')->with('MainEmployer:id,logo,name,is_verified,slug,industry_id,summary,value,no_of_offices,website,no_of_employees')->select('id', 'logo', 'employer_id', 'name', 'industry_id', 'summary', 'value', 'no_of_offices', 'website', 'no_of_employees', 'slug', 'is_verified');
                    }, 'JobPostSkill' => function($skill) {
                        $skill->with('Skill:id,name')->select('skill_id', 'job_post_id');
                    }, 'JobPostQuestion:id,job_post_id,question,answer'])
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
                    }, 'JobPostQuestion:id,job_post_id,question,answer'])
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
            'recommended_jobs' => $recommended_jobs
        ], 200);
    }

    public function profile(Request $request)
    {
        $seeker               = Seeker::with(['State:id,name','Township:id,name', 'SeekerEducation:id,seeker_id,degree,major_subject,location,from,to,school,is_current', 'SeekerExperience' => function($exp) {
            $exp->with('MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name')->select('id','seeker_id','job_title','company','main_functional_area_id','sub_functional_area_id','career_level','job_responsibility','industry_id','country','is_current_job','is_experience','start_date','end_date');
        },'SeekerSkill' => function($skill) {
            $skill->with('Skill:id,name')->select('id','seeker_id','skill_id');
        },'SeekerLanguage:id,seeker_id,name,level', 'SeekerReference:id,seeker_id,name,position,company,contact'])
                                ->whereId($request->user()->id)
                                ->select('id', 'first_name', 'last_name', 'email', 'country', 'state_id', 'township_id', 'address_detail', 'nationality', 'nrc', 'id_card', 'date_of_birth', 'gender', 'marital_status', 'image', 'phone', 'summary')
                                ->first();
        $states               = State::whereNull('deleted_at')->whereIsActive(1)->select('id','name')->get();
        $townships            = Township::whereNull('deleted_at')->whereIsActive(1)->select('id','name','state_id')->get();
        $main_functional_areas     = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->select('id','name')->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', '!=', 0)->whereIsActive(1)->select('id','name','functional_area_id')->get();
        $industries           = Industry::whereNull('deleted_at')->select('id','name')->get();
        $language_level       = array('Fluent', 'Advance', 'Conversational', 'Basic');
        return response()->json([
            'status' => 'success',
            'seeker' => $seeker,
            'states' => $states,
            'townships' => $townships,
            'main_functional_areas' => $main_functional_areas,
            'sub_functional_areas' => $sub_functional_areas,
            'industries' => $industries,
            'language_level' => $language_level
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
        $validator =  Validator::make($request->all(), [
            'profile_image'    => ['required']
        ], $messages = [
            'required' => ['The :attribute is required.']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
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

    public function personalInformation(Request $request)
    {
        
        if($request->column == 'phone') {
            $validator =  Validator::make($request->all(), [
                'value' => ['nullable', new MyanmarPhone],
            ], $messages = [
                'MyanmarPhone' => ['The phone number must be valid myanmar phone number.']
            ]);
        }elseif ($request->column == 'date_of_birth') {
            $validator =  Validator::make($request->all(), [
                'value' => ['date', 'nullable'],
            ], $messages = [
                'date' => ['The :attribute is not a valid date.']
            ]);
        }else {
            $validator =  Validator::make($request->all(), [
                'column' => ['required'],
                'value' => ['nullable'],
            ]);
        }
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {

            $seeker = Seeker::findOrFail($request->user()->id);
            
            if($request->column == 'date_of_birth') {
                $request->value = $request->value ? date('Y-m-d', strtotime($request->value)) : null;
            }
            $seeker->update([
                $request->column => $request->value,
            ]);

            $seeker_info = Seeker::findOrFail($request->user()->id);
            $seeker_percentage = $this->updateSeekerPercentage($seeker_info);
            return response()->json([
                'status' => 'success',
                $request->column => $request->value
            ], 200);
        }
    }

    public function updateSeekerPercentage(Seeker $seeker)
    {
        if (isset($seeker->first_name) && isset($seeker->last_name) && (isset($seeker->nrc) || isset($seeker->id_card)) && isset($seeker->date_of_birth) && isset($seeker->phone) && isset($seeker->country) && isset($seeker->nationality)) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Personal Information')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 15,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }else {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Personal Information')->first();
            if($seeker_percent->percentage > 0) {
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => $seeker_percent->percentage - 15,
                ]);
            }
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }
        if (isset($seeker->main_functional_area_id) && isset($seeker->sub_functional_area_id) && isset($seeker->job_title) && isset($seeker->job_type) && isset($seeker->career_level) && isset($seeker->preferred_salary) && isset($seeker->industry_id)) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Career of Choice')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 20,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }else {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Career of Choice')->first();
            if($seeker_percent->percentage > 0) {
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => $seeker_percent->percentage - 20,
                ]);
            }
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return true;
    }

    public function summaryGenerate(Request $request, \OpenAI\Client $client)
    {
        $seeker               = Seeker::whereId($request->user()->id)->select('first_name', 'last_name', 'gender')->first();
        $my_exp               = '';
        $experiences          = SeekerExperience::whereSeekerId($request->user()->id)->get();
        foreach($experiences as $exp) {
            $my_exp = $my_exp . ($exp->is_experience == 0 ? 'I have No Experience' : 'My work experience' . $exp->job_title . ' at ' . $exp->company . ' from ' . date('Y', strtotime($exp->start_date)) . ' to ' . ($exp->is_current_job == 1 ? '' : date('Y', strtotime($exp->end_date)) . $exp->career_level . 'my job responsibility ' . $exp->job_responsibility . ($exp->is_current_job == 1 ? 'is my current job' : '')));
        }
        $my_edu               = '';
        $educations           = SeekerEducation::whereSeekerId($request->user()->id)->get();
        foreach($educations as $edu) {
            $my_edu = $my_edu . ($edu->is_current == 1 ? 'My current Education' : 'My Education') . $edu->degree . $edu->major_subject . ' at ' . $edu->school . $edu->location . ' start study from ' . $edu->from . ' to ' . $edu->to;
        }
        $my_skill             = '';
        $skills               = SeekerSkill::whereSeekerId($request->user()->id)->get();
        foreach($skills as $skill) {
            $my_skill = $my_skill . $skill->Skill->name;
        }
        $my_lang              = '';
        $languages            = SeekerLanguage::whereSeekerId($request->user()->id)->get();
        foreach($languages as $lang) {
            $my_lang          = $my_lang . 'I am ' . $lang->level . ' in ' .$lang->name; 
        }
        
        $result = $client->completions()->create([
            'prompt' => 'Write about my summary name : ' . $seeker->first_name . $seeker->last_name . '.' . $my_exp . '.' . $my_edu. '.' . $my_skill,
            'model' => 'gpt-3.5-turbo-instruct',
            'max_tokens' => 400,
        ]);

        return response()->json([
            'status' => 'success',
            'summary_ai' => ltrim($result->choices[0]->text)
        ]);

        return response()->json([
            'status' => 'success',
            'summary_ai' => ltrim($result->choices[0]->text)
        ]);
    }

    public function getApplication(Request $request)
    {
        $applications    = JobApply::with(['JobPost' => function($query) {
            $query->with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Employer' => function ($query) {
                $query->with('Industry:id,name')->with('MainEmployer:id,logo,name,is_verified,slug,industry_id,summary,value,no_of_offices,website,no_of_employees')->select('id', 'logo', 'employer_id', 'name', 'industry_id', 'summary', 'value', 'no_of_offices', 'website', 'no_of_employees', 'slug', 'is_verified');
            }, 'JobPostSkill' => function($skill) {
                $skill->with('Skill:id,name')->select('skill_id', 'job_post_id');
            }, 'JobPostQuestion:id,job_post_id,question,answer'])
                    ->select('id', 'employer_id', 'slug', 'job_title', 'main_functional_area_id', 'sub_functional_area_id', 'industry_id', 'career_level', 'job_type', 'experience_level', 'degree', 'gender', 'currency', 'salary_range', 'country', 'state_id', 'township_id', 'job_description', 'job_requirement', 'benefit', 'job_highlight', 'hide_salary', 'hide_company', 'no_of_candidate', 'job_post_type', 'updated_at as posted_at');
        }])->whereSeekerId($request->user()->id)->select('id','employer_id','job_post_id','created_at as applied_at')->orderBy('created_at','desc')->paginate(15);
        return response()->json([
            'status' => 'success',
            'applications' => $applications
        ]);
    }

    public function applicationSearch(Request $request)
    {
        $applications    = JobApply::with(['JobPost' => function($query) {
            $query->with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Employer' => function ($query) {
                $query->with('Industry:id,name')->with('MainEmployer:id,logo,name,is_verified,slug,industry_id,summary,value,no_of_offices,website,no_of_employees')->select('id', 'logo', 'employer_id', 'name', 'industry_id', 'summary', 'value', 'no_of_offices', 'website', 'no_of_employees', 'slug', 'is_verified');
            }, 'JobPostSkill' => function($skill) {
                $skill->with('Skill:id,name')->select('skill_id', 'job_post_id');
            }, 'JobPostQuestion:id,job_post_id,question,answer'])
                    ->select('id', 'employer_id', 'slug', 'job_title', 'main_functional_area_id', 'sub_functional_area_id', 'industry_id', 'career_level', 'job_type', 'experience_level', 'degree', 'gender', 'currency', 'salary_range', 'country', 'state_id', 'township_id', 'job_description', 'job_requirement', 'benefit', 'job_highlight', 'hide_salary', 'hide_company', 'no_of_candidate', 'job_post_type', 'updated_at as posted_at');
        }])->whereSeekerId($request->user()->id)->select('id','employer_id','job_post_id','created_at as applied_at')->orderBy('created_at','desc')->paginate(15);

        if($request->job_title) {
            $applications    = JobApply::with(['JobPost' => function($query) use ($request) {
                $query->with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Employer' => function ($query) {
                    $query->with('Industry:id,name')->with('MainEmployer:id,logo,name,is_verified,slug,industry_id,summary,value,no_of_offices,website,no_of_employees')->select('id', 'logo', 'employer_id', 'name', 'industry_id', 'summary', 'value', 'no_of_offices', 'website', 'no_of_employees', 'slug', 'is_verified');
                }, 'JobPostSkill' => function($skill) {
                    $skill->with('Skill:id,name')->select('skill_id', 'job_post_id');
                }, 'JobPostQuestion:id,job_post_id,question,answer'])
                        ->select('id', 'employer_id', 'slug', 'job_title', 'main_functional_area_id', 'sub_functional_area_id', 'industry_id', 'career_level', 'job_type', 'experience_level', 'degree', 'gender', 'currency', 'salary_range', 'country', 'state_id', 'township_id', 'job_description', 'job_requirement', 'benefit', 'job_highlight', 'hide_salary', 'hide_company', 'no_of_candidate', 'job_post_type', 'updated_at as posted_at');
            }])->whereHas('JobPost', function($job_post) use ($request) {
                $job_post->where('job_title', 'Like', '%' . $request->job_title . '%');
            })->whereSeekerId($request->user()->id)->select('id','employer_id','job_post_id','created_at as applied_at')->orderBy('created_at','desc')->paginate(15);
        }
        return response()->json([
            'status' => 'success',
            'applications' => $applications
        ]);
    }

    public function jobPostApply($id, Request $request)
    {
        $jobpost = JobPost::findOrFail($id);
        if ($request->user()->percentage < 80) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Please upload your CV as an attachment or update your profile to a minimum of 80% completion for us to consider your qualifications.!'
            ]);
        } else {
            $already_apply = JobApply::whereSeekerId($request->user()->id)->whereJobPostId($id)->count();
            if($already_apply > 0) {
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Already Applied!'
                ], 200);
            }else {
                if($jobpost->JobPostQuestion->count() > 0) {
                    $validator =  Validator::make($request->all(), [
                        'answers'    => ['required']
                    ], $messages = [
                        'answers.required' => ['Need to answer all questions.']
                    ]);
                    if ($validator->fails()) {
                        return response(['errors'=>$validator->messages()], 422);
                    }else {
                        
                        $jobApply = JobApply::create([
                            'employer_id' => $jobpost->employer_id,
                            'job_post_id' => $id,
                            'seeker_id'   => $request->user()->id,
                        ]);
                        if(isset($jobpost->recruiter_email)) {
                            \Mail::to($jobpost->recruiter_email)->send(new JobApplyNotiToRecruiter($jobApply));
                        }
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
                        if(isset($recommended_jobs)) {
                            \Mail::to($request->user()->email)->send(new JobApplyMail($recommended_jobs, $jobApply));
                        }
                        if(isset($request->answers)) {
                            foreach($request->answers as $answer) {
                                $answer = SeekerJobPostAnswer::create([
                                    'job_post_id'          => $id,
                                    'seeker_id'            => $request->user()->id,
                                    'job_apply_id'         => $jobApply->id,
                                    'job_post_question_id' => $answer['job_post_question_id'],
                                    'answer'               => $answer['answer']
                                ]);
                            }
                        }
                        return response()->json([
                            'status' => 'success',
                            'msg' => 'Job Apply Successfully!'
                        ], 200);
                    }
                }else {
                        
                    $jobApply = JobApply::create([
                        'employer_id' => $jobpost->employer_id,
                        'job_post_id' => $id,
                        'seeker_id'   => $request->user()->id,
                    ]);
                    if(isset($jobpost->recruiter_email)) {
                        \Mail::to($jobpost->recruiter_email)->send(new JobApplyNotiToRecruiter($jobApply));
                    }
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
                    if(isset($recommended_jobs)) {
                        \Mail::to($request->user()->email)->send(new JobApplyMail($recommended_jobs, $jobApply));
                    }
                    if(isset($request->answers)) {
                        foreach($request->answers as $answer) {
                            $answer = SeekerJobPostAnswer::create([
                                'job_post_id'          => $id,
                                'seeker_id'            => $request->user()->id,
                                'job_apply_id'         => $jobApply->id,
                                'job_post_question_id' => $answer['job_post_question_id'],
                                'answer'               => $answer['answer']
                            ]);
                        }
                    }
                    return response()->json([
                        'status' => 'success',
                        'msg' => 'Job Apply Successfully!'
                    ], 200);
                }
            }
            
        }
    }

    public function changePassword(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'password'      => ['required', 'string', 'min:8', 'same:confirm-password'],
            'confirm-password'      => ['required', 'string', 'min:8', 'same:password'],
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            $seeker = Seeker::findOrFail($request->user()->id);
            if ($request->password) {
                $password = Hash::make($request->password);
            } else {
                $password = $seeker->password;
            }
            $seeker->update([
                'password' => $password
            ]);
            return response()->json([
                'status' => 'success',
                'msg' => 'Change Password Success.'
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'msg' => 'Logout!'
        ]);
    }

    public function applyJob(Request $request)
    {
        $apply_jobs = JobApply::whereSeekerId($request->user()->id)->select('id','job_post_id','created_at as applied_at')->get();
        return response()->json([
            'status' => 'success',
            'apply_jobs' => $apply_jobs
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $seeker_info = Seeker::with(['SeekerExperience','SeekerEducation', 'SeekerLanguage', 'SeekerReference', 'SeekerSkill'])->whereId($request->user()->id)->get();
        $seeker = Seeker::findOrFail($request->user()->id);

        // reset seeker percentage 
        $reset_percentage = SeekerPercentage::whereSeekerId($seeker->id)->update([
            'percentage' => 0
        ]);

        // update cv sync percentage 
        $update_cv_sync_percentage = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Resume Attachment')->update([
            'percentage' => 80
        ]);

        $image  = $seeker->image;
        
        if ($request->file('profile_image')) {
            $file  = $request->file('profile_image');
            $image = date('YmdHi') . $file->getClientOriginalName();
            
            $path     = 'seeker/profile/'. $request->user()->id . '/' . $image;
            Storage::disk('s3')->put($path, file_get_contents($file));
        }
        $date_of_birth = $request->date_of_birth ? date('Y-m-d', strtotime($request->date_of_birth)) : null;

        $seeker->update([
            'first_name'              => $request->first_name,
            'last_name'               => $request->last_name,
            'phone'                   => $request->phone,
            'image'                   => $image,
            'country'                 => $request->country,
            'state_id'                => $request->state_id,
            'township_id'             => $request->township_id,
            'address_detail'          => $request->address_detail,
            'nationality'             => $request->nationality,
            'nrc'                     => $request->nrc,
            'id_card'                 => $request->id_card,
            'date_of_birth'           => $date_of_birth,
            'gender'                  => $request->gender,
            'marital_status'          => $request->marital_status,
            'job_title'               => $request->job_title,
            'main_functional_area_id' => $request->main_functional_area_id,
            'sub_functional_area_id'  => $request->sub_functional_area_id,
            'job_type'                => $request->job_type,
            'career_level'            => $request->career_level,
            'preferred_salary'        => $request->preferred_salary,
            'industry_id'             => $request->industry_id,
            'summary'                 => $request->summary,
            'percentage'              => 80
        ]);

        // reset seeker experiences 
        $reset_seeker_experiences = SeekerExperience::whereSeekerId($seeker->id)->delete();

        // add seeker experiences 
        if(isset($request->experiences)) {
            foreach($request->experiences as $experience) {
                $end_date = Null;
                $start_date = NUll;
                if(isset($experience['end_date'])) {
                    $end_date = $experience['end_date'] ? date('Y-m-d', strtotime($experience['end_date'])) : null;
                }
                
                if(isset($experience['is_current_job']) && $experience['is_current_job'] == 1) {
                    $end_date = Null;
                }

                if(isset($experience['start_date'])) {
                    $start_date = $experience['start_date'] ? date('Y-m-d', strtotime($experience['start_date'])) : null;
                }
                
                $experience_create = SeekerExperience::create([
                    'seeker_id'               => $seeker->id,
                    'job_title'               => $experience['job_title'] ?? null,
                    'company'                 => $experience['company'] ?? null,
                    'main_functional_area_id' => $experience['main_functional_area_id'] ?? null,
                    'sub_functional_area_id'  => $experience['sub_functional_area_id'] ?? null,
                    'career_level'            => $experience['career_level'] ?? null,
                    'industry_id'             => $experience['industry_id'] ?? null,
                    'start_date'              => $start_date,
                    'end_date'                => $end_date,
                    'is_experience'           => $experience['is_experience'] ?? null,
                    'is_current_job'          => $experience['is_current_job'] ?? 0,
                    'country'                 => $experience['country'] ?? null,
                    'job_responsibility'      => $experience['job_responsibility'] ?? null,
                ]);
            }
        }

        // reset seeker educations 
        $reset_seeker_educations = SeekerEducation::whereSeekerId($seeker->id)->delete();

        // add seeker educations 
        if(isset($request->educations)) {
            foreach($request->educations as $education) {
                $to = Null;
                if(isset($education['to'])) {
                    $to = $education['to'];
                }
                if(isset($education['is_current']) && $education['is_current'] == 1) {
                    $to = null;
                }
                $education_create = SeekerEducation::create([
                    'seeker_id'     => $seeker->id,
                    'degree'        => $education['degree'] ?? null,
                    'major_subject' => $education['major_subject'] ?? null,
                    'location'      => $education['location'] ?? null,
                    'from'          => $education['from'] ?? null,
                    'to'            => $to ?? null,
                    'school'        => $education['school'] ?? null,
                    'is_current'    => $education['is_current'] ?? 0
                ]);
            }
        }

        // reset seeker languages 
        $reset_seeker_languages = SeekerLanguage::whereSeekerId($seeker->id)->delete();

        // add seeker languages 
        if(isset($request->languages)) {
            foreach($request->languages as $language) {
                $language = SeekerLanguage::create([
                    'seeker_id' => $seeker->id,
                    'name'      => $language['name'] ?? null,
                    'level'     => $language['level'] ?? null,
                ]);
            }
        }

        // reset seeker references 
        $reset_seeker_references = SeekerReference::whereSeekerId($seeker->id)->delete();

        // add seeker references 
        if(isset($request->references)) {
            foreach($request->references as $reference) {
                $reference = SeekerReference::create([
                    'seeker_id' => $seeker->id,
                    'name'      => $reference['name'] ?? null,
                    'position'  => $reference['position'] ?? null,
                    'company'   => $reference['company'] ?? null,
                    'contact'   => $reference['contact'] ?? null,
                ]);
            }
        }

        // reset seeker skills 
        $reset_seeker_skills = SeekerSkill::whereSeekerId($seeker->id)->delete();

        // add seeker skills 
        if(isset($request->skills)) {
            foreach ($request->skills as $skill) {
                $skill = SeekerSkill::create([
                    'seeker_id'               => $seeker->id,
                    'main_functional_area_id' => $skill['main_functional_area_id'] ?? null,
                    'skill_id'                => $skill['skill_id'] ?? null,
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'seeker' => $seeker_info,
            'msg' => 'Sync CV Successfully!'
        ], 200);
    }

    public function getSkillOnly()
    {
        $skills        = Skill::whereNull('deleted_at')->whereIsActive(1)->select('id','name','main_functional_area_id')->get();
        return response()->json([
            'status' => 'success',
            'data'   => $skills,
        ]);
    }
}
