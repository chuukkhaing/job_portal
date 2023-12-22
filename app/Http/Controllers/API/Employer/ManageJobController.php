<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;
use App\Models\Employer\PointRecord;
use App\Models\Employer\JobPostSkill;
use App\Models\Employer\JobPostQuestion;
use Str;

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

    public function changeJobPostStatus(Request $request)
    {
        $this->validate($request, [
            'id'  => ['required'],
            'status' => ['required']
        ]);
        $jobPost_update = JobPost::whereId($request->id)->update([
            'is_active' => $request->status
        ]);
        $jobPost = JobPost::whereId($request->id)->with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name'])->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','main_functional_area_id', 'sub_functional_area_id', 'status','is_active', 'updated_at as date')->first();
        return response()->json([
            'status' => 'success',
            'jobPost' => $jobPost
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'job_title' => 'required|string',
            'industry_id' => 'required',
            'main_functional_area_id' => 'required',
            'sub_functional_area_id' => 'required',
            'career_level' => 'required',
            'job_type' => 'required',
            'experience_level' => 'required',
            'degree' => 'required',
            'no_of_candidate' => 'required',
            'recruiter_name' => 'required',
            'country' => 'required',
            'skills' => 'required',
            'job_description' => 'required',
            'job_requirement' => 'required',
            'job_post_type' => 'required',
            'trending_job_package_item_id' => ['required_if:job_post_type,trending'],
            'trending_job_point' => ['required_if:job_post_type,trending'],
            'feature_job_package_item_id' => ['required_if:job_post_type,feature'],
            'feature_job_point' => ['required_if:job_post_type,feature'],
            'anonymous_posting_package_item_id' => ['required_if:hide_company_name,1'],
            'anonymous_posting_point' => ['required_if:hide_company_name,1'],
            'question_package_item_id' => ['required_with:questions,answer_types'],
            'question_point' => ['required_with:questions,answer_types'],
            'state_id' => ['required_if:country,Myanmar'],
            'total_point' => ['required'],
            'status' => ['required']
        ]);

        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }

        if($request->total_point && $request->total_point > $employer->package_point) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Your Balance Points are not enough to Post Job.'
            ], 200);
        }else {
            $gender = $request->gender;

            $salary_range = $request->salary_range;
            
            $hide_salary = $request->hide_salary;

            $hide_company = $request->hide_company_name;
            
            $jobPost = JobPost::create([
                'employer_id' => $request->user()->id,
                'job_title' => $request->job_title,
                'main_functional_area_id' => $request->main_functional_area_id,
                'sub_functional_area_id' => $request->sub_functional_area_id,
                'industry_id' => $request->industry_id,
                'career_level' => $request->career_level,
                'job_type' => $request->job_type,
                'experience_level' => $request->experience_level,
                'degree' => $request->degree,
                'gender' => $gender,
                'currency' => $request->currency,
                'salary_range' => $salary_range,
                'hide_salary' => $hide_salary ?? 0,
                'hide_company' => $hide_company ?? 0,
                'no_of_candidate' => $request->no_of_candidate,
                'recruiter_name' => $request->recruiter_name,
                'recruiter_email' => $request->recruiter_email,
                'country' => $request->country,
                'state_id' => $request->state_id,
                'township_id' => $request->township_id,
                'job_description' => $request->job_description,
                'job_requirement' => $request->job_requirement,
                'benefit' => $request->benefit,
                'job_highlight' => $request->highlight,
                'job_post_type' => $request->job_post_type,
                'status' => $request->status,
                'total_point' => $request->total_point
            ]);
            $slug = Str::slug($jobPost->job_title, '-') . '-' . $jobPost->id;
            $jobPost_slug = $jobPost->update([
                'slug' => $slug
            ]);
            if($request->job_post_type == "trending") {
                $trending_record = PointRecord::create([
                    'employer_id' => $request->user()->id,
                    'job_post_id' => $jobPost->id,
                    'package_item_id' => $request->trending_job_package_item_id,
                    'point' => $request->trending_job_point,
                    'status' => 'Pending'
                ]);
            }elseif($request->job_post_type == "feature") {
                $feature_record = PointRecord::create([
                    'employer_id' => $request->user()->id,
                    'job_post_id' => $jobPost->id,
                    'package_item_id' => $request->feature_job_package_item_id,
                    'point' => $request->feature_job_point,
                    'status' => 'Pending'
                ]);
            }
            if($hide_company == 1) {
                $anonymous_record = PointRecord::create([
                    'employer_id' => $request->user()->id,
                    'job_post_id' => $jobPost->id,
                    'package_item_id' => $request->anonymous_posting_package_item_id,
                    'point' => $request->anonymous_posting_point,
                    'status' => 'Pending'
                ]);
            }
            if($request->questions) {
                $question_record = PointRecord::create([
                    'employer_id' => $request->user()->id,
                    'job_post_id' => $jobPost->id,
                    'package_item_id' => $request->question_package_item_id,
                    'point' => $request->question_point,
                    'status' => 'Pending'
                ]);
                foreach($request->questions as $key => $question) {
                    foreach($request->answer_types as $answer_key => $answer_type) {
                        if($key == $answer_key) {
                            $question_create = JobPostQuestion::create([
                                'employer_id' => $request->user()->id,
                                'job_post_id' => $jobPost->id,
                                'question' => $question,
                                'answer' => $answer_type
                            ]);
                        }
                    }
                }
            }
            if($request->skills) {
                foreach($request->skills as $key => $skill) {
                    $skill_create = JobPostSkill::create([
                        'employer_id' => $request->user()->id,
                        'job_post_id' => $jobPost->id,
                        'skill_id' => $skill,
                    ]);
                }
            }

            if($jobPost->job_post_type == 'standard') {
                $jobpostType = "Standard";
            }elseif($jobPost->job_post_type == 'trending') {
                $jobpostType = "Trending";
            }elseif($jobPost->job_post_type == 'feature') {
                $jobpostType = "Feature";
            }
            return response()->json([
                'status' => 'success',
                'msg' => 'Your '.$jobpostType. ' Job Post has been created successfully.',
                'job_post' => $jobPost
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'job_title' => 'required|string',
            'industry_id' => 'required',
            'main_functional_area_id' => 'required',
            'sub_functional_area_id' => 'required',
            'career_level' => 'required',
            'job_type' => 'required',
            'experience_level' => 'required',
            'degree' => 'required',
            'no_of_candidate' => 'required',
            'recruiter_name' => 'required',
            'country' => 'required',
            'skills' => 'required',
            'job_description' => 'required',
            'job_requirement' => 'required',
            'job_post_type' => 'required',
            'trending_job_package_item_id' => ['required_if:job_post_type,trending'],
            'trending_job_point' => ['required_if:job_post_type,trending'],
            'feature_job_package_item_id' => ['required_if:job_post_type,feature'],
            'feature_job_point' => ['required_if:job_post_type,feature'],
            'anonymous_posting_package_item_id' => ['required_if:hide_company_name,1'],
            'anonymous_posting_point' => ['required_if:hide_company_name,1'],
            'question_package_item_id' => ['required_with:questions,answer_types'],
            'question_point' => ['required_with:questions,answer_types'],
            'state_id' => ['required_if:country,Myanmar'],
            'total_point' => ['required'],
            'status' => ['required']
        ]);
        if($request->total_point && $request->total_point > $request->user()->package_point) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Your Balance Points are not enough to Post Job.'
            ], 200);
        }else {
            $jobPost = JobPost::findOrFail($id);
            $gender = $request->gender ?? $jobPost->gender;

            $salary_range = $request->salary_range ?? $jobPost->salary_range;
            
            $hide_salary = $request->hide_salary ?? $jobPost->hide_salary;

            $hide_company = $request->hide_company_name ?? $jobPost->hide_company;
            $jobPost_update = $jobPost->update([
                'employer_id' => $request->user()->id,
                'job_title' => $request->job_title,
                'main_functional_area_id' => $request->main_functional_area_id,
                'sub_functional_area_id' => $request->sub_functional_area_id,
                'industry_id' => $request->industry_id,
                'career_level' => $request->career_level,
                'job_type' => $request->job_type,
                'experience_level' => $request->experience_level,
                'degree' => $request->degree,
                'gender' => $gender,
                'currency' => $request->currency,
                'salary_range' => $salary_range,
                'hide_salary' => $hide_salary ?? 0,
                'hide_company' => $hide_company ?? 0,
                'no_of_candidate' => $request->no_of_candidate,
                'recruiter_name' => $request->recruiter_name,
                'recruiter_email' => $request->recruiter_email,
                'country' => $request->country,
                'state_id' => $request->state_id,
                'township_id' => $request->township_id,
                'job_description' => $request->job_description,
                'job_requirement' => $request->job_requirement,
                'benefit' => $request->benefit,
                'job_highlight' => $request->highlight,
                'job_post_type' => $request->job_post_type,
                'status' => $request->status,
                'total_point' => $request->total_point
            ]);
            $slug = Str::slug($jobPost->job_title, '-') . '-' . $jobPost->id;
            $jobPost_slug = $jobPost->update([
                'slug' => $slug
            ]);
            if($request->job_post_type == "trending") {
                $trending_record_history = PointRecord::whereJobPostId($jobPost->id)->whereEmployerId($jobPost->employer_id)->wherePackageItemId($request->trending_job_package_item_id)->get();
                if($trending_record_history->count() == 0) {
                    $trending_record = PointRecord::create([
                        'employer_id' => $request->user()->id,
                        'job_post_id' => $jobPost->id,
                        'package_item_id' => $request->trending_job_package_item_id,
                        'point' => $request->trending_job_point,
                        'status' => 'Pending'
                    ]);
                }
            }elseif($request->job_post_type == "feature") {
                $feature_record_history = PointRecord::whereJobPostId($jobPost->id)->whereEmployerId($jobPost->employer_id)->wherePackageItemId($request->feature_job_package_item_id)->get();
                if($feature_record_history->count() == 0) {
                    $feature_record = PointRecord::create([
                        'employer_id' => $request->user()->id,
                        'job_post_id' => $jobPost->id,
                        'package_item_id' => $request->feature_job_package_item_id,
                        'point' => $request->feature_job_point,
                        'status' => 'Pending'
                    ]);
                }
            }
            if($hide_company == 1) {
                $anonymous_record_history = PointRecord::whereJobPostId($jobPost->id)->whereEmployerId($jobPost->employer_id)->wherePackageItemId($request->anonymous_posting_package_item_id)->get();
                if($anonymous_record_history->count() == 0) {
                    $anonymous_record = PointRecord::create([
                        'employer_id' => $request->user()->id,
                        'job_post_id' => $jobPost->id,
                        'package_item_id' => $request->anonymous_posting_package_item_id,
                        'point' => $request->anonymous_posting_point,
                        'status' => 'Pending'
                    ]);
                }
            }
            if($request->questions) {
                $question_record_history = PointRecord::whereJobPostId($jobPost->id)->whereEmployerId($jobPost->employer_id)->wherePackageItemId($request->question_package_item_id)->get();
                if($question_record_history->count() == 0) {
                    $question_record = PointRecord::create([
                        'employer_id' => $request->user()->id,
                        'job_post_id' => $jobPost->id,
                        'package_item_id' => $request->question_package_item_id,
                        'point' => $request->question_point,
                        'status' => 'Pending'
                    ]);
                }
                $delete_question = JobPostQuestion::whereJobPostId($jobPost->id)->delete();
                foreach($request->questions as $key => $question) {
                    foreach($request->answer_types as $answer_key => $answer_type) {
                        if($key == $answer_key) {
                            $question_create = JobPostQuestion::create([
                                'employer_id' => $request->user()->id,
                                'job_post_id' => $jobPost->id,
                                'question' => $question,
                                'answer' => $answer_type
                            ]);
                        }
                    }
                }
            }
            if($request->skills) {
                $delete_skill = JobPostSkill::whereJobPostId($jobPost->id)->delete();
                foreach($request->skills as $key => $skill) {
                    $skill_create = JobPostSkill::create([
                        'employer_id' => $request->user()->id,
                        'job_post_id' => $jobPost->id,
                        'skill_id' => $skill,
                    ]);
                }
            }
        }
        if($jobPost->job_post_type == 'standard') {
            $jobpostType = "Standard";
        }elseif($jobPost->job_post_type == 'trending') {
            $jobpostType = "Trending";
        }elseif($jobPost->job_post_type == 'feature') {
            $jobpostType = "Feature";
        }
        return response()->json([
            'status' => 'success',
            'msg' => 'Your '.$jobpostType.' Job Post has been updated Successfully.',
            'job_post' => $jobPost
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $jobPost = JobPost::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name', 'State:id,name', 'Township:id,name', 'JobPostSkill' => function ($jp_skill) {
            $jp_skill->with('skill:id,name')->select('id','skill_id','job_post_id');
        }, 'JobPostQuestion:id,question,answer'])->whereId($id)->select('id','job_title','main_functional_area_id','sub_functional_area_id','industry_id','career_level','job_type','experience_level','degree','gender','currency','salary_range','country','state_id','township_id','job_description','job_requirement','benefit','job_highlight','hide_salary','hide_company','no_of_candidate','recruiter_name','recruiter_email','job_post_type')->first();
        return response()->json([
            'status' => 'success',
            'jobPost' => $jobPost
        ], 200);
    }
}
