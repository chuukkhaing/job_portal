<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\SeekerExperience;
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
        $experience = SeekerExperience::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name'])->whereSeekerId($request->user()->id)->select('id','job_title','company','main_functional_area_id','sub_functional_area_id','career_level','job_responsibility','industry_id','country','start_date','end_date','is_current_job','is_experience')->get();
        return response()->json([
            'status' => 'success',
            'experience' => $experience
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
                'end_date'                => ['date','required'],
                'is_current_job'          => ['required'],
                'country'                 => ['required'],
                'job_responsibility'      => ['required']
            ]);

            if ($validator->fails()) {
                return response(['errors'=>$validator->messages()], 422);
            }else {
                if ($request->is_experience == 0) {
                    $exp = SeekerExperience::whereSeekerId($request->user()->id)->delete();
                }
                $experience = SeekerExperience::create([
                    'seeker_id'               => $request->user()->id,
                    'job_title'               => $request->exp_job_title,
                    'company'                 => $request->exp_company,
                    'main_functional_area_id' => $request->exp_main_functional_area_id,
                    'sub_functional_area_id'  => $request->exp_sub_functional_area_id,
                    'career_level'            => $request->exp_career_level,
                    'industry_id'             => $request->exp_industry_id,
                    'start_date'              => date('Y-m-d', strtotime($request->exp_start_date)),
                    'end_date'                => $request->exp_end_date ? date('Y-m-d', strtotime($request->exp_end_date)) : null,
                    'is_experience'           => $request->is_experience,
                    'is_current_job'          => $request->is_current_job,
                    'country'                 => $request->exp_country,
                    'job_responsibility'      => $request->exp_job_responsibility,
                ]);
                $seeker      = Seeker::findOrFail($request->user()->id);
                $seeker_exps = SeekerExperience::whereSeekerId($seeker->id)->get();
                if ($seeker_exps->count() > 0) {
                    $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Career History')->first();
                    $seeker_percent_update = $seeker_percent->update([
                        'percentage' => 30,
                    ]);
                    $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                    $seeker_update = $seeker->update([
                        'percentage' => $total_percent,
                    ]);
                }
                $exp_functions     = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
                $sub_exp_functions = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', '!=', 0)->whereIsActive(1)->get();
                $exp_industries    = Industry::whereNull('deleted_at')->get();
                return response()->json([
                    'status'            => 'success',
                    'experience'        => $experience,
                    'exp_functions'     => $exp_functions,
                    'sub_exp_functions' => $sub_exp_functions,
                    'exp_industries'    => $exp_industries,
                    'msg'               => 'Experience Create successfully!',
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
