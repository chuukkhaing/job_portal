<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Employer;
use App\Models\Admin\FeedBack;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;
use App\Models\Admin\Slider;
use App\Models\Employer\JobPost;
use DB;
use Illuminate\Http\Request;
use App\Models\Admin\State;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;

class HomeController extends Controller
{
    public function index()
    {
        $sliders  = Slider::whereNull('deleted_at')->whereIsActive(1)->orderBy('serial_no')->get();
        $industries = JobPost::select('industry_id', DB::raw('count(*) as total'))
            ->groupBy('industry_id')
            ->orderBy('total', 'desc')->whereIsActive(1)->whereStatus('Online')
            ->get()->take(8);
        $employers  = DB::table('employers as a')
                        ->join('package_with_package_items as b','a.package_id','=','b.package_id')
                        ->join('package_items as c','b.package_item_id','=','c.id')
                        ->where('c.name','=','Top Employer')
                        ->select('a.*')
                        ->where('a.is_active','=',1)
                        ->where('a.deleted_at','=',Null)
                        ->orderBy('a.updated_at','desc')
                        ->get()
                        ->take(6);
        $live_job              = JobPost::whereIsActive(1)->count();
        $today_job             = JobPost::whereIsActive(1)->where('updated_at', date('Y-m-d', strtotime(now())))->count();
        $functional_areas      = FunctionalArea::whereIsActive(1)->whereNull('deleted_at')->get();
        $main_functional_areas = FunctionalArea::whereIsActive(1)->where('functional_area_id', 0)->whereNull('deleted_at')->get();
        $sub_functional_areas  = FunctionalArea::whereIsActive(1)->where('functional_area_id', '!=', 0)->whereNull('deleted_at')->get();
        $states                = State::whereIsActive(1)->whereNull('deleted_at')->get();
        return view('frontend.home', compact('states', 'sliders', 'industries', 'employers', 'live_job', 'today_job', 'functional_areas', 'main_functional_areas', 'sub_functional_areas'));
    }

    public function jobCategory()
    {
        $industries = Industry::whereNull('deleted_at')->whereIsActive(1)->get();
        $live_job   = JobPost::whereIsActive(1)->count();
        $today_job  = JobPost::whereIsActive(1)->where('updated_at', date('Y-m-d', strtotime(now())))->count();
        return view('frontend.all-categories', compact('industries', 'live_job', 'today_job'));
    }

    public function contactUs()
    {
        return view('frontend.contact');
    }

    public function contactUsCreate(Request $request)
    {
        $request->validate([
            'phone' => ['nullable', new MyanmarPhone],
        ]);

        $feedback = FeedBack::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'description' => $request->description,
        ]);

        if ($feedback) {
            return redirect()->back()->with('success', 'Thank you for your interesting.');
        }
    }

    public function findJobs()
    {
        $main_functional_areas = FunctionalArea::whereIsActive(1)->where('functional_area_id', 0)->whereNull('deleted_at')->get();
        $sub_functional_areas  = FunctionalArea::whereIsActive(1)->where('functional_area_id', '!=', 0)->whereNull('deleted_at')->get();
        $states                = State::whereIsActive(1)->whereNull('deleted_at')->get();
        $jobPosts = JobPost::where('is_active',1)->where('status','Online')->paginate(10);
        return view('frontend.find-jobs', compact('jobPosts', 'states', 'sub_functional_areas', 'main_functional_areas'));
    }

    public function searchJob(Request $request)
    {
        $main_functional_areas = FunctionalArea::whereIsActive(1)->where('functional_area_id', 0)->whereNull('deleted_at')->get();
        $sub_functional_areas  = FunctionalArea::whereIsActive(1)->where('functional_area_id', '!=', 0)->whereNull('deleted_at')->get();
        $states                = State::whereIsActive(1)->whereNull('deleted_at')->get();
        $jobPosts = JobPost::where('is_active',1)->where('status','Online')->get();
        $jobPosts = JobPost::where('is_active',1);
        if($request->job_title) {
            $jobPosts = $jobPosts->where('job_title','like','%'.$request->job_title.'%');
        }
        if($request->function_area) {
            $jobPosts = $jobPosts->whereIn('sub_functional_area_id', $request->function_area);
        }
        if($request->location) {
            $jobPosts = $jobPosts->where('state_id',$request->location);
        }
        $jobPosts = $jobPosts->where('status','Online')->paginate(10);
        return view('frontend.find-jobs', compact('jobPosts', 'states', 'sub_functional_areas', 'main_functional_areas'));
    }

    public function companies()
    {
        $employers = Employer::whereIsActive(1)->whereNull('deleted_at')->paginate(6);
        return view('frontend.company');
    }

    public function industryJob($id)
    {
        $main_functional_areas = FunctionalArea::whereIsActive(1)->where('functional_area_id', 0)->whereNull('deleted_at')->get();
        $sub_functional_areas  = FunctionalArea::whereIsActive(1)->where('functional_area_id', '!=', 0)->whereNull('deleted_at')->get();
        $states                = State::whereIsActive(1)->whereNull('deleted_at')->get();
        $jobPosts = JobPost::where('is_active',1)->where('status','Online')->where('industry_id',$id)->paginate(10);
        return view('frontend.find-jobs', compact('jobPosts', 'states', 'sub_functional_areas', 'main_functional_areas'));
    }
}
