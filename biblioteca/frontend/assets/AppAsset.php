<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css = [
        // Tailwind via CDN
        
        'css/site.css',
        'https://cdn.jsdelivr.net/npm/tailwindcss@3.4.6/dist/tailwind.min.css',
    ];
    public $js = [
        // seus scripts aqui
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset', // <<< REMOVA esta linha
    ];
}
