<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\OwnershipType;
use Auth;
use Alert;

class OwnershipTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:ownership-type-list|ownership-type-create|ownership-type-edit|ownership-type-delete', ['only' => ['index','store']]);
        $this->middleware('permission:ownership-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:ownership-type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:ownership-type-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $ownershipTypes = OwnershipType::whereNull('deleted_at')->get();
        return view ('admin.ownership-type.index', compact('ownershipTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.ownership-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ownershipType = OwnershipType::create([
            'name' => $request->name,
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'New Ownership Type Created Successfully!');
        return redirect()->route('ownership-type.index');
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
        $ownershipType = OwnershipType::findOrFail($id);
        return view ('admin.ownership-type.edit', compact('ownershipType'));
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
        $ownershipType = OwnershipType::findOrFail($id);
        $ownershipType = $ownershipType->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Ownership Type Updated Successfully!');
        return redirect()->route('ownership-type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ownershipType = OwnershipType::findOrFail($id);
        
        try {
            $ownershipType = OwnershipType::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($ownershipType) {
                Alert::success('Success', 'Delete Ownership Type Successfully!');
                return redirect()->route('ownership-type.index');
            }
            else {
                Alert::error('Failed', 'Ownership Type deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Ownership Type');
                return redirect()->back();
            } 
        }
    }
}
