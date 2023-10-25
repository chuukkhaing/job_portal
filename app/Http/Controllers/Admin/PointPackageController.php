<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PointPackage;
use Alert;
use Auth;

class PointPackageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:point-package-list|point-package-create|point-package-edit|point-package-delete', ['only' => ['index','store']]);
        $this->middleware('permission:point-package-create', ['only' => ['create','store']]);
        $this->middleware('permission:point-package-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:point-package-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $point_packages = PointPackage::whereNull('deleted_at')->get();
        return view ('admin.point-package.index', compact('point_packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.point-package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $package = PointPackage::create([
            'point' => $request->point,
            'price' => $request->price,
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'New Point Package Created Successfully!');
        return redirect()->route('point-package.index');
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
        $package = PointPackage::findOrFail($id);
        return view ('admin.point-package.edit', compact('package'));
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
        $package = PointPackage::findOrFail($id);
        $package = $package->update([
            'point' => $request->point,
            'price' => $request->price,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Point Package Updated Successfully!');
        return redirect()->route('point-package.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = PointPackage::findOrFail($id);
        
        try {
            $package = PointPackage::findOrFail($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($package) {
                Alert::success('Success', 'Delete Point Package Successfully!');
                return redirect()->route('point-package.index');
            }
            else {
                Alert::error('Failed', 'Point Package deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Point Package');
                return redirect()->back();
            } 
        }
    }
}
