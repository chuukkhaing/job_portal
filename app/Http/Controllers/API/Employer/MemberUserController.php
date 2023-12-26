<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MOdels\Admin\Employer;
use App\Models\Employer\PointRecord;
use App\Models\Employer\MemberPermission;
use App\Mail\EmployerVerificationEmail;
use Auth;
use Hash;
use Str;
use DB;

class MemberUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        
        $members  = Employer::whereId($request->user()->id)->orWhere('employer_id', $employer->id)->whereNull('deleted_at')->select('id','email','is_active', DB::raw("(CASE WHEN (employer_id != 'NULL') THEN 'Member' ELSE 'Admin' End) as Access"))->get();
        return response()->json([
            'status' => 'success',
            'members' => $members
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $member_permissions = [
            'dashboard',
            'profile',
            'manage_job',
            'application_tracking'
        ];

        return response()->json([
            'status' => 'success',
            'member_permissions' => $member_permissions
        ],200);
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
        $check_member = Employer::whereEmployerId($request->user()->id)->count();
        $employer = Employer::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'employer_id' => $request->user()->id,
            'package_id' => $request->user()->package_id,
            'is_active' => $request->is_active,
            'register_at' => now(),
            'is_active' => $request->is_active,
            'created_by' => $request->user()->id,
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

        if($request->dashboard == 1) {
            $permission = MemberPermission::create([
                'employer_id' => $employer->id,
                'name' => 'dashboard'
            ]);
        }

        if($request->profile == 1) {
            $permission = MemberPermission::create([
                'employer_id' => $employer->id,
                'name' => 'profile'
            ]);
        }

        if($request->manage_job == 1) {
            $permission = MemberPermission::create([
                'employer_id' => $employer->id,
                'name' => 'manage_job'
            ]);
        }

        if($request->application_tracking == 1) {
            $permission = MemberPermission::create([
                'employer_id' => $employer->id,
                'name' => 'application_tracking'
            ]);
        }
        
        if ($employer) {

            return response()->json([
                'status' => 'success',
                'employer' => $employer
            ],200);
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
