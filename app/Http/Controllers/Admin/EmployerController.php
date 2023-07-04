<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Admin\Industry;
use App\Models\Admin\OwnershipType;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Admin\Package;
use Alert;
use Auth;
use Hash;

class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employers = Employer::whereNull('deleted_at')->get();
        return view ('admin.employer.index', compact('employers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $industries = Industry::whereNull('deleted_at')->get();
        $ownershipTypes = OwnershipType::whereNull('deleted_at')->get();
        $states = State::whereNull('deleted_at')->get();
        $townships = Township::whereNull('deleted_at')->get();
        $packages = Package::whereNull('deleted_at')->get();
        return view ('admin.employer.create', compact('industries', 'ownershipTypes', 'states', 'townships', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('logo')) {
            $file    = $request->file('logo');
            $logo = date('YmdHi').$file->getClientOriginalName();
            $path = $file-> move(public_path('storage/employer_logo/'), $logo);
        }

        $package_end_date = Null;
        if($request->package_id) {
            $package = Package::findOrFail($request->package_id);
            $package_end_date = date('Y-m-d', strtotime($request->package_start_date. ' + '.$package->number_of_days.'days'));
        }
        
        $employer = Employer::create([
            'logo' => $logo,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
            'is_active' => $request->is_active,
            'map' => $request->map,
            'package_id' => $request->package_id,
            'package_start_date' => $request->package_start_date,
            'package_end_date' => $package_end_date,
            'register_at' => now(),
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'New Employer Created Successfully!');
        return redirect()->route('employer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employer = Employer::findOrFail($id);
        return view ('admin.employer.show', compact('employer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employer = Employer::findOrFail($id);
        $industries = Industry::whereNull('deleted_at')->get();
        $ownershipTypes = OwnershipType::whereNull('deleted_at')->get();
        $states = State::whereNull('deleted_at')->get();
        $townships = Township::whereNull('deleted_at')->get();
        $packages = Package::whereNull('deleted_at')->get();
        return view ('admin.employer.edit', compact('employer', 'industries', 'ownershipTypes', 'states', 'townships', 'packages'));
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

        $package_end_date = Null;
        if($request->package_id) {
            $package = Package::findOrFail($request->package_id);
            $package_end_date = date('Y-m-d', strtotime($request->package_start_date. ' + '.$package->number_of_days.'days'));
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
            'is_active' => $request->is_active,
            'map' => $request->map,
            'package_id' => $request->package_id,
            'package_start_date' => $request->package_start_date,
            'package_end_date' => $package_end_date,
            'register_at' => now(),
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Employer Updated Successfully!');
        return redirect()->route('employer.index');
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
}
