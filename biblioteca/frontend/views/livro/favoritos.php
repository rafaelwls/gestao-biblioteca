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
                <button><svg class="w-5 h-5 text-red-500" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 21l-1.45-1.32C5.4 15.36 2 12.28 2 8.5A5.5
                       5.5 0 017.5 3c1.74 0 3.41.81
                       4.5 2.09A6.5 6.5 0 0117.5 3 5.5
                       5.5 0 0123 8.5c0 3.78-3.4 6.86-8.55
                       11.18L12 21z" />
                    </svg></button>
            </form>

            <p class="text-yellow-500 flex items-center text-sm mb-1">
                <svg class="w-4 h-4 mr-1" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M12 .587l3.668 7.568L24 9.75l-6
                 5.867 1.42 8.283L12 18.897 4.58
                 23.9 6 15.617 0 9.75l8.332-1.595z" />
                </svg> 4.8
            </p>
            <h2 class="font-semibold"><?= Html::encode($livro->titulo) ?></h2>
            <p class="text-gray-500 text-sm mb-2">
                <?= Html::encode($livro->autor) ?> • <?= $livro->ano_publicacao ?>
            </p>
            <span class="bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded">
                <?= Html::encode($livro->genero) ?>
            </span>
            <p class="text-sm mt-3 line-clamp-2">
                <?= Html::encode($livro->sinopse ?? '…') ?>
            </p>
            <?= Html::a(
                'Ler Agora',
                ['view', 'id' => $livro->id],
                ['class' => 'block mt-4 border px-3 py-2 text-center rounded text-sm']
            ) ?>
        </div>
    <?php endforeach; ?>
</div>
