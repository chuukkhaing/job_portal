<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Admin\Industry;
use App\Models\Admin\OwnershipType;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Admin\Package;
use App\Models\Admin\FunctionalArea;
use App\Models\Employer\JobPost;
use Auth;

class EmployerProfileController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('employer')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->route('home');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        $industries = Industry::whereNull('deleted_at')->get();
        $ownershipTypes = OwnershipType::whereNull('deleted_at')->get();
        $states = State::whereNull('deleted_at')->get();
        $townships = Township::whereNull('deleted_at')->get();
        $packages = Package::whereNull('deleted_at')->get();
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id','!=',0)->whereIsActive(1)->get();
        $jobPosts = JobPost::whereEmployerId(Auth::guard('employer')->user()->id)->get();
        return view ('employer.profile.dashboard', compact('employer', 'industries', 'ownershipTypes', 'states', 'townships', 'packages', 'functional_areas', 'sub_functional_areas', 'jobPosts'));
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
        $employer = Employer::findOrFail($id);
        $logo = $employer->logo;

        if($request->imageRemove == 'empty') {
            $logo = Null;
        }

        if($request->hasFile('logo')) {
            $file    = $request->file('logo');
            $logo = date('YmdHi').$file->getClientOriginalName();
            $path = $file-> move(public_path('storage/employer_logo/'), $logo);
        }

        if($request->password) {
            $password = Hash::make($request->password);
        }else {
            $password = $employer->password;
        }

        $employer = $employer->update([
            'logo' => $logo,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'ceo' => $request->ceo,
            'industry_id' => $request->industry_id,
            'ownership_type_id' => $request->ownership_type_id,
            'type_of_employer' => $request->type_of_employer,
            'description' => $request->description,
            'address' => $request->address,
            'no_of_offices' => $request->no_of_offices,
            'website' => $request->website,
            'no_of_employees' => $request->no_of_employees,
            'established_in' => $request->established_in,
            'fax' => $request->fax,
            'phone' => $request->phone,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'state_id' => $request->state_id,
            'township_id' => $request->township_id,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_phone' => $request->contact_person_phone,
            'contact_person_email' => $request->contact_person_email,
            'map' => $request->map,
            'updated_by' => $id,
        ]);

        return redirect()->back()->with('success','Profile Edit Successfully.');
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

    public function getTownship($id)
    {
        $townships = Township::whereStateId($id)->whereNull('deleted_at')->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data' => $townships
        ]);
    }

    public function getSubFunctionalArea($id)
    {
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id',$id)->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data' => $sub_functional_areas
        ]);
    }
}
