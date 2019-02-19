# Логин вендор для Laravel 5.7

Добавляет в проект простую авторизацию.
Показывает форму с логин/паролем, при удачной авторизации пишет в сессию переменную loginVendorRole.
Настроики в config/login.php
Добавляет в проект роуты:
/login
/logout

## Установка

1. добавить в composer.json

для Laravel 5.7
```
    "require": {
        "kemerovo-man/login-vendor": "5.7.*"
    }
```

2. добавить в app.conf
```
    'providers' => [
        KemerovoMan\LoginVendor\LoginVendorServiceProvider::class
    ]
```
3. php artisan vendor:publish

4. настроить config/login.php

можно настроить несколько ролей, в каждой роли настроить нескольких пользователей,
и редирект для каждой роли.

Например:
```
'roles' => [
        'admin' => [
            'redirectTo' => env('LOGIN_ADMIN_REDIRECT_TO'),
            'credentials' => [
                [
                    'login' => env('LOGIN_ADMIN_LOGIN'),
                    'password' => env('LOGIN_ADMIN_PASSWORD')
                ]
            ]
        ],
        'user' => [
            'redirectTo' => env('LOGIN_USER_REDIRECT_TO'),
            'credentials' => [
                [
                    'login' => env('LOGIN_USER_LOGIN'),
                    'password' => env('LOGIN_USER_PASSWORD')
                ]
            ]
        ]
    ]
```
Создать Middleware с проверкой в сессии переменной loginVendorRole

Например:
```
class IsAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (session('loginVendorRole') == 'admin') {
            return $next($request);
        } else {
            return redirect()
                ->action('\KemerovoMan\LoginVendor\LoginController@index');
        }
    }
}
```
или использовать готовую: добавить в app\Http\Kernel.php
```
   protected $routeMiddleware = [
          'isAdmin' => \KemerovoMan\LoginVendor\Middleware\IsAdminMiddleware::class
      ];
```
