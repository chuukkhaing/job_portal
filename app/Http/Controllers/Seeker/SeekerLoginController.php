<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class SeekerLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:seeker')->except('logout');
    }

    // public function showAdminLoginForm()
    // {
    //     return view('auth.login', ['url' => route('admin.login-view'), 'title'=>'Admin']);
    // }

    // public function adminLogin(Request $request)
    // {
    //     $this->validate($request, [
    //         'email'   => 'required|email',
    //         'password' => 'required|min:6'
    //     ]);

    //     if (\Auth::guard('admin')->attempt($request->only(['email','password']), $request->get('remember'))){
    //         return redirect()->intended('/admin/dashboard');
    //     }

    //     return back()->withInput($request->only('email', 'remember'));
    // }
}
