<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Slider;
use App\Models\Admin\Industry;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;
use App\Models\Admin\FeedBack;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::whereNull('deleted_at')->whereIsActive(1)->orderBy('serial_no')->get();
        $jobPosts = JobPost::select('industry_id', DB::raw('count(*) as total'))
                 ->groupBy('industry_id')
                 ->orderBy('total', 'desc')->whereIsActive(1)
                 ->get()->take(8);
        $employers = Employer::whereNull('deleted_at')->whereNotNull('logo')->orderBy('updated_at','desc')->whereIsActive(1)->get()->take(6);
        $live_job = JobPost::whereIsActive(1)->count();
        $today_job = JobPost::whereIsActive(1)->where('updated_at',date('Y-m-d', strtotime(now())))->count();
        return view ('frontend.home', compact('sliders', 'jobPosts', 'employers', 'live_job', 'today_job'));
    }

    public function jobCategory()
    {
        $industries = Industry::whereNull('deleted_at')->whereIsActive(1)->get();
        $live_job = JobPost::whereIsActive(1)->count();
        $today_job = JobPost::whereIsActive(1)->where('updated_at',date('Y-m-d', strtotime(now())))->count();
        return view ('frontend.all-categories', compact('industries', 'live_job', 'today_job'));
    }

    public function contactUs()
    {
        return view ('frontend.contact');
    }

    public function contactUsCreate(Request $request)
    {
        $request->validate([
            'phone' => ['nullable', new MyanmarPhone],
        ]);

        $feedback = FeedBack::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description
        ]);

        if($feedback) {
            return redirect()->back()->with('success','Thank you for your interesting.');
        }
    }
}
