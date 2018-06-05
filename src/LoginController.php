<?php
namespace KemerovoMan\LoginVendor;

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
                    if ($redirectTo) {
                        return redirect()
                            ->to($redirectTo);
                    }
                    return redirect()
                        ->to($roleInfo['redirectTo']);
                }

            }
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