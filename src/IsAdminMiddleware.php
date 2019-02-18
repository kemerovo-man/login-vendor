<?php

namespace KemerovoMan\LoginVendor;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $roles = config('login.roles', []);
        foreach (config('login.adminIps', []) as $ip) {
            if ($ip == $_SERVER['REMOTE_ADDR']) {
                foreach ($roles as $roleName => $roleInfo) {
                    if (session('loginVendorRole') == $roleName) {
                        return $next($request);
                    }
                }
            }
        }
        return redirect()
            ->action('\KemerovoMan\LoginVendor\LoginController@index', ['redirect_to' => $request->fullUrl()]);
    }
}

