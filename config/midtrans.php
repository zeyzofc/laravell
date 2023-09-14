<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'), // Use the variable name from .env
    'client_key' => env('MIDTRANS_CLIENT_KEY'), // Use the variable name from .env
    'server_key' => env('MIDTRANS_SERVER_KEY'), // Use the variable name from .env

    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => false,
    'is_3ds' => false,
];