<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "emprestimos".
 *
 * @property string $id
 * @property string $exemplar_id
 * @property string $usuario_id
 * @property string $data_emprestimo
 * @property string $data_devolucao_prevista
 * @property string|null $data_devolucao_real
 * @property float $multa_calculada
 *
 * @property Exemplares $exemplar
 * @property Usuarios $usuario
 */
class Emprestimos extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emprestimos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_devolucao_real'], 'default', 'value' => null],
            [['multa_calculada'], 'default', 'value' => 0.00],
            [['id', 'exemplar_id', 'usuario_id', 'data_devolucao_prevista'], 'required'],
            [['id', 'exemplar_id', 'usuario_id'], 'string'],
            [['data_emprestimo', 'data_devolucao_prevista', 'data_devolucao_real'], 'safe'],
            [['multa_calculada'], 'number'],
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
            'exemplar_id' => 'Exemplar ID',
            'usuario_id' => 'Usuario ID',
            'data_emprestimo' => 'Data Emprestimo',
            'data_devolucao_prevista' => 'Data Devolucao Prevista',
            'data_devolucao_real' => 'Data Devolucao Real',
            'multa_calculada' => 'Multa Calculada',
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
