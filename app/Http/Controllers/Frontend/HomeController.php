<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Slider;
use App\Models\Admin\Industry;
use App\Models\Admin\Employer;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::whereNull('deleted_at')->whereIsActive(1)->orderBy('serial_no')->get();
        $industries = Industry::whereNull('deleted_at')->whereIsActive(1)->get()->take(8);
        $employers = Employer::whereNull('deleted_at')->whereIsActive(1)->get()->take(6);
        return view ('frontend.home', compact('sliders', 'industries', 'employers'));
    }
}
