<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\PointOrder;
use App\Models\Employer\JobPostPointDetect;
use App\Models\Employer\JobPost;
use Auth;
use Alert;

class PointOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:point-topup-list|point-topup-create|point-topup-edit|point-topup-delete', ['only' => ['index','store']]);
        $this->middleware('permission:point-topup-create', ['only' => ['create','store']]);
        $this->middleware('permission:point-topup-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:point-topup-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $orders = PointOrder::whereNull('deleted_at')->orderBy('updated_at','desc')->get();
        if($request->status) {
            $orders = PointOrder::whereNull('deleted_at')->whereStatus($request->status)->orderBy('updated_at','desc')->get();
        }
        return view ('admin.point-topup.index', compact('orders'));
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
        $order = PointOrder::findOrFail($id);
        return view ('admin.point-topup.edit', compact('order'));
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
        $order = PointOrder::findOrFail($id);
        if($request->status == 'Approved') {
            $point = $order->PointPackage->point;
            $employer = $order->Employer;
            $employer_update = $employer->update([
                'add_on_point' => $employer->add_on_point + $point,
                'purchased_point' => $employer->purchased_point + $point
            ]);
        }
        $order_update = $order->update([
            'status' => $request->status,
            'updated_by' => Auth()->user()->id
        ]);

        $jobpostpoint = JobPostPointDetect::wherePointOrderId($id)->first();
        if(isset($jobpostpoint)) {
            $jobPost = JobPost::findOrFail($jobpostpoint->job_post_id);
            $jobPost->update([
                'status' => 'Pending'
            ]);
        }

        if($order_update) {
            Alert::success('Success', 'Point Topup Successfully!');
            return redirect()->route('point-topup.index');
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
