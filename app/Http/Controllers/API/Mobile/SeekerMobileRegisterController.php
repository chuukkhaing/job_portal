<?php

namespace App\Http\Controllers\API\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use Illuminate\Support\Facades\Validator;
use App\Models\Seeker\Seeker;
use App\Mail\SeekerMobileVerificationEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SeekerMobileRegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'phone'    => ['nullable', new MyanmarPhone],
            'email' => 'required|string|email|max:255|unique:seekers,email,NULL,id,deleted_at,NULL',
            'password' => ['required', 'string', 'min:8', 'same:confirmed'],
            'confirmed' => ['required', 'string', 'min:8', 'same:password'],
            'device_id' => ['required'],
            'device_type' => ['required']
        ], $messages = [
            'required' => 'The :attribute is required.',
            'MyanmarPhone' => 'The :attribute must be valid myanmar phone number.',
            'email' => 'The :attribute must be a valid email address.',
            'same' => 'The :attribute and :other must match.',
            'min' => 'The :attribute must be at least :min.',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        } else {
            $seeker = Seeker::create([
                'email'                    => $request['email'],
                'phone'                    => $request['phone'],
                'date_of_birth'            => null,
                'password'                 => Hash::make($request['password']),
                'email_verification_token' => Str::random(32),
                'register_at'              => Carbon::now(),
                'is_active'                => 0,
                'device_id'                => $request['device_id'],
                'device_type'              => $request['device_type']
            ]);
            if ($seeker) {
                \Mail::to($seeker->email)->send(new SeekerMobileVerificationEmail($seeker));

                return response()->json([
                    'status' => 'success',
                    'msg' => 'Please check your email to activate your account.',
                    'seeker_id' => $seeker->id,
                    'email_verification_token' => $seeker->email_verification_token
                ], 200);
            }
        }
    }
}
