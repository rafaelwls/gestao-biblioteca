<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\Exemplares;
use common\models\Usuarios;

class Emprestimos extends ActiveRecord
{
    public static function tableName()
    {
        return 'emprestimos';
    }

    public function rules()
    {
        return [
            [['exemplar_id'], 'required'],
            ['status', 'default', 'value' => 'PENDENTE'],
            ['status', 'in', 'range' => ['PENDENTE','APROVADO','REJEITADO']],

            [['data_emprestimo','data_devolucao_prevista','data_devolucao_real'], 'safe'],
            ['multa_calculada', 'number'],

            ['exemplar_id', 'exist', 'targetClass' => Exemplares::class, 'targetAttribute' => ['exemplar_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'                       => 'ID',
            'exemplar_id'              => 'Exemplar',
            'usuario_id'               => 'Usuário',
            'data_emprestimo'          => 'Data Empréstimo',
            'data_devolucao_prevista'  => 'Previsão Devolução',
            'data_devolucao_real'      => 'Data Devolução',
            'multa_calculada'          => 'Multa',
            'status'                   => 'Status',
        ];
    }

    public function getExemplar()
    {
        return $this->hasOne(Exemplares::class, ['id' => 'exemplar_id']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->usuario_id = Yii::$app->user->id;
            $this->data_emprestimo = date('Y-m-d');
            $this->data_devolucao_prevista = date('Y-m-d', strtotime('+14 days'));
            $this->status = 'PENDENTE';
        }
        return parent::beforeSave($insert);
    }
}
