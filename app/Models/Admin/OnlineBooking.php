<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\OnlineBookingTime;

class OnlineBooking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function OnlineBookingTime()
    {
        return $this->belongsTo(OnlineBookingTime::class, 'online_booking_time_id');
    }
}
