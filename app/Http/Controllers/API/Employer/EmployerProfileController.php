<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;

class EmployerProfileController extends Controller
{
    public function dashboard(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $lastJobPosts = JobPost::whereEmployerId($employer->id)->where('status','Online')->orderBy('updated_at','desc')->get()->take(5);
        return response()->json([
            'status' => 'success',
            'employer' => $employer,
            'lastJobPosts' => $lastJobPosts
        ], 200);
    }
}
