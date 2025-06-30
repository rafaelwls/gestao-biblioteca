<?php
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = 'Seus Livros Favoritos';
?>
<h1 class="text-xl font-semibold mb-4">Seus Livros Favoritos</h1>

<div class="grid grid-cols-3 gap-6">
    <?php foreach ($dataProvider->models as $livro): ?>
        <div class="bg-white p-5 rounded-lg shadow-sm relative">
            <!-- coração -->
            <form method="post" action="<?= yii\helpers\Url::to(['favorito/remove', 'id' => $livro->id]) ?>"
                class="absolute right-4 top-4">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                
            </form>

            <p class="text-yellow-500 flex items-center text-sm mb-1">
                
            </p>
            <h2 class="font-semibold"><?= Html::encode($livro->titulo) ?></h2>
            <p class="text-gray-500 text-sm mb-2">
                <?= Html::encode("Autor: " .$livro->autor) ?> 
            </p>
            <p class="text-gray-500 text-sm mb-2"></p>
                <?= Html::encode("Ano de publicação: " . $livro->ano_publicacao) ?>
            </p>
            <span class="bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded">
                <?= Html::encode(content: "Gênero: " . $livro->genero) ?>
            </span>
            <p class="text-sm mt-3 line-clamp-2">
                <?= Html::encode("Sipnose: " . $livro->sinopse ?? '…') ?>
            </p>
            <?= Html::a(
                'Detalhes do livro',
                ['view', 'id' => $livro->id],
                ['class' => 'block mt-4 border px-3 py-2 text-center rounded text-sm']
            ) ?>
        </div>
        <hr class="col-span-3 border-gray-200 my-4" />
    <?php endforeach; ?>
</div>
