<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\JobPost;
use App\Models\Employer\PointRecord;
use App\Models\Admin\Employer;
use DataTables;
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
        if ($request->ajax()) {
            $data = JobPost::orderBy('updated_at', 'desc')->get();
            if($request->has('status')) {
                $data = JobPost::whereStatus($request->status)->orderBy('updated_at', 'desc')->get();
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('employer_name', function($row){
                    if(isset($row->Employer->MainEmployer)) {
                        $employer = '<a href="'.route("employers.edit", $row->Employer->employer_id).'" class="text-decoration-none text-black">'. $row->Employer->MainEmployer->name.'</a>';
                        $verify = '';
                        if($row->Employer->MainEmployer->is_verified == 1) {
                            $verify = '<i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i>';
                        }
                        $employer_name = $employer . $verify;
                    }elseif(isset($row->Employer)) {
                        $employer = '<a href="'.route("employers.edit", $row->Employer->id).'" class="text-decoration-none text-black">'. $row->Employer->name.'</a>';
                        $verify = '';
                        if($row->Employer->is_verified == 1) {
                            $verify = '<i class="fa-solid fa-circle-check fs-6 px-2" style="color: #0355D0"></i>';
                        }
                        $employer_name = $employer . $verify;
                    }
                    return $employer_name;
                })
                ->addColumn('industry', function($row) {
                    return $industry = $row->Industry ? $row->Industry->name : '';
                })
                ->addColumn('main_functional_area', function($row) {
                    return $main_functional_area = $row->MainFunctionalArea ? $row->MainFunctionalArea->name : '';
                })
                ->addColumn('main_functional_area', function($row) {
                    return $main_functional_area = $row->MainFunctionalArea ? $row->MainFunctionalArea->name : '';
                })
                ->addColumn('activation', function($row) {
                    return $activation = $row->is_active == 1 ? '<span class="badge text-light bg-success">Active</span>' : '<span class="badge text-light bg-danger">In-Active</span>';
                })
                ->addColumn('job_post_status', function($row) {
                    if($row->status == 'Pending') {
                        $status = '<span class="badge text-light bg-secondary">'.$row->status.'</span>';
                    }
                    elseif($row->status == 'Online') {
                        $status = '<span class="badge text-light bg-success">'. $row->status .'</span>';
                    }
                    elseif($row->status == 'Reject') {
                        $status = '<span class="badge text-dark bg-warning">'. $row->status .'</span>';
                    }
                    elseif($row->status == 'Expire') {
                        $status = '<span class="badge text-light bg-danger">'. $row->status .'</span>';
                    }
                    elseif($row->status == 'Draft') {
                        $status = '<span class="badge text-light bg-dark">'. $row->status .'</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row) {
                    return $action = '<a href="'. route("job-posts.edit", $row->id) .'" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                })
                ->rawColumns(['employer_name', 'industry', 'main_functional_area', 'activation', 'job_post_status', 'action'])
                ->make(true);
        }
        return view ('admin.jobpost.index');
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
                            if($jobPost->Employer->employer_id != NULL) {
                                $point_update = Employer::findOrFail($jobPost->Employer->MainEmployer->id)->update(['package_point' => $point_reduce]);
                            }else {
                                $point_update = Employer::findOrFail($jobPost->employer_id)->update(['package_point' => $point_reduce]);
                            }
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
                        if($jobPost->Employer->employer_id != NULL) {
                            $point_reduce = $jobPost->Employer->MainEmployer->package_point - $jobPost->total_point;
                        }else {
                            $point_reduce = $jobPost->Employer->package_point - $jobPost->total_point;
                        }
                        if($point_reduce > 0) {
                            if($jobPost->Employer->employer_id != NULL) {
                                $point_update = Employer::findOrFail($jobPost->Employer->MainEmployer->id)->update(['package_point' => $point_reduce]);
                            }else {
                                $point_update = Employer::findOrFail($jobPost->employer_id)->update(['package_point' => $point_reduce]);
                            }
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
