<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Package;
use App\MOdels\Admin\Employer;
use App\Models\Admin\PackageItem;
use App\Models\Employer\PointRecord;
use App\Models\Employer\MemberPermission;
use App\Mail\EmployerVerificationEmail;
use Auth;
use Hash;
use Str;

class MemberUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        
        $members  = Employer::whereEmployerId($employer->id)->whereNull('deleted_at')->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        return view('employer.profile.manage-user', compact('packageItems','packages', 'employer', 'members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        return view('employer.profile.manage-user-create', compact('packages','packageItems', 'employer'));
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employers,email,NULL,id,deleted_at,NULL'],
            'password' => ['required', 'string', 'min:8', 'same:confirm-password'],
            'confirm-password' => ['required', 'string', 'min:8'],
            'is_active' => ['required'],
            'dashboard' => 'required_without_all:profile,manage_job,application_tracking',
            'profile' => 'required_without_all:dashboard,manage_job,application_tracking',
            'manage_job' => 'required_without_all:dashboard,profile,application_tracking',
            'application_tracking' => 'required_without_all:dashboard,profile,manage_job',
        ]);
        $check_member = Employer::whereEmployerId(Auth::guard('employer')->user()->id)->count();
        $employer = Employer::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'employer_id' => Auth::guard('employer')->user()->id,
            'package_id' => Auth::guard('employer')->user()->package_id,
            'is_active' => $request->is_active,
            'register_at' => now(),
            'is_active' => $request->is_active,
            'created_by' => Auth::guard('employer')->user()->id,
            'email_verification_token' => Str::random(32)
        ]);
        
        if($employer) {
            \Mail::to($employer->email)->send(new EmployerVerificationEmail($employer));
            if($check_member == 1) {
                $member_point = PointRecord::create([
                    'employer_id' => $employer->employer_id,
                    'package_item_id' => $request->package_item_id,
                    'point' => $request->package_item_point,
                    'status' => 'Complete'
                ]);
            }
        }

        if($request->dashboard == "on") {
            $permission = MemberPermission::create([
                'employer_id' => $employer->id,
                'name' => 'dashboard'
            ]);
        }

        if($request->profile == "on") {
            $permission = MemberPermission::create([
                'employer_id' => $employer->id,
                'name' => 'profile'
            ]);
        }

        if($request->manage_job == "on") {
            $permission = MemberPermission::create([
                'employer_id' => $employer->id,
                'name' => 'manage_job'
            ]);
        }

        if($request->application_tracking == "on") {
            $permission = MemberPermission::create([
                'employer_id' => $employer->id,
                'name' => 'application_tracking'
            ]);
        }
        
        if ($employer) {

            return redirect()->route('member-user.index')->with('success', 'New Member Created Successfully!');
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
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $member = Employer::findOrFail($id);
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        return view('employer.profile.manage-user-edit', compact('packages', 'employer', 'member', 'packageItems'));
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
            'password' => ['nullable', 'string', 'min:8', 'same:confirm-password'],
            'confirm-password' => ['nullable', 'string', 'min:8'],
            'is_active' => ['required'],
            'dashboard' => 'required_without_all:profile,manage_job,application_tracking',
            'profile' => 'required_without_all:dashboard,manage_job,application_tracking',
            'manage_job' => 'required_without_all:dashboard,profile,application_tracking',
            'application_tracking' => 'required_without_all:dashboard,profile,manage_job',
        ]);
        $member = Employer::findOrFail($id);
        if($id == Auth::guard('employer')->user()->id) {
            $is_active = $member->is_active;
        }else {
            $is_active = $request->is_active;
        }
        if($request->password){ 
            $password = Hash::make($request->password);
        }else{
            $password = $member->password;    
        }
        $member_update = $member->update([
            'email' => $request->email,
            'password' => $password,
            'is_active' => $is_active,
            'register_at' => now(),
            'updated_by' => Auth::guard('employer')->user()->id,
        ]);
        $permission_delete = MemberPermission::whereEmployerId($member->id)->delete();
        if($request->dashboard == "on") {
            $permission = MemberPermission::create([
                'employer_id' => $member->id,
                'name' => 'dashboard'
            ]);
        }

        if($request->profile == "on") {
            $permission = MemberPermission::create([
                'employer_id' => $member->id,
                'name' => 'profile'
            ]);
        }

        if($request->manage_job == "on") {
            $permission = MemberPermission::create([
                'employer_id' => $member->id,
                'name' => 'manage_job'
            ]);
        }

        if($request->application_tracking == "on") {
            $permission = MemberPermission::create([
                'employer_id' => $member->id,
                'name' => 'application_tracking'
            ]);
        }

        if($member_update) {
            return redirect()->route('member-user.index')->with('success', 'Member Updated Successfully!');
        }
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
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        
        try {
            $employer = Employer::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::guard('employer')->user()->id
            ]);
            if ($employer) {
                return response()->json([
                    'status' => 'success',
                    'msg' => 'Delete Employer Successfully!'
                ]);
            }
            else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Employer deleted failed'
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Employer deleted failed'
                ]);
            } 
        }
    }
}
