<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
	
		'authClientCollection' => [
			'class' => 'yii\authclient\Collection',
			'clients' => [
					'facebook' => [
							'class' => 'yii\authclient\clients\Facebook',
							'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
							//'clientId' => '1848502635402065',
							'clientId' => '1526000560772725',
							//'clientSecret' => '1f35128b3bc16f11b2f630d397561ef8',
							'clientSecret' => '10f43219664d393551ee195dfe4f407e',
					],
					'google' => [
							'class' => 'yii\authclient\clients\GoogleOAuth',
							//'clientId' => '245857181256-0it2kukhe6lucamqhr05lkke50o3dglc.apps.googleusercontent.com',
							'clientId' => '698009415187-ho0u3l90m40afjao4a5aubre7ata7l07.apps.googleusercontent.com',
							//'clientSecret' => 'dW5lI6mH8z_GZtSTmFT56-vF',
							'clientSecret' => '5FI1O3-uC0wsBk2p8bTl_ZBx',
							'returnUrl' => 'http://127.0.0.1/prakash/projects/nap/frontend/web/index.php?r=site/auth&authclient=google',
					],
			],
        ],
		
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
