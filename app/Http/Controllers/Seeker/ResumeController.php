<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use File;

class ResumeController extends Controller
{
    public function Create()
    {
        $states               = State::whereNull('deleted_at')->whereIsActive(1)->get();
        $townships            = Township::whereNull('deleted_at')->whereIsActive(1)->get();
        return view ('seeker.resume.create', compact('states', 'townships'));
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
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:seekers,email,' . $request->seeker_id],
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
            'phone'         => ['required', new MyanmarPhone],
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
}
