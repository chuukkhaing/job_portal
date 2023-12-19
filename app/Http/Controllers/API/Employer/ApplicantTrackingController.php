<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

        $activejobApplicants = JobPost::whereIn('employer_id', $employer_id)->whereIsActive(1)->where('status','!=', 'Expire')->orderBy('updated_at', 'desc')->get();
        $inactivejobApplicants = JobPost::whereIn('employer_id', $employer_id)->whereIsActive(0)->where('status','!=', 'Expire')->orderBy('updated_at', 'desc')->get();
        $expirejobApplicants = JobPost::whereIn('employer_id', $employer_id)->where('status', 'Expire')->orderBy('updated_at', 'desc')->get();
        return view ('employer.profile.applicant-tracking', compact('activejobApplicants', 'inactivejobApplicants', 'expirejobApplicants', 'employer', 'packages', 'packageItems'));
    }
}
