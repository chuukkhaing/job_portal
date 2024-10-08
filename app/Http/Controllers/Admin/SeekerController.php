<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;
use DB;
use PDF;
use Auth;
use Alert;

class SeekerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:seeker-list|seeker-create|seeker-edit|seeker-delete', ['only' => ['index','store']]);
        $this->middleware('permission:seeker-create', ['only' => ['create','store']]);
        $this->middleware('permission:seeker-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:seeker-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $seekers = Seeker::whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        if($request->has('is_active')) {
            $seekers = Seeker::whereNull('deleted_at')->where('is_active', $request->is_active)->orderBy('created_at', 'desc')->get();
        }
        return view('admin.seeker.index', compact('seekers'));
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
        $seeker = Seeker::findOrFail($id);
        return view('admin.seeker.show', compact('seeker'));
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
        $seeker = Seeker::findOrFail($id);
        
        try {
            $seeker = Seeker::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($seeker) {
                Alert::success('Success', 'Delete Seeker Successfully!');
                return redirect()->route('seeker.index');
            }
            else {
                Alert::error('Failed', 'Seeker deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Seeker');
                return redirect()->back();
            } 
        }
    }

    public function icFormatCVDownload($id, Request $request)
    {
        $seeker = Seeker::findOrFail($id);
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
}
