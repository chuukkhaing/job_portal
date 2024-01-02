<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;
use App\Models\Seeker\JobApply;
use App\Models\Employer\PointRecord;
use DB;

class ApplicantTrackingController extends Controller
{
    public function index(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        
        $member_ids = $employer->Member->pluck('id')->toArray();
        $employer_id = [];
        foreach($member_ids as $member_id) {
            $employer_id[] = $member_id;
        }
        
        $employer_id[] = $employer->id;
        $employer_id[] = $employer->employer_id;

        $activejobApplicants = JobPost::whereIn('employer_id', $employer_id)->whereIsActive(1)->where('status','!=', 'Expire')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','recruiter_name as contact_name', 'created_at as posted_at', 'slug')->withCount(['JobApply as Apps'])->withCount([ 'JobApply as NotSuitable' => function($not_suit) {
            $not_suit->where('status','not-suitable');
        }])->withCount([ 'JobApply as ShortedList' => function($short_list) {
            $short_list->where('status','short-listed');
        }])->withCount([ 'JobApply as Hired' => function($hire) {
            $hire->where('status','hire');
        }])->paginate(15);
        $inactivejobApplicants = JobPost::whereIn('employer_id', $employer_id)->whereIsActive(0)->where('status','!=', 'Expire')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','recruiter_name as contact_name', 'created_at as posted_at', 'slug')->withCount(['JobApply as Apps'])->withCount([ 'JobApply as NotSuitable' => function($not_suit) {
            $not_suit->where('status','not-suitable');
        }])->withCount([ 'JobApply as ShortedList' => function($short_list) {
            $short_list->where('status','short-listed');
        }])->withCount([ 'JobApply as Hired' => function($hire) {
            $hire->where('status','hire');
        }])->paginate(15);
        $expirejobApplicants = JobPost::whereIn('employer_id', $employer_id)->where('status', 'Expire')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','recruiter_name as contact_name', 'created_at as posted_at', 'slug')->withCount(['JobApply as Apps'])->withCount([ 'JobApply as NotSuitable' => function($not_suit) {
            $not_suit->where('status','not-suitable');
        }])->withCount([ 'JobApply as ShortedList' => function($shot_list) {
            $shot_list->where('status','short-listed');
        }])->withCount([ 'JobApply as Hired' => function($hire) {
            $hire->where('status','hire');
        }])->paginate(15);
        
        return response()->json([
            'status' => 'success',
            'activejobApplicants' => $activejobApplicants,
            'inactivejobApplicants' => $inactivejobApplicants,
            'expirejobApplicants' => $expirejobApplicants,
        ], 200);
    }

    public function getApplicant($id, $status)
    {
        $applications = JobApply::with(['Seeker'=> function($state) {
                        $state->with(['State:id,name', 'Township:id,name', 'SeekerEducation:id,seeker_id,degree,major_subject,location,from,to,school,is_current','SeekerExperience' => function($exp) {
                            $exp->with('MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name')->select('id','seeker_id','job_title','company','main_functional_area_id','sub_functional_area_id','career_level','job_responsibility','industry_id','country','is_current_job','is_experience','start_date','end_date');
                        },'SeekerSkill' => function($skill) {
                            $skill->with('Skill:id,name')->select('id','seeker_id','skill_id');
                        },'SeekerLanguage:id,seeker_id,name,level', 'SeekerReference:id,seeker_id,name,position,company,contact', 'SeekerAttach:id,name,seeker_id'])->select('id','first_name','last_name','email','state_id','township_id','address_detail','nationality','nrc','id_card','date_of_birth','gender','marital_status','image','phone','preferred_salary','is_immediate_available','summary');
                    }, 'SeekerJobPostAnswer' => function($qanda) {
                        $qanda->with(['JobPostQuestion:id,question,answer as answer_type'])->select('id','job_post_question_id','job_apply_id','answer');
                    }])->whereJobPostId($id)->whereStatus($status)->select('id','seeker_id','job_post_id','status')->get();
        $application_count = $applications->count();
        return response()->json([
            'status' => 'success',
            'application_count' => $application_count,
            'applications' => $applications
        ], 200);
    }

    public function getApplicantInfo($job_post_id, $seeker_id, $status)
    {
        $application = JobApply::with(['Seeker'=> function($state) {
                    $state->with(['State:id,name', 'Township:id,name', 'SeekerEducation:id,seeker_id,degree,major_subject,location,from,to,school,is_current','SeekerExperience' => function($exp) {
                        $exp->with('MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name')->select('id','seeker_id','job_title','company','main_functional_area_id','sub_functional_area_id','career_level','job_responsibility','industry_id','country','is_current_job','is_experience','start_date','end_date');
                    },'SeekerSkill' => function($skill) {
                        $skill->with('Skill:id,name')->select('id','seeker_id','skill_id');
                    },'SeekerLanguage:id,seeker_id,name,level', 'SeekerReference:id,seeker_id,name,position,company,contact', 'SeekerAttach:id,name,seeker_id'])->select('id','first_name','last_name','email','state_id','township_id','address_detail','nationality','nrc','id_card','date_of_birth','gender','marital_status','image','phone','preferred_salary','is_immediate_available','summary');
                }, 'SeekerJobPostAnswer' => function($qanda) {
                    $qanda->with(['JobPostQuestion:id,question,answer as answer_type'])->select('id','job_post_question_id','job_apply_id','answer');
                }])->whereJobPostId($job_post_id)->whereSeekerId($seeker_id)->whereStatus($status)->select('id','seeker_id','job_post_id','status')->first();
        
        return response()->json([
        'status' => 'success',
        'application' => $application
        ], 200);
    }

    public function changeStatus(Request $request)
    {
        $job_apply = JobApply::whereId($request->job_apply_id)->whereJobPostId($request->job_post_id)->whereSeekerId($request->seeker_id)->update([
            'status' => $request->status
        ]);
        $change_status_application = JobApply::findOrFail($request->job_apply_id);
        return response()->json([
            'status' => 'success',
            'change_status_application' => $change_status_application
        ], 200);
    }

    public function unlockApplication(Request $request)
    {
        $point = 0;
        $item_id = Null;
        $employer = Employer::findOrFail($request->user()->id);
        if(isset($employer->employer_id)) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $packageItems = $employer->Package->PackageWithPackageItem;
        foreach($packageItems as $packageItem){
            if($packageItem->PackageItem->name == 'Application Unlock') {
                $point = $packageItem->PackageItem->point;
                $item_id = $packageItem->PackageItem->id;
            }
        }
        if($point > 0 && $point > $employer->package_point) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Your Balance Points are not enough to Post Job.'
            ], 200);
        }else {
            $cvunlock = PointRecord::whereEmployerId($request->user()->id)->whereJobPostId($request->job_post_id)->whereJobApplyId($request->job_apply_id)->wherePackageItemId($item_id)->get();
            if($cvunlock->count() == 0) {
                $cvunlock = PointRecord::create([
                    'employer_id' => $request->user()->id,
                    'job_post_id' => $request->job_post_id,
                    'job_apply_id' => $request->job_apply_id,
                    'package_item_id' => $item_id,
                    'point' => $point,
                    'status' => 'Complete'
                ]);
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $cvunlock
            ]);
        }
    }
}
