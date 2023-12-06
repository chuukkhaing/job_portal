<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use Illuminate\Support\Facades\Validator;
use App\Models\Seeker\Seeker;
use App\Mail\SeekerVerificationEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SeekerRegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'phone'    => ['nullable', new MyanmarPhone],
            'email' => 'required|string|email|max:255|unique:seekers,email,NULL,id,deleted_at,NULL',
            'password' => ['required', 'string', 'min:8', 'same:confirmed'],
            'confirmed' => ['required', 'string', 'min:8', 'same:password'],
        ], $messages = [
            'required' => ['The :attribute is required.'],
            'MyanmarPhone' => ['The :attribute must be valid myanmar phone number.'],
            'email' => 'The :attribute must be a valid email address.',
            'same' => 'The :attribute and :other must match.',
            'min' => 'The :attribute must be at least :min.',
        ]);
        if ($validator->fails()) {
            return  $validator->messages();
        } else {
            $seeker = Seeker::create([
                'email'                    => $request['email'],
                'phone'                    => $request['phone'],
                'date_of_birth'            => null,
                'password'                 => Hash::make($request['password']),
                'email_verification_token' => Str::random(32),
                'register_at'              => Carbon::now(),
                'is_active'                => 0
            ]);
            if ($seeker) {
                \Mail::to($seeker->email)->send(new SeekerVerificationEmail($seeker));

                return response()->json([
                    'status' => 'success',
                    'msg' => 'Please check your email to activate your account.',
                    'seeker_id' => $seeker->id,
                    'email_verification_token' => $seeker->email_verification_token
                ], 200);
            }
        }
    }

    public function seekerVerifyResend(Request $request)
    {
        $seeker = Seeker::whereId($request->seeker_id)->whereNotNull('email_verification_token')->whereNull('deleted_at')->whereIsActive(0)->first();
        if ($seeker) {
            $seeker_update = $seeker->update([
                'email_verification_token' => Str::random(32),
            ]);

            \Mail::to($seeker->email)->send(new SeekerVerificationEmail($seeker));

            return response()->json([
                'status' => 'success',
                'msg' => 'Successfully resend!Please check your email to activate your account.',
                'seeker_id' => $seeker->id,
                'email_verification_token' => $seeker->email_verification_token
            ], 200);
        }else {
            return response()->json([
                'status' => 'success',
                'msg' => "Your email was done't exist. Please Try Again!",
            ], 200);
        }
    }
}
