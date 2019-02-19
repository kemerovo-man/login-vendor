<?php

namespace KemerovoMan\LoginVendor;

use Closure;
use Illuminate\Http\Request;

class LoginMiddleware
{
    public function getCurrentRole()
    {
        $roles = config('login.roles', []);
        foreach ($roles as $roleName => $roleInfo) {
            if (session('loginVendorRole') == $roleName) {
                return $roleName;
            }
        }
        return null;
    }

    private function ipCheck($ips)
    {
        foreach ($ips as $ip) {
            if ($ip && $ip == $_SERVER['REMOTE_ADDR']) {
                return true;
            }
        }
        return false;
    }

    public function isRole($roleName)
    {
        if ($this->getCurrentRole() != $roleName) {
            return false;
        }
        $ips = array_filter(config('login.roles.' . $roleName . '.allowIps', []));
        if (!$ips) {
            return true;
        }
        return $this->ipCheck($ips);
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->getCurrentRole()) {
            return $next($request);
        }
        return redirect()
            ->action('\KemerovoMan\LoginVendor\LoginController@index', ['redirect_to' => $request->fullUrl()]);
    }
}

