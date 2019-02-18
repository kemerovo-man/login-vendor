<?php

return [

    // 'loginView' => 'custom',
    'roles' => [
        'admin' => [
            'redirectTo' => env('LOGIN_ADMIN_REDIRECT_TO'),
            'credentials' => [
                [
                    'login' => env('LOGIN_ADMIN_LOGIN'),
                    'password' => env('LOGIN_ADMIN_PASSWORD')
                ]
            ],
            'adminIps' => [
                env('LOGIN_ADMIN_IP')
            ],
        ],
    ]
];