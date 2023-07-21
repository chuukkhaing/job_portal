<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PackageItem;
use Alert;
use Auth;

class PackageItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:package-item-list|package-item-create|package-item-edit|package-item-delete', ['only' => ['index','store']]);
        $this->middleware('permission:package-item-create', ['only' => ['create','store']]);
        $this->middleware('permission:package-item-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:package-item-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $package_items = PackageItem::whereNull('deleted_at')->get();
        return view ('admin.package-item.index', compact('package_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.package-item.create');
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
            'name' => 'unique:package_items'
        ]);
        $package_item = PackageItem::create([
            'name' => $request->name,
            'point' => $request->point,
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'New Package Item Created Successfully!');
        return redirect()->route('package-item.index');
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
        $package_item = PackageItem::findOrFail($id);
        return view ('admin.package-item.edit', compact('package_item'));
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
        $package_item = PackageItem::findOrFail($id);
        
        $package_item = $package_item->update([
            'name' => $request->name,
            'point' => $request->point,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Package Item Updated Successfully!');
        return redirect()->route('package-item.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package_item = PackageItem::findOrFail($id);
        
        try {
            $package_item = PackageItem::findOrFail($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($package_item) {
                Alert::success('Success', 'Delete Package Item Successfully!');
                return redirect()->route('package-item.index');
            }
            else {
                Alert::error('Failed', 'Package Item deleted failed');
                return back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this State');
                return back();
            } 
        }
    }
}
