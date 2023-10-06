<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Mail\EmployerResetPassword;
use App\Mail\EmployerVerificationEmail;
use App\Models\Admin\Employer;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Admin\Industry;
use URL;

class EmployerRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:employer');
    }

    public function frontendEmployerRegister()
    {
        $industries = Industry::whereNull('deleted_at')->whereIsActive(1)->get();
        return view('frontend.employer-register', compact('industries'));
    }

    protected function register(Request $request)
    {
        $this->validate($request, [
            'company_phone'    => ['nullable', new MyanmarPhone],
            'company_name'     => ['required', 'string'],
            'industry_id'      => ['required'],
            'company_email'    => ['required', 'string', 'email', 'max:255', 'unique:employers,email,NULL,id,deleted_at,NULL'],
            'company_password' => ['required', 'string', 'min:8', 'same:company_confirmed'],
            'company_confirmed' => ['required', 'string', 'min:8', 'same:company_password'],
        ]);

        $employer = Employer::create([
            'name'                     => $request['company_name'],
            'industry_id'              => $request['industry_id'],
            'email'                    => $request['company_email'],
            'phone'                    => $request['company_phone'],
            'password'                 => Hash::make($request['company_password']),
            'package_id'               => 4,
            'email_verification_token' => Str::random(32),
            'register_at'              => Carbon::now(),
        ]);
        $slug = Str::slug($request->name, '-') . '-' . $employer->id;
        $employer->update([
            'slug' => $slug,
        ]);
        if ($employer) {
            \Mail::to($employer->email)->send(new EmployerVerificationEmail($employer));

            return redirect()->route('employer-verify-notice', $employer->id)->with('success', 'Please check your email to activate your account.');
        }
    }

    public function notice($id)
    {
        $employer = Employer::whereId($id)->whereNull('deleted_at')->whereIsActive(0)->first();
        if ($employer) {
            return view('employer.verify.notice', compact('id'));
        }
    }

    public function resend($id)
    {
        $employer        = Employer::whereId($id)->whereNull('deleted_at')->whereIsActive(0)->first();
        if ($employer) {
            $employer_update = $employer->update([
                'email_verification_token' => Str::random(32),
            ]);

            \Mail::to($employer->email)->send(new SeekerVerificationEmail($employer));

            return redirect()->route('employer-verify-notice', $employer->id)->with('success', 'Successfully resend!Please check your email to activate your account.');
        }else {
            return redirect()->back()->with('error', "Your email was done't exist. Please Try Again!");
        }
    }

    public function forgotPassword()
    {
        return view('frontend.forgot-password');
    }

    public function getEmail(Request $request)
    {
        $request->validate([
            'company_email' => 'required|email|exists:employers,email',
        ]);

        $employer = Employer::whereEmail($request->email)->whereIsActive(1)->whereNotNull('email_verified_at')->whereNull('deleted_at')->first();

        if (isset($employer)) {
            $employer_update = $employer->update([
                'email_verification_token' => Str::random(32),
            ]);

            $user_name = $employer->name;
            $reseturl  = URL::to('/') . '/employer' . '/' . $employer->id . '/reset-password';

            \Mail::to($employer->email)->send(new EmployerResetPassword($user_name, $reseturl));

            return redirect()->back()->with('info', 'Please, check email for reset link.');
        } else {
            return redirect()->back()->with('error', "Your email was done't exist. Please Try Again!");
        }
    }

    public function getResetPassword($id)
    {
        return view('frontend.reset-password', compact('id'));
    }

    public function storeResetPassword(Request $request)
    {
        $this->validate($request, [
            'company_password' => ['required', 'string', 'min:8', 'same:company_confirmed'],
        ]);
        $password = Hash::make($request['company_password']);

        $employer = Employer::find($request->id);

        $employer->update([
            'password' => $password,
        ]);

        return redirect()->route('employer-login-form')->with('success', 'Reset Password Successfully.');
    }
}
