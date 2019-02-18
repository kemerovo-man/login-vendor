<?php

namespace KemerovoMan\LoginVendor;

class LoginMiddleware
{
    public static function getCurrentRole()
    {
        $roles = config('login.roles', []);
        foreach ($roles as $roleName => $roleInfo) {
            if (session('loginVendorRole') == $roleName) {
                return $roleName;
            }
        }
        return null;
    }

    public static function isRole($roleName)
    {
        if (static::getCurrentRole() != $roleName) {
            return false;
        }
        $ips = array_filter(config('login.roles.' . $roleName . '.allowIps', []));
        if (!$ips) {
            return true;
        }
        foreach ($ips as $ip) {
            if ($ip && $ip == $_SERVER['REMOTE_ADDR']) {
                return true;
            }
        }
        return false;
    }
}

