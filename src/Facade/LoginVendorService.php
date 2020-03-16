<?php

namespace KemerovoMan\LoginVendor\Facade;

use Illuminate\Support\Facades\Facade;

class LoginVendorService extends Facade
{
    /**
     * @return \KemerovoMan\LoginVendor\LoginVendorService;
     */
    public static function instance()
    {
        return parent::getFacadeRoot();
    }

    protected static function getFacadeAccessor()
    {
        return \KemerovoMan\LoginVendor\LoginVendorService::class;
    }
}
