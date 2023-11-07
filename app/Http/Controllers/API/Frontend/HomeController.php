<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Slider;
use App\Models\Employer\JobPost;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getSliderandIndustry()
    {
        $sliders    = Slider::whereNull('deleted_at')->whereIsActive(1)->orderBy('serial_no')->pluck('id')->toArray();
        $industries = JobPost::select('industry_id', DB::raw('count(*) as total'))
            ->groupBy('industry_id')
            ->orderBy('total', 'desc')->whereIsActive(1)->whereStatus('Online')
            ->pluck('industry_id')
            ->take(8)
            ->toArray();
        return response()->json([
            'sliders' => $sliders,
            'industries' => $industries
        ], 200);
    }
}
