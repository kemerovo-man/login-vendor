<?php

namespace KemerovoMan\LoginVendor;

class LoginVendorService
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

    public function ipCheck($ips)
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
}

