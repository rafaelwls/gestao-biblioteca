<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var \app\models\Usuarios $user */
$menu = [

  // LIVROS (público)
  [
    'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24"><path stroke-linecap="round"
                     stroke-linejoin="round" stroke-width="2"
                     d="M12 6l-2 5h4l-2 5"/></svg>',
    'title' => 'Livros',
    'items' => [
      ['label' => 'Favoritos',     'url' => ['/livro/favoritos']],
      ['label' => 'Todos os Livros', 'url' => ['/livro/index']],
    ],
  ],

  // DASHBOARD (admin + trabalhador)
  ($user->is_admin || $user->is_trabalhador) ? [
    'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24"><path stroke-linecap="round"
                     stroke-linejoin="round" stroke-width="2"
                     d="M3 3h18v18H3V3z"/></svg>',
    'title' => 'Dashboard',
    'items' => [
      ['label' => 'Fluxo de Pessoas', 'url' => ['/dashboard/fluxo']],
      ['label' => 'Dashboard Livros', 'url' => ['/dashboard/livros']],
    ],
  ] : null,

  // COMPRAS
  ($user->is_admin || $user->is_trabalhador) ? [
    'icon' => '…',
    'title' => 'Compras',
    'items' => [['label' => 'Pedidos de Compras', 'url' => ['/compras']]],
  ] : null,

  ($user->is_admin || $user->is_trabalhador) ? [
    'icon' => '…',
    'title' => 'Vendas',
    'items' => [['label' => 'Pedidos de Vendas', 'url' => ['/vendas']]],
  ] : null,

  // CONTROLE (admin + trabalhador)
  ($user->is_admin || $user->is_trabalhador) ? [
    'icon'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24"><path stroke-linecap="round"
                     stroke-linejoin="round" stroke-width="2"
                     d="M3 7h18M3 12h18M3 17h18"/></svg>',
    'title' => 'Controle de Livros',
    'items' => [
      ['label' => 'Gerenciar Livros', 'url' => ['/controle/livros']],
    ],
  ] : null,
];

// remove nulls
$menu = array_filter($menu);
?>

<aside class="fixed inset-y-0 left-0 w-60 bg-white border-r z-40">
  <div class="p-4 mb-4">
    <h1 class="text-xl font-bold leading-5">BiblioTech</h1>
    <p class="text-xs text-gray-500">Sistema de Biblioteca</p>
  </div>

  <nav class="space-y-2">
    <?php
    foreach ($menu as $group) {
      echo $this->render('_menuGroup', $group);
    }
    ?>
  </nav>
</aside>
