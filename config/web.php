<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
	'timeZone' => 'PRC',
	'language' => 'zh-CN',
    'bootstrap' => ['log'],
	'modules' => [
		'admin' => [
			'class' => 'app\modules\admin\Module'
		],
		'wap' => [
			'class' => 'app\modules\wap\Module'
		],
	],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wengfj15306560313',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser', // required for POST input via `php://input`
            ]
        ],
        'cache' => require(__DIR__ . '/cache.php'),
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
    	'authManager'=>array(
    		'class'=>'yii\rbac\DbManager',//认证类名称
    		'defaultRoles'=>array('guest'),//默认角色
    		'itemTable' => 'auth_item',//认证项表名称
    		'itemChildTable' => 'auth_item_child',//认证项父子关系
    		'assignmentTable' => 'auth_assignment',//认证项赋权关系
    	),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            	'' => 'default/index',	//首页
            	'wap' => 'wap/default/index',	//Wap首页
            	'<module:admin>/<action:\w+>' => '<module>admin/community/<action>',
				'<module:admin>/<action:\w+>/<id:\d+>' => '<module>admin/community/<action>'
            ],
        ],
    ],	
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    	'allowedIPs' => ['*'],
    ];
}

return $config;
