<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;
use App\Models\Seeker\JobApply;
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

        $activejobApplicants = JobPost::whereIn('employer_id', $employer_id)->whereIsActive(1)->where('status','!=', 'Expire')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','recruiter_name as contact_name', 'created_at as posted at')->withCount(['JobApply as Apps'])->withCount([ 'JobApply as NotSuitable' => function($not_suit) {
            $not_suit->where('status','not-suitable');
        }])->withCount([ 'JobApply as ShortedList' => function($short_list) {
            $short_list->where('status','short-listed');
        }])->withCount([ 'JobApply as Hired' => function($hire) {
            $hire->where('status','hire');
        }])->paginate(15);
        $inactivejobApplicants = JobPost::whereIn('employer_id', $employer_id)->whereIsActive(0)->where('status','!=', 'Expire')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','recruiter_name as contact_name', 'created_at as posted at')->withCount(['JobApply as Apps'])->withCount([ 'JobApply as NotSuitable' => function($not_suit) {
            $not_suit->where('status','not-suitable');
        }])->withCount([ 'JobApply as ShortedList' => function($short_list) {
            $short_list->where('status','short-listed');
        }])->withCount([ 'JobApply as Hired' => function($hire) {
            $hire->where('status','hire');
        }])->paginate(15);
        $expirejobApplicants = JobPost::whereIn('employer_id', $employer_id)->where('status', 'Expire')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','recruiter_name as contact_name', 'created_at as posted at')->withCount(['JobApply as Apps'])->withCount([ 'JobApply as NotSuitable' => function($not_suit) {
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
        $jobApply = JobApply::with(['Seeker:id,first_name,last_name,email,state_id,township_id,address_detail,nationality,nrc,id_card,date_of_birth,gender,marital_status,image,phone,preferred_salary,is_immediate_available,summary', 'SeekerJobPostAnswer'])->whereJobPostId($id)->whereStatus($status)->select('seeker_id', DB::raw('COUNT(job_applies.status) as application_count'))->get();
        return $jobApply;
    }
}
