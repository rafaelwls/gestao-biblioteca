<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Usuarios */

$this->title = "Usuário: " . $model->nome . ' ' . $model->sobrenome; 
?>
<div class="bg-white p-6 rounded-lg shadow-sm max-w-3xl mx-auto">

    <!-- Cabeçalho e botão Voltar -->
    <div class="flex items-center justify-between mb-6">
        <?= Html::a('← Voltar', ['index'], [
            'class' => 'text-sm text-gray-600 hover:underline'
        ]) ?>
        <h1 class="text-2xl font-semibold"><?= Html::encode($this->title) ?></h1>
    </div>

    <!-- Campos em readonly -->
    <div class="space-y-4">
        <div>
            <?= Html::label('ID', 'id', ['class' => 'block text-sm font-medium mb-1']) ?>
            <?= Html::textInput('id', $model->id, [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'id',
            ]) ?>
        </div>
        <div>
            <?= Html::label('Nome', 'nome', ['class' => 'block text-sm font-medium mb-1']) ?>
            <?= Html::textInput('nome', $model->nome, [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'nome',
            ]) ?>
        </div>
        <div>
            <?= Html::label('Sobrenome', 'sobrenome', ['class' => 'block text-sm font-medium mb-1']) ?>
            <?= Html::textInput('sobrenome', $model->sobrenome, [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'sobrenome',
            ]) ?>
        </div>
        <div>
            <?= Html::label('E-mail', 'email', ['class' => 'block text-sm font-medium mb-1']) ?>
            <?= Html::textInput('email', $model->email, [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'email',
            ]) ?>
        </div>
        <div>
            <?= Html::label('Data de Cadastro', 'data_cadastro', ['class' => 'block text-sm font-medium mb-1']) ?>
            <?= Html::textInput('data_cadastro', Yii::$app->formatter->asDate($model->data_cadastro), [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'data_cadastro',
            ]) ?>
        </div>
        <div>
            <?= Html::label('Data de Validade', 'data_validade', ['class' => 'block text-sm font-medium mb-1']) ?>
            <?= Html::textInput('data_validade', $model->data_validade
                ? Yii::$app->formatter->asDate($model->data_validade)
                : '-', [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'data_validade',
            ]) ?>
        </div>
        <div>
            <?= Html::label('Administrador?', 'is_admin', ['class' => 'block text-sm font-medium mb-1']) ?>
            <?= Html::textInput('is_admin', $model->is_admin ? 'Sim' : 'Não', [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'is_admin',
            ]) ?>
        </div>
        <div>
            <?= Html::label('Trabalhador?', 'is_trabalhador', ['class' => 'block text-sm font-medium mb-1']) ?>
            <?= Html::textInput('is_trabalhador', $model->is_trabalhador ? 'Sim' : 'Não', [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'is_trabalhador',
            ]) ?>
        </div>
        <div>
            <?= Html::label('Criado em', 'created_at', ['class' => 'block text-sm font-medium mb-1']) ?>
            <?= Html::textInput('created_at', Yii::$app->formatter->asDatetime($model->created_at), [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'created_at',
            ]) ?>
        </div>
        <div>
            <?= Html::label('Atualizado em', 'updated_at', ['class' => 'block text-sm font-medium mb-1']) ?>
            <?= Html::textInput('updated_at', Yii::$app->formatter->asDatetime($model->updated_at), [
                'class'    => 'form-input w-full',
                'readonly' => true,
                'id'       => 'updated_at',
            ]) ?>
        </div>
    </div>

    <!-- Botões de ação -->
    <div class="mt-6 flex space-x-2">
        <?= Html::a('Editar', ['update', 'id' => $model->id], [
            'class' => 'bg-primary text-white px-4 py-2 rounded'
        ]) ?>
         
    </div>

</div>
