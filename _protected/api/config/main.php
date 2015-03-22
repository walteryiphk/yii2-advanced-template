<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'options' => [
                'token_param_name' => 'access_token',
                'access_lifetime' => 3600 * 24,
                'allow_implicit' => true,
            ],
            'storageMap' => [
                'user_credentials' => 'common\models\User'
            ],
            'grantTypes' => [
                'authorization_code' => [
                    'class' => '\OAuth2\GrantType\AuthorizationCode',
                ],
                'user_credentials' => [
                    'class' => '\OAuth2\GrantType\UserCredentials'
                ],
                'client_credentials' => [
                    'class' => '\OAuth2\GrantType\ClientCredentials',
                    'allow_public_clients' => false
                ],
                'refresh_token' => [
                    'class' => '\OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => false,   //default
                    'refresh_token_lifetime' => 1209600,    //default
                ],
            ],
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\UserIdentity',
            'enableAutoLogin' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                'GET,POST oauth2/<action:\w+>' => 'oauth2/default/<action>',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['site'],
                ],
            ],
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
        'response' => [
            'format' => 'json'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
