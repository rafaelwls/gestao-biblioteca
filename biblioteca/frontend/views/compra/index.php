<?php

use yii\helpers\Html;

$this->title = 'Pedidos de Compras';
?>
<h1 class="text-xl font-semibold mb-4"><?= Html::encode($this->title) ?></h1>

<div class="grid grid-cols-3 gap-4 mb-6">
    <?= $this->render('//dashboard/_cardStat', [
        'icon' => '<svg class="w-6 h-6" ...></svg>',
        'label' => 'Pedidos Pendentes',
        'value' => $pendentes
    ]) ?>
    <?= $this->render('//dashboard/_cardStat', [
        'icon' => '<svg class="w-6 h-6" ...></svg>',
        'label' => 'Total do Mês',
        'value' => 'R$ ' . number_format($totalMes, 2, ',', '.')
    ]) ?>
    <?= $this->render('//dashboard/_cardStat', [
        'icon' => '<svg class="w-6 h-6" ...></svg>',
        'label' => 'Livros Comprados',
        'value' => $livrosMes
    ]) ?>
</div>

<div class="flex justify-end mb-3">
    <?= Html::a('+ Novo Pedido', ['create'], ['class' => 'bg-primary text-white px-4 py-2 rounded']) ?>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow-sm">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2">Pedido</th>
                <th>Fornecedor</th>
                <th>Itens</th>
                <th>Total</th>
                <th>Data</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->models as $comp): ?>
                <?php
                $badge = [
                    'PENDENTE' => 'bg-yellow-100 text-yellow-700',
                    'APROVADO' => 'bg-blue-100 text-blue-600',
                    'ENTREGUE' => 'bg-green-100 text-green-600',
                ][$comp->status] ?? 'bg-gray-100 text-gray-600';
                $qtd = $comp->getItemCompras()->sum('quantidade');
                ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2"><?= Html::encode(substr($comp->id, 0, 6)) ?></td>
                    <td class="px-4 py-2"><?= Html::encode($comp->usuario->nome ?? '-') ?></td>
                    <td class="px-4 py-2"><?= $qtd ?> livros</td>
                    <td class="px-4 py-2">R$ <?= number_format($comp->valor_total, 2, ',', '.') ?></td>
                    <td class="px-4 py-2"><?= Yii::$app->formatter->asDate($comp->data_compra) ?></td>
                    <td class="px-4 py-2"><span class="<?= $badge ?> text-xs px-2 py-0.5 rounded"><?= $comp->status ?></span></td>
                    <td class="px-4 py-2 text-center">
                        <?= Html::a('Ver', ['view', 'id' => $comp->id], ['class' => 'text-primary text-xs']) ?>
                        <?= Html::a('Editar', ['update', 'id' => $comp->id], ['class' => 'text-primary text-xs ml-2']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
