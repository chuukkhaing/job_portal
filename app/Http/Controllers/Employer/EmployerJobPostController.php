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
use App\Models\Admin\PointPackage;
use App\Models\Admin\PointOrder;
use App\Models\Employer\JobPostPointDetect;
use App\Models\Seeker\SeekerJobPostAnswer;
use Auth;
use Str;
use DB;
use PDF;
use App\Models\Admin\Invoice;
use App\Models\Admin\BankInfo;
use App\Models\Admin\Tax;
use Storage;

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
        $pointPackages = PointPackage::whereNull('deleted_at')->whereIsActive(1)->get();
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        $industries = Industry::whereNull('deleted_at')->get();
        $states = State::whereNull('deleted_at')->get();
        $townships = Township::whereNull('deleted_at')->get();
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id','!=',0)->whereIsActive(1)->get();
        return view ('employer.profile.post-job', compact('pointPackages', 'packages', 'employer','industries', 'states', 'townships', 'functional_areas', 'sub_functional_areas', 'packageItems'));
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
            'job_post_type' => 'required',
            'job_post_state' => ['required_if:job_post_country,Myanmar']
        ]);

        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }

        if($request->total_point && $request->total_point > $employer->package_point) {
            return redirect()->back()->with('warning','Your Balance Points are not enough to Post Job.');
        }else {
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
            if($request->hide_company_name == 'on') {
                $hide_company = 1;
            }else{
                $hide_company = 0;
            }
            $jobPost = JobPost::create([
                'employer_id' => Auth::guard('employer')->user()->id,
                'job_title' => $request->job_title,
                'main_functional_area_id' => $request->main_functional_area,
                'sub_functional_area_id' => $request->sub_functional_area,
                'industry_id' => $request->job_post_industry,
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
                'state_id' => $request->job_post_state,
                'township_id' => $request->job_post_township_id,
                'job_description' => $request->job_description,
                'job_requirement' => $request->job_requirement,
                'benefit' => $request->benefit,
                'job_highlight' => $request->highlight,
                'job_post_type' => $request->job_post_type,
                'status' => $request->status,
                'total_point' => $request->total_point
            ]);
            $slug = Str::slug($jobPost->job_title, '-') . '-' . $jobPost->id;
            $jobPost_slug = $jobPost->update([
                'slug' => $slug
            ]);
            if($request->job_post_type == "trending") {
                $trending_record = PointRecord::create([
                    'employer_id' => Auth::guard('employer')->user()->id,
                    'job_post_id' => $jobPost->id,
                    'package_item_id' => $request->trending_job_package_item_id,
                    'point' => $request->trending_job_point,
                    'status' => 'Pending'
                ]);
            }elseif($request->job_post_type == "feature") {
                $feature_record = PointRecord::create([
                    'employer_id' => Auth::guard('employer')->user()->id,
                    'job_post_id' => $jobPost->id,
                    'package_item_id' => $request->feature_job_package_item_id,
                    'point' => $request->feature_job_point,
                    'status' => 'Pending'
                ]);
            }
            if($hide_company == 1) {
                $anonymous_record = PointRecord::create([
                    'employer_id' => Auth::guard('employer')->user()->id,
                    'job_post_id' => $jobPost->id,
                    'package_item_id' => $request->anonymous_posting_package_item_id,
                    'point' => $request->anonymous_posting_point,
                    'status' => 'Pending'
                ]);
            }
            if($request->questions) {
                $question_record = PointRecord::create([
                    'employer_id' => Auth::guard('employer')->user()->id,
                    'job_post_id' => $jobPost->id,
                    'package_item_id' => $request->question_package_item_id,
                    'point' => $request->question_point,
                    'status' => 'Pending'
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
            }
            if($request->skills) {
                foreach($request->skills as $key => $skill) {
                    $skill_create = JobPostSkill::create([
                        'employer_id' => Auth::guard('employer')->user()->id,
                        'job_post_id' => $jobPost->id,
                        'skill_id' => $skill,
                    ]);
                }
            }

            if($jobPost->job_post_type == 'standard') {
                $jobpostType = "Standard";
            }elseif($jobPost->job_post_type == 'trending') {
                $jobpostType = "Trending";
            }elseif($jobPost->job_post_type == 'feature') {
                $jobpostType = "Feature";
            }
            return redirect()->route('manageJob')->with('success','Your '.$jobpostType. ' Job Post has been created successfully.');
        }
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
        $pointPackages = PointPackage::whereNull('deleted_at')->whereIsActive(1)->get();
        $jobPost = JobPost::findOrFail($id);
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        $industries = Industry::whereNull('deleted_at')->get();
        $states = State::whereNull('deleted_at')->get();
        $townships = Township::whereNull('deleted_at')->get();
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id','!=',0)->whereIsActive(1)->get();
        return view('employer.profile.post-job-edit', compact('pointPackages', 'packageItems', 'jobPost', 'packages', 'employer','industries', 'states', 'townships', 'functional_areas', 'sub_functional_areas'));
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
            'job_post_type' => 'required',
            'job_post_state' => ['required_if:job_post_country,Myanmar']
        ]);
        if($request->total_point && $request->total_point > Auth::guard('employer')->user()->package_point) {
            return redirect()->back()->with('warning','Your Balance Points are not enough to Post Job.');
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
            $slug = Str::slug($jobPost->job_title, '-') . '-' . $jobPost->id;
            $jobPost_update = $jobPost->update([
                'job_title' => $request->job_title,
                'main_functional_area_id' => $request->main_functional_area,
                'sub_functional_area_id' => $request->sub_functional_area,
                'industry_id' => $request->job_post_industry,
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
                'state_id' => $request->job_post_state,
                'township_id' => $request->job_post_township_id,
                'job_description' => $request->job_description,
                'job_requirement' => $request->job_requirement,
                'benefit' => $request->benefit,
                'job_highlight' => $request->highlight,
                'job_post_type' => $request->job_post_type,
                'total_point' => $request->total_point,
                'status' => $request->status,
                'slug' => $slug
            ]);
            
            if(count($jobPost->getChanges()) > 0 && $request->status != 'Draft') {
                $jobPost_status = $jobPost->update([
                    'status' => "Pending"
                ]);
            }
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
        if($jobPost->job_post_type == 'standard') {
            $jobpostType = "Standard";
        }elseif($jobPost->job_post_type == 'trending') {
            $jobpostType = "Trending";
        }elseif($jobPost->job_post_type == 'feature') {
            $jobpostType = "Feature";
        }
        if(count($jobPost->getChanges()) > 0 && $request->status != 'Draft') {
            return redirect()->route('manageJob')->with('success','Your '.$jobpostType.' Job Post has been updated Successfully.');
        }elseif(count($jobPost->getChanges()) > 0 && $request->status == 'Draft') {
            return redirect()->route('manageJob')->with('success','Your Job Post has been updated as Draft Successfully.');
        }elseif(count($jobPost->getChanges()) == 0) {
            return redirect()->route('manageJob')->with('info','There is no Changes In your Job Post.');
        }
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
        $seeker_img = '';
        $seeker_cv = '';
        $answers = [];
        if($jobApply->count() > 0){
            $seeker = Seeker::findOrFail($jobApply->first()->seeker_id);
            $image = $seeker->image;
            if($seeker->country == 'Myanmar') {
                $seeker = DB::table('seekers as a')
                            ->join('states as b', 'a.state_id', '=', 'b.id')
                            ->join('townships as c', 'a.township_id', '=', 'c.id')
                            ->where('a.id','=',$jobApply->first()->seeker_id)
                            ->select('a.*','b.name as state_name','c.name as township_name')
                            ->first();
                $image = $seeker->image ?? '';
            }
            $seeker_attach = SeekerAttach::whereSeekerId($jobApply->first()->seeker_id)->orderBy('updated_at','desc')->first();
            if(isset($seeker_attach)) {
                $seeker_cv = getS3File('seeker/cv',$seeker_attach->name);
            }
            $educations = SeekerEducation::whereSeekerId($jobApply->first()->seeker_id)->get();
            $experiences = SeekerExperience::whereSeekerId($jobApply->first()->seeker_id)->first();
            if($experiences) {
                if($experiences->is_experience == 1) {
                    $experiences = DB::table('seeker_experiences as a')
                                ->where('a.seeker_id','=',$jobApply->first()->seeker_id)
                                ->join('industries as b','a.industry_id','=','b.id')
                                ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                                ->join('functional_areas as d','a.sub_functional_area_id','=','d.id')
                                ->select('a.*','b.name as industry_name', 'c.name as main_functional_area_name', 'd.name as sub_functional_area_name')
                                ->get();
                }
            }else {
                $experiences = [];
            }
            $skill_main_functional_areas = DB::table('seeker_skills as a')
                            ->where('a.seeker_id','=',$jobApply->first()->seeker_id)
                            ->join('skills as b','a.skill_id','=','b.id')
                            ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                            ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                            ->groupBy('a.main_functional_area_id')
                            ->get();
            $skills = DB::table('seeker_skills as a')
                        ->where('a.seeker_id','=',$jobApply->first()->seeker_id)
                        ->join('skills as b','a.skill_id','=','b.id')
                        ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                        ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                        ->get();
            $languages = SeekerLanguage::whereSeekerId($jobApply->first()->seeker_id)->get();
            $references = SeekerReference::whereSeekerId($jobApply->first()->seeker_id)->get();
            $seeker_img = getS3File('seeker/profile/'.$jobApply->first()->seeker_id ,$image);
            if($jobPost->JobPostQuestion->count() > 0) {
                $answers = SeekerJobPostAnswer::with(['JobPostQuestion:id,question,answer'])->whereJobPostId($id)->whereJobApplyId($jobApply->first()->id)->whereSeekerId($jobApply->first()->seeker_id)->get();
            }
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
        $short-listed = JobApply::whereStatus('short-listed')->whereJobPostId($id)->count();
        $interview = JobApply::whereStatus('interview')->whereJobPostId($id)->count();
        $hire = JobApply::whereStatus('hire')->whereJobPostId($id)->count();
        $notsuitable = JobApply::whereStatus('not-suitable')->whereJobPostId($id)->count();
        $count = [];
        $count = [
            'received' => $received,
            'viewed' => $viewed,
            'short-listed' => $short-listed,
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
            'cvunlock' => $cvunlock,
            'seeker_cv' => $seeker_cv,
            'seeker_img' => $seeker_img,
            'answers' => $answers
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
        $answers = [];
        if($jobPost->JobPostQuestion->count() > 0) {
            $answers = SeekerJobPostAnswer::with(['JobPostQuestion:id,question,answer'])->whereJobPostId($jobPostId)->whereJobApplyId($jobApply->first()->id)->whereSeekerId($jobApply->first()->seeker_id)->get();
        }
        $educations = SeekerEducation::whereSeekerId($seeker->id)->get();
        $experiences = SeekerExperience::whereSeekerId($seeker->id)->first();
        $seeker_attach = SeekerAttach::whereSeekerId($seeker->id)->orderBy('updated_at','desc')->first();
        if($experiences) {
            if($experiences->is_experience == 1) {
                $experiences = DB::table('seeker_experiences as a')
                            ->where('a.seeker_id','=',$seeker->id)
                            ->join('industries as b','a.industry_id','=','b.id')
                            ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                            ->join('functional_areas as d','a.sub_functional_area_id','=','d.id')
                            ->select('a.*','b.name as industry_name', 'c.name as main_functional_area_name', 'd.name as sub_functional_area_name')
                            ->get();
            }
        }else {
            $experiences = [];
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
        $short-listed = JobApply::whereStatus('short-listed')->whereJobPostId($jobPostId)->count();
        $interview = JobApply::whereStatus('interview')->whereJobPostId($jobPostId)->count();
        $hire = JobApply::whereStatus('hire')->whereJobPostId($jobPostId)->count();
        $notsuitable = JobApply::whereStatus('not-suitable')->whereJobPostId($jobPostId)->count();
        $count = [];
        $count = [
            'received' => $received,
            'viewed' => $viewed,
            'short-listed' => $short-listed,
            'interview' => $interview,
            'hire' => $hire,
            'notsuitable' => $notsuitable,
        ];
        $seeker_img = getS3File('seeker/profile/'.$seeker->id ,$seeker->image);
        $seeker_cv = getS3File('seeker/cv',$seeker_attach->name);
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
            'cvunlock' => $cvunlock,
            'seeker_img' => $seeker_img,
            'seeker_cv' => $seeker_cv,
            'answers' => $answers
        ]);
    }

    public function icFormatCVDownload($id, Request $request)
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

        if($request->currentResume == "resume_2") {
            $pdf = PDF::loadView('download.ic_format_resume_2_cv', compact('seeker'));
            return $pdf->download(date('YmdHi').$seeker->id.'_ic_format_resume_2_cv.pdf');
        }else {
            $pdf = PDF::loadView('download.ic_format_resume_1_cv', compact('seeker'));
            return $pdf->download(date('YmdHi').$seeker->id.'_ic_format_resume_1_cv.pdf');
        }
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
        $answers = [];
        if($jobPost->JobPostQuestion->count() > 0) {
            $answers = SeekerJobPostAnswer::with(['JobPostQuestion:id,question,answer'])->whereJobPostId($jobPostId)->whereJobApplyId($jobApply->first()->id)->whereSeekerId($seekerId)->get();
        }
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
        if($experiences) {
            if($experiences->is_experience == 1) {
                $experiences = DB::table('seeker_experiences as a')
                            ->where('a.seeker_id','=',$seeker->id)
                            ->join('industries as b','a.industry_id','=','b.id')
                            ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                            ->join('functional_areas as d','a.sub_functional_area_id','=','d.id')
                            ->select('a.*','b.name as industry_name', 'c.name as main_functional_area_name', 'd.name as sub_functional_area_name')
                            ->get();
            }
        }else {
            $experiences = [];
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
        $short-listed = JobApply::whereStatus('short-listed')->whereJobPostId($jobPostId)->count();
        $interview = JobApply::whereStatus('interview')->whereJobPostId($jobPostId)->count();
        $hire = JobApply::whereStatus('hire')->whereJobPostId($jobPostId)->count();
        $notsuitable = JobApply::whereStatus('not-suitable')->whereJobPostId($jobPostId)->count();
        $cvunlock = [];
        $count = [];
        $count = [
            'received' => $received,
            'viewed' => $viewed,
            'short-listed' => $short-listed,
            'interview' => $interview,
            'hire' => $hire,
            'notsuitable' => $notsuitable,
        ];
        $seeker_img = getS3File('seeker/profile/'.$seeker->id ,$seeker->image);
        $seeker_cv = getS3File('seeker/cv',$seeker_attach->name);
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
            'cvunlock' => $cvunlock,
            'seeker_img' => $seeker_img,
            'seeker_cv' => $seeker_cv,
            'answers' => $answers
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

    public function pointBalance($id)
    {
        $employer = Employer::findOrFail($id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        return response()->json([
            'status' => 'success',
            'point'  => $employer->package_point
        ]);
    }

    public function phoneCheck(Request $request)
    {
        $this->validate($request, [
            'phone'    => ['nullable', new MyanmarPhone],
        ]);
        $phone = $request->phone;

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function buypointWithJobPost(Request $request)
    {
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

        if($request->hide_company_name == 'on') {
            $hide_company = 1;
        }else{
            $hide_company = 0;
        }

        $job_title = '-';
        if($request->job_title) {
            $job_title = $request->job_title;
        }
        $jobPost = JobPost::create([
            'employer_id' => Auth::guard('employer')->user()->id,
            'job_title' => $job_title,
            'main_functional_area_id' => $request->main_functional_area,
            'sub_functional_area_id' => $request->sub_functional_area,
            'industry_id' => $request->job_post_industry,
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
            'state_id' => $request->job_post_state,
            'township_id' => $request->job_post_township_id,
            'job_description' => $request->job_description,
            'job_requirement' => $request->job_requirement,
            'benefit' => $request->benefit,
            'job_highlight' => $request->highlight,
            'job_post_type' => $request->job_post_type,
            'status' => 'Draft',
            'total_point' => $request->total_point
        ]);

        $slug = Str::slug($jobPost->job_title, '-') . '-' . $jobPost->id;
        $jobPost_slug = $jobPost->update([
            'slug' => $slug
        ]);

        if($request->job_post_type == "trending") {
            $trending_record = PointRecord::create([
                'employer_id' => Auth::guard('employer')->user()->id,
                'job_post_id' => $jobPost->id,
                'package_item_id' => $request->trending_job_package_item_id,
                'point' => $request->trending_job_point,
                'status' => 'Pending'
            ]);
        }elseif($request->job_post_type == "feature") {
            $feature_record = PointRecord::create([
                'employer_id' => Auth::guard('employer')->user()->id,
                'job_post_id' => $jobPost->id,
                'package_item_id' => $request->feature_job_package_item_id,
                'point' => $request->feature_job_point,
                'status' => 'Pending'
            ]);
        }
        if($hide_company == 1) {
            $anonymous_record = PointRecord::create([
                'employer_id' => Auth::guard('employer')->user()->id,
                'job_post_id' => $jobPost->id,
                'package_item_id' => $request->anonymous_posting_package_item_id,
                'point' => $request->anonymous_posting_point,
                'status' => 'Pending'
            ]);
        }
        if($request->questions) {
            $question_record = PointRecord::create([
                'employer_id' => Auth::guard('employer')->user()->id,
                'job_post_id' => $jobPost->id,
                'package_item_id' => $request->question_package_item_id,
                'point' => $request->question_point,
                'status' => 'Pending'
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
        }
        if($request->skills) {
            foreach($request->skills as $key => $skill) {
                $skill_create = JobPostSkill::create([
                    'employer_id' => Auth::guard('employer')->user()->id,
                    'job_post_id' => $jobPost->id,
                    'skill_id' => $skill,
                ]);
            }
        }

        if($jobPost->job_post_type == 'standard') {
            $jobpostType = "Standard";
        }elseif($jobPost->job_post_type == 'trending') {
            $jobpostType = "Trending";
        }elseif($jobPost->job_post_type == 'feature') {
            $jobpostType = "Feature";
        }

        $order = PointOrder::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'point_package_id' => $request->point_package_id,
            'employer_id' => Auth::guard('employer')->user()->id,
            'status' => 'Pending'
        ]);
        $last_invoice_no = Invoice::orderBy('invoice_no', 'desc')->first();
        if(isset($last_invoice_no)){
            $last_invoice_no = $last_invoice_no->invoice_no;
        }else {
            $last_invoice_no = 000000;
        }
        $invoice_no = sprintf('%06d', $last_invoice_no + 1);
        $tax = Tax::first();
        $tax_amount = ($order->PointPackage->price * $tax->tax) / 100 ;
        $final_balance = $order->PointPackage->price + $tax_amount;
        $banks = BankInfo::whereNull('deleted_at')->whereIsActive(1)->get();
        $fileName =  date('YmdHi').$invoice_no.'_ic_point_invoice.pdf';
        $invoice = Invoice::create([
            'invoice_no' => $invoice_no,
            'point_order_id' => $order->id,
            'tax' => $tax_amount,
            'sub_total' => $order->PointPackage->price,
            'final_balance' => $final_balance,
            'file_name' => $fileName,
            'tax_percent' => $tax->tax,
            'status' => 'Pending',
            'created_by' => Auth::user()->id
        ]);
        $tax = $invoice->tax;
        $pdf = PDF::loadView('download.invoice', compact('invoice', 'tax', 'tax_amount', 'final_balance', 'banks'));
        
        $fileName =  date('YmdHi').$invoice_no.'_ic_point_invoice.pdf';
        
        $path     = 'invoice/' . $fileName;
        Storage::disk('s3')->put($path, $pdf->output());
        $path = Storage::disk('s3')->url($path);
        $order->update([
            'invoice_id' => $invoice->id
        ]);

        if($request->is_make_point_detect == 'on') {
            JobPostPointDetect::create([
                'point_order_id' => $order->id,
                'job_post_id' => $jobPost->id
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function jobDescriptionGenerate(Request $request, \OpenAI\Client $client)
    {
        $result = $client->completions()->create([
            'prompt' => 'Write about job description for ' . $request->job_title . $request->experience_level . $request->career_level,
            'model' => 'gpt-3.5-turbo-instruct',
            'max_tokens' => 250,
        ]);

        return response()->json([
            'status' => 'success',
            'job_description_ai' => ltrim($result->choices[0]->text)
        ]);
    }

    public function jobRequirementGenerate(Request $request, \OpenAI\Client $client)
    {
        $skills = Skill::whereIn('id', $request->skill_id)->select('name')->get();
        
        $result = $client->completions()->create([
            'prompt' => 'Write about job requirement for ' . $request->job_title . $request->experience_level . 'skills = ' . $skills . $request->career_level .  $request->degree,
            'model' => 'gpt-3.5-turbo-instruct',
            'max_tokens' => 250,
        ]);

        return response()->json([
            'status' => 'success',
            'job_requirement_ai' => ltrim($result->choices[0]->text)
        ]);
    }

    public function buypointWithJobPostUpdate(Request $request)
    {
        
        $jobPost = JobPost::findOrFail($request->job_post_id);
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
            'main_functional_area_id' => $request->main_functional_area,
            'sub_functional_area_id' => $request->sub_functional_area,
            'industry_id' => $request->job_post_industry,
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
            'state_id' => $request->job_post_state,
            'township_id' => $request->job_post_township_id,
            'job_description' => $request->job_description,
            'job_requirement' => $request->job_requirement,
            'benefit' => $request->benefit,
            'job_highlight' => $request->highlight,
            'job_post_type' => $request->job_post_type,
            'total_point' => $request->total_point,
            'status' => 'Draft',
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

        $order = PointOrder::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'point_package_id' => $request->point_package_id,
            'employer_id' => Auth::guard('employer')->user()->id,
            'status' => 'Pending'
        ]);
        $last_invoice_no = Invoice::orderBy('invoice_no', 'desc')->first();
        if(isset($last_invoice_no)){
            $last_invoice_no = $last_invoice_no->invoice_no;
        }else {
            $last_invoice_no = 000000;
        }
        $invoice_no = sprintf('%06d', $last_invoice_no + 1);
        $tax = Tax::first();
        $tax_amount = ($order->PointPackage->price * $tax->tax) / 100 ;
        $final_balance = $order->PointPackage->price + $tax_amount;
        $banks = BankInfo::whereNull('deleted_at')->whereIsActive(1)->get();
        $fileName =  date('YmdHi').$invoice_no.'_ic_point_invoice.pdf';
        $invoice = Invoice::create([
            'invoice_no' => $invoice_no,
            'point_order_id' => $order->id,
            'tax' => $tax_amount,
            'tax_percent' => $tax->tax,
            'sub_total' => $order->PointPackage->price,
            'final_balance' => $final_balance,
            'file_name' => $fileName,
            'status' => 'Pending',
            'created_by' => Auth::user()->id
        ]);
        $tax = $invoice->tax;
        $pdf = PDF::loadView('download.invoice', compact('invoice', 'tax', 'tax_amount', 'final_balance', 'banks'));
        
        $fileName =  date('YmdHi').$invoice_no.'_ic_point_invoice.pdf';
        
        $path     = 'invoice/' . $fileName;
        Storage::disk('s3')->put($path, $pdf->output());
        $path = Storage::disk('s3')->url($path);
        $order->update([
            'invoice_id' => $invoice->id
        ]);

        if($request->is_make_point_detect == 'on') {
            JobPostPointDetect::create([
                'point_order_id' => $order->id,
                'job_post_id' => $request->job_post_id
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}
