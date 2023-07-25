<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\JobPost;
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

    public function index()
    {
        $jobPosts = JobPost::whereIsActive(1)->orderBy('updated_at')->get();
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
        $jobPost = JobPost::findOrFail($id);
        return view ('admin.jobpost.edit', compact('jobPost'));
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
        if($request->status == 'Online') {
            if($jobPost->expired_at) {
                $update_status = $jobPost->update([
                    'status' => $request->status,
                    'approved_at' => date('Y-m-d', strtotime(now())),
                    'approved_by' => Auth::user()->id,
                ]);
            }else {
                $update_status = $jobPost->update([
                    'status' => $request->status,
                    'approved_at' => date('Y-m-d', strtotime(now())),
                    'approved_by' => Auth::user()->id,
                    'expired_at' => date('Y-m-d', strtotime(now(). ' + 30 days'))
                ]);
            }
            
        }else {
            $update_status = $jobPost->update([
                'status' => $request->status,
                'rejected_at' => date('Y-m-d', strtotime(now())),
                'rejected_by' => Auth::user()->id,
            ]);
            
        }
        
        Alert::success('Success', 'Job Post Updated Successfully!');
        return redirect()->route('job-posts.index');
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
