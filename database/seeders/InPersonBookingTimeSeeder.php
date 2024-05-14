<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\InPersonBookingTime;

class InPersonBookingTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $times = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00'];
        foreach($times as $time) {
            InPersonBookingTime::create([
                'time' => $time
            ]);
        }
    }
}
