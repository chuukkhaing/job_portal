<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\OnlineBooking;
use App\Models\Admin\OnlineBookingTime;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;

class OnlineBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => ['required', new MyanmarPhone],
            'description' => 'required',
            'date' => 'required|date',
            'time_id' => 'required',
        ]);
        OnlineBooking::create([
            'date' => date('Y-m-d', strtotime($request->date)),
            'online_booking_time_id' => $request->time_id,
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'remark' => $request->description,
            'is_available' => false,
        ]);
        return response()->json([
            'status' => 'success',
            'msg' => 'Online Booking Successfully send!'
        ], 200);
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

    public function getCloseTimeByDate(Request $request)
    {
        $this->validate($request, [
            'date'    => 'required|date'
        ]);
        $unavailable_time_by_date = OnlineBooking::with('OnlineBookingTime:id,time')->where('date', date('Y-m-d',strtotime($request->date)))->select('id','date','online_booking_time_id')->get();
        $default_available_times = OnlineBookingTime::where('is_active', 1)->select('id','time')->get();
        return response()->json([
            'status' => 'success',
            'unavailable_time_by_date' => $unavailable_time_by_date,
            'default_available_times' => $default_available_times,
        ], 200);
    }
}
