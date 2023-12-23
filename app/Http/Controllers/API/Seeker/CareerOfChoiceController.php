<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;
use Illuminate\Support\Facades\Validator;
use App\Models\Seeker\SeekerPercentage;

class CareerOfChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $career_of_choice = Seeker::whereId($request->user()->id)->with('MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name')->select('id','job_title','main_functional_area_id', 'sub_functional_area_id', 'job_type', 'career_level', 'preferred_salary', 'industry_id')->first();
        return response()->json([
            'status' => 'success',
            'career_of_choice' => $career_of_choice
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
        $validator =  Validator::make($request->all(), [
            'job_title'                     => ['required'],
            'main_functional_area_id'       => ['required'],
            'sub_functional_area_id'        => ['required'],
            'job_type'                      => ['required'],
            'career_level'                  => ['required'],
            'preferred_salary'              => ['required'],
            'industry_id'                   => ['required']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            $seeker = Seeker::findOrFail($request->user()->id);

            $seeker->update([
                'job_title'               => $request->job_title,
                'main_functional_area_id' => $request->main_functional_area_id,
                'sub_functional_area_id'  => $request->sub_functional_area_id,
                'job_type'                => $request->job_type,
                'career_level'            => $request->career_level,
                'preferred_salary'        => $request->preferred_salary,
                'industry_id'             => $request->industry_id,
            ]);
            $career_of_choice = Seeker::whereId($request->user()->id)->with('MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name')->select('id','job_title','main_functional_area_id', 'sub_functional_area_id', 'job_type', 'career_level', 'preferred_salary', 'industry_id')->first();
            $seeker_percentage = $this->updateSeekerPercentage($career_of_choice);
            return response()->json([
                'status' => 'success',
                'career_of_choice' => $career_of_choice,
                'msg' => 'Career of Choice Update Successfully.'
            ]);
        }
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

    public function updateSeekerPercentage(Seeker $seeker)
    {
        if (isset($seeker->first_name) && isset($seeker->last_name) && (isset($seeker->nrc) || isset($seeker->id_card)) && isset($seeker->date_of_birth) && isset($seeker->phone) && isset($seeker->country) && isset($seeker->nationality)) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Personal Information')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 15,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }
        if (isset($seeker->main_functional_area_id) && isset($seeker->sub_functional_area_id) && isset($seeker->job_title) && isset($seeker->job_type) && isset($seeker->career_level) && isset($seeker->preferred_salary) && isset($seeker->industry_id)) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Career of Choice')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 20,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return true;
    }
}
