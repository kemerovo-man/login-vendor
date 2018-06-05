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
        
        $this->app->bind('Form', function($app){
            return new \Collective\Html\FormFacade();
        });
        $this->app->bind('Html', function($app){
            return new \Collective\Html\HtmlFacade();
        });
    }

}
