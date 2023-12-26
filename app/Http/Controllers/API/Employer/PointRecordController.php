<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\PointRecord;
use App\Models\Admin\Employer;

class PointRecordController extends Controller
{
    public function usedPointHistory(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);

        $member_ids = $employer->Member->pluck('id')->toArray();
        $employer_id = [];
        foreach($member_ids as $member_id) {
            $employer_id[] = $member_id;
        }
        
        $employer_id[] = $employer->id;
        $employer_id[] = $employer->employer_id;
        $point_records = PointRecord::with(['JobPost:id,job_title','PackageItem:id,name,point','JobApply' => function($job_apply) {
            $job_apply->with(['Seeker:id,first_name,last_name'])->select('id','seeker_id');
        }])->whereIn('employer_id', $employer_id)->whereStatus('Complete')->orderBy('created_at','desc')->select('id','job_post_id','job_apply_id','package_item_id','point','created_at as date')->get();
        return response()->json([
            'status' => 'success',
            'point_records' => $point_records
        ], 200);
    }
}
