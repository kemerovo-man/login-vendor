<?php

namespace KemerovoMan\LoginVendor;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class LoginVendorServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        require_once __DIR__ . '/' . 'routes.php';

        $this->publishes([
            __DIR__ . '/Config/login.php' => config_path('login.php'),
        ]);

        App::register(\Collective\Html\HtmlServiceProvider::class);

        app()->bind('Form', function () {
            return new \Collective\Html\FormFacade();
        });
        app()->bind('Html', function () {
            return new \Collective\Html\HtmlFacade();
        });
        app()->bind(LoginVendorService::class, function () {
            return new LoginVendorService();
        });
        app()->alias(LoginVendorService::class,
            'login.vendor.service');
    }

}
