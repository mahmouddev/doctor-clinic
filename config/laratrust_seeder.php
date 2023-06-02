<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users'    => false,
    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => false,

    'roles_structure' => [
        'superadmin'       => [
            'users'     => 'c,r,u,d',
            'roles'     => 'c,r,u,d',
            'pages'     => 'c,r,u,d',
            'hub-files' => 'c,r,u,d',
            'settings'  => 'u',
            'profile'   => 'r,u',
        ],
        'admin'            => [
            'users'     => 'c,r,u,d',
            'roles'     => 'r',
            'articles'  => 'c,r,u,d',
            'pages'     => 'c,r,u,d',
            'hub-files' => 'c,r,u,d',
            'profile'   => 'r,u',
        ],
        'customer_support' => [
            'profile' => 'r,u',
        ],
        'editor'           => [
            'pages'   => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'user'             => [
            'profile' => 'r,u',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
