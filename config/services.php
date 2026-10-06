<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'openagentic' => [
        'base_url' => env('OPENAGENTIC_BASE_URL', 'https://openagentic.id/api/v1'),
        'key'      => env('OPENAGENTIC_API_KEY'),
        'model'    => env('OPENAGENTIC_MODEL', 'ali-z-image-turbo'),
    ],

    'cartethyia' => [
        'base_url' => env('CARTETHYIA_BASE_URL', 'https://carte.risun.web.id/v1'),
        'key'      => env('CARTETHYIA_API_KEY'),
        'model'    => env('CARTETHYIA_MODEL', 'bansos/deepseek-v4.1-flash'),
        'timeout'  => (int) env('CARTETHYIA_TIMEOUT', 60),
    ],

];
