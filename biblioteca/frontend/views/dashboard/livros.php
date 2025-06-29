<?php
/* @var $this yii\web\View */
/* @var int $totLivros */
/* @var int $totUsuarios */
/* @var int $totCompras */
/* @var string $vendasMes */
/* @var array $activities */
/* @var array $popular */

$this->title = 'Dashboard de Livros';
?>
<div class="grid grid-cols-4 gap-4 mb-6">
    <?= $this->render('_cardStat', [
        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor"
                       viewBox="0 0 24 24"><path stroke-linecap="round"
                       stroke-linejoin="round" stroke-width="2"
                       d="M12 12v9m4-9v9M4 12v9"/></svg>',
        'label' => 'Total de Livros',
        'value' => $totLivros
    ]) ?>
    <?= $this->render('_cardStat', [
        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor"
                       viewBox="0 0 24 24"><path stroke-linecap="round"
                       stroke-linejoin="round" stroke-width="2"
                       d="M16 14a4 4 0 01-8 0"/></svg>',
        'label' => 'Usuários Ativos',
        'value' => $totUsuarios
    ]) ?>
    <?= $this->render('_cardStat', [
        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor"
                       viewBox="0 0 24 24"><path stroke-linecap="round"
                       stroke-linejoin="round" stroke-width="2"
                       d="M3 3h18v18H3V3z"/></svg>',
        'label' => 'Pedidos Compras',
        'value' => $totCompras
    ]) ?>
    <?= $this->render('_cardStat', [
        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor"
                       viewBox="0 0 24 24"><path stroke-linecap="round"
                       stroke-linejoin="round" stroke-width="2"
                       d="M3 9l2 2m0 0l7.5 7.5M5 11l6 6"/></svg>',
        'label' => 'Vendas do Mês',
        'value' => $vendasMes
    ]) ?>
</div>

<div class="grid grid-cols-12 gap-6">
    <div class="col-span-7">
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <h2 class="font-semibold mb-3">Atividade Recente</h2>
            <ul class="space-y-2">
                <?php foreach ($activities as $act): ?>
                    <li class="text-sm bg-gray-50 px-3 py-2 rounded">
                        <?= Html::encode($act) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-span-5">
        <div class="bg-white rounded-lg p-4 shadow-sm">
            <h2 class="font-semibold mb-3">Livros Populares</h2>
            <ul class="space-y-3">
                <?php foreach ($popular as $bk): ?>
                    <li class="text-sm flex justify-between">
                        <span>
                            <strong><?= Html::encode($bk['titulo']) ?></strong><br>
                            <span class="text-gray-500"><?= Html::encode($bk['autor']) ?></span>
                        </span>
                        <span class="text-primary"><?= $bk['emprestimos'] ?> emp.</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
