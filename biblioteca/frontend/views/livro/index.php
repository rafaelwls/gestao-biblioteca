<?php
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Todos os Livros';
?>
<h1 class="text-xl font-semibold mb-4">Todos os Livros</h1>

<div class="flex justify-between mb-3">
    <input type="search" placeholder="Buscar por título ou autor…"
        class="px-3 py-2 rounded-md border w-80 text-sm">
    <?= Html::a(
        '+ Adicionar Livro',
        ['create'],
        ['class' => 'bg-primary text-white px-4 py-2 rounded-md text-sm']
    ) ?>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow-sm">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-left bg-gray-50">
                <th class="px-4 py-2">Título</th>
                <th class="px-4 py-2">Autor</th>
                <th class="px-4 py-2">Gênero</th>
                <th class="px-4 py-2">ISBN</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2 text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->models as $livro): ?>
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2"><?= Html::encode($livro->titulo) ?></td>
                    <td class="px-4 py-2"><?= Html::encode($livro->autor) ?></td>
                    <td class="px-4 py-2">
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded">
                            <?= Html::encode($livro->genero) ?>
                        </span>
                    </td>
                    <td class="px-4 py-2"><?= Html::encode($livro->isbn) ?></td>
                    <td class="px-4 py-2">
                        <?php
                        $badge = [
                            'Disponível' => 'bg-green-100 text-green-600',
                            'Emprestado' => 'bg-red-100 text-red-600',
                            'Vendido'    => 'bg-yellow-100 text-yellow-600',
                        ][$livro->status] ?? 'bg-gray-100 text-gray-600';
                        ?>
                        <span class="<?= $badge ?> text-xs px-2 py-0.5 rounded">
                            <?= $livro->status ?>
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center space-x-2">
                        <?= Html::a(
                            'Editar',
                            ['update', 'id' => $livro->id],
                            ['class' => 'text-primary text-xs']
                        ) ?>
                        <?= Html::a('Remover', ['delete', 'id' => $livro->id], [
                            'class' => 'text-red-500 text-xs',
                            'data-confirm' => 'Remover este livro?',
                            'data-method' => 'post'
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
