<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Employer;
use App\Models\Admin\FeedBack;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;
use App\Models\Admin\Package;
use App\Models\Admin\Slider;
use App\Models\Admin\State;
use App\Models\Employer\JobPost;
use DB;
use Illuminate\Http\Request;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;

class HomeController extends Controller
{
    public function index()
    {
        $sliders    = Slider::whereNull('deleted_at')->whereIsActive(1)->orderBy('serial_no')->get();
        $industries = JobPost::select('industry_id', DB::raw('count(*) as total'))
            ->groupBy('industry_id')
            ->orderBy('total', 'desc')->whereIsActive(1)->whereStatus('Online')
            ->get()->take(8);
        $employers = DB::table('employers as a')
            ->join('package_with_package_items as b', 'a.package_id', '=', 'b.package_id')
            ->join('package_items as c', 'b.package_item_id', '=', 'c.id')
            ->where('c.name', '=', 'Top Employer')
            ->where('a.slug', '!=', null)
            ->select('a.*')
            ->where('a.is_active', '=', 1)
            ->where('a.deleted_at', '=', null)
            ->orderBy('a.updated_at', 'desc')
            ->get()
            ->take(6);
        $trending_jobs         = JobPost::whereIsActive(1)->whereStatus('Online')->orderBy('updated_at', 'desc')->whereJobPostType('trending')->get()->take(18);
        $feature_jobs          = JobPost::whereIsActive(1)->whereStatus('Online')->orderBy('updated_at', 'desc')->whereJobPostType('feature')->get()->take(20);
        $live_job              = JobPost::whereIsActive(1)->count();
        $packages              = Package::whereNull('deleted_at')->get();
        $today_job             = JobPost::whereIsActive(1)->where('updated_at', date('Y-m-d', strtotime(now())))->count();
        $functional_areas      = FunctionalArea::whereIsActive(1)->whereNull('deleted_at')->get();
        $main_functional_areas = FunctionalArea::whereIsActive(1)->where('functional_area_id', 0)->whereNull('deleted_at')->get();
        $sub_functional_areas  = FunctionalArea::whereIsActive(1)->where('functional_area_id', '!=', 0)->whereNull('deleted_at')->get();
        $states                = State::whereIsActive(1)->whereNull('deleted_at')->get();
        return view('frontend.home', compact('packages', 'feature_jobs', 'trending_jobs', 'states', 'sliders', 'industries', 'employers', 'live_job', 'today_job', 'functional_areas', 'main_functional_areas', 'sub_functional_areas'));
    }

    public function jobCategory()
    {
        $industries = Industry::whereNull('deleted_at')->whereIsActive(1)->get();
        $live_job   = JobPost::whereIsActive(1)->count();
        $packages   = Package::whereNull('deleted_at')->get();
        $today_job  = JobPost::whereIsActive(1)->where('updated_at', date('Y-m-d', strtotime(now())))->count();
        return view('frontend.all-categories', compact('packages', 'industries', 'live_job', 'today_job'));
    }

    public function contactUs()
    {
        $packages = Package::whereNull('deleted_at')->get();
        return view('frontend.contact', compact('packages'));
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
        $packages              = Package::whereNull('deleted_at')->get();
        $main_functional_areas = FunctionalArea::whereIsActive(1)->where('functional_area_id', 0)->whereNull('deleted_at')->get();
        $sub_functional_areas  = FunctionalArea::whereIsActive(1)->where('functional_area_id', '!=', 0)->whereNull('deleted_at')->get();
        $states                = State::whereIsActive(1)->whereNull('deleted_at')->get();
        $jobPosts              = JobPost::where('is_active', 1)->where('status', 'Online')->orderBy('updated_at', 'desc')->paginate(10);
        $trending_jobs         = JobPost::whereIsActive(1)->whereStatus('Online')->orderBy('updated_at', 'desc')->whereJobPostType('trending')->get()->take(5);
        $feature_jobs          = JobPost::whereIsActive(1)->whereStatus('Online')->orderBy('updated_at', 'desc')->whereJobPostType('feature')->get()->take(5);
        return view('frontend.find-jobs', compact('packages', 'trending_jobs', 'feature_jobs', 'jobPosts', 'states', 'sub_functional_areas', 'main_functional_areas'));
    }

    public function searchJob(Request $request)
    {
        $main_functional_areas = FunctionalArea::whereIsActive(1)->where('functional_area_id', 0)->whereNull('deleted_at')->get();
        $sub_functional_areas  = FunctionalArea::whereIsActive(1)->where('functional_area_id', '!=', 0)->whereNull('deleted_at')->get();
        $states                = State::whereIsActive(1)->whereNull('deleted_at')->get();
        $jobPosts              = JobPost::where('is_active', 1)->where('status', 'Online')->get();
        $jobPosts              = JobPost::where('is_active', 1);
        if ($request->job_title) {
            $jobPosts = $jobPosts->where('job_title', 'like', '%' . $request->job_title . '%');
        }
        if ($request->function_area) {
            $jobPosts = $jobPosts->whereIn('sub_functional_area_id', $request->function_area);
        }
        if ($request->location) {
            $jobPosts = $jobPosts->where('state_id', $request->location);
        }
        $jobPosts      = $jobPosts->where('status', 'Online')->orderBy('updated_at', 'desc')->paginate(10);
        $trending_jobs = JobPost::whereIsActive(1)->whereStatus('Online')->orderBy('updated_at', 'desc')->whereJobPostType('trending')->get()->take(5);
        $feature_jobs  = JobPost::whereIsActive(1)->whereStatus('Online')->orderBy('updated_at', 'desc')->whereJobPostType('feature')->get()->take(5);
        return view('frontend.find-jobs', compact('trending_jobs', 'feature_jobs', 'jobPosts', 'states', 'sub_functional_areas', 'main_functional_areas'));
    }

    public function companies()
    {
        $packages  = Package::whereNull('deleted_at')->get();
        $employers = Employer::whereIsActive(1)->whereNull('deleted_at')->orderBy(DB::raw('FIELD(package_id, 1, 2, 3, 4)'))->paginate(6);
        return view('frontend.company', compact('packages', 'employers'));
    }

    public function industryJob($id)
    {
        $packages              = Package::whereNull('deleted_at')->get();
        $main_functional_areas = FunctionalArea::whereIsActive(1)->where('functional_area_id', 0)->whereNull('deleted_at')->get();
        $sub_functional_areas  = FunctionalArea::whereIsActive(1)->where('functional_area_id', '!=', 0)->whereNull('deleted_at')->get();
        $states                = State::whereIsActive(1)->whereNull('deleted_at')->get();
        $jobPosts              = JobPost::where('is_active', 1)->where('status', 'Online')->orderBy('updated_at', 'desc')->where('industry_id', $id)->paginate(10);
        $trending_jobs         = JobPost::whereIsActive(1)->whereStatus('Online')->orderBy('updated_at', 'desc')->whereJobPostType('trending')->get()->take(5);
        $feature_jobs          = JobPost::whereIsActive(1)->whereStatus('Online')->orderBy('updated_at', 'desc')->whereJobPostType('feature')->get()->take(5);
        return view('frontend.find-jobs', compact('packages', 'trending_jobs', 'feature_jobs', 'jobPosts', 'states', 'sub_functional_areas', 'main_functional_areas'));
    }

    public function findCompany(Request $request)
    {
        $packages  = Package::whereNull('deleted_at')->get();
        $employers = Employer::whereIsActive(1)->where('name', 'like', '%' . $request->company_name . '%')->whereNull('deleted_at')->orderBy(DB::raw('FIELD(package_id, 1, 2, 3, 4)'))->paginate(6);
        return view('frontend.company', compact('packages', 'employers'));
    }

    public function aboutUs(Request $request)
    {
        $packages = Package::whereNull('deleted_at')->get();
        return view('frontend.about', compact('packages'));
    }

    public function termsOfUse(Request $request)
    {
        $packages = Package::whereNull('deleted_at')->get();
        return view('frontend.terms-of-use', compact('packages'));
    }

    public function privacyPolicy(Request $request)
    {
        $packages = Package::whereNull('deleted_at')->get();
        return view('frontend.privacy-policy', compact('packages'));
    }
}
