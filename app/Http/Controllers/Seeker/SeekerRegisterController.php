<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Seeker\Seeker;
use Illuminate\Support\Facades\Hash;
use App\Mail\SeekerVerificationEmail;
use App\Mail\SeekerResetPassword;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use App\Models\Admin\Industry;
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
        $industries = Industry::whereNull('deleted_at')->whereIsActive(1)->get();
        return view ('frontend.register', compact('industries'));
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
            'date_of_birth' => null,
            'password' => Hash::make($request['password']),
            'email_verification_token' => Str::random(32),
            'register_at' => Carbon::now(),
        ]);
        if($seeker) {
            \Mail::to($seeker->email)->send(new SeekerVerificationEmail($seeker));

            return redirect()->route('seeker-verify-notice', $seeker->id)->with('success','Please check your email to activate your account.');
        }
    }

    public function notice($id)
    {
        $seeker = Seeker::findOrFail($id);
        if($seeker) {
            return view ('seeker.verify.notice', compact('id'));
        }
    }

    public function resend($id)
    {
        $seeker = Seeker::findOrFail($id);
        $seeker_update = $seeker->update([
            'email_verification_token' => Str::random(32)
        ]);
        if($seeker) {
            \Mail::to($seeker->email)->send(new SeekerVerificationEmail($seeker));

            return redirect()->route('seeker-verify-notice', $seeker->id)->with('success','Successfully resend!Please check your email to activate your account.');
        }
    }

    public function forgotPassword()
    {
        return view ('frontend.forgot-password');
    }

    public function getEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:seekers',
        ]);
        $seeker = Seeker::whereEmail($request->email)->first();
        if($seeker) {
            $seeker_update = $seeker->update([
                'email_verification_token' => Str::random(32)
            ]);
            \Mail::to($seeker->email)->send(new SeekerResetPassword($seeker));
        }else {
            return redirect()->back()->with('error', "Your email was done't exist. Please Try Again!");
        }
        return view ('frontend.forgot-password');
    }
}
