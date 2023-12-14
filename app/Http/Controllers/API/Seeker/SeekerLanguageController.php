<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\SeekerLanguage;
use Illuminate\Support\Facades\Validator;
use App\Models\Seeker\Seeker;
use App\Models\Seeker\SeekerPercentage;

class SeekerLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $languages            = SeekerLanguage::whereSeekerId($request->user()->id)->select('id','name','level')->get();
        return response()->json([
            'status' => 'success',
            'languages'   => $languages,
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
            'name'           => ['required'],
            'level'          => ['required']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            $language = SeekerLanguage::create([
                'seeker_id' => $request->user()->id,
                'name'      => $request->name,
                'level'     => $request->level,
            ]);
            $seeker           = Seeker::findOrFail($request->user()->id);
            $seeker_languages = SeekerLanguage::whereSeekerId($seeker->id)->get();
            if ($seeker_languages->count() > 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Language')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 5,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }
    
            return response()->json([
                'status'   => 'success',
                'language' => $language,
                'msg'      => 'Language Create successfully!',
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
            'name'           => ['required'],
            'level'          => ['required']
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        }else {
            $language        = SeekerLanguage::findOrFail($id);
            $language_update = $language->update([
                'name'      => $request->name,
                'level'     => $request->level,
            ]);
            $language        = SeekerLanguage::findOrFail($id);
            return response()->json([
                'status'   => 'success',
                'language' => $language,
                'msg'      => 'Language Update successfully!',
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
            $language               = SeekerLanguage::findOrFail($id)->delete();
            $seeker                 = Seeker::findOrFail($request->user()->id);
            $seeker_languages_count = SeekerLanguage::whereSeekerId($seeker->id)->count();
            if ($seeker_languages_count == 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Language')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 0,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }

            return response()->json([
                'status'                 => 'success',
                'msg'                    => 'language deleted successfully!',
                'seeker_languages_count' => $seeker_languages_count,
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
