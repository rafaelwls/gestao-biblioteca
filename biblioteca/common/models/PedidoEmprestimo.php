<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pedido_emprestimo".
 *
 * @property string $id
 * @property string $usuario_id
 * @property string $exemplar_id
 * @property string $data_solicitacao
 * @property string $status
 *
 * @property Exemplares $exemplar
 * @property Usuarios $usuario
 */
class PedidoEmprestimo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido_emprestimo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 'PENDENTE'],
            [['id', 'usuario_id', 'exemplar_id'], 'required'],
            [['id', 'usuario_id', 'exemplar_id'], 'string'],
            [['data_solicitacao'], 'safe'],
            [['status'], 'string', 'max' => 20],
            [['id'], 'unique'],
            [['exemplar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exemplares::class, 'targetAttribute' => ['exemplar_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'exemplar_id' => 'Exemplar ID',
            'data_solicitacao' => 'Data Solicitacao',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Exemplar]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExemplar()
    {
        return $this->hasOne(Exemplares::class, ['id' => 'exemplar_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id']);
    }

}
