<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BiblioAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $css = [
        'css/biblio.css',   // Tailwind minificado (já compilado)
    ];

    public $js = [];        // sem JS adicional por enquanto

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
