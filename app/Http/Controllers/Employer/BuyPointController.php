<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Admin\Package;
use App\Models\Admin\PointPackage;
use App\Models\Admin\PointOrder;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Admin\PackageItem;
use Auth;

class BuyPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $pointPackages = PointPackage::whereNull('deleted_at')->whereIsActive(1)->get();
        $orders = PointOrder::whereNull('deleted_at')->whereEmployerId($employer->id)->orderBy('updated_at','desc')->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        return view('employer.profile.buy-point.index', compact('employer', 'packages', 'pointPackages', 'orders', 'packageItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $pointPackages = PointPackage::whereNull('deleted_at')->whereIsActive(1)->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        return view('employer.profile.buy-point.create', compact('employer', 'packages', 'pointPackages', 'packageItems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'phone'    => ['required', new MyanmarPhone],
            'name'     => ['required', 'string'],
            'point_package_id' => ['required']
        ]);

        if(isset(Auth('employer')->user()->employer_id)) {
            $employer_id = Auth('employer')->user()->employer_id;
        }else {
            $employer_id = Auth('employer')->user()->id;
        }

        $order = PointOrder::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'point_package_id' => $request->point_package_id,
            'employer_id' => $employer_id,
            'status' => 'Pending'
        ]);

        if($order) {
            return redirect()->route('employer-job-post.create')->with('success','Your Points order was successful.');
        }else {
            return redirect()->back()->with('warning','Your Points order was somthing wrong. Try Again!');
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
    public function destroy($id)
    {
        //
    }
}
