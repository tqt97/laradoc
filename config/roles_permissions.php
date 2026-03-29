<?php

return [
    'roles' => [
        'super-admin' => [
            'permissions' => '*',
        ],
        'admin' => [
            'permissions' => [
                'view-dashboard',
                'manage-posts',
                'manage-categories',
                'manage-tags',
                'manage-links',
                'manage-ideas',
                'manage-snippets',
            ],
        ],
        'editor' => [
            'permissions' => [
                'view-dashboard',
                'manage-posts',
            ],
        ],
        'user' => [
            'permissions' => [
                'view-dashboard',
            ],
        ],
        'pro-user' => [
            'permissions' => [
                // 'view-dashboard',
                'access-pro-content',
            ],
        ],
        'premium-user' => [
            'permissions' => [
                // 'view-dashboard',
                'access-pro-content',
                'access-premium-content',
            ],
        ],
    ],
    'super-admin' => [
        'name' => 'Super Admin',
        'email' => 'admin@gmail.com',
        'password' => '12341234',
    ],
];
