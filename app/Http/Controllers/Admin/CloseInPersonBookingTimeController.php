<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\InPersonBookingTime;
use App\Models\Admin\InPersonBooking;
use Alert;
use Auth;

class CloseInPersonBookingTimeController extends Controller
{
    public function index()
    {
        $inpersonBookings = InPersonBooking::where('is_admin',1)->get();
        return view('admin.booking-schedule.inperson.unavailable.index', compact('inpersonBookings'));
    }

    public function create()
    {
        $times = InPersonBookingTime::get();
        return view('admin.booking-schedule.inperson.unavailable.create', compact('times'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time_id' => 'required',
        ]);
        $check_booking = InPersonBooking::where('date', date('Y-m-d',strtotime($request->date)))->whereIn('in_person_booking_time_id',$request->time_id)->get();
        if($check_booking->count() > 0) {
            Alert::error('Error', 'Fail!');
            return redirect()->route('close-inperson-booking-time.index');
        }else {
            foreach($request->time_id as $time)
            {
                InPersonBooking::create([
                    'date' => date('Y-m-d', strtotime($request->date)),
                    'in_person_booking_time_id' => $time,
                    'remark' => $request->remark,
                    'is_available' => false,
                    'is_admin' => true,
                    'status' => 'Close',
                    'created_by' => Auth::user()->id,
                ]);
            }
            Alert::success('Success', 'In-Person Booking Unavailable Time Set Successfully!');
            return redirect()->route('close-inperson-booking-time.index');
        }
    }
}
