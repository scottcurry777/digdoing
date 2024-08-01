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
        if (($request->wantsJSON()) or ($request->root() == 'https://api.digdoing.com')) {
            // API
            
            // Do not re-direct; just show unauthenticated
            
            // return route('/');
        } else {
            // WEB
            return route('login');
        }
    }
}
