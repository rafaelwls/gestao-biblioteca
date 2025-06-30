<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this  yii\web\View */
/* @var $model common\models\Livros */

$this->title                   = $model->titulo; 
?>
<div class="livro-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Ações -->
    <div class="mt-6 flex space-x-2">
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'form-button form-button-primary']) ?>
        <?= Html::a('Solicitar Venda', ['compras/create', 'livroId' => $model->id], ['class' => 'form-button form-button-primary']) ?>
        <!-- Botão de Favoritos -->
        <?php if (!Yii::$app->user->isGuest): ?>
            <?php $isFav = $model->getFavoritos()
                ->andWhere(['usuario_id' => Yii::$app->user->id])
                ->exists(); ?>
            <?= Html::a(
                $isFav ? 'Remover Favorito' : 'Adicionar Favorito',
                ['toggle-favorite', 'id' => $model->id],
                ['class' => 'form-button form-button-secondary']
            ) ?>
        <?php endif; ?>
        <?= Html::a('Registrar Empréstimo', ['emprestimos/create','livroId' => $model->id], [
            'class' => 'form-button form-button-primary',
            'data-method' => 'post',
        ]) ?>

    </div>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'titulo',
            'autor',
            'genero',
            'subtitulo',            // novo
            'ano_publicacao:integer',// novo
            'idioma',               // novo
            'paginas:integer',      // novo
            'isbn',
            'status',
        ],
    ]) ?>

    <hr>

    <h2>Exemplares</h2>

    <?php if (!empty($model->exemplares)): ?>
        <?php foreach ($model->exemplares as $ex): ?>
            <div class="exemplar-block">
                <p><strong>Quantidade:</strong> <?= $ex->quantidade ?></p>
                <p><strong>Estado:</strong> <?= ucfirst($ex->estado) ?></p>
                <p><strong>Código de Barras:</strong> <?= Html::encode($ex->codigo_barras) ?: '<em>—</em>' ?></p>
                <p><strong>Data de Aquisição:</strong> <?= Yii::$app->formatter->asDate($ex->data_aquisicao) ?></p>
                <p><strong>Status:</strong> <?= ucfirst($ex->status) ?></p>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p><em>Não há exemplares cadastrados para este livro.</em></p>
    <?php endif; ?>
</div>
