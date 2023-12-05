<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\FunctionalArea;
use Alert;
use Auth;

class SubFunctionalAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:sub-functional-area-list|sub-functional-area-create|sub-functional-area-edit|sub-functional-area-delete', ['only' => ['index','store']]);
        $this->middleware('permission:sub-functional-area-create', ['only' => ['create','store']]);
        $this->middleware('permission:sub-functional-area-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sub-functional-area-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id','!=',0)->get();
        return view ('admin.sub-functional-area.index', compact('functional_areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        return view ('admin.sub-functional-area.create', compact('functional_areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $functional_area = FunctionalArea::create([
            'name' => $request->name,
            'functional_area_id' => $request->functional_area_id,
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'New Sub Functional Area Created Successfully!');
        return redirect()->route('sub-functional-area.index');
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
        $functional_area = FunctionalArea::findOrFail($id);
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        return view ('admin.sub-functional-area.edit', compact('functional_area', 'functional_areas'));
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
        $functional_area = FunctionalArea::findOrFail($id);
        $functional_area = $functional_area->update([
            'name' => $request->name,
            'functional_area_id' => $request->functional_area_id,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Sub Functional Area Updated Successfully!');
        return redirect()->route('sub-functional-area.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $functional_area = FunctionalArea::findOrFail($id);
        
        try {
            $functional_area = FunctionalArea::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($functional_area) {
                Alert::success('Success', 'Delete Sub Functional Area Successfully!');
                return redirect()->route('sub-functional-area.index');
            }
            else {
                Alert::error('Failed', 'Sub Functional Area deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Sub Functional Area');
                return redirect()->back();
            } 
        }
    }
}
