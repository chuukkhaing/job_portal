<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class EmployerLoginController extends Controller
{
    public function login(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], $messages = [
            'required' => ['The :attribute is required.'],
            'email' => 'The :attribute must be a valid email address.',
            'min' => 'The :attribute must be at least :min.',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->messages()], 422);
        } else {
            if (\Auth::guard('employer')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'is_active' => 1, 'deleted_at' => Null])) {
                if(Auth::guard('employer')->user()->is_active == 0 || isset(Auth::guard('employer')->user()->deleted_at) || Auth::guard('employer')->user()->email_verified_at == Null) {
                    Auth::guard('employer')->logout();
                    return response()->json([
                        'status' => 'error',
                        'msg' => 'Your account is not active.',
                    ], 200);
                }else {
                    $token = Auth::guard('employer')->user()->createToken(Auth::guard('employer')->user()->email.'-AuthToken')->plainTextToken;
            
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
