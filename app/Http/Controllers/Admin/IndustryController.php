<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Industry;
use Alert;
use Auth;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:industry-list|industry-create|industry-edit|industry-delete', ['only' => ['index','store']]);
        $this->middleware('permission:industry-create', ['only' => ['create','store']]);
        $this->middleware('permission:industry-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:industry-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $industries = Industry::whereNull('deleted_at')->get();
        return view ('admin.industry.index', compact('industries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.industry.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required'
        ]);
        $industry = Industry::create([
            'name' => $request->name,
            'icon' => $request->icon,
            'color_code' => $request->color_code,
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'New Industry Created Successfully!');
        return redirect()->route('industry.index');
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
        $industry = Industry::findOrFail($id);
        return view ('admin.industry.edit', compact('industry'));
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
        $industry = Industry::findOrFail($id);
        $industry = $industry->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'color_code' => $request->color_code,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Industry Updated Successfully!');
        return redirect()->route('industry.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $industry = Industry::findOrFail($id);
        
        try {
            $industry = Industry::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($industry) {
                Alert::success('Success', 'Delete Industry Successfully!');
                return redirect()->route('industry.index');
            }
            else {
                Alert::error('Failed', 'Industry deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Industry');
                return redirect()->back();
            } 
        }
    }
}
