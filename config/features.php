<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Feature Flags
    |--------------------------------------------------------------------------
    |
    | This file is for managing feature flags. You can enable or disable
    | features for the entire application and restrict them to certain
    | roles. By default, features are disabled unless explicitly
    | enabled in the .env file.
    |
    */

    'dashboard_analytics' => [
        'enabled' => env('FEATURE_DASHBOARD_ANALYTICS_ENABLED', false),
        'roles' => ['super-admin', 'admin'],
        'description' => 'Enable analytics section on the main dashboard.',
    ],

    'user_impersonation' => [
        'enabled' => env('FEATURE_USER_IMPERSONATION_ENABLED', false),
        'roles' => ['super-admin'],
        'description' => 'Allows super-admins to log in as other users.',
    ],

    'library' => [
        'enabled' => env('FEATURE_LIBRARY_ENABLED', false),
        'roles' => ['super-admin'],
        'description' => 'Access to the media library management.',
    ],

    'portfolio' => [
        'enabled' => env('FEATURE_PORTFOLIO_ENABLED', false),
        'roles' => ['super-admin'],
        'description' => 'Access to portfolio management features.',
    ],

    'public_feature' => [
        'enabled' => env('FEATURE_PUBLIC_FEATURE_ENABLED', true), // Always enabled by default if global toggle is on
        'roles' => [], // Empty roles means accessible by any authenticated user
        'description' => 'A feature that is always enabled for authenticated users.',
    ],

];
