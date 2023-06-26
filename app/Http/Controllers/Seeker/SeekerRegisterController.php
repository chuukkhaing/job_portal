<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Seeker\Seeker;
use Illuminate\Support\Facades\Hash;
use App\Mail\SeekerVerificationEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;

class SeekerRegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:seeker');
    }

    public function frontendRegister() 
    {
        if(auth()->guard('seeker')->user()) {
            return redirect()->route ('home');
        }else {
            return view ('frontend.register');
        }
    }

    protected function register(Request $request)
    {
        $this->validate($request, [
            'phone' => ['nullable', new MyanmarPhone],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:seekers'],
            'password' => ['required', 'string', 'min:8', 'same:confirmed'],
        ]);
        $seeker = Seeker::create([
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'email_verification_token' => Str::random(32)
        ]);
        if($seeker) {
            \Mail::to($seeker->email)->send(new SeekerVerificationEmail($seeker));

            return redirect()->route('seeker-verify-notice')->with('success','Please check your email to activate your account.');
        }
    }
}
