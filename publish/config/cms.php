<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Images
     |--------------------------------------------------------------------------
     */
    'image_path' => 's3' == env('FILESYSTEM_DRIVER')
        ? 'https://'.env('AWS_BUCKET').'.s3.'.env('AWS_DEFAULT_REGION').'.amazonaws.com/'
        : env('APP_URL').'/storage/',


    /*
     |--------------------------------------------------------------------------
     | Multilingual feature
     |--------------------------------------------------------------------------
     */
    'enable_multilingual_feature' => false,
    'locales' => [
        'en' => 'English',
        'fr' => 'Français',
    ],
    'default_language' => 'en',

    /*
     |--------------------------------------------------------------------------
     | SEO
     |--------------------------------------------------------------------------
     */
    'disable_robots_follow' => env('DISABLE_ROBOTS_FOLLOW', false),
];
