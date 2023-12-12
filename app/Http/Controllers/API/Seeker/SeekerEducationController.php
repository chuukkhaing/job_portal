<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\SeekerEducation;
use Illuminate\Support\Facades\Validator;
use App\Models\Seeker\Seeker;
use App\Models\Seeker\SeekerPercentage;

class SeekerEducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $educations           = SeekerEducation::whereSeekerId($request->user()->id)->select('id','seeker_id','degree','major_subject','location','from','to','school','is_current')->get();
        
        return response()->json([
            'status' => 'success',
            'educations' => $educations
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
            'degree'           => ['required'],
            'school'           => ['required'],
            'major_subject'    => ['required'],
            'location'         => ['required'],
            'school'           => ['required'],
            'from'             => ['numeric','required'],
            'is_current'       => ['required'],
            'to'               => ['numeric','required_if:is_current,0', 'gte:from']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            if($request->is_current == 1) {
                $request->to = null;
            }
            $education_create = SeekerEducation::create([
                'seeker_id'     => $request->user()->id,
                'degree'        => $request->degree,
                'major_subject' => $request->major_subject,
                'location'      => $request->location,
                'from'          => $request->from,
                'to'            => $request->to,
                'school'        => $request->school,
                'is_current'    => $request->is_current ?? 0
            ]);

            $seeker            = Seeker::findOrFail($request->user()->id);
            $seeker_educations = SeekerEducation::whereSeekerId($request->user()->id)->get();
            if ($seeker_educations->count() > 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($request->user()->id)->whereTitle('Education')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 10,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($request->user()->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }

            $education           = SeekerEducation::whereSeekerId($request->user()->id)->select('id','seeker_id','degree','major_subject','location','from','to','school','is_current')->findOrFail($education_create->id);

            return response()->json([
                'status'    => 'success',
                'education' => $education,
                'msg'       => 'Education Create successfully!',
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
        $validator =  Validator::make($request->all(), [
            'degree'           => ['required'],
            'school'           => ['required'],
            'major_subject'    => ['required'],
            'location'         => ['required'],
            'school'           => ['required'],
            'from'             => ['numeric','required'],
            'is_current'       => ['required'],
            'to'               => ['numeric','required_if:is_current,0', 'gte:from']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            if($request->is_current == 1) {
                $request->to = null;
            }
            $education = SeekerEducation::findOrFail($id);
            $education_update = $education->update([
                'degree'        => $request->degree,
                'major_subject' => $request->major_subject,
                'location'      => $request->location,
                'from'          => $request->from,
                'to'            => $request->to,
                'school'        => $request->school,
                'is_current'    => $request->is_current ?? 0
            ]);

            $education           = SeekerEducation::whereSeekerId($request->user()->id)->select('id','seeker_id','degree','major_subject','location','from','to','school','is_current')->findOrFail($id);

            return response()->json([
                'status'    => 'success',
                'education' => $education,
                'msg'       => 'Education Update successfully!',
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
        $education               = SeekerEducation::findOrFail($id)->delete();
        $seeker                  = Seeker::findOrFail($request->user()->id);
        $seeker_educations_count = SeekerEducation::whereSeekerId($request->user()->id)->count();
        if ($seeker_educations_count == 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($request->user()->id)->whereTitle('Education')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 0,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($request->user()->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'                  => 'success',
            'msg'                     => 'Education deleted successfully!',
            'seeker_educations_count' => $seeker_educations_count,
        ]);
    }
}
