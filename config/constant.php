<?php

return [

	'USER' => [
			'DEFAULT_IMAGE'   => '/assets/img/icons/user/user.png',
		],
    'IMAGE_EXTENTIONS' => ['png','jpg','jpeg','ico'],


	'DEFAULT_IMAGE'   => '/images/default.jpg',


    'PAGINATION' => [
			'SEARCH' => 5,

		],

    'USER_SAVE_IMAGE_PATH'   => '/uploads/profile-image',

    'MAIL_SETTING' => [
        'MAIL_DRIVER' => env('MAIL_DRIVER'),
        'MAIL_HOST' => env('MAIL_HOST'),
        'MAIL_PORT' => env('MAIL_PORT'),
        'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
//        'MAIL_USERNAME' => env('MAIL_USERNAME'),
//        'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
    ],

    'CONFIGURATION' => [
        'APP_NAME' => env('APP_NAME'),
//        'APP_DEBUG' => env('APP_DEBUG'),
        'APP_SLOGUN' => env('App_SLOGUN')
    ],

    'SOCIAL' => [
        'facebook'=>[
            'FACEBOOK_CLIENT_ID'=>env('FACEBOOK_CLIENT_ID'),
            'FACEBOOK_CLIENT_SECRET'=>env('FACEBOOK_CLIENT_SECRET'),
            'FACEBOOK_REDIRECT'=>env('FACEBOOK_REDIRECT')
        ],
        'google'=> [
            'GOOGLE_APP_ID'=>env('GOOGLE_APP_ID'),
            'GOOGLE_APP_SECRET'=>env('GOOGLE_APP_SECRET'),
            'GOOGLE_REDIRECT'=>env('GOOGLE_REDIRECT'),
        ],
        'twitter'=> [
            'TWITTER_APP_ID'=>env('TWITTER_APP_ID'),
            'TWITTER_APP_SECRET'=>env('TWITTER_APP_SECRET'),
            'TWITTER_REDIRECT'=>env('TWITTER_REDIRECT'),
        ],
    ],

    'COLOR' => [
        'theme-type',
        '--gradient-first-color',
        '--gradient-second-color',
        '--gradient-degree',
        '--theme-color',
        '--main-border-color',
        '--text-main',
    ],

    'FONT' => [
        '--font-family'
    ],
];
