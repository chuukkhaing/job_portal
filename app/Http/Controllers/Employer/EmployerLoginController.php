<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Admin\Employer;
use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class EmployerLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/employer/profile';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:employer')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'company_email'    => 'required',
            'company_password' => 'required|min:6',
        ]);

        if (\Auth::guard('employer')->attempt(['email' => $request->company_email, 'password' => $request->company_password], $request->get('company_remember'))) {
            if(Auth::guard('employer')->user()->is_active == 0) {
                Auth::guard('employer')->logout();

                $request->session()->flush();
        
                $request->session()->regenerate();
                return redirect()->route('home')->with('error', 'Your account is not active.');
            }else {
                return redirect()->route('employer-profile.index')->with('success', 'Login Successfully.');
            }
        } else {
            return redirect()->back()->with('error', 'You have entered wrong credentials. Please Try Again!')->withInput($request->only('company_email', 'company_remember'));
        }

    }

    public function VerifyEmail($token = null)
    {
        if ($token == null) {
            return redirect()->route('home')->with('error', 'Invlid token.');
        }

        $employer = Employer::where('email_verification_token', $token)->first();

        if ($employer == null) {
            return redirect()->route('home')->with('error', 'Invlid token.');
        }
        if ($employer->email_verified == 1) {
            return redirect()->route('home')->with('error', 'Your account was already activated.');
        } else {
            $employer_update = $employer->update([
                'email_verified'           => 1,
                'email_verified_at'        => Carbon::now(),
                'is_active'                => 1,
                'email_verification_token' => '',
            ]);

            Auth::guard('employer')->login($employer);
            if (Auth::guard('employer')->user()) {
                return redirect()->route('employer-profile.index')->with('success', 'Your account is activated.');
            }
        }
    }
}
