<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;

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
        }])->withCount([ 'JobApply as ShortedList' => function($not_suit) {
            $not_suit->where('status','short-listed');
        }])->withCount([ 'JobApply as Hired' => function($not_suit) {
            $not_suit->where('status','hire');
        }])->paginate(15);
        $inactivejobApplicants = JobPost::whereIn('employer_id', $employer_id)->whereIsActive(0)->where('status','!=', 'Expire')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','recruiter_name as contact_name', 'created_at as posted at')->withCount(['JobApply as Apps'])->withCount([ 'JobApply as NotSuitable' => function($not_suit) {
            $not_suit->where('status','not-suitable');
        }])->withCount([ 'JobApply as ShortedList' => function($not_suit) {
            $not_suit->where('status','short-listed');
        }])->withCount([ 'JobApply as Hired' => function($not_suit) {
            $not_suit->where('status','hire');
        }])->paginate(15);
        $expirejobApplicants = JobPost::whereIn('employer_id', $employer_id)->where('status', 'Expire')->orderBy('updated_at', 'desc')->select('id','job_title','job_post_type','recruiter_name as contact_name', 'created_at as posted at')->withCount(['JobApply as Apps'])->withCount([ 'JobApply as NotSuitable' => function($not_suit) {
            $not_suit->where('status','not-suitable');
        }])->withCount([ 'JobApply as ShortedList' => function($not_suit) {
            $not_suit->where('status','short-listed');
        }])->withCount([ 'JobApply as Hired' => function($not_suit) {
            $not_suit->where('status','hire');
        }])->paginate(15);
        
        return response()->json([
            'status' => 'success',
            'activejobApplicants' => $activejobApplicants,
            'inactivejobApplicants' => $inactivejobApplicants,
            'expirejobApplicants' => $expirejobApplicants,
        ], 200);
    }
}
