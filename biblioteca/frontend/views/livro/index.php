<?php
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Html;
use yii\db\Query;
use yii\widgets\LinkPager;

$this->title = 'Todos os Livros'; 
?>
<div class="livros-index">

    <h1 class="text-xl font-semibold mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="flex justify-between mb-3">
        <input
            type="search"
            placeholder="Buscar por título ou autor…"
            class="px-3 py-2 rounded-md border w-80 text-sm"
        >
        <?= Html::a(
            '+ Adicionar Livro',
            ['create'],
            ['class' => 'bg-primary text-white px-3 py-1 rounded']
        ) ?>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg w-full">
        <div class="overflow-x-auto">
            <table class="grid-view min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Título</th>
                        <th class="px-4 py-2">Autor</th>
                        <th class="px-4 py-2">Gênero</th>
                        <th class="px-4 py-2">ISBN</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-center">Favorito</th>
                        <th class="px-4 py-2 text-center">Detalhes</th>
                        <th class="px-4 py-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($dataProvider->models as $livro): ?>
                    <?php
                        $isFav = (new Query())
                            ->from('favoritos')
                            ->where([
                                'usuario_id' => Yii::$app->user->id,
                                'livro_id'   => $livro->id,
                            ])
                            ->exists();
                    ?>
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2"><?= Html::encode($livro->titulo) ?></td>
                        <td class="px-4 py-2"><?= Html::encode($livro->autor) ?></td>
                        <td class="px-4 py-2">
                            <span class="bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded">
                                <?= Html::encode($livro->genero) ?>
                            </span>
                        </td>
                        <td class="px-4 py-2"><?= Html::encode($livro->isbn) ?></td>
                        <td class="px-4 py-2"><?= Html::encode($livro->status) ?></td>
                        <td class="px-4 py-2 text-center">
                            <?php if ($isFav): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline h-2 w-2 text-red-500" fill="currentColor" viewBox="0 0 60 60">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42
                                             4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81
                                             14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4
                                             6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            <?php else: ?>
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline h-2 w-2 text-gray-400" fill="none" viewBox="0 0 60 60" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3.172 5.172a4 4 0 015.656 0L12 8.343l3.172-3.171
                                             a4 4 0 115.656 5.656L12 21.657l-8.828-8.83
                                             a4 4 0 010-5.656z"/>
                                </svg>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <?= Html::a(
                                'Detalhes',
                                ['view', 'id' => $livro->id],
                                ['class' => 'text-primary hover:underline text-sm']
                            ) ?>
                        </td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <?= Html::a(
                                'Editar',
                                ['update', 'id' => $livro->id],
                                ['class' => 'text-primary text-xs']
                            ) ?>
                            <?= Html::a(
                                'Inativar',
                                ['delete', 'id' => $livro->id],
                                [
                                    'class' => 'text-red-500 text-xs',
                                    'data-confirm' => 'Inativar este livro?',
                                    'data-method'  => 'post',
                                ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?= LinkPager::widget([
                'pagination'   => $dataProvider->pagination,
                'options'      => ['class' => 'pagination justify-center mt-4 flex'],
                'linkOptions'  => ['class' => 'px-3 py-1 border rounded mx-1'],
                'prevPageLabel'=> '< Anterior',
                'nextPageLabel'=> 'Próximo >',
            ]) ?>
        </div>
    </div>

</div>
