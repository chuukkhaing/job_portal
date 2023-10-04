<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Mail\SeekerResetPassword;
use App\Mail\SeekerVerificationEmail;
use App\Models\Admin\Industry;
use App\Models\Seeker\Seeker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use URL;

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
        $this->middleware('guest:employer');
    }

    public function frontendRegister()
    {
        return view('frontend.register');
    }

    protected function register(Request $request)
    {
        $this->validate($request, [
            'phone'    => ['nullable', new MyanmarPhone],
            'email' => 'required|string|email|max:255|unique:seekers,email,NULL,id,deleted_at,NULL',
            'password' => ['required', 'string', 'min:8', 'same:confirmed'],
            'confirmed' => ['required', 'string', 'min:8', 'same:password'],
        ]);
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

            return redirect()->route('seeker-verify-notice', $seeker->id)->with('success', 'Please check your email to activate your account.');
        }
    }

    public function notice($id)
    {
        $seeker = Seeker::whereId($id)->whereNull('deleted_at')->whereIsActive(0)->first();
        if ($seeker) {
            return view('seeker.verify.notice', compact('id'));
        }
    }

    public function resend($id)
    {
        $seeker = Seeker::whereId($id)->whereNull('deleted_at')->whereIsActive(0)->first();
        if ($seeker) {
            $seeker_update = $seeker->update([
                'email_verification_token' => Str::random(32),
            ]);

            \Mail::to($seeker->email)->send(new SeekerVerificationEmail($seeker));

            return redirect()->route('seeker-verify-notice', $seeker->id)->with('success', 'Successfully resend!Please check your email to activate your account.');
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
            'email' => 'required|email|exists:seekers',
        ]);
        $seeker = Seeker::whereEmail($request->email)->whereIsActive(1)->whereNotNull('email_verified_at')->whereNull('deleted_at')->first();
        
        if (isset($seeker)) {
            $seeker_update = $seeker->update([
                'email_verification_token' => Str::random(32),
            ]);

            $first_name = $seeker->first_name;
            $last_name  = $seeker->last_name;
            $reseturl   = URL::to('/') . '/seeker' . '/' . $seeker->id . '/reset-password';

            \Mail::to($seeker->email)->send(new SeekerResetPassword($first_name, $last_name, $reseturl));

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
            'password' => ['required', 'string', 'min:8', 'same:confirmed'],
        ]);
        $password = Hash::make($request['password']);

        $seeker = Seeker::find($request->id);

        $seeker->update([
            'password' => $password,
        ]);

        return redirect()->route('login-form')->with('success', 'Reset Password Successfully.');

    }
}
