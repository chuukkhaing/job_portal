<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;
use Auth;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;
use App\Models\Admin\Skill;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Seeker\SeekerAttach;
use App\Models\Seeker\SeekerEducation;
use App\Models\Seeker\SeekerExperience;
use App\Models\Seeker\SeekerLanguage;
use App\Models\Seeker\SeekerPercentage;
use App\Models\Seeker\SeekerReference;
use App\Models\Seeker\SeekerSkill;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use File;
use PDF;
use DB;

class ResumeController extends Controller
{

    public function create()
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
        return view ('seeker.resume.create', compact('states', 'townships', 'functional_areas', 'sub_functional_areas', 'industries', 'educations', 'experiences', 'skills', 'languages', 'references', 'cvs'));
    }
    public function profileImageStore(Request $request)
    {
        $seeker = Seeker::findOrFail($request->seeker_id);
        
        if ($request->file('profile_image')) {
            $file  = $request->file('profile_image');
            $image = date('YmdHi') . $file->getClientOriginalName();
            $path  = $file->move(public_path('storage/seeker/profile' . '/' . $request->seeker_id), $image);
        }
        
        $seeker->update([
            'image'                   => $image,
        ]);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function profileImageDestory(Request $request)
    {
        $seeker = Seeker::findOrFail($request->seeker_id);
        $image  = $seeker->image;
        $image_delete = File::deleteDirectory(public_path('storage/seeker/profile' . '/' . $request->seeker_id . '/' . $image));
        $image        = null;
        
        $seeker->update([
            'image'                   => $image,
        ]);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function seekerPhoneStore(Request $request)
    {
        $this->validate($request, [
            'phone'         => ['nullable', new MyanmarPhone],
        ]);

        $seeker = Seeker::findOrFail($request->seeker_id);

        $seeker_update = $seeker->update([
            'phone'                   => $request->phone,
        ]);
        return response()->json([
            'status' => 'success',
            'phone'  => $request->phone
        ]);
    }

    public function seekerResumeUpdate(Request $request)
    {
        $seeker = Seeker::findOrFail($request->seeker_id);
        if($request->column == 'date_of_birth') {
            $request->value = $request->value ? date('Y-m-d', strtotime($request->value)) : null;
        }
        $seeker->update([
            $request->column                   => $request->value,
        ]);

        $seeker_info = Seeker::findOrFail($request->seeker_id);
        $seeker_percentage = $this->updateSeekerPercentage($seeker_info);
        return response()->json([
            'status' => 'success',
            'seeker_info' => $seeker_info
        ]);
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
        }else {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Personal Information')->first();
            if($seeker_percent->percentage > 0) {
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => $seeker_percent->percentage - 15,
                ]);
            }
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
        }else {
            $seeker_percent        = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Career of Choice')->first();
            if($seeker_percent->percentage > 0) {
                $seeker_percent_update = $seeker_percent->update([
                    'percentage' => $seeker_percent->percentage - 20,
                ]);
            }
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent,
            ]);
        }

        return true;
    }

    public function careerCreate(Request $request)
    {
        $seeker = Seeker::findOrFail($request->seeker_id);

        $seeker->update([
            'job_title'               => $request->job_title,
            'main_functional_area_id' => $request->main_functional_area_id,
            'sub_functional_area_id'  => $request->sub_functional_area_id,
            'job_type'                => $request->job_type,
            'career_level'            => $request->career_level,
            'preferred_salary'        => $request->preferred_salary,
            'industry_id'             => $request->industry_id,
        ]);
        $seeker_info = Seeker::findOrFail($request->seeker_id);
        $seeker_percentage = $this->updateSeekerPercentage($seeker_info);
        return response()->json([
            'status' => 'success',
            'msg' => 'Career of Choice create Successfully.'
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
        // return $pdf->stream();
        return $pdf->download($seeker->id.'_ic_format_cv.pdf');
    }
}
