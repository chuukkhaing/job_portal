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
use App\Mail\EmployerVerificationEmail;
use Storage;
use Alert;
use Auth;
use Hash;
use Str;

class EmployerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:employer-list|employer-create|employer-edit|employer-delete', ['only' => ['index','store']]);
        $this->middleware('permission:employer-create', ['only' => ['create','store']]);
        $this->middleware('permission:employer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:employer-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $employers = Employer::whereNull('deleted_at')->whereNull('employer_id')->orderBy('created_at','desc')->get();
        if($request->has('is_active')) {
            $employers = Employer::whereNull('deleted_at')->whereNull('employer_id')->where('is_active', $request->is_active)->orderBy('created_at','desc')->get();
        }
        return view ('admin.employer.index', compact('employers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::whereNull('deleted_at')->get();
        return view ('admin.employer.create', compact('packages'));
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
            'email' => 'required|string|email|max:255|unique:employers,email,NULL,id,deleted_at,NULL',
            'password' => ['required', 'string', 'min:8', 'same:confirm-password'],
            'package_start_date' => 'required_if:package_id,1,2,3'
        ]);

        if($request->image_base64 != ''){
            $logo = $this->storeBase64($request->image_base64);
        }else {
            $logo = '';
        }

        $package_end_date = Null;
        if($request->package_id && $request->package_start_date) {
            $package = Package::findOrFail($request->package_id);
            $package_end_date = date('Y-m-d', strtotime($request->package_start_date. ' + '.$package->number_of_days.'days'));
        }
        $employer = Employer::create([
            'logo' => $logo,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->is_active,
            'package_id' => $request->package_id,
            'package_start_date' => $request->package_start_date ? date('Y-m-d', strtotime($request->package_start_date)) : Null,
            'package_end_date' => $package_end_date,
            'package_point' => $package->point ?? 0,
            'purchased_point' => $package->point ?? 0,
            'email_verification_token' => Str::random(32),
            'register_at' => now(),
            'created_by' => Auth::user()->id,
        ]);
        if ($employer) {
            \Mail::to($employer->email)->send(new EmployerVerificationEmail($employer));
        }
        $slug = Str::slug($request->name, '-') . '-' . $employer->id;
        $employer->update([
            'slug' => $slug
        ]);
        Alert::success('Success', 'New Employer Created Successfully!');
        return redirect()->route('employers.index');
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
        
        $request->validate([
            'email' => 'required|string|email|max:255|unique:employers,email,'.$id.',id,deleted_at,NULL',
        ]);

        if($request->package_id != 4) {
            $request->validate([
                'package_start_date' => 'required'
            ]);
        }
        $employer = Employer::findOrFail($id);

        if($request->image_base64 != ''){
            $logo = $this->storeBase64($request->image_base64);
        }else {
            $logo = '';
        }

        $package = Package::findOrFail($request->package_id);
        $package_start_date = $employer->package_start_date;
        $package_end_date = $employer->package_end_date;
        $package_point = $employer->package_point;
        $purchased_point = $employer->purchased_point;

        if($request->package_start_date != null) {
            $package_end_date = Null;
            if($request->package_id) {
                $package_end_date = date('Y-m-d', strtotime($request->package_start_date. ' + '.$package->number_of_days.'days'));
            }
            
            $package_start_date = date('Y-m-d', strtotime($request->package_start_date));
        }else {
            $package_start_date = null;
        }

        if($request->package_id != $employer->package_id) {
            $package_point = $employer->package_point + $package->point;
            $purchased_point = $employer->purchased_point + $package->point;
        }

        $slug = Str::slug($request->name, '-') . '-' . $id;
        $employer = $employer->update([
            'name' => $request->name,
            'logo' => $logo,
            'email' => $request->email,
            'package_id' => $package->id,
            'package_start_date' => $package_start_date,
            'package_end_date' => $package_end_date,
            'package_point' => $package_point,
            'purchased_point' => $purchased_point,
            'slug' => $slug,
            'register_at' => now(),
            'is_active' => $request->is_active,
            'is_verified' => $request->is_verified,
            'updated_by_admin' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Employer Updated Successfully!');
        return redirect()->route('employers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employer = Employer::findOrFail($id);
        
        try {
            $employer = Employer::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($employer) {
                Alert::success('Success', 'Delete Employer Successfully!');
                return redirect()->route('employers.index');
            }
            else {
                Alert::error('Failed', 'Employer deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Employer');
                return redirect()->back();
            } 
        }
    }

    private function storeBase64($imageBase64)
    {
        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64)      = explode(',', $imageBase64);
        $imageBase64 = base64_decode($imageBase64);
        $imageName= time().'.png';

        $path     = 'employer_logo/' . $imageName;
        Storage::disk('s3')->put($path, $imageBase64);
        $path = Storage::disk('s3')->url($path);
          
        return $imageName;
    }

    public function getTownship($id)
    {
        $townships = Township::whereStateId($id)->whereNull('deleted_at')->whereIsActive(1)->orderBy('name')->get();
        return response()->json([
            'status' => 'success',
            'data' => $townships
        ]);
    }
}
