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
        'redirect' => 'https://www.1platform.tv/stripe_oauth_redirect',
    ],

    'facebook' => [
        'client_id' => '2410593049051877',
        'client_secret' => 'af89dde37f7647d76bde6fb24e1b9ab2',
        'redirect' => 'https://www.1platform.tv/login/facebook/callback',
    ],


    'twitter' => [
        'client_id' => '0t1RRRh4TtDdqXZrjnzqX1mwc',
        'client_secret' => 'R8KFwit0M6EE0yMD9OxmoT74VKmlS7Lr09ZnjxPXuPa71A4FJg',
        'redirect' => 'https://www.1platform.tv/login/twitter/callback',
        'user_name' => '1Platform_Tv',
    ],

    'google' => [
        'client_id' => '755919802113-pi9ak7oao6hraikd68i7ehagm5k7ok62.apps.googleusercontent.com',
        'client_secret' => 'Mz_Nr8nSdbsfIlftqn9_1QPK',
        'redirect' => 'https://www.1platform.tv/login/google/callback',
    ],

    'instagram' => [
        'client_id' => '658756721566560',
        'client_secret' => '80baa0284f5a3f1caa48133a7af05214',
        'redirect' => 'https://www.1platform.tv/connect-instagram-confirmed',
    ],

];
