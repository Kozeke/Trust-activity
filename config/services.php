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
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '361241247840775',         // Your GitHub Client ID
        'client_secret' => '429ef39ac61c2218b5d2064b1134a082', // Your GitHub Client Secret
        'redirect' => 'https://www.trustactivity.com/auth/facebook/callback',
    ],

    'google' => [
        'client_id' => '925509346463-chqcjkmsnhkm69h5u06sjq0hts08ni75.apps.googleusercontent.com',         // Your GitHub Client ID
        'client_secret' => 'iB82nJ0w733kzWlPee8NJwdb', // Your GitHub Client Secret
        'redirect' => 'https://www.trustactivity.com/auth/google/callback',
    ],

    'twitter' => [
        'client_id' => '361241247840775',         // Your GitHub Client ID
        'client_secret' => '429ef39ac61c2218b5d2064b1134a082', // Your GitHub Client Secret
        'redirect' => 'https://www.trustactivity.com/auth/facebook/callback',
    ],

];
