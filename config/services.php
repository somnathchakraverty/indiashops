<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => indiashopps\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => '1656762601211077',
        'client_secret' => '58d20e0d5f5a76e8a5821eab336efbd7',
        'redirect' => '/slogin/process/facebook',
    ],
    'google' => [
        'client_id' => '435001265601-dr0f2dr2r302s9e8ikqbigrg43e1papd.apps.googleusercontent.com',
        'client_secret' => 'ekSqhfBRBkVkH_ZsYeXps2ot',
        'redirect' => '/slogin/process',
    ],

];
