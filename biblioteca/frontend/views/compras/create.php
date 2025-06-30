<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Compras */
/* @var $exemplar common\models\Exemplares */

$this->title = 'Registrar Compra';
?>
<div class="compras-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form=ActiveForm::begin(); ?>

    <p><strong>Livro:</strong> <?= Html::encode($exemplar->livro->titulo) ?></p>
    <p><strong>Cód. Barras:</strong> <?= Html::encode($exemplar->codigo_barras) ?></p>
    <p><strong>Disponível:</strong> <?= $exemplar->quantidade ?></p>
    <hr>

    <?= $form->field($model,'quantidade')->input('number',[
        'min'=>1,'max'=>$exemplar->quantidade,'class'=>'form-input'
    ]) ?>
    <?= $form->field($model,'valor_unitario')->input('number',[
        'step'=>'0.01','class'=>'form-input'
    ]) ?>

    <div class="mt-6">
        <?= Html::submitButton('Enviar para Aprovação',[
            'class'=>'form-button form-button-primary'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
