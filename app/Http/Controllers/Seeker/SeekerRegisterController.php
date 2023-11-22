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
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Admin\FunctionalArea;
use URL;
use App\Models\Seeker\SeekerPercentage;
use Auth;

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

    public function applicationCreate()
    {
        $states               = State::whereNull('deleted_at')->whereIsActive(1)->get();
        $townships            = Township::whereNull('deleted_at')->whereIsActive(1)->get();
        $functional_areas     = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id', '!=', 0)->whereIsActive(1)->get();
        $industries           = Industry::whereNull('deleted_at')->get();
        return view ('frontend.application.create', compact('states', 'townships', 'functional_areas', 'sub_functional_areas', 'industries'));
    }

    public function applicationRegister(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:seekers,email,NULL,id,deleted_at,NULL',
            'password' => ['required', 'string', 'min:8'],
            'confirmed' => ['required', 'string', 'min:8', 'same:password'],
        ]);
        $seeker = Seeker::create([
            'email'                    => $request['email'],
            'date_of_birth'            => null,
            'password'                 => Hash::make($request['password']),
            'register_at'              => Carbon::now(),
            'email_verified'           => 1,
            'email_verified_at'        => Carbon::now(),
            'is_active'                => 1,
            'email_verification_token' => '',
        ]);
        foreach (config('seekerPercentTitle')['name'] as $title) {
            $seeker_percent = SeekerPercentage::create([
                'seeker_id' => $seeker->id,
                'title'     => $title,
            ]);
        }
        Auth::guard('seeker')->login($seeker);
        if ($seeker) {
            return response()->json([
                'status' => 'success',
                'seeker' => $seeker,
                'msg' => 'Thank for your information.'
            ]);
        }
    }

    public function getTownship($id)
    {
        $townships = Township::whereStateId($id)->whereNull('deleted_at')->orderBy('name')->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data'   => $townships,
        ]);
    }
}
