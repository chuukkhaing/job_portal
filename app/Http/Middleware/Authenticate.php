<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if($request->route()->getPrefix() == 'admin') {
            if (! $request->expectsJson()) {
                return route('login');
            }
        }elseif($request->route()->getPrefix() == 'seeker') {
            if (! $request->expectsJson()) {
                return route('login-form');
            }
        }elseif($request->route()->getPrefix() == 'employer') {
            if (! $request->expectsJson()) {
                return route('employer-login-form');
            }
        }
        
    }
}
