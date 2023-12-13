<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\SeekerSkill;
use App\Models\Admin\Skill;
use App\Models\Seeker\SeekerPercentage;
use Illuminate\Support\Facades\Validator;
use App\Models\Seeker\Seeker;

class SeekerSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $skills = SeekerSkill::with('Skill:id,name')->whereSeekerId($request->user()->id)->select('id','skill_id')->get();
        return response()->json([
            'status' => 'success',
            'skills'   => $skills,
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
            'skill_id'                  => ['required'],
            'main_functional_area_id'   => ['required']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            if ($request->skill_id) {
                foreach ($request->skill_id as $skill_id) {
                    $skill = SeekerSkill::create([
                        'seeker_id'               => $request->user()->id,
                        'main_functional_area_id' => $request->main_functional_area_id,
                        'skill_id'                => $skill_id,
                    ]);
                }
            }
            $seeker          = Seeker::findOrFail($request->user()->id);
            $seeker_skills   = SeekerSkill::whereSeekerId($seeker->id)->get();
            
            if ($seeker_skills->count() > 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Skills')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 5,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }
    
            return response()->json([
                'status'          => 'success',
                'skills'          => $seeker_skills,
                'msg'             => 'Skill Create successfully!',
            ], 200);
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
        $skill               = SeekerSkill::findOrFail($id)->delete();
        $seeker              = Seeker::findOrFail($request->user()->id);
        $seeker_skills_count = SeekerSkill::whereSeekerId($seeker->id)->count();
        if ($seeker_skills_count == 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Skills')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 0,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'              => 'success',
            'msg'                 => 'skill deleted successfully!',
            'seeker_skills_count' => $seeker_skills_count,
        ], 200);
    }
}
