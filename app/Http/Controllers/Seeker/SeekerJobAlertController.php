<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\JobAlert;
use Auth;

class SeekerJobAlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request,[
            'job_alert_email' => 'required|email',
            'job_alert_title' => 'required'
        ]);

        if(Auth::guard('seeker')->user()->id) {
            $job_alert = JobAlert::create([
                'seeker_id' => Auth::guard('seeker')->user()->id,
                'email'     => $request->job_alert_email,
                'job_title' => $request->job_alert_title,
                'job_type' => $request->job_alert_job_type,
                'industry_id' => $request->job_alert_industry,
                'career_level' => $request->job_alert_career_level,
                'functional_area_id' => $request->job_alert_functional_area,
                'experience_level' => $request->job_alert_experience_level,
                'country' => $request->job_alert_country,
                'state_id' => $request->job_alert_state
            ]);

            $job_alerts = JobAlert::whereSeekerId(Auth::guard('seeker')->user()->id)->paginate(10);
            if($job_alert) {
                return redirect()->back()->with(compact('job_alerts'), ['success' => 'Create Job Alert Successfully!']);
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
    public function destroy($id)
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
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Job Alert deleted failed'
                ]);
            } 
        }
    }
}
