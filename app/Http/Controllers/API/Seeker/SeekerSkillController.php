<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\SeekerSkill;
use App\Models\Admin\Skill;

class SeekerSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $seeker_skills = SeekerSkill::whereSeekerId($request->user()->id)->pluck('skill_id')->toArray();
        $skills        = Skill::whereNull('deleted_at')->whereIn('id', $seeker_skills)->select('id','name')->whereIsActive(1)->get();
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
        $skill_functions = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $skill_names     = Skill::whereNull('deleted_at')->whereIsActive(1)->get();
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
            'skill_functions' => $skill_functions,
            'skill_names'     => $skill_names,
            'msg'             => 'Skill Create successfully!',
        ]);
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
