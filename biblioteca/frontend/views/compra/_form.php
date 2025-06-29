<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use common\models\Exemplares;

/* @var $model common\models\Compras */
/* @var $items ItemCompraForm[] */

$listaExemplares = ArrayHelper::map(
    Exemplares::find()->with('livro')->all(),
    'id',
    fn($e) => $e->livro->titulo . ' - ' . substr($e->id, 0, 4)
);
?>

<div class="bg-white p-6 rounded-lg shadow-sm">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'data_compra')->textInput(['value' => date('Y-m-d'), 'disabled' => true]) ?>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody'      => '.container-items',
        'widgetItem'      => '.item',
        'min'             => 1,
        'insertButton'    => '.add-item',
        'deleteButton'    => '.remove-item',


        'model'           => $items[0],            //  ← esta linha resolve o erro
        'formId'          => 'dynamic-form',

        'formFields'      => ['exemplar_id', 'quantidade', 'valor_unitario'],
    ]); ?>


    <table class="w-full text-sm mb-4">
        <thead>
            <tr>
                <th>Exemplar</th>
                <th>Qtd</th>
                <th>Valor</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="container-items">
            <?php foreach ($items as $i => $item): ?>
                <tr class="item border-t">
                    <td>
                        <?= $form->field($item, "[{$i}]exemplar_id")->dropDownList(
                            $listaExemplares,
                            ['prompt' => 'Selecione']
                        )->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($item, "[{$i}]quantidade")
                            ->textInput(['type' => 'number', 'min' => 1])->label(false) ?>
                    </td>
                    <td>
                        <?= $form->field($item, "[{$i}]valor_unitario")
                            ->textInput(['type' => 'number', 'step' => '0.01'])->label(false) ?>
                    </td>
                    <td class="text-center">
                        <button type="button" class="remove-item text-red-600">×</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="button" class="add-item bg-primary text-white px-2 py-1 rounded text-xs">+ Item</button>

    <?php DynamicFormWidget::end(); ?>

    <div class="mt-4">
        <?= Html::submitButton('Salvar', ['class' => 'bg-primary text-white px-4 py-2 rounded']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'ml-2 text-gray-600']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
