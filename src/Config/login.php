<?php

return [

    // 'loginView' => 'custom',
    'loginRoute' => 'login',
    'logoutRoute' => 'logout',
    'log' => true,
    'roles' => [
        'admin' => [
            'redirectTo' => env('LOGIN_ADMIN_REDIRECT_TO'),
            'credentials' => [
                [
                    'login' => env('LOGIN_ADMIN_LOGIN'),
                    'password' => env('LOGIN_ADMIN_PASSWORD')
                ]
            ],
            'allowIps' => [
                env('LOGIN_ADMIN_IP')
            ],
        ],
        'developer' => [
            'redirectTo' => env('LOGIN_DEVELOPER_REDIRECT_TO'),
            'credentials' => [
                [
                    'login' => env('LOGIN_DEVELOPER_LOGIN'),
                    'password' => env('LOGIN_DEVELOPER_PASSWORD')
                ]
            ],
            'allowIps' => [
                env('LOGIN_DEVELOPER_IP')
            ],
        ],
    ]
];