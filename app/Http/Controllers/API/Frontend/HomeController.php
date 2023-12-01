<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\Slider;
use App\Models\Employer\JobPost;
use DB;
use Illuminate\Http\Request;
use App\Models\Admin\State;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;
use App\Models\Admin\Employer;

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
            ->orderBy('open_position', 'desc')->where('a.is_active',1)->whereNull('b.deleted_at')->where('b.is_active', 1)->where('a.status', 'Online')
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

    public function getTopEmployer()
    {
        $employers = DB::table('employers as a')
            ->join('package_with_package_items as b', 'a.package_id', '=', 'b.package_id')
            ->join('package_items as c', 'b.package_item_id', '=', 'c.id')
            ->where('c.name', '=', 'Top Employer')
            ->where('a.slug', '!=', null)
            ->select('a.id', 'a.logo', 'a.name', 'a.is_verified', 'a.slug')
            ->where('a.is_active', '=', 1)
            ->where('a.deleted_at', '=', null)
            ->orderBy('a.updated_at', 'desc')
            ->get()
            ->take(12);
        return response()->json([
            'status' => 'success',
            'top_employers' => $employers
        ], 200);
    }

    public function getTrendingJob()
    {
        $trending_jobs         = JobPost::with(['MainFunctionalArea:id,name', 'Township:id,name', 'Employer' => function ($query) {
            $query->select('id','employer_id','logo','name','is_verified','slug')->with('MainEmployer:id,logo,name,is_verified,slug');
        }])
                                ->whereIsActive(1)->whereStatus('Online')
                                ->orderBy('updated_at', 'desc')
                                ->whereJobPostType('trending')
                                ->select('job_title', 'employer_id', 'main_functional_area_id', 'township_id', 'hide_company', 'slug')
                                ->get()
                                ->take(18);
        return response()->json([
            'status' => 'success',
            'trending_jobs' => $trending_jobs
        ], 200);
    }

    public function getFeaturedJob()
    {
        $featured_jobs         = JobPost::with(['MainFunctionalArea:id,name', 'Township:id,name', 'Employer' => function ($query) {
            $query->select('id','employer_id','logo','name','is_verified','slug')->with('MainEmployer:id,logo,name,is_verified,slug');
        }])
                                ->whereIsActive(1)->whereStatus('Online')
                                ->orderBy('updated_at', 'desc')
                                ->whereJobPostType('feature')
                                ->select('job_title', 'employer_id', 'main_functional_area_id', 'township_id', 'hide_company', 'slug')
                                ->get()
                                ->take(20);
        return response()->json([
            'status' => 'success',
            'featured_jobs' => $featured_jobs
        ], 200);
    }

    public function getState()
    {
        $states = State::whereIsActive(1)->whereNull('deleted_at')->select('id', 'name')->get();
        return response()->json([
            'status' => 'success',
            'states' => $states
        ], 200);
    }

    public function getFunctionalArea()
    {
        $functional_areas = FunctionalArea::with('SubFunctionalArea:id,functional_area_id,name')->whereIsActive(1)->whereNull('deleted_at')->where('functional_area_id',0)->select('id', 'name', 'functional_area_id')->get();
        return response()->json([
            'status' => 'success',
            'functional_areas' => $functional_areas
        ], 200);
    }

    public function getAllCategory()
    {
        $industries = Industry::select('id', 'name', 'icon', 'color_code')->withCount(['JobPost' => function ($query) {
            $query->where('is_active',1)->where('status','Online');
        }])->whereIsActive(1)->whereNull('deleted_at')->get();
        $live_job   = JobPost::whereIsActive(1)->count();
        $today_job  = JobPost::whereIsActive(1)->whereDate('updated_at','=', date('Y-m-d', strtotime(now())))->count();
        return response()->json([
            'status' => 'success',
            'live_job' => $live_job,
            'today_job' => $today_job,
            'industries' => $industries
        ], 200);
    }

    public function getAllEmployer()
    {
        $employers = Employer::select('id', 'logo', 'name', 'is_verified', 'slug')->withCount(['JobPost' => function ($query) {
            $query->where('is_active',1)->where('status','Online');
        }])->whereIsActive(1)->whereNull('employer_id')->whereNull('deleted_at')->orderBy(DB::raw('FIELD(package_id, 1, 2, 3, 4)'))->paginate(20);
        return response()->json([
            'status' => 'success',
            'employers' => $employers,
        ], 200);
    }

    public function jobPostDetail(Request $request)
    {
        $this->validate($request, [
            'slug' => 'required'
        ]);
        $jobpost = JobPost::with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name', 'Employer' => function ($query) {
            $query->with('Industry:id,name')->with('MainEmployer:id,logo,name,is_verified,slug')->select('id', 'logo', 'employer_id', 'name', 'industry_id', 'summary', 'value', 'no_of_offices', 'website', 'no_of_employees', 'slug', 'is_verified');
        }])->whereSlug($request->slug)->select('id', 'employer_id', 'slug', 'job_title', 'main_functional_area_id', 'sub_functional_area_id', 'industry_id', 'career_level', 'job_type', 'experience_level', 'degree', 'gender', 'currency', 'salary_range', 'country', 'state_id', 'township_id', 'job_description', 'job_requirement', 'benefit', 'job_highlight', 'hide_salary', 'hide_company', 'no_of_candidate', 'job_post_type')->first();
        return response()->json([
            'status' => 'success',
            'jobpost' => $jobpost,
        ], 200);
    }

    public function companyJob(Request $request)
    {
        $employer = Employer::findOrFail($request->id);
        $member_ids = $employer->Member->pluck('id')->toArray();
        $employer_id = [];
        foreach($member_ids as $member_id) {
            $employer_id[] = $member_id;
        }
        
        $employer_id[] = $employer->id;
        $employer_id[] = $employer->employer_id;

        $jobPosts = JobPost::with(['MainFunctionalArea:id,name', 'Township:id,name', 'Employer' => function($query) {
                        $query->select('id','employer_id','logo','name','is_verified','slug')->with('MainEmployer:id,logo,name,is_verified,slug');
                    }])
                    ->where('is_active', 1)
                    ->where('status', 'Online')
                    ->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')
                    ->select('job_title', 'job_post_type','hide_company', 'job_requirement', 'township_id', 'main_functional_area_id', 'employer_id', 'slug', 'updated_at as posted_at')
                    ->orderBy('posted_at','desc')
                    ->whereIn('employer_id', $employer_id)
                    ->where('hide_company', 0)
                    ->paginate(10);
        return response()->json([
            'status' => 'success',
            'jobPosts' => $jobPosts,
        ], 200);
    }

    public function companyDetail(Request $request)
    {
        $employer = Employer::whereSlug($request->slug)->first();
        $member_ids = $employer->Member->pluck('id')->toArray();
        $employer_id = [];
        foreach($member_ids as $member_id) {
            $employer_id[] = $member_id;
        }
        
        $employer_id[] = $employer->id;
        $employer_id[] = $employer->employer_id;
        $employer = Employer::with(['EmployerMedia:id,employer_id,name,type', 'JobPost' => function($query) use ($employer_id) {
            $query->with(['MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'State:id,name', 'Township:id,name'])
                    ->select('id', 'employer_id', 'slug', 'job_title', 'main_functional_area_id', 'sub_functional_area_id', 'industry_id', 'career_level', 'job_type', 'experience_level', 'degree', 'gender', 'currency', 'salary_range', 'country', 'state_id', 'township_id', 'job_description', 'job_requirement', 'benefit', 'job_highlight', 'hide_salary', 'hide_company', 'no_of_candidate', 'job_post_type')
                    ->whereIn('employer_id', $employer_id)
                    ->take(6);
        }, 'Industry:id,name', 'EmployerAddress' => function($address) {
                        $address->with(['State:id,name', 'Township:id,name'])->select('id', 'employer_id', 'country', 'state_id', 'township_id');
                    }])
                    ->select('id','slug','background','logo','name','industry_id','no_of_employees','no_of_offices','value','summary', 'is_verified')->whereIsActive(1)
                    ->whereNull('deleted_at')
                    ->whereSlug($request->slug)
                    ->first();
        
        return response()->json([
            'status' => 'success',
            'employer' => $employer
        ], 200);
    }
}
