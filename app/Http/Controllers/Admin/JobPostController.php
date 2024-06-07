<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\JobPost;
use App\Models\Employer\PointRecord;
use App\Models\Admin\Employer;
use App\Models\Seeker\JobAlert;
use App\Models\Seeker\Seeker;
use Kreait\Laravel\Firebase\Facades\Firebase;    
use Kreait\Firebase\Messaging\CloudMessage;
use App\Notifications\JobAlertNotification;
use Illuminate\Support\Facades\Notification;
use Alert;
use Auth;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $notification;

    function __construct()
    {
        $this->middleware('permission:job-post-list|job-post-create|job-post-edit|job-post-delete', ['only' => ['index','store']]);
        $this->middleware('permission:job-post-create', ['only' => ['create','store']]);
        $this->middleware('permission:job-post-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:job-post-delete', ['only' => ['destroy']]);
        $this->notification = Firebase::messaging();
    }

    public function index(Request $request)
    {
        
        $data = JobPost::orderBy('updated_at', 'desc')->paginate(10);
        if($request->has('status')) {
            $data = JobPost::whereStatus($request->status)->orderBy('updated_at', 'desc')->paginate(10);
        }
        if ($request->ajax()) {
                $data = JobPost::orderBy('updated_at', 'desc')
                        ->whereHas('Employer', function($employer) use($request) {
                            $employer->where('name', 'Like', '%'. $request->search .'%');
                        })->orWhereHas('Industry', function($industry) use($request) {
                            $industry->where('name','Like','%'. $request->search . '%');
                        })->orWhereHas('MainFunctionalArea', function($functional_area) use($request) {
                            $functional_area->where('name','Like','%'. $request->search . '%');
                        })->orWhere('job_title','Like','%'. $request->search .'%')
                        ->orWhere('status', $request->search)
                        ->when($request->search == 'active', function ($active) {
                            return $active->orWhere('is_active',1);
                        })
                        ->when($request->search == 'inactive' || $request->search == 'in-active', function ($active) {
                            return $active->orWhere('is_active',0);
                        })
                        ->paginate(10);
                if($request->has('status')) {
                    $data = JobPost::whereStatus($request->status)->orderBy('updated_at', 'desc')
                            ->whereHas('Employer', function($employer) use($request) {
                                $employer->where('name', 'Like', '%'. $request->search .'%');
                            })->orWhereHas('Industry', function($industry) use($request) {
                                $industry->where('name','Like','%'. $request->search . '%');
                            })->orWhereHas('MainFunctionalArea', function($functional_area) use($request) {
                                $functional_area->where('name','Like','%'. $request->search . '%');
                            })->orWhere('job_title','Like','%'. $request->search .'%')
                            ->orWhere('status', $request->search)
                            ->when($request->search == 'active', function ($active) {
                                return $active->orWhere('is_active',1);
                            })
                            ->when($request->search == 'inactive' || $request->search == 'in-active', function ($active) {
                                return $active->orWhere('is_active',0);
                            })
                            ->paginate(10);
                }
                return view('admin.jobpost.table', compact('data'));
        }
        if ($request->search) {
            $data = JobPost::orderBy('updated_at', 'desc')
                    ->whereHas('Employer', function($employer) use($request) {
                        $employer->where('name', 'Like', '%'. $request->search .'%');
                    })->orWhereHas('Industry', function($industry) use($request) {
                        $industry->where('name','Like','%'. $request->search . '%');
                    })->orWhereHas('MainFunctionalArea', function($functional_area) use($request) {
                        $functional_area->where('name','Like','%'. $request->search . '%');
                    })->orWhere('job_title','Like','%'. $request->search .'%')
                    ->orWhere('status', $request->search)
                    ->when($request->search == 'active', function ($active) {
                        return $active->orWhere('is_active',1);
                    })
                    ->when($request->search == 'inactive' || $request->search == 'in-active', function ($active) {
                        return $active->orWhere('is_active',0);
                    })
                    ->paginate(10);
            if($request->has('status')) {
                $data = JobPost::whereStatus($request->status)->orderBy('updated_at', 'desc')
                        ->whereHas('Employer', function($employer) use($request) {
                            $employer->where('name', 'Like', '%'. $request->search .'%');
                        })->orWhereHas('Industry', function($industry) use($request) {
                            $industry->where('name','Like','%'. $request->search . '%');
                        })->orWhereHas('MainFunctionalArea', function($functional_area) use($request) {
                            $functional_area->where('name','Like','%'. $request->search . '%');
                        })->orWhere('job_title','Like','%'. $request->search .'%')
                        ->orWhere('status', $request->search)
                        ->when($request->search == 'active', function ($active) {
                            return $active->orWhere('is_active',1);
                        })
                        ->when($request->search == 'inactive' || $request->search == 'in-active', function ($active) {
                            return $active->orWhere('is_active',0);
                        })
                        ->paginate(10);
            }
            return view('admin.jobpost.index',compact('data'));
        }
            return view('admin.jobpost.index',compact('data'));
        // return view ('admin.jobpost.index')->withJobPosts($dummyDetails);
        
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

                    $jobAlerts = JobAlert::where('job_title', 'Like', '%' . $jobPost->job_title . '%')->get();
                    if($jobAlerts->count() > 0) {
                        foreach($jobAlerts as $job_alert) {
                            $title = 'Infinity Careers Job Alert';
                            $msg = json_encode([
                                'title' => $title,
                                'body' => 'Your Job Alert for '. $jobPost->job_title,
                                'job_post_slug' => $jobPost->slug,
                                'imageUrl' => null
                            ]);
                            try {
                                if(isset($job_alert->Seeker->fcm_token)) {
                                    $seeker = $job_alert->Seeker;
                                    $FcmToken = $job_alert->Seeker->fcm_token;
                                    
                                    $body = json_encode([
                                        'job_post_slug' => $jobPost->slug,
                                        'imageUrl' => null
                                    ]);

                                    $message = CloudMessage::fromArray([
                                        'token' => $FcmToken,
                                        'notification' => [
                                            'title' => $title,
                                            'body' => 'Your Job Alert for '. $jobPost->job_title
                                            ],
                                        'data' => [
                                            'body' => $body
                                            ]
                                    ]);
                                    $this->notification->send($message);
                                }
                            } catch (\Exception $e) {
                                $e->getMessage();
                            }
                            Notification::send($job_alert->Seeker, new JobAlertNotification($msg, $job_alert, $jobPost));
                        }
                    }
                    Alert::success('Success', 'Job Post Updated Successfully!');
                    return redirect()->route('job-posts.index');
                }elseif($jobPost->total_point > 0) {
                    if($jobPost->expired_at) {
                        $point_reduce = $jobPost->Employer->package_point - $jobPost->total_point;
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

                            $jobAlerts = JobAlert::where('job_title', 'Like', '%' . $jobPost->job_title . '%')->get();
                            if($jobAlerts->count() > 0) {
                                foreach($jobAlerts as $job_alert) {
                                    $title = 'Infinity Careers Job Alert';
                                    $msg = json_encode([
                                        'title' => $title,
                                        'body' => 'Your Job Alert for '. $jobPost->job_title,
                                        'job_post_slug' => $jobPost->slug,
                                        'imageUrl' => null
                                    ]);
                                    try {
                                        if(isset($job_alert->Seeker->fcm_token)) {
                                            $seeker = $job_alert->Seeker;
                                            $FcmToken = $job_alert->Seeker->fcm_token;
                                            
                                            $body = json_encode([
                                                'job_post_slug' => $jobPost->slug,
                                                'imageUrl' => null
                                            ]);

                                            $message = CloudMessage::fromArray([
                                                'token' => $FcmToken,
                                                'notification' => [
                                                    'title' => $title,
                                                    'body' => 'Your Job Alert for '. $jobPost->job_title
                                                    ],
                                                'data' => [
                                                    'body' => $body
                                                    ]
                                            ]);
                                            $this->notification->send($message);
                                        }
                                    } catch (\Exception $e) {
                                        $e->getMessage();
                                    }
                                    Notification::send($job_alert->Seeker, new JobAlertNotification($msg, $job_alert, $jobPost));
                                }
                            }
                            Alert::success('Success', 'Job Post Updated Successfully!');
                            return redirect()->route('job-posts.index');
                        }else {
                            Alert::error('Failed', "Employer's points are not enough!");
                            return redirect()->back();
                        }
                    }else {
                        $point_reduce = $jobPost->Employer->package_point - $jobPost->total_point;
                        if($point_reduce >= 0) {
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

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output = "";
            $dummyDetails = JobPost::orderBy('updated_at', 'desc')->where('job_title','Like','%'. $request->search .'%')->paginate(10);
            if($request->has('status')) {
                $dummyDetails = JobPost::whereStatus($request->status)->orderBy('updated_at', 'desc')->where('job_title','Like','%'. $request->search .'%')->paginate(10);
            }
            if($dummyDetails)
            {
                foreach ($dummyDetails as $key => $row) {
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
                    $industry = $row->Industry ? $row->Industry->name : '';
                    $main_functional_area = $row->MainFunctionalArea ? $row->MainFunctionalArea->name : '';
                    $activation = $row->is_active == 1 ? '<span class="badge text-light bg-success">Active</span>' : '<span class="badge text-light bg-danger">In-Active</span>';
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
                    $action = '<a href="'. route("job-posts.edit", $row->id) .'" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>';
                    $output.='<tr>'.
                    '<td>'. $key+1 .'</td>'.
                    '<td>'.$row->job_title.'</td>'.
                    '<td>'.$employer_name.'</td>'.
                    '<td>'.$industry.'</td>'.
                    '<td>'.$main_functional_area.'</td>'.
                    '<td>'.$activation.'</td>'.
                    '<td>'.$status.'</td>'.
                    '<td>'.$action.'</td>'.
                    '</tr>';
                }
                $paginate = 'There is no item to show.';
                if($dummyDetails->count() > 0) {
                    $paginate = '{{ '.$dummyDetails->links().' }}';
                }
            return Response()->json([
                'output' => $output,
                'paginate' => $paginate
            ]);
            }
        }
    }
}
