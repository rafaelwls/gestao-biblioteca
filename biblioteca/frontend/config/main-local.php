<?php

$config = [
    'components' => [
        'request' => [

            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_DRLWsKRJnSX9RbERMFvVy2dGp1-BFdO',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,    // ativa URLs “bonitinhas”
            'showScriptName' => false,    // esconde o index.php
            'rules' => [
                // suas regras de rota, se precisar
            ],
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
    ];
}

return $config;
