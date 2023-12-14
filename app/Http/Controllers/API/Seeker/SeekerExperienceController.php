<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\SeekerExperience;
use App\Models\Seeker\Seeker;
use App\Models\Seeker\SeekerPercentage;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;
use Illuminate\Support\Facades\Validator;

class SeekerExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $experiences = SeekerExperience::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name'])->whereSeekerId($request->user()->id)->select('id','job_title','company','main_functional_area_id','sub_functional_area_id','career_level','job_responsibility','industry_id','country','start_date','end_date','is_current_job','is_experience')->get();
        return response()->json([
            'status' => 'success',
            'experiences' => $experiences
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
            'is_experience'           => ['required'],
        ]);
        if($request->is_experience == 1) {
            $validator =  Validator::make($request->all(), [
                'is_experience'           => ['required'],
                'job_title'               => ['required'],
                'company'                 => ['required'],
                'main_functional_area_id' => ['required'],
                'sub_functional_area_id'  => ['required'],
                'career_level'            => ['required'],
                'industry_id'             => ['required'],
                'start_date'              => ['date','required'],
                'is_current_job'          => ['required'],
                'country'                 => ['required'],
                'job_responsibility'      => ['required'],
                'end_date'                => ['date','after_or_equal:start_date', 'required_if:is_current_job,0']
            ]);
        }
        
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            if($request->is_current_job == 1) {
                $request->end_date = Null;
            }
            if ($request->is_experience == 0) {
                $exp = SeekerExperience::whereSeekerId($request->user()->id)->delete();
            }
            $no_exp = SeekerExperience::whereSeekerId($request->user()->id)->whereIsExperience(0)->count();
            if($no_exp > 0) {
                return response()->json([
                    'status'            => 'error',
                    'msg'               => 'Experience Cannot Create!',
                ], 500);
            }else {
                $experience_create = SeekerExperience::create([
                    'seeker_id'               => $request->user()->id,
                    'job_title'               => $request->job_title,
                    'company'                 => $request->company,
                    'main_functional_area_id' => $request->main_functional_area_id,
                    'sub_functional_area_id'  => $request->sub_functional_area_id,
                    'career_level'            => $request->career_level,
                    'industry_id'             => $request->industry_id,
                    'start_date'              => date('Y-m-d', strtotime($request->start_date)),
                    'end_date'                => $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : null,
                    'is_experience'           => $request->is_experience,
                    'is_current_job'          => $request->is_current_job ?? 0,
                    'country'                 => $request->country,
                    'job_responsibility'      => $request->job_responsibility,
                ]);
                $experience = SeekerExperience::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name'])->whereSeekerId($request->user()->id)->select('id','job_title','company','main_functional_area_id','sub_functional_area_id','career_level','job_responsibility','industry_id','country','start_date','end_date','is_current_job','is_experience')->findOrFail($experience_create->id);

                $seeker_exps = SeekerExperience::whereSeekerId($request->user()->id)->get();
                $seeker                  = Seeker::findOrFail($request->user()->id);
                if ($seeker_exps->count() > 0) {
                    $seeker_percent        = SeekerPercentage::whereSeekerId($request->user()->id)->whereTitle('Career History')->first();
                    $seeker_percent_update = $seeker_percent->update([
                        'percentage' => 30,
                    ]);
                    $total_percent = SeekerPercentage::whereSeekerId($request->user()->id)->sum('percentage');
                    $seeker_update = $seeker->update([
                        'percentage' => $total_percent,
                    ]);
                }
                
                return response()->json([
                    'status'            => 'success',
                    'experience'        => $experience,
                    'msg'               => 'Experience Create successfully!',
                ], 200);
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
    public function update($id, Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'is_experience'           => ['required'],
        ]);
        if($request->is_experience == 1) {
            $validator =  Validator::make($request->all(), [
                'is_experience'           => ['required'],
                'job_title'               => ['required'],
                'company'                 => ['required'],
                'main_functional_area_id' => ['required'],
                'sub_functional_area_id'  => ['required'],
                'career_level'            => ['required'],
                'industry_id'             => ['required'],
                'start_date'              => ['date','required'],
                'is_current_job'          => ['required'],
                'country'                 => ['required'],
                'job_responsibility'      => ['required'],
                'end_date'                => ['date','after_or_equal:start_date', 'required_if:is_current_job,0']
            ]);
        }
        
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            if($request->is_current_job == 1) {
                $request->end_date = Null;
            }
            if ($request->is_experience == 0) {
                $exp = SeekerExperience::whereSeekerId($request->user()->id)->delete();
            }
            $experience        = SeekerExperience::findOrFail($id);
            $experience_update = $experience->update([
                'job_title'               => $request->job_title,
                'company'                 => $request->company,
                'main_functional_area_id' => $request->main_functional_area_id,
                'sub_functional_area_id'  => $request->sub_functional_area_id,
                'career_level'            => $request->career_level,
                'industry_id'             => $request->industry_id,
                'start_date'              => date('Y-m-d', strtotime($request->start_date)),
                'end_date'                => $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : null,
                'is_experience'           => $request->is_experience,
                'is_current_job'          => $request->is_current_job,
                'country'                 => $request->country,
                'job_responsibility'      => $request->job_responsibility,
            ]);
            $experience = SeekerExperience::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name'])->whereSeekerId($request->user()->id)->select('id','job_title','company','main_functional_area_id','sub_functional_area_id','career_level','job_responsibility','industry_id','country','start_date','end_date','is_current_job','is_experience')->findOrFail($id);
            return response()->json([
                'status'            => 'success',
                'experience'        => $experience,
                'msg'               => 'Experience Update successfully!',
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        try{
            $experience               = SeekerExperience::findOrFail($id)->delete();
            $seeker                  = Seeker::findOrFail($request->user()->id);
            $seeker_experiences_count = SeekerExperience::whereSeekerId($request->user()->id)->count();
            if ($seeker_experiences_count == 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($request->user()->id)->whereTitle('Career History')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 0,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($request->user()->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }

            return response()->json([
                'status'                   => 'success',
                'msg'                      => 'Experience deleted successfully!',
                'seeker_experiences_count' => $seeker_experiences_count,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
