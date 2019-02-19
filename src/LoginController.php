<?php

namespace KemerovoMan\LoginVendor;

use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function index()
    {
        $redirectTo = Input::get('redirect_to');
        $view = config('login.loginView');
        if ($view) {
            return View::make($view);
        } else {
            View::addLocation(__DIR__);
            return View::make('login')
                ->with('redirectTo', $redirectTo);
        }
    }

    public function login()
    {
        $login = Input::get('login');
        $password = Input::get('password');
        $redirectTo = Input::get('redirect_to');
        $now = Carbon::now();
        if (file_exists(storage_path('last_login_timestamp'))) {
            $lastAttempt = file_get_contents(storage_path('last_login_timestamp'));
            if ($lastAttempt) {
                $lastAttempt = Carbon::createFromTimestamp($lastAttempt);
                if ($lastAttempt->diffInSeconds($now) < 10) {
                    return redirect()->back()
                        ->withErrors(['message' => 'Попробуйте еще раз через 10 сек']);
                }
            }
        }
        file_put_contents(storage_path('last_login_timestamp'), $now->timestamp);
        if (!$login || !$password) {
            return redirect()->back()
                ->withErrors(['message' => 'Не заполнены поля']);
        }
        $roles = config('login.roles', []);

        foreach ($roles as $roleName => $roleInfo) {
            $credentials = isset($roleInfo['credentials']) ? $roleInfo['credentials'] : [];
            foreach ($credentials as $cred) {
                if (isset($cred['login'])
                    && isset($cred['password'])
                    && $login == $cred['login']
                    && $password == $cred['password']
                ) {
                    session()->put('loginVendorRole', $roleName);
                    session()->save();
                    if (config('login.log', true)) {
                        file_put_contents(storage_path('login.log'), $now->toDateTimeString() . ' ' . $login . "\n", FILE_APPEND);
                    }
                    if ($redirectTo) {
                        return redirect()
                            ->to($redirectTo);
                    }
                    return redirect()
                        ->to($roleInfo['redirectTo']);
                }

            }
        }
        if (config('login.log', true)) {
            file_put_contents(storage_path('login_failed.log'), $now . ' ' . $login . "\n", FILE_APPEND);
        }
        return redirect()->back()
            ->withErrors(['message' => 'Не верные логин пароль']);
    }

    public function logout()
    {
        session()->put('loginVendorRole', false);
        return redirect()
            ->action('\KemerovoMan\LoginVendor\LoginController@index');
    }
}