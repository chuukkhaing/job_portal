<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;
use Auth;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Seeker\SeekerPercentage;
use File;

class ResumeController extends Controller
{

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
        }

        return true;
    }

}
