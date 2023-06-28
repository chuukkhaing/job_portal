<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Seeker\Seeker;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Seeker\SeekerPercentage;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;
use Auth;
use Hash;
use Arr;

class SeekerProfileController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('seeker')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function index()
    {
        $states = State::whereNull('deleted_at')->whereIsActive(1)->get();
        $townships = Township::whereNull('deleted_at')->whereIsActive(1)->get();
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id','!=',0)->whereIsActive(1)->get();
        $industries = Industry::whereNull('deleted_at')->get();
        return view ('frontend.seeker.dashboard', compact('states', 'townships', 'functional_areas', 'sub_functional_areas', 'industries'));
    }

    public function getTownship($id)
    {
        $townships = Township::whereStateId($id)->whereNull('deleted_at')->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data' => $townships
        ]);
    }

    public function getSubFunctionalArea($id)
    {
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id',$id)->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data' => $sub_functional_areas
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'phone' => ['required', new MyanmarPhone],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:seekers,email,'.$id],
            'password' => ['nullable', 'string', 'min:8', 'same:confirm-password'],
        ]);

        $seeker = Seeker::findOrFail($id);
        $image = $seeker->image;
        if($request->imageStatus == "empty") {
            $image = null;
        }
        if($request->file('image')){
            $file= $request->file('image');
            $image= date('YmdHi').$file->getClientOriginalName();
            $path = $file-> move(public_path('storage/seeker/profile'.'/'.$id), $image);
        }
        $input = $request->all();
        $input['date_of_birth'] = date('Y-m-d', strtotime($request->date_of_birth));
        $input['image'] = $image;
        
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
        $input = Arr::except($input,array('imageStatus', 'confirm-password'));
        
        $seeker->update($input);
        $seeker_percentage = $this->updateSeekerPercentage($seeker);
        
        return redirect()->back()->with('success','Profile Edit Successfully.');
    }

    public function updateSeekerPercentage(Seeker $seeker)
    {
        if(isset($seeker->first_name) && isset($seeker->last_name) && (isset($seeker->nrc) || isset($seeker->id_card)) && isset($seeker->date_of_birth) && isset($seeker->phone) && isset($seeker->country) && isset($seeker->nationality))
        {
            $seeker_percent = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Personal Information')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 18
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent
            ]);
        }
        if(isset($seeker->main_functional_area_id) && isset($seeker->sub_functional_area_id) && isset($seeker->job_title) && isset($seeker->job_type) && isset($seeker->career_level) && isset($seeker->preferred_salary) && isset($seeker->industry_id))
        {
            $seeker_percent = SeekerPercentage::whereSeekerId($seeker->id)->whereTitle('Career of Choice')->first();
            $seeker_percent_update = $seeker_percent->update([
                'percentage' => 20
            ]);
            $total_percent = SeekerPercentage::whereSeekerId($seeker->id)->sum('percentage');
            $seeker_update = $seeker->update([
                'percentage' => $total_percent
            ]);
        }

        return true;
    }
}
