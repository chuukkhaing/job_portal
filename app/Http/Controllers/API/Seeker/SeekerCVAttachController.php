<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\SeekerAttach;
use App\Models\Seeker\Seeker;
use App\Models\Seeker\SeekerPercentage;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;
use Storage;

class SeekerCVAttachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cvs                  = SeekerAttach::whereSeekerId($request->user()->id)->select('id','name')->get();
        return response()->json([
            'status' => 'success',
            'cvs' => $cvs
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
        if($request->is_ic_cv == 1) {
            $seeker = Seeker::findOrFail($request->user()->id);
            $skill_main_functional_areas = DB::table('seeker_skills as a')
                            ->where('a.seeker_id','=',$seeker->id)
                            ->join('skills as b','a.skill_id','=','b.id')
                            ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                            ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                            ->groupBy('a.main_functional_area_id')
                            ->get();
            view()->share('seeker',$seeker);

            if($request->currentResume == "resume_2") {
                $pdf = PDF::loadView('download.ic_format_resume_2_cv', compact('seeker'));
                $fileName = (date('YmdHi').$seeker->id.'_ic_format_resume_2_cv.pdf');
            }else {
                $pdf = PDF::loadView('download.ic_format_resume_1_cv', compact('seeker'));
                $fileName = (date('YmdHi').$seeker->id.'_ic_format_resume_1_cv.pdf');
            }
            
            $path     = 'seeker/cv/' . $fileName;
            Storage::disk('s3')->put($path, $pdf->output());
            $path = Storage::disk('s3')->url($path);
            
            $attach = seekerAttach::create([
                'seeker_id' => $request->user()->id,
                'name'      => $fileName,
            ]);

            $seeker         = Seeker::findOrFail($request->user()->id);
            $seeker_attachs = seekerAttach::whereSeekerId($seeker->id)->get();
            if ($seeker_attachs->count() > 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Resume Attachment')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 10,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }
    
            return response()->json([
                'status' => 'success',
                'attach' => $attach,
                'msg'    => 'CV Upload successfully!',
            ]);

        }else {
            $validator =  Validator::make($request->all(), [
                'cv_attach'       => ['required']
            ]);
            if ($validator->fails()) {
                return response(['errors'=>$validator->messages()], 422);
            }else {
                $file = $request->file('cv_attach');
                $cv   = date('YmdHi') . $file->getClientOriginalName();
    
                $path     = 'seeker/cv/' . $cv;
                Storage::disk('s3')->put($path, file_get_contents($file));
                $path = Storage::disk('s3')->url($path);
                $attach = seekerAttach::create([
                    'seeker_id' => $request->user()->id,
                    'name'      => $cv,
                ]);
        
                $seeker         = Seeker::findOrFail($request->user()->id);
                $seeker_attachs = seekerAttach::whereSeekerId($seeker->id)->get();
                if ($seeker_attachs->count() > 0) {
                    $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Resume Attachment')->first();
                    $seeker_percent_update = $seeker_percent->update([
                        'percentage' => 10,
                    ]);
                    $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                    $seeker_update = $seeker->update([
                        'percentage' => $total_percent,
                    ]);
                }
        
                return response()->json([
                    'status' => 'success',
                    'attach' => $attach,
                    'msg'    => 'CV Upload successfully!'
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
        try {
            $cv               = SeekerAttach::findOrFail($id);
            Storage::disk('s3')->delete('seeker/cv/' . $cv->name);
            $cv               = SeekerAttach::whereId($id)->delete();
            $seeker           = Seeker::findOrFail($request->user()->id);
            $seeker_cvs_count = SeekerAttach::whereSeekerId($seeker->id)->count();
            if ($seeker_cvs_count == 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Resume Attachment')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 0,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }

            return response()->json([
                'status'           => 'success',
                'msg'              => 'cv deleted successfully!',
                'seeker_cvs_count' => $seeker_cvs_count,
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function cvDownload(Request $request)
    {
        $seeker = Seeker::findOrFail($request->user()->id);
        $skill_main_functional_areas = DB::table('seeker_skills as a')
                        ->where('a.seeker_id','=',$seeker->id)
                        ->join('skills as b','a.skill_id','=','b.id')
                        ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                        ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                        ->groupBy('a.main_functional_area_id')
                        ->get();
        view()->share('seeker',$seeker);
        
        if($request->currentResume == "resume_2") {
            $pdf = PDF::loadView('download.ic_format_resume_2_cv', compact('seeker'));
            return $pdf->download(date('YmdHi').$seeker->id.'_ic_format_resume_2_cv.pdf');
        }else {
            $pdf = PDF::loadView('download.ic_format_resume_1_cv', compact('seeker'));
            return $pdf->download(date('YmdHi').$seeker->id.'_ic_format_resume_1_cv.pdf');
        }
    }

    public function OrgCvDownload(Request $request)
    {
        $seeker = Seeker::findOrFail($request->user()->id);
        $attach = seekerAttach::whereId($request->cv_id)->whereSeekerId($seeker->id)->first();
        
        return Storage::disk('s3')->download('seeker/cv/'. $attach->name);
        
    }
}
