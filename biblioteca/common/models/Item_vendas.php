<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_vendas".
 *
 * @property string $venda_id
 * @property string $exemplar_id
 * @property float $valor_unitario
 * @property int $quantidade
 *
 * @property Exemplares $exemplar
 * @property Vendas $venda
 */
class Item_vendas extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_vendas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade'], 'default', 'value' => 1],
            [['venda_id', 'exemplar_id', 'valor_unitario'], 'required'],
            [['venda_id', 'exemplar_id'], 'string'],
            [['valor_unitario'], 'number'],
            [['quantidade'], 'default', 'value' => null],
            [['quantidade'], 'integer'],
            [['venda_id', 'exemplar_id'], 'unique', 'targetAttribute' => ['venda_id', 'exemplar_id']],
            [['exemplar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exemplares::class, 'targetAttribute' => ['exemplar_id' => 'id']],
            [['venda_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vendas::class, 'targetAttribute' => ['venda_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'venda_id' => 'Venda ID',
            'exemplar_id' => 'Exemplar ID',
            'valor_unitario' => 'Valor Unitario',
            'quantidade' => 'Quantidade',
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
     * Gets query for [[Venda]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVenda()
    {
        return $this->hasOne(Vendas::class, ['id' => 'venda_id']);
    }

}
