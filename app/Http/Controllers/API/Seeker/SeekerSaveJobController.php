<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\SaveJob;
use Illuminate\Support\Facades\Validator;

class SeekerSaveJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $saveJobs             = SaveJob::with(['JobPost' => function($query) {
            $query->with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Employer' => function ($query) {
                $query->with('Industry:id,name')->with('MainEmployer:id,logo,name,is_verified,slug,industry_id,summary,value,no_of_offices,website,no_of_employees')->select('id', 'logo', 'employer_id', 'name', 'industry_id', 'summary', 'value', 'no_of_offices', 'website', 'no_of_employees', 'slug', 'is_verified');
            }, 'JobPostSkill' => function($skill) {
                $skill->with('Skill:id,name')->select('skill_id', 'job_post_id');
            }])
                    ->select('id', 'employer_id', 'slug', 'job_title', 'main_functional_area_id', 'sub_functional_area_id', 'industry_id', 'career_level', 'job_type', 'experience_level', 'degree', 'gender', 'currency', 'salary_range', 'country', 'state_id', 'township_id', 'job_description', 'job_requirement', 'benefit', 'job_highlight', 'hide_salary', 'hide_company', 'no_of_candidate', 'job_post_type', 'updated_at as posted_at');
        }])->whereSeekerId($request->user()->id)->select('id','job_post_id','created_at as added_at')->orderBy('created_at','desc')->paginate(15);
        return response()->json([
            'status' => 'success',
            'saveJobs' => $saveJobs
        ]);
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
            'job_post_id'           => ['required']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            $find_save_job = SaveJob::whereJobPostId($request->job_post_id)->whereSeekerId($request->user()->id)->get();
            if($find_save_job->count() > 0) {
                $find_save_job = SaveJob::whereJobPostId($request->job_post_id)->whereSeekerId($request->user()->id)->delete();
                $saveJobCount             = SaveJob::whereSeekerId($request->user()->id)->count();
                return response()->json([
                    'status' => 'remove',
                    'msg' => 'Removed Job'
                ]);
            }else {
                SaveJob::create([
                    'seeker_id' => $request->user()->id,
                    'job_post_id' => $request->job_post_id
                ]);
    
                return response()->json([
                    'status' => 'create',
                    'msg' => 'Saved Job'
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
    public function destroy($id)
    {
        //
    }
}
