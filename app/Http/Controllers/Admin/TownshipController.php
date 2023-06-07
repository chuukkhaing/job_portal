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
        $states = State::whereNull('deleted_at')->get();
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
            'created_at' => now()
        ]);

        Alert::success('Success', 'New Township Created Successfully!');
        return redirect()->route('township.index');
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
        $township = Townhip::findOrFail($id);
        $states = State::whereNull('deleted_at')->get();
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
        $township = Townhip::findOrFail($id);
        $township = $township->update([
            'state_id' => $request->state_id,
            'name' => $request->name,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
            'updated_at' => now()
        ]);

        Alert::success('Success', 'Township Updated Successfully!');
        return redirect()->route('township.index');
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
