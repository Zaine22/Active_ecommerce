<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |--------------------------------------------------------------------------
    |
    | These are the credentials for the SMSPoh API. You can obtain your
    | API key and sender ID from your SMSPoh account dashboard.
    |
     */

    'api_key' => function_exists('env') ? env('SMSPOH_API_KEY', '') : '',
    'sender_id' => function_exists('env') ? env('SMSPOH_SENDER_ID', '') : '',

    /*
    |--------------------------------------------------------------------------
    | API Endpoint
    |--------------------------------------------------------------------------
    |
    | This is the base URL for the SMSPoh API. It is used for sending messages
    | and handling API requests. Modify this only if SMSPoh changes its endpoint.
    |
     */

    'api_url' => 'https://www.smspoh.com/api/v2/send',

    /*
    |--------------------------------------------------------------------------
    | Application Identifiers
    |--------------------------------------------------------------------------
    |
    | Add an application name and version here to identify your application when
    | making API calls. This is optional and can be used for debugging.
    |
     */

    'app' => [
        'name' => function_exists('env') ? env('SMSPOH_APP_NAME', 'SMSPohLaravel') : 'SMSPohLaravel',
        'version' => function_exists('env') ? env('SMSPOH_APP_VERSION', '1.0.0') : '1.0.0',
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Override
    |--------------------------------------------------------------------------
    |
    | In case you need to override the default HTTP client, you can specify
    | a custom HTTP client here.
    |
     */

    'http_client' => function_exists('env') ? env('SMSPOH_HTTP_CLIENT', '') : '',
];