<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Slider;
use App\Models\Employer\JobPost;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getSlider()
    {
        $sliders    = Slider::whereNull('deleted_at')->whereIsActive(1)->orderBy('serial_no')->select('id','image')->get();
        return response()->json([
            'status' => 'success',
            'sliders' => $sliders
        ], 200);
    }

    public function getPopularCategory()
    {
        $industries = DB::table('job_posts as a')->select('b.name','b.icon','b.color_code', DB::raw('count(*) as open_position'))
            ->join('industries as b', 'b.id','=','a.industry_id')
            ->groupBy('a.industry_id')
            ->orderBy('open_position', 'desc')->where('a.is_active',1)->where('a.status', 'Online')
            ->get()->take(8);
        $live_job_post              = JobPost::whereIsActive(1)->count();
        $today_job_post             = JobPost::whereIsActive(1)->whereDate('updated_at','=', date('Y-m-d', strtotime(now())))->count();
        return response()->json([
            'status' => 'success',
            'industries' => $industries,
            'live_job_post' => $live_job_post,
            'today_job_post' => $today_job_post
        ], 200);
    }
}
