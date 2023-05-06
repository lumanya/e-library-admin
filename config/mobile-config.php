<?php

return [
    'ADMOB' => [
        'APP_ID'   => '',
        'BANNER_ID' => '',
        'INTERSTITIAL_ID' => '',
    ],

    // 'PAYPAL' => [
    //     'CLIENT_ID' => '',
    // ],

    'PAYTM' => [
        'MERCHANT_ID' => '',
        'SECRET_KEY' => '',
        'CHANNEL_ID' => '',
        'WEBSITE' => '',
        'INDUSTRY_TYPE_ID' => '',
        'CALLBACK_URL' => '',
    ],

    // 'COLOR' => [
    //     'PRIMARY_COLOR' => '',
    //     'SECONDARY_COLOR' => '',
    // ],
    'ONESIGNAL' => [
        'API_KEY' => env('ONESIGNAL_API_KEY'),
        'REST_API_KEY' => env('ONESIGNAL_REST_API_KEY'),
    ],
    'BRAINTREE' => [
        'ENV' => env('BRAINTREE_ENV'),
        'MERCHANT_ID' => env('BRAINTREE_MERCHANT_ID'),
        'PUBLIC_KEY' => env('BRAINTREE_PUBLIC_KEY'),
        'PRIVATE_KEY' => env('BRAINTREE_PRIVATE_KEY'),
        'Merchant_Account_Id' => env('BRAINTREE_Merchant_Account_Id'),
    ],

]

?>
