<?php

use yii\helpers\Html;

/* @var $entradas int */
/* @var $saidas int */
/* @var $presentes int */
/* @var $rows array */

$this->title = 'Fluxo de Pessoas';
?>
<h1 class="text-xl font-semibold mb-4"><?= Html::encode($this->title) ?></h1>

<div class="grid grid-cols-3 gap-4 mb-6">
    <?= $this->render('//dashboard/_cardStat', [
        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor"
        viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M16 7a4 4 0 11-8 0"/></svg>',
        'label' => 'Pessoas Hoje',
        'value' => $entradas
    ]) ?>
    <?= $this->render('//dashboard/_cardStat', [
        'icon' => '<svg class="w-6 h-6 text-red-500" ...></svg>',
        'label' => 'Saídas Hoje',
        'value' => $saidas
    ]) ?>
    <?= $this->render('//dashboard/_cardStat', [
        'icon' => '<svg class="w-6 h-6 text-blue-500" ...></svg>',
        'label' => 'Pessoas Presentes',
        'value' => $presentes
    ]) ?>
</div>

<div class="bg-white rounded-lg shadow-sm">
    <h2 class="px-6 py-3 font-semibold border-b">Fluxo por Horário</h2>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-2 text-left">Horário</th>
                <th class="px-6 py-2 text-left">Entradas</th>
                <th class="px-6 py-2 text-left">Saídas</th>
                <th class="px-6 py-2 text-left">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r): $saldo = $r['ent'] - $r['sai']; ?>
                <tr class="border-t">
                    <td class="px-6 py-2"><?= $r['hora'] ?></td>
                    <td class="px-6 py-2 text-green-600">+<?= $r['ent'] ?></td>
                    <td class="px-6 py-2 text-red-600">-<?= $r['sai'] ?></td>
                    <td class="px-6 py-2 <?= $saldo >= 0 ? 'text-green-700' : 'text-red-700' ?>">
                        <?= $saldo >= 0 ? '+' . $saldo : $saldo ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
