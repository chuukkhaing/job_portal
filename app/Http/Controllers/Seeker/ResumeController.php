<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;
use App\Models\Admin\State;
use App\Models\Seeker\SeekerEducation;
use Auth;
use App\Models\Admin\Township;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Seeker\SeekerExperience;
use App\Models\Seeker\SeekerLanguage;
use App\Models\Seeker\SeekerReference;
use App\Models\Seeker\SeekerSkill;
use App\Models\Admin\FunctionalArea;
use App\Models\Admin\Industry;
use File;

class ResumeController extends Controller
{
    public function Create()
    {
        $states               = State::whereNull('deleted_at')->whereIsActive(1)->get();
        $townships            = Township::whereNull('deleted_at')->whereIsActive(1)->get();
        $educations           = SeekerEducation::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $experiences          = SeekerExperience::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $skills               = SeekerSkill::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $languages            = SeekerLanguage::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $references           = SeekerReference::whereSeekerId(Auth::guard('seeker')->user()->id)->get();
        $functional_areas     = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', '!=', 0)->whereIsActive(1)->get();
        $industries           = Industry::whereNull('deleted_at')->get();
        return view ('seeker.resume.create', compact('states', 'townships', 'educations', 'experiences', 'skills', 'languages', 'references', 'functional_areas', 'sub_functional_areas', 'industries'));
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
    public function seekerEmailStore(Request $request)
    {
        $this->validate($request, [
            'email'         => ['nullable', 'string', 'email', 'max:255', 'unique:seekers,email,' . $request->seeker_id],
        ]);

        $seeker = Seeker::findOrFail($request->seeker_id);
    
        $seeker->update([
            'email'                   => $request->email,
        ]);
        return response()->json([
            'status' => 'success',
            'email'  => $request->email
        ]);
    }

    public function seekerPhoneStore(Request $request)
    {
        $this->validate($request, [
            'phone'         => ['nullable', new MyanmarPhone],
        ]);

        $seeker = Seeker::findOrFail($request->seeker_id);

        $seeker->update([
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
        return response()->json([
            'status' => 'success',
        ]);
    }
}
