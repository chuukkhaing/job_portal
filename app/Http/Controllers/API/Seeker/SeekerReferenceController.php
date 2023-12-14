<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\SeekerReference;
use Illuminate\Support\Facades\Validator;
use App\Models\Seeker\Seeker;
use App\Models\Seeker\SeekerPercentage;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;

class SeekerReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $references = SeekerReference::whereSeekerId($request->user()->id)->select('id','name','position','company','contact')->get();
        return response()->json([
            'status' => 'success',
            'references'   => $references,
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
            'name'              => ['required'],
            'position'          => ['required'],
            'company'           => ['required'],
            'contact'           => ['required', new MyanmarPhone]
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            $reference = SeekerReference::create([
                'seeker_id' => $request->user()->id,
                'name'      => $request->name,
                'position'  => $request->position,
                'company'   => $request->company,
                'contact'   => $request->contact,
            ]);
            $seeker            = Seeker::findOrFail($request->user()->id);
            $seeker_references = SeekerReference::whereSeekerId($seeker->id)->get();
            if ($seeker_references->count() > 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Reference')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 5,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }
    
            return response()->json([
                'status'    => 'success',
                'reference' => $reference,
                'msg'       => 'Reference Create successfully!',
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
            'name'              => ['required'],
            'position'          => ['required'],
            'company'           => ['required'],
            'contact'           => ['required', new MyanmarPhone]
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            $reference        = SeekerReference::findOrFail($id);
            $reference_update = $reference->update([
                'name'      => $request->name,
                'position'  => $request->position,
                'company'   => $request->company,
                'contact'   => $request->contact,
            ]);
            $reference        = SeekerReference::findOrFail($id);
            return response()->json([
                'status'    => 'success',
                'reference' => $reference,
                'msg'       => 'Reference Update successfully!',
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
        try { 
            $reference               = SeekerReference::findOrFail($id)->delete();
            $seeker                  = Seeker::findOrFail($request->user()->id);
            $seeker_references_count = SeekerReference::whereSeekerId($seeker->id)->count();
            if ($seeker_references_count == 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Reference')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 0,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }

            return response()->json([
                'status'                  => 'success',
                'msg'                     => 'reference deleted successfully!',
                'seeker_references_count' => $seeker_references_count,
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
