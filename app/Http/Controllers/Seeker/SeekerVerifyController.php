<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Seeker\Seeker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class SeekerVerifyController extends Controller
{
   public function VerifyEmail($token = null)
   {
      if($token == null) {
         return redirect()->route('home')->with('error','Invlid token.');
      }

      $seeker = Seeker::where('email_verification_token',$token)->first();
      
      if($seeker == null )
      {
         return redirect()->route('home')->with('error','Invlid token.');
      }
      if($seeker->email_verified == 1) {
         return redirect()->route('home')->with('error','Your account was already activated.');
      } else {
         $seeker_update = $seeker->update([
            'email_verified' => 1,
            'email_verified_at' => Carbon::now(),
            'is_active' => 1,
            'register_at' => Carbon::now()
         ]);
         Auth::guard('seeker')->login($seeker);
         if(Auth::guard('seeker')->user()) {
         return redirect()->route('home')->with('success','Your account is activated.');
         }
      }
   }

   public function notice()
   {
      if(auth()->guard('seeker')->user() == null || auth()->guard('seeker')->user()->email_verified == 1) {
         return redirect()->route ('home');
      }else {
         return view ('seeker.verify.notice');
      }
   }
}
