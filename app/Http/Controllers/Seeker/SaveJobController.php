<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\JobPost;
use App\Models\Seeker\Seeker;
use App\Models\Seeker\SaveJob;
use Auth;

class SaveJobController extends Controller
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
    public function create($id)
    {
        if(Auth::guard('seeker')->user()->id) {
            
            $find_save_job = SaveJob::whereJobPostId($id)->whereSeekerId(Auth::guard('seeker')->user()->id)->get();
            if($find_save_job->count() > 0) {
                $find_save_job = SaveJob::whereJobPostId($id)->whereSeekerId(Auth::guard('seeker')->user()->id)->delete();
                $saveJobCount             = SaveJob::whereSeekerId(Auth::guard('seeker')->user()->id)->count();
                return response()->json([
                    'status' => 'remove',
                    'msg' => 'Removed Job',
                    'saveJobCount' => $saveJobCount
                ]);
            }else {
                SaveJob::create([
                    'seeker_id' => Auth::guard('seeker')->user()->id,
                    'job_post_id' => $id
                ]);
    
                return response()->json([
                    'status' => 'create',
                    'msg' => 'Saved Job'
                ]);
            }
        }else {
            return response()->json([
                'status' => 'error',
                'msg' => 'Please Log In'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
