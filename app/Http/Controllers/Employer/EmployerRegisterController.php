<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Admin\Employer;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Mail\EmployerVerificationEmail;
use Illuminate\Foundation\Auth\RegistersUsers;

class EmployerRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:employer');
    }

    protected function register(Request $request)
    {
        $request->validate([
            'company_phone' => ['nullable', new MyanmarPhone],
            'company_email' => ['required', 'string', 'email', 'max:255', 'unique:employers,email'],
            'company_password' => ['required', 'string', 'min:8', 'same:company_confirmed'],
        ]);
        
        $employer = Employer::create([
            'name' => $request['company_name'],
            'industry_id' => $request['industry_id'],
            'email' => $request['company_email'],
            'phone' => $request['company_phone'],
            'password' => Hash::make($request['company_password']),
            'email_verification_token' => Str::random(32),
            'register_at' => Carbon::now(),
        ]);
        if($employer) {
            \Mail::to($employer->email)->send(new EmployerVerificationEmail($employer));

            return redirect()->route('employer-verify-notice', $employer->id)->with('success','Please check your email to activate your account.');
        }
    }

    public function notice($id)
    {
        $employer = Employer::findOrFail($id);
        if($employer) {
            return view ('employer.verify.notice', compact('id'));
        }
    }

    public function resend($id)
    {
        $employer = Employer::findOrFail($id);
        $employer_update = $employer->update([
            'email_verification_token' => Str::random(32)
        ]);
        if($employer) {
            \Mail::to($employer->email)->send(new EmployerVerificationEmail($employer));

            return redirect()->route('employer-verify-notice', $employer->id)->with('success','Successfully resend!Please check your email to activate your account.');
        }
    }
}
