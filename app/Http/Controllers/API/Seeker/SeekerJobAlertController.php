<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\JobAlert;
use Illuminate\Support\Facades\Validator;

class SeekerJobAlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $job_alerts           = JobAlert::with(['FunctionalArea:id,name', 'State:id,name'])->whereSeekerId($request->user()->id)->select('id','job_title','job_type','functional_area_id','country','state_id','created_at')->paginate(15);
        return response()->json([
            'status' => 'success',
            'job_alerts' => $job_alerts
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'email' => 'required|email',
            'job_title' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
        
            $job_alert = JobAlert::create([
                'seeker_id' => $request->user()->id,
                'email'     => $request->email,
                'job_title' => $request->job_title,
                'job_type' => $request->job_type,
                'industry_id' => $request->industry_id,
                'career_level' => $request->career_level,
                'functional_area_id' => $request->functional_area_id,
                'experience_level' => $request->experience_level,
                'country' => $request->country,
                'state_id' => $request->state_id
            ]);

            if($job_alert) {
                return response()->json([
                    'status' => 'success',
                    'job_alert' => $job_alert,
                    'msg' => 'Create Job Alert Successfully!'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $job_alert = JobAlert::findOrFail($id);
        
        try {
            $job_alert = JobAlert::findOrFail($id)->delete();
            if ($job_alert) {
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Delete Job Alert Successfully!'
                ]);
            }
            else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Job Alert deleted failed'
                ], 200);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
