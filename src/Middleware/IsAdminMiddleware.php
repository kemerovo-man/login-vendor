<?php

namespace KemerovoMan\LoginVendor\Middleware;

use Closure;
use Illuminate\Http\Request;
use KemerovoMan\LoginVendor\Facade\LoginVendorService;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (LoginVendorService::instance()->isRole('admin')) {
            return $next($request);
        }
        return redirect()
            ->action('\KemerovoMan\LoginVendor\LoginController@index', ['redirect_to' => $request->fullUrl()]);
    }
}

