<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Package;
use App\Models\Admin\PackageItem;
use App\Models\Admin\PackageWithPackageItem;
use Alert;
use Auth;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:package-type-list|package-type-create|package-type-edit|package-type-delete', ['only' => ['index','store']]);
        $this->middleware('permission:package-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:package-type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:package-type-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $packages = Package::whereNull('deleted_at')->get();
        return view ('admin.package.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $package_items = PackageItem::whereNull('deleted_at')->whereIsActive(1)->get();
        return view ('admin.package.create', compact('package_items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->is_clear_point == 'on') {
            $is_clear_point = 1;
        }else {
            $is_clear_point = 0;
        }
        $package = Package::create([
            'name' => $request->name,
            'point' => $request->point,
            'price' => $request->price,
            'number_of_users' => $request->number_of_users,
            'number_of_days' => $request->number_of_days,
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
            'is_clear_point' => $is_clear_point
        ]);

        if(isset($request->package_item_id)){
            foreach($request->package_item_id as $package_item) {
                $package_item_id = PackageWithPackageItem::create([
                    'package_id' => $package->id,
                    'package_item_id' => $package_item
                ]);
            }
        }

        Alert::success('Success', 'New Package Created Successfully!');
        return redirect()->route('package-type.index');
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
        $package = Package::findOrFail($id);
        $package_items = PackageItem::whereNull('deleted_at')->whereIsActive(1)->get();
        $package_with_items = PackageWithPackageItem::wherePackageId($id)->pluck('package_item_id')->toArray();
        return view ('admin.package.edit', compact('package', 'package_items', 'package_with_items'));
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
        $package = Package::findOrFail($id);
        $is_clear_point = $package->is_clear_point;
        if($request->is_clear_point == 'on') {
            $is_clear_point = 1;
        }
        $package = $package->update([
            'name' => $request->name,
            'point' => $request->point,
            'price' => $request->price,
            'number_of_users' => $request->number_of_users,
            'number_of_days' => $request->number_of_days,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
            'is_clear_point' => $is_clear_point
        ]);

        if(isset($request->package_item_id)){
            $delete_package_with_items = PackageWithPackageItem::wherePackageId($id)->delete();
            foreach($request->package_item_id as $package_item) {
                $package_item_id = PackageWithPackageItem::create([
                    'package_id' => $id,
                    'package_item_id' => $package_item
                ]);
            }
        }

        Alert::success('Success', 'Package Updated Successfully!');
        return redirect()->route('package-type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        
        try {
            $package = Package::findOrFail($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($package) {
                Alert::success('Success', 'Delete Package Successfully!');
                return redirect()->route('package-type.index');
            }
            else {
                Alert::error('Failed', 'Package deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this State');
                return redirect()->back();
            } 
        }
    }
}
