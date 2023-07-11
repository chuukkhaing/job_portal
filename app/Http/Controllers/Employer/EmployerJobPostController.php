<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\JobPost;
use Auth;
use Str;

class EmployerJobPostController extends Controller
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
        $gender = Null;
        if($request->male == 'on' && $request->female == 'on') {
            $gender = 'Male/Female';
        }elseif($request->male == 'on' && $request->female == '') {
            $gender = 'Male';
        }elseif($request->male == '' && $request->female == 'on') {
            $gender = 'Female';
        }
        $salary_range = Null;
        if($request->mmk_salary) {
            $salary_range = $request->mmk_salary;
        }else {
            $salary_range = $request->usd_salary;
        }
        
        $jobPost = JobPost::create([
            'employer_id' => Auth::guard('employer')->user()->id,
            'job_title' => $request->job_title,
            'main_functional_area_id' => $request->main_functional_area_id,
            'sub_functional_area_id' => $request->sub_functional_area_id,
            'industry_id' => $request->job_post_industry_id,
            'career_level' => $request->career_level,
            'job_type' => $request->job_type,
            'experience_level' => $request->experience_level,
            'degree' => $request->degree,
            'gender' => $gender,
            'currency' => $request->currency,
            'salary_range' => $salary_range,
            'salary_status' => $request->salary_status,
            'country' => $request->job_post_country,
            'state_id' => $request->job_post_state_id,
            'township_id' => $request->job_post_township_id,
            'job_description' => $request->job_description,
            'benefit' => $request->benefit,
            'job_higlight' => $request->job_higlight,
            'requirement_and_skill' => $request->requirement_and_skill,
        ]);
        $slug = Str::slug($jobPost->job_title, '-') . '-' . $jobPost->id;
        $jobPost->update([
            'slug' => $slug
        ]);
        return redirect()->back()->with('success','Create Job Post Successfully.');
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
