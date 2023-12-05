<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Township;
use App\Models\Admin\State;
use Alert;
use Auth;

class TownshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:township-list|township-create|township-edit|township-delete', ['only' => ['index','store']]);
        $this->middleware('permission:township-create', ['only' => ['create','store']]);
        $this->middleware('permission:township-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:township-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $townships = Township::whereNull('deleted_at')->get();
        return view ('admin.township.index', compact('townships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::whereNull('deleted_at')->whereIsActive(1)->get();
        return view ('admin.township.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $township = Township::create([
            'state_id' => $request->state_id,
            'name' => $request->name,
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'New City Created Successfully!');
        return redirect()->route('city.index');
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
        $township = Township::findOrFail($id);
        $states = State::whereNull('deleted_at')->whereIsActive(1)->get();
        return view ('admin.township.edit', compact('states', 'township'));
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
        $township = Township::findOrFail($id);
        $township = $township->update([
            'state_id' => $request->state_id,
            'name' => $request->name,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'City Updated Successfully!');
        return redirect()->route('city.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $township = Township::findOrFail($id);
        
        try {
            $township = Township::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($township) {
                Alert::success('Success', 'Delete Township Successfully!');
                return redirect()->route('city.index');
            }
            else {
                Alert::error('Failed', 'Township deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Township');
                return redirect()->back();
            } 
        }
    }
}
