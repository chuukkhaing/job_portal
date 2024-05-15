<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\InPersonBookingTime;

class InPersonBooking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function InPersonBookingTime()
    {
        return $this->belongsTo(InPersonBookingTime::class, 'in_person_booking_time_id');
    }
}
