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
        'base_url' => env('OPENAGENTIC_BASE_URL', 'https://bansos-ai.digitalindotech.cloud/v1'),
        'key' => env('OPENAGENTIC_API_KEY'),
        'model' => env('OPENAGENTIC_MODEL', 'antigravity/gemini-3.1-flash-image'),
        'image_dir' => env('OPENAGENTIC_IMAGE_DIR'),

        // Hanya model yang benar-benar punya rute imageGeneration di gateway.
        'models' => [
            'antigravity/gemini-3.1-flash-image' => 'Gemini 3.1 Flash Image',
        ],
    ],

    'inferhub' => [
        'base_url' => env('INFERHUB_BASE_URL', 'https://api.inferhub.dev/v1'),
        'key' => env('INFERHUB_API_KEY'),
        'model' => env('INFERHUB_MODEL', 'zai/glm-5.3-flash'),
        'timeout' => (int) env('INFERHUB_TIMEOUT', 60),
    ],

];
