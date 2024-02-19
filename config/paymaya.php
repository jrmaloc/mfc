<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayMaya Public Key
    |--------------------------------------------------------------------------
    |
    | This value is your PayMaya public API key. You can find this key in
    | your PayMaya account settings. Make sure to keep this key secure.
    |
    */
    'public_key' => env('PAYMAYA_PUBLIC_KEY'),

    /*
    |--------------------------------------------------------------------------
    | PayMaya Secret Key
    |--------------------------------------------------------------------------
    |
    | This value is your PayMaya secret API key. You can find this key in
    | your PayMaya account settings. Make sure to keep this key secure.
    |
    */
    'secret_key' => env('PAYMAYA_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | PayMaya Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the environment in which your PayMaya integration
    | operates. You can set it to 'SANDBOX' for testing and 'PRODUCTION' for
    | live transactions.
    |
    */
    'environment' => env('PAYMAYA_ENVIRONMENT', 'PRODUCTION'),
];
