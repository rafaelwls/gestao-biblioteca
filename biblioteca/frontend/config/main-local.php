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
                ''                     => 'dashboard/index',
                'dashboard'            => 'dashboard/index',
                'emprestimos'          => 'emprestimo/index',
                'livros'            => 'livro/index',
                'livros/create'     => 'livro/create',
                'livros/<id>'       => 'livro/view',
                'livros/<id>/edit'  => 'livro/update',
                'favoritos'         => 'livro/favoritos',
                /* Dashboard */
                'dashboard/fluxo'    => 'dashboard/fluxo',
                /* Compras */
                'compras'            => 'compra/index',
                'compras/create'     => 'compra/create',
                'compras/<id>'       => 'compra/view',
                'compras/<id>/edit'  => 'compra/update',
                'compras/<id>/delete' => 'compra/delete',
                /* Vendas */
                'vendas'             => 'venda/index',
                'vendas/create'      => 'venda/create',
                'vendas/<id>'        => 'venda/view',
                'vendas/<id>/edit'   => 'venda/update',
                'vendas/<id>/delete' => 'venda/delete',
                'vendas/<id>/status/<status>' => 'venda/set-status',   # opcional uso direto
                /* Controle */
                'controle/livros'    => 'controle/livros',
                /* User */
                'meus-emprestimos'        => 'emprestimo/meus',
                'emprestimos/pedidos'     => 'emprestimo/pedidos',
                'emprestimos/<id>/dev'    => 'emprestimo/devolver',
                'emprestimos'             => 'emprestimo/index',
                'POST api/fluxo' => 'api/fluxo',
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
