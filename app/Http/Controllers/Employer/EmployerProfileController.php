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
use App\Models\Employer\EmployerAddress;
use App\Models\Employer\EmployerTestimonial;
use DB;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
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
        $jobPosts = JobPost::whereEmployerId(Auth::guard('employer')->user()->id)->paginate(10);
        $jobApplicants = JobPost::whereEmployerId(Auth::guard('employer')->user()->id)->get();
        $lastJobPosts = JobPost::whereEmployerId(Auth::guard('employer')->user()->id)->orderBy('updated_at','desc')->get()->take(5);
        return view ('employer.profile.dashboard', compact('employer', 'industries', 'ownershipTypes', 'states', 'townships', 'packages', 'functional_areas', 'sub_functional_areas', 'jobPosts', 'jobApplicants', 'lastJobPosts'));
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
        $this->validate($request, [
            'phone' => ['nullable', new MyanmarPhone],
        ]);
        $employer = Employer::findOrFail($id);
        $logo = $employer->logo;
        $background = $employer->background;
        $qr = $employer->qr;

        if($request->logoStatus == 'empty') {
            $logo = Null;
        }
        if($request->backgroundStatus == 'empty') {
            $background = Null;
        }
        if($request->qrStatus == 'empty') {
            $qr = Null;
        }

        if($request->hasFile('logo')) {
            $file    = $request->file('logo');
            $logo = date('YmdHi').$file->getClientOriginalName();
            $path = $file-> move(public_path('storage/employer_logo/'), $logo);
        }
        if($request->hasFile('background')) {
            $file    = $request->file('background');
            $background = date('YmdHi').$file->getClientOriginalName();
            $path = $file-> move(public_path('storage/employer_background/'), $background);
        }
        if($request->hasFile('qr')) {
            $file    = $request->file('qr');
            $qr = date('YmdHi').$file->getClientOriginalName();
            $path = $file-> move(public_path('storage/employer_qr/'), $qr);
        }

        if($request->password) {
            $password = Hash::make($request->password);
        }else {
            $password = $employer->password;
        }

        $employer = $employer->update([
            'logo' => $logo,
            'background' => $background,
            'qr' => $qr,
            'name' => $request->name,
            'industry_id' => $request->industry_id,
            'ownership_type_id' => $request->ownership_type_id,
            'type_of_employer' => $request->type_of_employer,
            'description' => $request->description,
            'no_of_offices' => $request->no_of_offices,
            'website' => $request->website,
            'no_of_employees' => $request->no_of_employees,
            'phone' => $request->phone,
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

    public function employerAddressStore(Request $request)
    {
        $address_create = EmployerAddress::create([
            'employer_id' => $request->employer_id,
            'country' => $request->country,
            'state_id' => $request->state_id,
            'township_id' => $request->township_id,
            'address_detail' => $request->address_detail
        ]);
        if($address_create->country == 'Myanmar') {
            $address = DB::table('employer_addresses as a')
                ->join('states as b','a.state_id','=','b.id')
                ->join('townships as c','a.township_id','=','c.id')
                ->where('a.id','=',$address_create->id)
                ->select('a.*','b.name as state_name','c.name as township_name')
                ->first();
        }else {
            $address = $address_create;
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $address
        ]);
    }

    public function employerAddressDestroy($id, Request $request)
    {
        $address = EmployerAddress::findOrFail($id)->delete();
        $employer = Employer::findOrFail($request->employer_id);
        $address_count = EmployerAddress::whereEmployerId($employer->id)->count();

        return response()->json([
            'status' => 'success',
            'msg' => 'Address deleted successfully!',
            'address_count' => $address_count
        ]);
    }

    public function employerTestimonialStore(Request $request)
    {
        $image = Null;
        if ($request->hasFile('image')) {
            $file    = $request->file('image');
            $image = date('YmdHi').$file->getClientOriginalName();
            $path = $file-> move(public_path('storage/employer_testimonial/'), $image);
        }
        $test_create = EmployerTestimonial::create([
            'employer_id' => $request->employer_id,
            'name' => $request->name,
            'title' => $request->title,
            'remark' => $request->remark,
            'image' => $image
        ]);
        
        return response()->json([
            'status' => 'success',
            'data' => $test_create
        ]);
    }
}
