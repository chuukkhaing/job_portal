<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;
use App\Models\Admin\Skill;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Employer\JobPost;
use App\Models\Seeker\JobApply;
use App\Models\Seeker\SaveJob;
use App\Models\Seeker\Seeker;
use App\Models\Seeker\SeekerAttach;
use App\Models\Seeker\SeekerEducation;
use App\Models\Seeker\SeekerExperience;
use App\Models\Seeker\SeekerLanguage;
use App\Models\Seeker\SeekerPercentage;
use App\Models\Seeker\SeekerReference;
use App\Models\Seeker\SeekerSkill;
use App\Models\Seeker\SeekerJobPostAnswer;
use Auth;
use DB;
use File;
use Hash;
use Illuminate\Http\Request;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Seeker\JobAlert;
use PDF;
use Storage;

class SeekerProfileController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('seeker')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function index()
    {
        $jobPosts             = JobPost::whereIsActive(1)
                                ->where('job_title', 'like', '%' . Auth::guard('seeker')->user()->job_title . '%')
                                ->where('main_functional_area_id', Auth::guard('seeker')->user()->main_functional_area_id)
                                ->where('sub_functional_area_id', Auth::guard('seeker')->user()->sub_functional_area_id)
                                ->where('career_level', Auth::guard('seeker')->user()->career_level)
                                ->where('status','Online')
                                ->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')
                                ->get()
                                ->take(16);
        if($jobPosts->count() == 0) {
            $jobPosts             = JobPost::whereIsActive(1)
            ->where('status','Online')
            ->orderBy(DB::raw('FIELD(job_post_type, "feature", "trending")'),'desc')
            ->get()
            ->take(16);
        }
        $employers            = DB::table('employers as a')
            ->join('package_with_package_items as b', 'a.package_id', '=', 'b.package_id')
            ->join('package_items as c', 'b.package_item_id', '=', 'c.id')
            ->where('c.name', '=', 'Top Employer')
            ->where('a.slug', '!=', null)
            ->select('a.*')
            ->where('a.is_active', '=', 1)
            ->where('a.deleted_at', '=', null)
            ->orderBy('a.updated_at', 'desc')
            ->get();
        return view('seeker.profile.dashboard', compact('employers', 'jobPosts'));
    }

    public function edit($id)
    {
        $states               = State::whereNull('deleted_at')->whereIsActive(1)->get();
        $townships            = Township::whereNull('deleted_at')->whereIsActive(1)->get();
        $functional_areas     = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', '!=', 0)->whereIsActive(1)->get();
        $industries           = Industry::whereNull('deleted_at')->get();
        $educations           = SeekerEducation::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $experiences          = SeekerExperience::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $skills               = SeekerSkill::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $languages            = SeekerLanguage::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $references           = SeekerReference::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $cvs                  = SeekerAttach::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        return view ('seeker.profile.edit-profile', compact('states', 'townships', 'functional_areas', 'sub_functional_areas', 'industries', 'educations', 'experiences', 'skills', 'languages', 'references', 'cvs'));
        // return view('seeker.profile.edit-profile');
    }

    public function getTownship($id)
    {
        $townships = Township::whereStateId($id)->whereNull('deleted_at')->orderBy('name')->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data'   => $townships,
        ]);
    }

    public function getSubFunctionalArea($id)
    {
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', $id)->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data'   => $sub_functional_areas,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // 'phone'         => ['required', new MyanmarPhone],
            // 'first_name'    => ['required', 'string', 'max:255'],
            // 'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:seekers,email,' . $id],
            'password'      => ['nullable', 'string', 'min:8', 'same:confirm-password'],
            // 'date_of_birth' => ['required'],
            // 'gender'        => ['required'],
        ]);

        $seeker = Seeker::findOrFail($id);
        $image  = $seeker->image;
        if ($request->imageStatus == "empty") {

            Storage::disk('s3')->delete('seeker/profile/' . $id . '/' . $image);
            $image        = null;
        }
        if ($request->file('image')) {
            $file  = $request->file('image');
            $image = date('YmdHi') . $file->getClientOriginalName();
            
            $path     = 'seeker/profile/'. $id . '/' . $image;
            Storage::disk('s3')->put($path, file_get_contents($file));
        }
        $date_of_birth = $request->date_of_birth ? date('Y-m-d', strtotime($request->date_of_birth)) : null;

        if ($request->password) {
            $password = Hash::make($request->password);
        } else {
            $password = $seeker->password;
        }

        $seeker->update([
            'first_name'              => $request->first_name,
            'last_name'               => $request->last_name,
            'email'                   => $request->email,
            'password'                => $password,
            'phone'                   => $request->phone,
            'image'                   => $image,
            'country'                 => $request->country,
            'state_id'                => $request->state_id,
            'township_id'             => $request->township_id,
            'address_detail'          => $request->address_detail,
            'nationality'             => $request->nationality,
            'nrc'                     => $request->nrc,
            'id_card'                 => $request->id_card,
            'date_of_birth'           => $date_of_birth,
            'gender'                  => $request->gender,
            'marital_status'          => $request->marital_status,
            'job_title'               => $request->job_title,
            'main_functional_area_id' => $request->main_functional_area_id,
            'sub_functional_area_id'  => $request->sub_functional_area_id,
            'job_type'                => $request->job_type,
            'career_level'            => $request->career_level,
            'preferred_salary'        => $request->preferred_salary,
            'industry_id'             => $request->industry_id,
        ]);
        $seeker_percentage = $this->updateSeekerPercentage($seeker);

        return redirect()->back()->with('success', 'Profile Edit Successfully.');
    }

    public function updateSeekerPercentage(Seeker $seeker)
    {
        if (isset($seeker->first_name) && isset($seeker->last_name) && (isset($seeker->nrc) || isset($seeker->id_card)) && isset($seeker->date_of_birth) && isset($seeker->phone) && isset($seeker->country) && isset($seeker->nationality)) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Personal Information')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 15,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }
        if (isset($seeker->main_functional_area_id) && isset($seeker->sub_functional_area_id) && isset($seeker->job_title) && isset($seeker->job_type) && isset($seeker->career_level) && isset($seeker->preferred_salary) && isset($seeker->industry_id)) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Career of Choice')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 20,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return true;
    }

    public function educationStore(Request $request)
    {
        $education = SeekerEducation::create([
            'seeker_id'     => $request->seeker_id,
            'degree'        => $request->degree,
            'major_subject' => $request->major_subject,
            'location'      => $request->location,
            'from'          => $request->from,
            'to'            => $request->to,
            'school'        => $request->school,
            'is_current'    => $request->current_school
        ]);
        $seeker            = Seeker::findOrFail($request->seeker_id);
        $seeker_educations = SeekerEducation::whereSeekerId($seeker->id)->get();
        if ($seeker_educations->count() > 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Education')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 10,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'    => 'success',
            'education' => $education,
            'msg'       => 'Education Create successfully!',
        ]);
    }

    public function educationEdit($id)
    {
        $education = SeekerEducation::findOrFail($id);
        return response()->json([
            'status'    => 'success',
            'education' => $education,
        ]);
    }

    public function educationUpdate($id, Request $request)
    {
        $education        = SeekerEducation::findOrFail($id);
        $education_update = $education->update([
            'seeker_id'     => $request->seeker_id,
            'degree'        => $request->degree,
            'major_subject' => $request->major_subject,
            'location'      => $request->location,
            'from'          => $request->from,
            'to'            => $request->to,
            'school'        => $request->school,
            'is_current'    => $request->is_current
        ]);
        return response()->json([
            'status'    => 'success',
            'education' => $education,
            'msg'       => 'Education Update successfully!',
        ]);
    }

    public function educationDestory($id, Request $request)
    {
        $education               = SeekerEducation::findOrFail($id)->delete();
        $seeker                  = Seeker::findOrFail($request->seeker_id);
        $seeker_educations_count = SeekerEducation::whereSeekerId($seeker->id)->count();
        if ($seeker_educations_count == 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Education')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 0,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'                  => 'success',
            'msg'                     => 'Education deleted successfully!',
            'seeker_educations_count' => $seeker_educations_count,
        ]);
    }

    public function getExperience(Request $request)
    {
        $experience = SeekerExperience::whereSeekerId($request->seeker_id)->count();
        return response()->json([
            'experience' => $experience,
            'status' => 'success'
        ]);
    }

    public function experienceStore(Request $request)
    {
        if ($request->is_experience == 0) {
            $exp = SeekerExperience::whereSeekerId($request->seeker_id)->delete();
        }
        $experience = SeekerExperience::create([
            'seeker_id'               => $request->seeker_id,
            'job_title'               => $request->exp_job_title,
            'company'                 => $request->exp_company,
            'main_functional_area_id' => $request->exp_main_functional_area_id,
            'sub_functional_area_id'  => $request->exp_sub_functional_area_id,
            'career_level'            => $request->exp_career_level,
            'industry_id'             => $request->exp_industry_id,
            'start_date'              => date('Y-m-d', strtotime($request->exp_start_date)),
            'end_date'                => $request->exp_end_date ? date('Y-m-d', strtotime($request->exp_end_date)) : null,
            'is_experience'           => $request->is_experience,
            'is_current_job'          => $request->is_current_job,
            'country'                 => $request->exp_country,
            'job_responsibility'      => $request->exp_job_responsibility,
        ]);
        $seeker      = Seeker::findOrFail($request->seeker_id);
        $seeker_exps = SeekerExperience::whereSeekerId($seeker->id)->get();
        if ($seeker_exps->count() > 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Career History')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 30,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }
        $exp_functions     = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_exp_functions = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', '!=', 0)->whereIsActive(1)->get();
        $exp_industries    = Industry::whereNull('deleted_at')->get();
        return response()->json([
            'status'            => 'success',
            'experience'        => $experience,
            'exp_functions'     => $exp_functions,
            'sub_exp_functions' => $sub_exp_functions,
            'exp_industries'    => $exp_industries,
            'msg'               => 'Experience Create successfully!',
        ]);
    }

    public function experienceEdit($id)
    {
        $experience = SeekerExperience::findOrFail($id);
        return response()->json([
            'status'     => 'success',
            'experience' => $experience,
        ]);
    }

    public function experienceUpdate($id, Request $request)
    {
        
        $experience        = SeekerExperience::findOrFail($id);
        $experience_update = $experience->update([
            'seeker_id'               => $request->seeker_id,
            'job_title'               => $request->exp_job_title,
            'company'                 => $request->exp_company,
            'main_functional_area_id' => $request->exp_main_functional_area_id,
            'sub_functional_area_id'  => $request->exp_sub_functional_area_id,
            'career_level'            => $request->exp_career_level,
            'industry_id'             => $request->exp_industry_id,
            'start_date'              => date('Y-m-d', strtotime($request->exp_start_date)),
            'end_date'                => $request->exp_end_date ? date('Y-m-d', strtotime($request->exp_end_date)) : null,
            'is_experience'           => $request->is_experience,
            'is_current_job'          => $request->is_current_job,
            'country'                 => $request->exp_country,
            'job_responsibility'      => $request->exp_job_responsibility,
        ]);
        $exp_functions     = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_exp_functions = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', '!=', 0)->whereIsActive(1)->get();
        $exp_industries    = Industry::whereNull('deleted_at')->get();
        return response()->json([
            'status'            => 'success',
            'experience'        => $experience,
            'exp_functions'     => $exp_functions,
            'sub_exp_functions' => $sub_exp_functions,
            'exp_industries'    => $exp_industries,
            'msg'               => 'Experience Update successfully!',
        ]);
    }

    public function experienceDestory($id, Request $request)
    {
        $experience               = SeekerExperience::findOrFail($id)->delete();
        $seeker                   = Seeker::findOrFail($request->seeker_id);
        $seeker_experiences_count = SeekerExperience::whereSeekerId($seeker->id)->count();
        if ($seeker_experiences_count == 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Career History')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 0,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'                   => 'success',
            'msg'                      => 'Experience deleted successfully!',
            'seeker_experiences_count' => $seeker_experiences_count,
        ]);
    }

    public function getSkill($id)
    {
        $seeker_skills = SeekerSkill::whereSeekerId(Auth::guard('seeker')->user()->id)->pluck('skill_id')->toArray();
        $skills        = Skill::whereNull('deleted_at')->where('main_functional_area_id', $id)->whereNotIn('id', $seeker_skills)->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data'   => $skills,
        ]);
    }

    public function skillStore(Request $request)
    {
        if ($request->skill_id) {
            foreach ($request->skill_id as $skill_id) {
                $skill = SeekerSkill::create([
                    'seeker_id'               => $request->seeker_id,
                    'main_functional_area_id' => $request->skill_main_functional_area_id,
                    'skill_id'                => $skill_id,
                ]);
            }
        }
        $seeker          = Seeker::findOrFail($request->seeker_id);
        $seeker_skills   = SeekerSkill::whereSeekerId($seeker->id)->get();
        $skill_functions = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $skill_names     = Skill::whereNull('deleted_at')->whereIsActive(1)->get();
        if ($seeker_skills->count() > 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Skills')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 5,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'          => 'success',
            'skills'          => $seeker_skills,
            'skill_functions' => $skill_functions,
            'skill_names'     => $skill_names,
            'msg'             => 'Skill Create successfully!',
        ]);
    }

    public function skillDestory($id, Request $request)
    {
        $skill               = SeekerSkill::findOrFail($id)->delete();
        $seeker              = Seeker::findOrFail($request->seeker_id);
        $seeker_skills_count = SeekerSkill::whereSeekerId($seeker->id)->count();
        if ($seeker_skills_count == 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Skills')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 0,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'              => 'success',
            'msg'                 => 'skill deleted successfully!',
            'seeker_skills_count' => $seeker_skills_count,
        ]);
    }

    public function languageStore(Request $request)
    {
        $language = SeekerLanguage::create([
            'seeker_id' => $request->seeker_id,
            'name'      => $request->language_name,
            'level'     => $request->language_level,
        ]);
        $seeker           = Seeker::findOrFail($request->seeker_id);
        $seeker_languages = SeekerLanguage::whereSeekerId($seeker->id)->get();
        if ($seeker_languages->count() > 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Language')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 5,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'   => 'success',
            'language' => $language,
            'msg'      => 'Language Create successfully!',
        ]);
    }

    public function languageEdit($id)
    {
        $language = SeekerLanguage::findOrFail($id);
        return response()->json([
            'status'   => 'success',
            'language' => $language,
        ]);
    }

    public function languageUpdate($id, Request $request)
    {
        $language        = SeekerLanguage::findOrFail($id);
        $language_update = $language->update([
            'seeker_id' => $request->seeker_id,
            'name'      => $request->language_name,
            'level'     => $request->language_level,
        ]);
        return response()->json([
            'status'   => 'success',
            'language' => $language,
            'msg'      => 'Language Update successfully!',
        ]);
    }

    public function languageDestory($id, Request $request)
    {
        $language               = SeekerLanguage::findOrFail($id)->delete();
        $seeker                 = Seeker::findOrFail($request->seeker_id);
        $seeker_languages_count = SeekerLanguage::whereSeekerId($seeker->id)->count();
        if ($seeker_languages_count == 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Language')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 0,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'                 => 'success',
            'msg'                    => 'language deleted successfully!',
            'seeker_languages_count' => $seeker_languages_count,
        ]);
    }

    public function referenceStore(Request $request)
    {
        $this->validate($request, [
            'ref_contact' => ['required', new MyanmarPhone],
        ]);
        $reference = SeekerReference::create([
            'seeker_id' => $request->seeker_id,
            'name'      => $request->ref_name,
            'position'  => $request->ref_position,
            'company'   => $request->ref_company,
            'contact'   => $request->ref_contact,
        ]);
        $seeker            = Seeker::findOrFail($request->seeker_id);
        $seeker_references = SeekerReference::whereSeekerId($seeker->id)->get();
        if ($seeker_references->count() > 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Reference')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 5,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'    => 'success',
            'reference' => $reference,
            'msg'       => 'Reference Create successfully!',
        ]);
    }

    public function referenceEdit($id)
    {
        $reference = SeekerReference::findOrFail($id);
        return response()->json([
            'status'    => 'success',
            'reference' => $reference,
        ]);
    }

    public function referenceUpdate($id, Request $request)
    {
        $this->validate($request, [
            'ref_contact' => ['required', new MyanmarPhone],
        ]);
        $reference        = SeekerReference::findOrFail($id);
        $reference_update = $reference->update([
            'seeker_id' => $request->seeker_id,
            'name'      => $request->ref_name,
            'position'  => $request->ref_position,
            'company'   => $request->ref_company,
            'contact'   => $request->ref_contact,
        ]);
        return response()->json([
            'status'    => 'success',
            'reference' => $reference,
            'msg'       => 'Reference Update successfully!',
        ]);
    }

    public function referenceDestory($id, Request $request)
    {
        $reference               = SeekerReference::findOrFail($id)->delete();
        $seeker                  = Seeker::findOrFail($request->seeker_id);
        $seeker_references_count = SeekerReference::whereSeekerId($seeker->id)->count();
        if ($seeker_references_count == 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Reference')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 0,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'                  => 'success',
            'msg'                     => 'reference deleted successfully!',
            'seeker_references_count' => $seeker_references_count,
        ]);
    }

    public function seekerAttachStore(Request $request)
    {

        if($request->is_ic_cv == 1) {
            $seeker = Seeker::findOrFail($request->seeker_id);
            $skill_main_functional_areas = DB::table('seeker_skills as a')
                            ->where('a.seeker_id','=',$seeker->id)
                            ->join('skills as b','a.skill_id','=','b.id')
                            ->join('functional_areas as c','a.main_functional_area_id','=','c.id')
                            ->select('a.*', 'b.name as skill_name', 'c.name as main_functional_area_name')
                            ->groupBy('a.main_functional_area_id')
                            ->get();
            view()->share('seeker',$seeker);

            $pdf = PDF::loadView('download.ic_format_cv', compact('seeker','skill_main_functional_areas'));
            $fileName =  date('YmdHi').$seeker->id.'_ic_format_cv.pdf';
            
            $path     = 'seeker/cv/' . $fileName;
            Storage::disk('s3')->put($path, $pdf->output());
            $path = Storage::disk('s3')->url($path);
            
            $attach = seekerAttach::create([
                'seeker_id' => $request->seeker_id,
                'name'      => $fileName,
            ]);

            $seeker         = Seeker::findOrFail($request->seeker_id);
            $seeker_attachs = seekerAttach::whereSeekerId($seeker->id)->get();
            if ($seeker_attachs->count() > 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Resume Attachment')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 10,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }
    
            return response()->json([
                'status' => 'success',
                'attach' => $attach,
                'msg'    => 'CV Upload successfully!',
            ]);

        }else {
            $file = $request->file('cv_attach');
            $cv   = date('YmdHi') . $file->getClientOriginalName();

            $path     = 'seeker/cv/' . $cv;
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);
            $attach = seekerAttach::create([
                'seeker_id' => $request->seeker_id,
                'name'      => $cv,
            ]);

            $seeker_cv = getS3File('seeker/cv',$attach->name);
    
            $seeker         = Seeker::findOrFail($request->seeker_id);
            $seeker_attachs = seekerAttach::whereSeekerId($seeker->id)->get();
            if ($seeker_attachs->count() > 0) {
                $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Resume Attachment')->first();
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => 10,
                ]);
                $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
                $seeker_update = $seeker->update([
                    'percentage' => $total_percent,
                ]);
            }
    
            return response()->json([
                'status' => 'success',
                'attach' => $attach,
                'msg'    => 'CV Upload successfully!',
                'seeker_cv' => $seeker_cv
            ]);
        }
    }

    public function seekerAttachDestory($id, Request $request)
    {
        $cv               = SeekerAttach::findOrFail($id);
        Storage::disk('s3')->delete('seeker/cv/' . $cv->name);
        $cv               = SeekerAttach::findOrFail($id)->delete();
        $seeker           = Seeker::findOrFail($request->seeker_id);
        $seeker_cvs_count = SeekerAttach::whereSeekerId($seeker->id)->count();
        if ($seeker_cvs_count == 0) {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Resume Attachment')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 0,
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return response()->json([
            'status'           => 'success',
            'msg'              => 'cv deleted successfully!',
            'seeker_cvs_count' => $seeker_cvs_count,
        ]);
    }

    public function immediateAvailableUpdate($id, Request $request)
    {
        $seeker = Seeker::findOrFail($id);
        $seeker->update([
            'is_immediate_available' => $request->is_immediate_available,
        ]);
        return response()->json([
            'status' => 'success',
            'msg'    => 'Update successfully!',
        ]);
    }

    public function jobPostApply(Request $request, $id)
    {
        $jobpost = JobPost::findOrFail($id);
        if(isset($jobpost->JobPostQuestion)) {
            $this->validate($request, [
                'answers.*.*' => 'required'
            ],[
                'answers.*.*.required' => 'Need to answer all questions.'
            ]);
        }
        if(url()->previous() == route('jobpost-detail', $jobpost->slug)) {
            session()->forget('returnUrl');
        }
        if(session('returnUrl') == "jobpost-detail") {
            session()->forget('returnUrl');
            return redirect()->route('jobpost-detail', $jobpost->slug);
        }else {
            if (Auth::guard('seeker')->user()->percentage < 80) {
                return redirect()->back()->with('error', 'Please upload your CV as an attachment or update your profile to a minimum of 80% completion for us to consider your qualifications.!');
            } else {
                $jobApply = JobApply::create([
                    'employer_id' => $jobpost->employer_id,
                    'job_post_id' => $id,
                    'seeker_id'   => Auth::guard('seeker')->user()->id,
                ]);
                if(isset($request->answers)) {
                    foreach($request->answers as $key => $answer) {
                        $answer = SeekerJobPostAnswer::create([
                            'job_post_id'          => $id,
                            'seeker_id'            => Auth::guard('seeker')->user()->id,
                            'job_apply_id'         => $jobApply->id,
                            'job_post_question_id' => $key,
                            'answer'               => $answer[0]
                        ]);
                    }
                }
                
                if(session('previous_url')) {
                    $previous_url = session('previous_url');
                    session()->forget('previous_url');
                    return redirect($previous_url)->with('success', 'Job Apply Successfully!');
                }else {
                    return redirect()->back()->with('success', 'Job Apply Successfully!');
                }
            }
        }
    }

    public function getApplication()
    {
        $jobsApplyBySeeker    = JobApply::whereSeekerId(Auth::guard('seeker')->user()->id)->orderBy('created_at','desc')->get();
        return view('seeker.profile.job-application', compact('jobsApplyBySeeker'));
    }
    
    public function getSavedJob()
    {
        $saveJobs             = SaveJob::whereSeekerId(Auth::guard('seeker')->user()->id)->orderBy('created_at','desc')->get();
        return view('seeker.profile.favourite-job', compact('saveJobs'));
    }

    public function getJobAlert()
    {
        $job_alerts           = JobAlert::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $industries           = Industry::whereNull('deleted_at')->get();
        $functional_areas     = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $states               = State::whereNull('deleted_at')->whereIsActive(1)->get();
        return view('seeker.profile.job-alert', compact('job_alerts', 'industries', 'functional_areas', 'states'));
    }

    public function changePassword()
    {
        return view('seeker.profile.changePassword');
    }
}
