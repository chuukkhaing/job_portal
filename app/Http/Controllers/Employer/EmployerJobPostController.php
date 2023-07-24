<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\JobPost;
use App\Models\Seeker\JobApply;
use App\Models\Seeker\Seeker;
use App\Models\Seeker\SeekerEducation;
use App\Models\Seeker\SeekerExperience;
use App\Models\Seeker\SeekerSkill;
use App\Models\Seeker\SeekerLanguage;
use App\Models\Seeker\SeekerReference;
use App\Models\Seeker\SeekerAttach;
use App\Models\Admin\Employer;
use App\Models\Admin\Package;
use App\Models\Admin\Industry;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Admin\FunctionalArea;
use App\Models\Employer\JobPostQuestion;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use Auth;
use Str;
use DB;
use PDF;

class EmployerJobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        $packages = Package::whereNull('deleted_at')->get();
        $industries = Industry::whereNull('deleted_at')->get();
        $states = State::whereNull('deleted_at')->get();
        $townships = Township::whereNull('deleted_at')->get();
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id','!=',0)->whereIsActive(1)->get();
        return view ('employer.profile.post-job', compact('packages', 'employer','industries', 'states', 'townships', 'functional_areas', 'sub_functional_areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'recruiter_phone' => ['nullable', new MyanmarPhone],
        ]);
        $gender = Null;
        if($request->male == 'on' && $request->female == 'on') {
            $gender = 'Male/Female';
        }elseif($request->male == 'on' && $request->female == '') {
            $gender = 'Male';
        }elseif($request->male == '' && $request->female == 'on') {
            $gender = 'Female';
        }
        $salary_range = Null;
        if($request->mmk_salary) {
            $salary_range = $request->mmk_salary;
        }else {
            $salary_range = $request->usd_salary;
        }
        if($request->hide_salary == 'on') {
            $hide_salary = 1;
        }else{
            $hide_salary = 0;
        }
        if($request->hide_company == 'on') {
            $hide_company = 1;
        }else{
            $hide_company = 0;
        }
        $jobPost = JobPost::create([
            'employer_id' => Auth::guard('employer')->user()->id,
            'job_title' => $request->job_title,
            'main_functional_area_id' => $request->main_functional_area_id,
            'sub_functional_area_id' => $request->sub_functional_area_id,
            'industry_id' => $request->job_post_industry_id,
            'career_level' => $request->career_level,
            'job_type' => $request->job_type,
            'experience_level' => $request->experience_level,
            'degree' => $request->degree,
            'gender' => $gender,
            'currency' => $request->currency,
            'salary_range' => $salary_range,
            'hide_salary' => $hide_salary,
            'hide_company' => $hide_company,
            'no_of_candidate' => $request->no_of_candidate,
            'recruiter_name' => $request->recruiter_name,
            'recruiter_email' => $request->recruiter_email,
            'recruiter_phone' => $request->recruiter_phone,
            'country' => $request->job_post_country,
            'state_id' => $request->job_post_state_id,
            'township_id' => $request->job_post_township_id,
            'job_description' => $request->job_description,
            'job_requirement' => $request->job_requirement,
            'benefit' => $request->benefit,
            'job_highlight' => $request->highlight,
            'job_post_type' => $request->job_post_type,
            'status' => 'Pending',
        ]);
        $slug = Str::slug($jobPost->job_title, '-') . '-' . $jobPost->id;
        $jobPost_slug = $jobPost->update([
            'slug' => $slug
        ]);
        foreach($request->questions as $key => $question) {
            foreach($request->answer_types as $answer_key => $answer_type) {
                if($key == $answer_key) {
                    $question_create = JobPostQuestion::create([
                        'employer_id' => Auth::guard('employer')->user()->id,
                        'job_post_id' => $jobPost->id,
                        'question' => $question,
                        'answer' => $answer_type
                    ]);
                }
            }
        }
        return redirect()->back()->with('success','Create Job Post Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getJobPost($id, $status)
    {
        $jobPost = JobPost::findOrFail($id);
        $jobApply = DB::table('job_applies as a')
                    ->join('seekers as b','a.seeker_id','=','b.id')
                    ->where('a.job_post_id','=',$id)
                    ->where('a.status',$status)
                    ->select('a.*', 'b.first_name as seeker_first_name', 'b.last_name as seeker_last_name', 'a.created_at as seeker_applied_date')
                    ->orderBy('seeker_applied_date','desc')
                    ->get();
        $seeker = 'no-seeker';
        $seeker_attach = [];
        $educations = [];
        $experiences = [];
        $skill_main_functional_areas = [];
        $skills = [];
        $languages = [];
        $references = [];
        if($jobApply->count() > 0){
            $seeker = Seeker::findOrFail($jobApply->first()->seeker_id);
            if($seeker->country == 'Myanmar') {
                $seeker = DB::table('seekers as a')
                            ->join('states as b', 'a.state_id', '=', 'b.id')
                            ->join('townships as c', 'a.township_id', '=', 'c.id')
                            ->where('a.id','=',$seeker->id)
                            ->select('a.*','b.name as state_name','c.name as township_name')
                            ->first();
            }
            $seeker_attach = SeekerAttach::whereSeekerId($seeker->id)->orderBy('updated_at','desc')->first();
            $educations = SeekerEducation::whereSeekerId($seeker->id)->get();
            $experiences = SeekerExperience::whereSeekerId($seeker->id)->first();
            if($experiences->is_experience == 1) {
                $experiences = DB::table('seeker_experiences as a')
                            ->where('a.seeker_id','=',$seeker->id)
                            ->join('industries as b','a.industry_id','=','b.id')
                            ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                            ->join('functional_areas as d','a.sub_functional_area_id','=','d.id')
                            ->select('a.*','b.name as industry_name', 'c.name as main_functional_area_name', 'd.name as sub_functional_area_name')
                            ->get();
            }
            $skill_main_functional_areas = DB::table('seeker_skills as a')
                            ->where('a.seeker_id','=',$seeker->id)
                            ->join('skills as b','a.skill_id','=','b.id')
                            ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                            ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                            ->groupBy('a.main_functional_area_id')
                            ->get();
            $skills = DB::table('seeker_skills as a')
                        ->where('a.seeker_id','=',$seeker->id)
                        ->join('skills as b','a.skill_id','=','b.id')
                        ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                        ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                        ->get();
            $languages = SeekerLanguage::whereSeekerId($seeker->id)->get();
            $references = SeekerReference::whereSeekerId($seeker->id)->get();
        }
        
        $received = JobApply::whereStatus('received')->whereJobPostId($id)->count();
        $viewed = JobApply::whereStatus('viewed')->whereJobPostId($id)->count();
        $shortlisted = JobApply::whereStatus('short-listed')->whereJobPostId($id)->count();
        $interview = JobApply::whereStatus('interview')->whereJobPostId($id)->count();
        $hire = JobApply::whereStatus('hire')->whereJobPostId($id)->count();
        $notsuitable = JobApply::whereStatus('not-suitable')->whereJobPostId($id)->count();
        $count = [];
        $count = [
            'received' => $received,
            'viewed' => $viewed,
            'shortlisted' => $shortlisted,
            'interview' => $interview,
            'hire' => $hire,
            'notsuitable' => $notsuitable,
        ];
        return response()->json([
            'status' => 'success',
            'jobPost' => $jobPost,
            'jobApply' => $jobApply,
            'seeker' => $seeker,
            'educations' => $educations,
            'experiences' => $experiences,
            'skills' => $skills,
            'skill_main_functional_areas' => $skill_main_functional_areas,
            'languages' => $languages,
            'references' => $references,
            'seeker_attach' => $seeker_attach,
            'count' => $count
        ]);
    }

    public function getJobPostInfo($id, $jobPostId, $status)
    {
        $jobPost = JobPost::findOrFail($jobPostId);
        $jobApply = DB::table('job_applies as a')
                    ->join('seekers as b','a.seeker_id','=','b.id')
                    ->where('a.job_post_id','=',$jobPostId)
                    ->where('a.status','=',$status)
                    ->select('a.*', 'b.first_name as seeker_first_name', 'b.last_name as seeker_last_name', 'a.created_at as seeker_applied_date')
                    ->orderBy('seeker_applied_date','desc')
                    ->get();
        $seeker = Seeker::findOrFail($id);
        if($seeker->country == 'Myanmar') {
            $seeker = DB::table('seekers as a')
                        ->join('states as b', 'a.state_id', '=', 'b.id')
                        ->join('townships as c', 'a.township_id', '=', 'c.id')
                        ->where('a.id','=',$id)
                        ->select('a.*','b.name as state_name','c.name as township_name')
                        ->first();
        }
        $educations = SeekerEducation::whereSeekerId($seeker->id)->get();
        $experiences = SeekerExperience::whereSeekerId($seeker->id)->first();
        $seeker_attach = SeekerAttach::whereSeekerId($seeker->id)->orderBy('updated_at','desc')->first();
        if($experiences->is_experience == 1) {
            $experiences = DB::table('seeker_experiences as a')
                        ->where('a.seeker_id','=',$seeker->id)
                        ->join('industries as b','a.industry_id','=','b.id')
                        ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                        ->join('functional_areas as d','a.sub_functional_area_id','=','d.id')
                        ->select('a.*','b.name as industry_name', 'c.name as main_functional_area_name', 'd.name as sub_functional_area_name')
                        ->get();
        }
        $skill_main_functional_areas = DB::table('seeker_skills as a')
                        ->where('a.seeker_id','=',$seeker->id)
                        ->join('skills as b','a.skill_id','=','b.id')
                        ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                        ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                        ->groupBy('a.main_functional_area_id')
                        ->get();
        $skills = DB::table('seeker_skills as a')
                    ->where('a.seeker_id','=',$seeker->id)
                    ->join('skills as b','a.skill_id','=','b.id')
                    ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                    ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                    ->get();
        $languages = SeekerLanguage::whereSeekerId($seeker->id)->get();
        $references = SeekerReference::whereSeekerId($seeker->id)->get();
        $received = JobApply::whereStatus('received')->whereJobPostId($jobPostId)->count();
        $viewed = JobApply::whereStatus('viewed')->whereJobPostId($jobPostId)->count();
        $shortlisted = JobApply::whereStatus('short-listed')->whereJobPostId($jobPostId)->count();
        $interview = JobApply::whereStatus('interview')->whereJobPostId($jobPostId)->count();
        $hire = JobApply::whereStatus('hire')->whereJobPostId($jobPostId)->count();
        $notsuitable = JobApply::whereStatus('not-suitable')->whereJobPostId($jobPostId)->count();
        $count = [];
        $count = [
            'received' => $received,
            'viewed' => $viewed,
            'shortlisted' => $shortlisted,
            'interview' => $interview,
            'hire' => $hire,
            'notsuitable' => $notsuitable,
        ];
        return response()->json([
            'status' => 'success',
            'jobPost' => $jobPost,
            'jobApply' => $jobApply,
            'seeker' => $seeker,
            'educations' => $educations,
            'experiences' => $experiences,
            'skills' => $skills,
            'skill_main_functional_areas' => $skill_main_functional_areas,
            'languages' => $languages,
            'references' => $references,
            'seeker_attach' => $seeker_attach,
            'count' => $count
        ]);
    }

    public function icFormatCVDownload($id)
    {
        $seeker = Seeker::findOrFail($id);
        $skill_main_functional_areas = DB::table('seeker_skills as a')
                        ->where('a.seeker_id','=',$seeker->id)
                        ->join('skills as b','a.skill_id','=','b.id')
                        ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                        ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                        ->groupBy('a.main_functional_area_id')
                        ->get();
        view()->share('seeker',$seeker);

        $pdf = PDF::loadView('download.ic_format_cv', compact('seeker','skill_main_functional_areas'));
        return $pdf->download($seeker->first_name.'_'.$seeker->last_name.'_ic_format_cv.pdf');
    }

    public function changeStatus($jobPostId, $seekerId, $status)
    {
        $jobPost = JobPost::findOrFail($jobPostId);
        $changeStatus = JobApply::whereSeekerId($seekerId)->whereJobPostId($jobPostId)->update(['status'=>$status]);
        $jobApply = DB::table('job_applies as a')
                    ->join('seekers as b','a.seeker_id','=','b.id')
                    ->where('a.job_post_id','=',$jobPostId)
                    ->where('a.status','=',$status)
                    ->select('a.*', 'b.first_name as seeker_first_name', 'b.last_name as seeker_last_name', 'a.created_at as seeker_applied_date')
                    ->orderBy('seeker_applied_date','desc')
                    ->get();
        $seeker = Seeker::findOrFail($seekerId);
        if($seeker->country == 'Myanmar') {
            $seeker = DB::table('seekers as a')
                        ->join('states as b', 'a.state_id', '=', 'b.id')
                        ->join('townships as c', 'a.township_id', '=', 'c.id')
                        ->where('a.id','=',$seekerId)
                        ->select('a.*','b.name as state_name','c.name as township_name')
                        ->first();
        }
        $educations = SeekerEducation::whereSeekerId($seeker->id)->get();
        $experiences = SeekerExperience::whereSeekerId($seeker->id)->first();
        $seeker_attach = SeekerAttach::whereSeekerId($seeker->id)->orderBy('updated_at','desc')->first();
        if($experiences->is_experience == 1) {
            $experiences = DB::table('seeker_experiences as a')
                        ->where('a.seeker_id','=',$seeker->id)
                        ->join('industries as b','a.industry_id','=','b.id')
                        ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                        ->join('functional_areas as d','a.sub_functional_area_id','=','d.id')
                        ->select('a.*','b.name as industry_name', 'c.name as main_functional_area_name', 'd.name as sub_functional_area_name')
                        ->get();
        }
        $skill_main_functional_areas = DB::table('seeker_skills as a')
                        ->where('a.seeker_id','=',$seeker->id)
                        ->join('skills as b','a.skill_id','=','b.id')
                        ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                        ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                        ->groupBy('a.main_functional_area_id')
                        ->get();
        $skills = DB::table('seeker_skills as a')
                    ->where('a.seeker_id','=',$seeker->id)
                    ->join('skills as b','a.skill_id','=','b.id')
                    ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                    ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                    ->get();
        $languages = SeekerLanguage::whereSeekerId($seeker->id)->get();
        $references = SeekerReference::whereSeekerId($seeker->id)->get();
        $received = JobApply::whereStatus('received')->whereJobPostId($jobPostId)->count();
        $viewed = JobApply::whereStatus('viewed')->whereJobPostId($jobPostId)->count();
        $shortlisted = JobApply::whereStatus('short-listed')->whereJobPostId($jobPostId)->count();
        $interview = JobApply::whereStatus('interview')->whereJobPostId($jobPostId)->count();
        $hire = JobApply::whereStatus('hire')->whereJobPostId($jobPostId)->count();
        $notsuitable = JobApply::whereStatus('not-suitable')->whereJobPostId($jobPostId)->count();
        $count = [];
        $count = [
            'received' => $received,
            'viewed' => $viewed,
            'shortlisted' => $shortlisted,
            'interview' => $interview,
            'hire' => $hire,
            'notsuitable' => $notsuitable,
        ];
        return response()->json([
            'status' => 'success',
            'jobPost' => $jobPost,
            'jobApply' => $jobApply,
            'seeker' => $seeker,
            'educations' => $educations,
            'experiences' => $experiences,
            'skills' => $skills,
            'skill_main_functional_areas' => $skill_main_functional_areas,
            'languages' => $languages,
            'references' => $references,
            'seeker_attach' => $seeker_attach,
            'count' => $count
        ]);
    }
}
