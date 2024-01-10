<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;
use App\Models\Seeker\SeekerPercentage;
use Storage;

class SeekerMobileProfileController extends Controller
{
    public function mobileProfile(Request $request)
    {
        $seeker = Seeker::with(['SeekerPercentage:id,seeker_id,title,percentage','State:id,name','Township:id,name', 'SeekerEducation:id,seeker_id,degree,major_subject,location,from,to,school,is_current', 'SeekerExperience' => function($exp) {
            $exp->with('MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name')->select('id','seeker_id','job_title','company','main_functional_area_id','sub_functional_area_id','career_level','job_responsibility','industry_id','country','is_current_job','is_experience','start_date','end_date');
        },'SeekerSkill' => function($skill) {
            $skill->with('Skill:id,name')->select('id','seeker_id','skill_id');
        },'SeekerLanguage:id,seeker_id,name,level', 'SeekerReference:id,seeker_id,name,position,company,contact', 'SeekerAttach:id,name,seeker_id','MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name'])
                    ->whereId($request->user()->id)
                    ->select('id', 'first_name', 'last_name', 'email', 'email_verified_at as since_member_at', 'image', 'phone', 'is_immediate_available', 'percentage', 'state_id', 'number_of_profile_view','country', 'state_id', 'township_id', 'address_detail', 'nationality', 'nrc', 'id_card', 'date_of_birth', 'gender', 'marital_status', 'summary', 'job_title','main_functional_area_id', 'sub_functional_area_id', 'job_type', 'career_level', 'preferred_salary', 'industry_id')
                    ->withCount(['SeekerAttach as cv_list'])
                    ->first();
        
        $states               = State::whereNull('deleted_at')->whereIsActive(1)->select('id','name')->get();
        $townships            = Township::whereNull('deleted_at')->whereIsActive(1)->select('id','name','state_id')->get();
        $main_functional_areas     = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->select('id','name')->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', '!=', 0)->whereIsActive(1)->select('id','name','functional_area_id')->get();
        $industries           = Industry::whereNull('deleted_at')->select('id','name')->get();
        $language_level       = array('Fluent', 'Advance', 'Conversational', 'Basic');
        return response()->json([
            'status' => 'success',
            'seeker' => $seeker,
            'states' => $states,
            'townships' => $townships,
            'main_functional_areas' => $main_functional_areas,
            'sub_functional_areas' => $sub_functional_areas,
            'industries' => $industries,
            'language_level' => $language_level
        ], 200);
    }

    public function personalInformation(Request $request)
    {
        $seeker = Seeker::findOrFail($request->user()->id);
        $image  = $seeker->image;
        if($request->image == $seeker->image) {
            $image  = $seeker->image;
        }elseif ($request->file('image')) {
            $file  = $request->file('image');
            $image = date('YmdHi') . $file->getClientOriginalName();
            
            $path     = 'seeker/profile/'. $request->user()->id . '/' . $image;
            Storage::disk('s3')->put($path, file_get_contents($file));
        }elseif($request->image == null) {
            Storage::disk('s3')->delete('seeker/profile/' . $request->user()->id . '/' . $image);
            $image        = null;
        }
        
        $date_of_birth = $request->date_of_birth ? date('Y-m-d', strtotime($request->date_of_birth)) : null;

        $seeker->update([
            'first_name'              => $request->first_name,
            'last_name'               => $request->last_name,
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
            'marital_status'          => $request->marital_status
        ]);
        $seeker_percentage = $this->updateSeekerPercentage($seeker);
        $seeker_update_percentage = $seeker->update([
            'percentage' => (int)$seeker->percentage,
            'state_id' => (int)$seeker->state_id,
            'township_id' => (int)$seeker->township_id
        ]);
        return response()->json([
            'status' => 'success',
            'seeker' => $seeker,
            'msg' => 'Personal Information Edit Successfully.'
        ], 200);
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
}
