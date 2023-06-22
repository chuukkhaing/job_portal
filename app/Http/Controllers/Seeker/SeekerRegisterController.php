<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Seeker\Seeker;
use Illuminate\Auth\Events\Registered;
use App\Mail\SeekerVerificationEmail;

class SeekerRegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:seeker');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone' => ['nullable', new MyanmarPhone],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:seekers'],
            'password' => ['required', 'string', 'min:8', 'same:confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    public function frontendRegister() 
    {
        return view ('frontend.register');
    }

    protected function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $seeker = Seeker::create([
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
        ]);
        \Mail::to($seeker->email)->send(new SeekerVerificationEmail($seeker));

        session()->flash('message', 'Please check your email to activate your account');
       
        return redirect()->back();
    }
}
