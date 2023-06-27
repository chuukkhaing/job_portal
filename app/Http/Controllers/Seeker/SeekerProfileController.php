<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

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
        return view ('frontend.seeker.dashboard');
    }
}
