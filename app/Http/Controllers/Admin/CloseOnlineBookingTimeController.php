<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\OnlineBookingTime;
use App\Models\Admin\OnlineBooking;
use Alert;
use Auth;

class CloseOnlineBookingTimeController extends Controller
{
    public function index()
    {
        $onlineBookings = OnlineBooking::where('is_admin',1)->get();
        return view('admin.booking-schedule.online.unavailable.index', compact('onlineBookings'));
    }

    public function create()
    {
        $times = OnlineBookingTime::get();
        return view('admin.booking-schedule.online.unavailable.create', compact('times'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time_id' => 'required',
        ]);
        $check_booking = OnlineBooking::where('date', date('Y-m-d',strtotime($request->date)))->whereIn('online_booking_time_id',$request->time_id)->get();
        if($check_booking->count() > 0) {
            Alert::error('Error', 'Fail!');
            return redirect()->route('close-online-booking-time.index');
        }else {
            foreach($request->time_id as $time)
            {
                OnlineBooking::create([
                    'date' => date('Y-m-d', strtotime($request->date)),
                    'online_booking_time_id' => $time,
                    'remark' => $request->remark,
                    'is_available' => false,
                    'is_admin' => true,
                    'status' => 'Close',
                    'created_by' => Auth::user()->id,
                ]);
            }
            Alert::success('Success', 'Online Booking Unavailable Time Set Successfully!');
            return redirect()->route('close-online-booking-time.index');
        }
    }
}
