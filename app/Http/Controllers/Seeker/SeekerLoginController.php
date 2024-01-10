<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Seeker\Seeker;
use App\Models\Seeker\SeekerPercentage;
use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class SeekerLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/seeker/profile';

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
        $this->middleware('guest:seeker')->except('logout');
        $this->middleware('guest:employer')->except('logout');
    }

    public function frontendLogin()
    {
        // session(['returnUrl' => 'jobpost-detail', 'previous_url' => url()->previous()]);
        return view('frontend.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ]);
        Auth::viaRemember();
        $remember = $request->has('remember') ? true : false; 
        if (\Auth::guard('seeker')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'deleted_at' => Null, 'is_active' => 1], $remember)) {
            if(Auth::guard('seeker')->user()->is_active == 0 || isset(Auth::guard('seeker')->user()->deleted_at) || Auth::guard('seeker')->user()->email_verified_at == Null) {
                Auth::guard('seeker')->logout();

                $request->session()->flush();
        
                $request->session()->regenerate();
                return redirect()->route('login-form')->with('error', 'Your account is not active.');
            }else {
                return redirect()->intended('seeker/profile')->with('success', 'Login Successfully.');
            }
        } else {
            return redirect()->back()->with('error', 'You have entered wrong credentials. Please Try Again!')->withInput($request->only('email', 'remember'));
        }
    }

    public function VerifyEmail($token = null)
    {
        if ($token == null) {
            // return redirect()->route('home')->with('error', 'Invalid token.');
            $url = env('MAIN_DOMAIN').'?msg=Invalid token.';
            return redirect()->to($url);
        }

        $seeker = Seeker::where('email_verification_token', $token)->first();

        if ($seeker == null) {
            // return redirect()->route('home')->with('error', 'Invalid token.');
            $url = env('MAIN_DOMAIN').'?msg=Invalid token.';
            return redirect()->to($url);
        }
        if ($seeker->email_verified == 1) {
            // return redirect()->route('home')->with('error', 'Your account was already activated.');
            $url = env('MAIN_DOMAIN').'?msg=Your account was already activated.';
            return redirect()->to($url);
        } else {
            $seeker_update = $seeker->update([
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
            // if (Auth::guard('seeker')->user()) {
            //     return redirect()->route('profile.index')->with('success', 'Your account is activated.');
            // }
            $token = Auth::guard('seeker')->user()->createToken(Auth::guard('seeker')->user()->email.'-AuthToken')->plainTextToken;
            $url = env('MAIN_DOMAIN').'?token='.$token.'type=seeker';
            
            if (Auth::guard('seeker')->user()) {
                return redirect()->to($url);
            }
        }
    }

    public function VerifyMobileEmail ($token = null)
    {
        if ($token == null) {
            return redirect()->route('home')->with('error', 'Invalid token.');
        }

        $seeker = Seeker::where('email_verification_token', $token)->first();

        if ($seeker == null) {
            return redirect()->route('home')->with('error', 'Invalid token.');
        }
        if ($seeker->email_verified == 1) {
            return redirect()->route('home')->with('error', 'Your account was already activated.');
        } else {
            $seeker_update = $seeker->update([
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
            $token = Auth::guard('seeker')->user()->createToken(Auth::guard('seeker')->user()->email.'-AuthToken')->plainTextToken;
            $url = env('MOBILE_LOGIN_REDIRECT_URL').'?token_type=Bearer&access_token='.$token;
            
            if (Auth::guard('seeker')->user()) {
                return redirect()->to($url);
            }
        }
    }
}
