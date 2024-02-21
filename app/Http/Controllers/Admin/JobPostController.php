<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\JobPost;
use App\Models\Employer\PointRecord;
use App\Models\Admin\Employer;
use Alert;
use Auth;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:job-post-list|job-post-create|job-post-edit|job-post-delete', ['only' => ['index','store']]);
        $this->middleware('permission:job-post-create', ['only' => ['create','store']]);
        $this->middleware('permission:job-post-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:job-post-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $jobPosts = JobPost::orderBy('updated_at', 'desc')->get();
        if($request->has('status')) {
            $jobPosts = JobPost::whereStatus($request->status)->orderBy('updated_at', 'desc')->get();
        }
        return view ('admin.jobpost.index', compact('jobPosts'));
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
        $jobpost = JobPost::findOrFail($id);
        return view ('admin.jobpost.edit', compact('jobpost'));
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
        $jobPost = JobPost::findOrFail($id);
        if($request->status != $jobPost->status) {
            if($request->status == 'Online') {
                if($jobPost->total_point == 0) {
                    $update_status = $jobPost->update([
                        'status' => $request->status,
                        'approved_at' => date('Y-m-d', strtotime(now())),
                        'approved_by' => Auth::user()->id,
                    ]);
                    Alert::success('Success', 'Job Post Updated Successfully!');
                    return redirect()->route('job-posts.index');
                }elseif($jobPost->total_point > 0) {
                    if($jobPost->expired_at) {
                        if($jobPost->Employer->employer_id != NULL) {
                            $point_reduce = $jobPost->Employer->MainEmployer->package_point - $jobPost->total_point;
                        }else {
                            $point_reduce = $jobPost->Employer->package_point - $jobPost->total_point;
                        }
                        if($point_reduce > 0) {
                            $point_update = Employer::findOrFail($jobPost->employer_id)->update(['package_point' => $point_reduce]);
                            $update_status = $jobPost->update([
                                'status' => $request->status,
                                'approved_at' => date('Y-m-d', strtotime(now())),
                                'approved_by' => Auth::user()->id,
                            ]);
                            $point_record = PointRecord::whereJobPostId($jobPost->id)->update([
                                'status' => 'Complete'
                            ]);
                            Alert::success('Success', 'Job Post Updated Successfully!');
                            return redirect()->route('job-posts.index');
                        }else {
                            Alert::error('Failed', "Employer's points are not enough!");
                            return redirect()->back();
                        }
                    }else {
                        $point_reduce = $jobPost->Employer->package_point - $jobPost->total_point;
                        if($point_reduce > 0) {
                            $point_update = Employer::findOrFail($jobPost->employer_id)->update(['package_point' => $point_reduce]);
                            $update_status = $jobPost->update([
                                'status' => $request->status,
                                'approved_at' => date('Y-m-d', strtotime(now())),
                                'approved_by' => Auth::user()->id,
                                'expired_at' => date('Y-m-d', strtotime(now(). ' + 30 days'))
                            ]);
                            $point_record = PointRecord::whereJobPostId($jobPost->id)->update([
                                'status' => 'Complete'
                            ]);
                            Alert::success('Success', 'Job Post Updated Successfully!');
                            return redirect()->route('job-posts.index');
                        }else {
                            Alert::error('Failed', "Employer's points are not enough!");
                            return redirect()->back();
                        }
                    }
                }
                
            }else {
                $update_status = $jobPost->update([
                    'status' => $request->status,
                    'rejected_at' => date('Y-m-d', strtotime(now())),
                    'rejected_by' => Auth::user()->id,
                ]);
                Alert::success('Success', 'Job Post Updated Successfully!');
                return redirect()->route('job-posts.index');
            }
        }else {
            Alert::success('Success', 'There is no changes!');
            return redirect()->route('job-posts.index');
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
        //
    }
}
