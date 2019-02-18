<?php

namespace KemerovoMan\LoginVendor;

class LoginMiddleware
{
    private function getCurrentRole()
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
            if ($ip && ($ip == $_SERVER['REMOTE_ADDR']
                    || (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $ip == $_SERVER['HTTP_X_FORWARDED_FOR'])
                )
            ) {
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
}

