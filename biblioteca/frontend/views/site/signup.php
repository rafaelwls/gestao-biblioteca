<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Cadastre-se';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['id'=>'form-signup']); ?>
    <?= $form->field($model,'nome') ?>
    <?= $form->field($model,'sobrenome') ?>
    <?= $form->field($model,'email') ?>
    <?= $form->field($model,'password')->passwordInput() ?>
    <?= $form->field($model,'password_repeat')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Cadastrar', [
            'class'=>'btn btn-primary','name'=>'signup-button'
        ]) ?>
    </div>
<?php ActiveForm::end(); ?>
