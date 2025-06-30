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
        [
            'title' => 'Usuários',
            'icon' => '👥',
            'items' => [
                ['title' => 'Todos os usuários', 'url' => ['/usuarios/index'], 'icon' => '👥'], 
            ],
        ],  
    ];

    public function run()
    {
        return $this->render('sidebar', [
            'menuItems' => $this->menuItems,
        ]);
    }
}
