<?php

namespace KemerovoMan\LoginVendor;

use Closure;
use Illuminate\Http\Request;

class IsDeveloperMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (app('login.vendor.middleware')->isRole('developer')) {
            return $next($request);
        }
        return redirect()
            ->action('\KemerovoMan\LoginVendor\LoginController@index', ['redirect_to' => $request->fullUrl()]);
    }
}

