<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;

class SeekerMobileProfileController extends Controller
{
    public function mobileProfile(Request $request)
    {
        $seeker = Seeker::with(['SeekerPercentage:id,seeker_id,title,percentage','State:id,name','Township:id,name', 'SeekerEducation:id,seeker_id,degree,major_subject,location,from,to,school,is_current', 'SeekerExperience' => function($exp) {
            $exp->with('MainFunctionalArea:id,name', 'SubFunctionalArea:id,name', 'Industry:id,name')->select('id','seeker_id','job_title','company','main_functional_area_id','sub_functional_area_id','career_level','job_responsibility','industry_id','country','is_current_job','is_experience','start_date','end_date');
        },'SeekerSkill' => function($skill) {
            $skill->with('Skill:id,name')->select('id','seeker_id','skill_id');
        },'SeekerLanguage:id,seeker_id,name,level', 'SeekerReference:id,seeker_id,name,position,company,contact'])
                    ->whereId($request->user()->id)
                    ->select('id', 'first_name', 'last_name', 'email', 'email_verified_at as since_member_at', 'image', 'phone', 'is_immediate_available', 'percentage', 'state_id', 'number_of_profile_view','country', 'state_id', 'township_id', 'address_detail', 'nationality', 'nrc', 'id_card', 'date_of_birth', 'gender', 'marital_status')
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
}
