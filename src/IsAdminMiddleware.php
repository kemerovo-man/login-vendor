<?php

namespace KemerovoMan\LoginVendor;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    private function getRole()
    {
        $roles = config('login.roles', []);
        foreach ($roles as $roleName => $roleInfo) {
            if (session('loginVendorRole') == $roleName) {
                return $roleName;
            }
        }
        return null;
    }

    public function handle(Request $request, Closure $next)
    {
        $roleName = $this->getRole();
        if ($roleName) {
            $ips = config('login.roles' . $roleName . '.adminIps', []);
            if (!$ips) {
                return $next($request);
            }
            foreach ($ips as $ip) {
                if ($ip == $_SERVER['REMOTE_ADDR']) {
                    return $next($request);
                }
            }
        }
        return redirect()
            ->action('\KemerovoMan\LoginVendor\LoginController@index', ['redirect_to' => $request->fullUrl()]);
    }
}

