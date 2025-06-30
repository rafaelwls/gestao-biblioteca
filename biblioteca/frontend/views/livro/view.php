<?php
use yii\helpers\Html;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $model common\models\Livros */

$this->title = $model->titulo;
?>
<div class="bg-white p-6 rounded-lg shadow-sm max-w-3xl mx-auto">

    <!-- Cabeçalho: Título + Voltar + Toggle Favorito -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4"> 
            <?= Html::a('← Voltar', ['index'], [
                'class' => 'text-sm text-gray-600 hover:underline'
            ]) ?>
            <h1 class="text-2xl font-semibold"><?= Html::encode($this->title) ?></h1>
        </div>

        <?php if (!Yii::$app->user->isGuest): ?>
            <?php
                $isFav = (new Query())
                    ->from('favoritos')
                    ->where([
                        'usuario_id' => Yii::$app->user->id,
                        'livro_id'   => $model->id,
                    ])
                    ->exists();
            ?>
            <?= Html::beginForm(
                ['livros/toggle-favorite', 'id' => $model->id],
                'post',
                ['class' => 'inline']
            ) ?>
                <?= Html::submitButton(
                    $isFav
                        ? 'Remover dos favoritos'
                        : 'Adicionar aos favoritos',
                    [
                        'class' => $isFav
                            ? 'form-button form-button-secondary'
                            : 'form-button form-button-primary'
                    ]
                ) ?>
            <?= Html::endForm() ?>
        <?php endif; ?>
    </div>

    <!-- Detalhes do Livro em inputs readonly -->
    <div class="space-y-4">
        <div>
            <?= Html::label('Autor', 'autor', [
                'class' => 'block text-sm font-medium mb-1'
            ]) ?>
            <?= Html::textInput('autor', $model->autor, [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'autor',
            ]) ?>
        </div>
        <div>
            <?= Html::label('Gênero', 'genero', [
                'class' => 'block text-sm font-medium mb-1'
            ]) ?>
            <?= Html::textInput('genero', $model->genero, [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'genero',
            ]) ?>
        </div>
        <div>
            <?= Html::label('ISBN', 'isbn', [
                'class' => 'block text-sm font-medium mb-1'
            ]) ?>
            <?= Html::textInput('isbn', $model->isbn, [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'isbn',
            ]) ?>
        </div>
        <div>
            <?= Html::label('Status', 'status', [
                'class' => 'block text-sm font-medium mb-1'
            ]) ?>
            <?= Html::textInput('status', $model->status, [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'status',
            ]) ?>
        </div>
    </div>

    <!-- Ações -->
    <div class="mt-6 flex space-x-2">
        <?= Html::a('Editar', ['update', 'id' => $model->id], [
            'class' => 'form-button form-button-primary'
        ]) ?>
        <?= Html::a('Registrar Compra', ['compras/create', 'livroId' => $model->id], [
            'class' => 'form-button form-button-primary'
        ]) ?>
    </div>

</div>
