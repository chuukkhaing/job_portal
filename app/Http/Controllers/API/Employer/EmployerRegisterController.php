<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\EmployerVerificationEmail;
use App\Mail\EmployerResetPassword;
use App\Models\Admin\Employer;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Str;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Admin\Industry;
use URL;

class EmployerRegisterController extends Controller
{
    protected function register(Request $request)
    {
        $this->validate($request, [
            'phone'            => ['nullable', new MyanmarPhone],
            'name'             => ['required', 'string'],
            'industry_id'      => ['required'],
            'email'            => ['required', 'string', 'email', 'max:255', 'unique:employers,email,NULL,id,deleted_at,NULL'],
            'password'         => ['required', 'string', 'min:8', 'same:confirmed'],
            'confirmed'        => ['required', 'string', 'min:8', 'same:password'],
        ]);

        $employer = Employer::create([
            'name'                     => $request['name'],
            'industry_id'              => $request['industry_id'],
            'email'                    => $request['email'],
            'phone'                    => $request['phone'],
            'password'                 => Hash::make($request['password']),
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

            return response()->json([
                'status' => 'success',
                'msg' => 'Please check your email to activate your account.',
                'employer_id' => $employer->id,
                'email_verification_token' => $employer->email_verification_token
            ], 200);
        }
    }

    public function employerVerifyResend(Request $request)
    {
        $employer        = Employer::whereId($request->employer_id)->whereNull('deleted_at')->whereIsActive(0)->first();
        if ($employer) {
            $employer_update = $employer->update([
                'email_verification_token' => Str::random(32),
            ]);

            \Mail::to($employer->email)->send(new EmployerVerificationEmail($employer));

            return response()->json([
                'status' => 'success',
                'msg' => 'Successfully resend!Please check your email to activate your account.',
                'employer_id' => $employer->id,
                'email_verification_token' => $employer->email_verification_token
            ], 200);
        }else {
            return response()->json([
                'status' => 'success',
                'msg' => "Your email was don't exist. Please Try Again!",
            ], 200);
        }
    }

    public function getEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $employer = Employer::whereEmail($request->email)->whereIsActive(1)->whereNotNull('email_verified_at')->whereNull('deleted_at')->first();

        if (isset($employer)) {
            $employer_update = $employer->update([
                'email_verification_token' => Str::random(32),
            ]);

            $user_name = $employer->name;
            
            $reseturl  = env('MAIN_DOMAIN').'/account/change-password?type=employer&employer_id='.$employer->id;
            \Mail::to($employer->email)->send(new EmployerResetPassword($user_name, $reseturl));

            return response()->json([
                'status' => 'success',
                'employer_id' => $employer->id,
                'msg' => 'Please, check email for reset link.'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => "Your email was don't exist. Please Try Again!"
            ], 500);
        }
    }

    public function storeResetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'same:confirmed'],
            'confirmed' => ['required', 'string', 'min:8', 'same:password'],
            'employer_id' => ['required']
        ]);
        
        $password = Hash::make($request['password']);

        $employer = Employer::find($request->employer_id);

        $employer->update([
            'password' => $password,
        ]);
        return response()->json([
            'status' => 'success',
            'msg' => "Reset Password Successfully."
        ], 200);
    }
}
