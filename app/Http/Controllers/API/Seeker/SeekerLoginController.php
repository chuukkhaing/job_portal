<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class SeekerLoginController extends Controller
{
    public function login(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], $messages = [
            'required' => 'The :attribute is required.',
            'email' => 'The :attribute must be a valid email address.',
            'min' => 'The :attribute must be at least :min.',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        } else {
            if (\Auth::guard('seeker')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'deleted_at' => Null])) {
                if(Auth::guard('seeker')->user()->is_active == 0 || isset(Auth::guard('seeker')->user()->deleted_at) || Auth::guard('seeker')->user()->email_verified_at == Null) {
                    Auth::guard('seeker')->logout();
                    return response()->json([
                        'status' => 'error',
                        'msg' => "Your account wasn't activated. Please check your email!",
                    ], 200);
                }elseif(Auth::guard('seeker')->user()->is_active == 1 || isset(Auth::guard('seeker')->user()->deleted_at) || Auth::guard('seeker')->user()->email_verified_at == Null)  {
                    $token = Auth::guard('seeker')->user()->createToken(Auth::guard('seeker')->user()->email.'-AuthToken')->plainTextToken;
            
                    return response()->json([
                        'status' => 'success',
                        'msg' => 'Login Successfully.',
                        'token_type' => 'Bearer',
                        'access_token' => $token,
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'You have entered wrong credentials. Please Try Again!',
                ], 200);
            }
        }
    }
}
