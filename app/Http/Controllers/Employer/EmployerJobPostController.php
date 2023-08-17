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
use App\Models\Admin\Skill;
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
use App\Models\Employer\JobPostSkill;
use App\Models\Admin\PackageItem;
use App\Models\Employer\PointRecord;
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
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        $industries = Industry::whereNull('deleted_at')->get();
        $states = State::whereNull('deleted_at')->get();
        $townships = Township::whereNull('deleted_at')->get();
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id','!=',0)->whereIsActive(1)->get();
        return view ('employer.profile.post-job', compact('packages', 'employer','industries', 'states', 'townships', 'functional_areas', 'sub_functional_areas', 'packageItems'));
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
            'job_title' => 'required|string',
            'job_post_industry' => 'required',
            'main_functional_area' => 'required',
            'sub_functional_area' => 'required',
            'career_level' => 'required',
            'job_type' => 'required',
            'experience_level' => 'required',
            'degree' => 'required',
            'no_of_candidate' => 'required',
            'recruiter_name' => 'required',
            'job_post_country' => 'required',
            'skills' => 'required',
            'job_description' => 'required',
            'job_requirement' => 'required',
            'job_post_type' => 'required'
        ]);
        if($request->job_post_country == "Myanmar") {
            $this->validate($request, [
                'job_post_state' => 'required'
            ]);
        }
        // if($request->total_point && $request->total_point > Auth::guard('employer')->user()->package_point) {
        //     return redirect()->back()->with('error','Your Balance Points are not enough to Post Job.');
        // }else {
        //     $gender = Null;
        //     if($request->male == 'on' && $request->female == 'on') {
        //         $gender = 'Male/Female';
        //     }elseif($request->male == 'on' && $request->female == '') {
        //         $gender = 'Male';
        //     }elseif($request->male == '' && $request->female == 'on') {
        //         $gender = 'Female';
        //     }
        //     $salary_range = Null;
        //     if($request->mmk_salary) {
        //         $salary_range = $request->mmk_salary;
        //     }else {
        //         $salary_range = $request->usd_salary;
        //     }
        //     if($request->hide_salary == 'on') {
        //         $hide_salary = 1;
        //     }else{
        //         $hide_salary = 0;
        //     }
        //     if($request->hide_company_name == 'on') {
        //         $hide_company = 1;
        //     }else{
        //         $hide_company = 0;
        //     }
        //     $jobPost = JobPost::create([
        //         'employer_id' => Auth::guard('employer')->user()->id,
        //         'job_title' => $request->job_title,
        //         'main_functional_area_id' => $request->main_functional_area,
        //         'sub_functional_area_id' => $request->sub_functional_area,
        //         'industry_id' => $request->job_post_industry,
        //         'career_level' => $request->career_level,
        //         'job_type' => $request->job_type,
        //         'experience_level' => $request->experience_level,
        //         'degree' => $request->degree,
        //         'gender' => $gender,
        //         'currency' => $request->currency,
        //         'salary_range' => $salary_range,
        //         'hide_salary' => $hide_salary,
        //         'hide_company' => $hide_company,
        //         'no_of_candidate' => $request->no_of_candidate,
        //         'recruiter_name' => $request->recruiter_name,
        //         'recruiter_email' => $request->recruiter_email,
        //         'country' => $request->job_post_country,
        //         'state_id' => $request->job_post_state,
        //         'township_id' => $request->job_post_township_id,
        //         'job_description' => $request->job_description,
        //         'job_requirement' => $request->job_requirement,
        //         'benefit' => $request->benefit,
        //         'job_highlight' => $request->highlight,
        //         'job_post_type' => $request->job_post_type,
        //         'status' => 'Pending',
        //         'total_point' => $request->total_point
        //     ]);
        //     $slug = Str::slug($jobPost->job_title, '-') . '-' . $jobPost->id;
        //     $jobPost_slug = $jobPost->update([
        //         'slug' => $slug
        //     ]);
        //     if($request->job_post_type == "trending") {
        //         $trending_record = PointRecord::create([
        //             'employer_id' => Auth::guard('employer')->user()->id,
        //             'job_post_id' => $jobPost->id,
        //             'package_item_id' => $request->trending_job_package_item_id,
        //             'point' => $request->trending_job_point,
        //             'status' => 'Pending'
        //         ]);
        //     }elseif($request->job_post_type == "feature") {
        //         $feature_record = PointRecord::create([
        //             'employer_id' => Auth::guard('employer')->user()->id,
        //             'job_post_id' => $jobPost->id,
        //             'package_item_id' => $request->feature_job_package_item_id,
        //             'point' => $request->feature_job_point,
        //             'status' => 'Pending'
        //         ]);
        //     }
        //     if($hide_company == 1) {
        //         $anonymous_record = PointRecord::create([
        //             'employer_id' => Auth::guard('employer')->user()->id,
        //             'job_post_id' => $jobPost->id,
        //             'package_item_id' => $request->anonymous_posting_package_item_id,
        //             'point' => $request->anonymous_posting_point,
        //             'status' => 'Pending'
        //         ]);
        //     }
        //     if($request->questions) {
        //         $question_record = PointRecord::create([
        //             'employer_id' => Auth::guard('employer')->user()->id,
        //             'job_post_id' => $jobPost->id,
        //             'package_item_id' => $request->question_package_item_id,
        //             'point' => $request->question_point,
        //             'status' => 'Pending'
        //         ]);
        //         foreach($request->questions as $key => $question) {
        //             foreach($request->answer_types as $answer_key => $answer_type) {
        //                 if($key == $answer_key) {
        //                     $question_create = JobPostQuestion::create([
        //                         'employer_id' => Auth::guard('employer')->user()->id,
        //                         'job_post_id' => $jobPost->id,
        //                         'question' => $question,
        //                         'answer' => $answer_type
        //                     ]);
        //                 }
        //             }
        //         }
        //     }
        //     if($request->skills) {
        //         foreach($request->skills as $key => $skill) {
        //             $skill_create = JobPostSkill::create([
        //                 'employer_id' => Auth::guard('employer')->user()->id,
        //                 'job_post_id' => $jobPost->id,
        //                 'skill_id' => $skill,
        //             ]);
        //         }
        //     }
        //     return redirect()->route('employer-profile.index')->with('success','Create Job Post Successfully.');
        // }
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
        $jobPost = JobPost::findOrFail($id);
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        $packages = Package::whereNull('deleted_at')->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        $industries = Industry::whereNull('deleted_at')->get();
        $states = State::whereNull('deleted_at')->get();
        $townships = Township::whereNull('deleted_at')->get();
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id','!=',0)->whereIsActive(1)->get();
        return view('employer.profile.post-job-edit', compact('packageItems', 'jobPost', 'packages', 'employer','industries', 'states', 'townships', 'functional_areas', 'sub_functional_areas'));
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
        if($request->total_point && $request->total_point > Auth::guard('employer')->user()->package_point) {
            return redirect()->back()->with('error','Your Balance Points are not enough to Post Job.');
        }else {
            $jobPost = JobPost::findOrFail($id);
            $gender = $jobPost->gender;
            if($request->male == 'on' && $request->female == 'on') {
                $gender = 'Male/Female';
            }elseif($request->male == 'on' && $request->female == '') {
                $gender = 'Male';
            }elseif($request->male == '' && $request->female == 'on') {
                $gender = 'Female';
            }
            $salary_range = $jobPost->salary_range;
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
            if($request->hide_company_name == 'on') {
                $hide_company = 1;
            }else{
                $hide_company = 0;
            }
            $jobPost_update = $jobPost->update([
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
                'country' => $request->job_post_country,
                'state_id' => $request->job_post_state_id,
                'township_id' => $request->job_post_township_id,
                'job_description' => $request->job_description,
                'job_requirement' => $request->job_requirement,
                'benefit' => $request->benefit,
                'job_highlight' => $request->highlight,
                'job_post_type' => $request->job_post_type,
                'total_point' => $request->total_point,
                'status' => 'Pending',
            ]);
            $slug = Str::slug($jobPost->job_title, '-') . '-' . $jobPost->id;
            $jobPost_slug = $jobPost->update([
                'slug' => $slug
            ]);
            if($request->job_post_type == "trending") {
                $trending_record_history = PointRecord::whereJobPostId($jobPost->id)->whereEmployerId($jobPost->employer_id)->wherePackageItemId($request->trending_job_package_item_id)->get();
                if($trending_record_history->count() == 0) {
                    $trending_record = PointRecord::create([
                        'employer_id' => Auth::guard('employer')->user()->id,
                        'job_post_id' => $jobPost->id,
                        'package_item_id' => $request->trending_job_package_item_id,
                        'point' => $request->trending_job_point,
                        'status' => 'Pending'
                    ]);
                }
            }elseif($request->job_post_type == "feature") {
                $feature_record_history = PointRecord::whereJobPostId($jobPost->id)->whereEmployerId($jobPost->employer_id)->wherePackageItemId($request->feature_job_package_item_id)->get();
                if($feature_record_history->count() == 0) {
                    $feature_record = PointRecord::create([
                        'employer_id' => Auth::guard('employer')->user()->id,
                        'job_post_id' => $jobPost->id,
                        'package_item_id' => $request->feature_job_package_item_id,
                        'point' => $request->feature_job_point,
                        'status' => 'Pending'
                    ]);
                }
            }
            if($hide_company == 1) {
                $anonymous_record_history = PointRecord::whereJobPostId($jobPost->id)->whereEmployerId($jobPost->employer_id)->wherePackageItemId($request->anonymous_posting_package_item_id)->get();
                if($anonymous_record_history->count() == 0) {
                    $anonymous_record = PointRecord::create([
                        'employer_id' => Auth::guard('employer')->user()->id,
                        'job_post_id' => $jobPost->id,
                        'package_item_id' => $request->anonymous_posting_package_item_id,
                        'point' => $request->anonymous_posting_point,
                        'status' => 'Pending'
                    ]);
                }
            }
            if($request->questions) {
                $question_record_history = PointRecord::whereJobPostId($jobPost->id)->whereEmployerId($jobPost->employer_id)->wherePackageItemId($request->question_package_item_id)->get();
                if($question_record_history->count() == 0) {
                    $question_record = PointRecord::create([
                        'employer_id' => Auth::guard('employer')->user()->id,
                        'job_post_id' => $jobPost->id,
                        'package_item_id' => $request->question_package_item_id,
                        'point' => $request->question_point,
                        'status' => 'Pending'
                    ]);
                }
                $delete_question = JobPostQuestion::whereJobPostId($jobPost->id)->delete();
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
            }
            if($request->skills) {
                $delete_skill = JobPostSkill::whereJobPostId($jobPost->id)->delete();
                foreach($request->skills as $key => $skill) {
                    $skill_create = JobPostSkill::create([
                        'employer_id' => Auth::guard('employer')->user()->id,
                        'job_post_id' => $jobPost->id,
                        'skill_id' => $skill,
                    ]);
                }
            }
        }
        return redirect()->route('employer-profile.index')->with('success','Update Job Post Successfully.');
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
        $item_id = Null;
        $packageItems = Auth::guard('employer')->user()->Package->PackageWithPackageItem;
        foreach($packageItems as $packageItem){
            if($packageItem->PackageItem->name == 'Application Unlock') {
                $item_id = $packageItem->PackageItem->id;
            }
        }
        
        $cvunlock = PointRecord::whereEmployerId($jobPost->employer_id)->whereJobPostId($jobPost->id)->wherePackageItemId($item_id)->get();
        
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
            'count' => $count,
            'cvunlock' => $cvunlock
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
            if($seeker->township_id) {
                $seeker = DB::table('seekers as a')
                        ->join('states as b', 'a.state_id', '=', 'b.id')
                        ->join('townships as c', 'a.township_id', '=', 'c.id')
                        ->where('a.id','=',$id)
                        ->select('a.*','b.name as state_name','c.name as township_name')
                        ->first();
            }else {
                $seeker = DB::table('seekers as a')
                        ->join('states as b', 'a.state_id', '=', 'b.id')
                        ->where('a.id','=',$id)
                        ->select('a.*','b.name as state_name')
                        ->first();
            }
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
        $item_id = Null;
        $packageItems = Auth::guard('employer')->user()->Package->PackageWithPackageItem;
        foreach($packageItems as $packageItem){
            if($packageItem->PackageItem->name == 'Application Unlock') {
                $item_id = $packageItem->PackageItem->id;
            }
        }
        
        $cvunlock = PointRecord::whereEmployerId($jobPost->employer_id)->whereJobPostId($jobPost->id)->wherePackageItemId($item_id)->get();
        
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
            'count' => $count,
            'cvunlock' => $cvunlock
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

    public function getSkill($id)
    {
        $skills = Skill::whereNull('deleted_at')->where('main_functional_area_id',$id)->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data' => $skills
        ]);
    }

    public function changeJobPostStatus(Request $request)
    {
        $jobPost_update = JobPost::whereId($request->id)->update([
            'is_active' => $request->status
        ]);
        $jobPost = JobPost::findOrFail($request->id);
        return response()->json([
            'status' => 'success',
            'data' => $jobPost
        ]);
    }

    public function unlockApplication(Request $request)
    {
        $point = 0;
        $item_id = Null;
        $packageItems = Auth::guard('employer')->user()->Package->PackageWithPackageItem;
        foreach($packageItems as $packageItem){
            if($packageItem->PackageItem->name == 'Application Unlock') {
                $point = $packageItem->PackageItem->point;
                $item_id = $packageItem->PackageItem->id;
            }
        }
        $cvunlock = PointRecord::whereEmployerId($request->employer_id)->whereJobPostId($request->jobPost_id)->whereJobApplyId($request->jobApply_id)->wherePackageItemId($item_id)->get();
        if($cvunlock->count() == 0) {
            $cvunlock = PointRecord::create([
                'employer_id' => $request->employer_id,
                'job_post_id' => $request->jobPost_id,
                'job_apply_id' => $request->jobApply_id,
                'package_item_id' => $item_id,
                'point' => $point,
                'status' => 'Complete'
            ]);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $cvunlock
        ]);
    }
}
