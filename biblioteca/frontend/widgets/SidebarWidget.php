<?php

namespace frontend\widgets;

use yii\base\Widget;

class SidebarWidget extends Widget
{
    public $menuItems = [
        [
            'title' => 'Livros',
            'icon'  => '📚',
            'items' => [
                ['title' => 'Favoritos', 'url' => ['/livros/favoritos'], 'icon' => '❤️'],
                ['title' => 'Todos os Livros', 'url' => ['/livros/index'], 'icon' => '📖'],
            ],
        ],
        [
            'title' => 'Dashboard',
            'icon' => '📊',
            'items' => [
                ['title' => 'Fluxo de Pessoas', 'url' => ['/dashboard/fluxo-pessoas'], 'icon' => '👥'],
                ['title' => 'Dashboard Livros', 'url' => ['/dashboard/livros'], 'icon' => '📚'],
            ],
        ],
        // … adicione o resto aqui …
    ];

    public function run()
    {
        return $this->render('sidebar', [
            'menuItems' => $this->menuItems,
        ]);
    }
}
