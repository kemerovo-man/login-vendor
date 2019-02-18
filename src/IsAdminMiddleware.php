<?php

namespace KemerovoMan\LoginVendor;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (app('login.vendor.middleware')->isRole('admin')) {
            return $next($request);
        }
        return redirect()
            ->action('\KemerovoMan\LoginVendor\LoginController@index', ['redirect_to' => $request->fullUrl()]);
    }
}

