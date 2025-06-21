<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_compras".
 *
 * @property string $compra_id
 * @property string $exemplar_id
 * @property float $valor_unitario
 * @property int $quantidade
 *
 * @property Compras $compra
 * @property Exemplares $exemplar
 */
class Item_compras extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade'], 'default', 'value' => 1],
            [['compra_id', 'exemplar_id', 'valor_unitario'], 'required'],
            [['compra_id', 'exemplar_id'], 'string'],
            [['valor_unitario'], 'number'],
            [['quantidade'], 'default', 'value' => null],
            [['quantidade'], 'integer'],
            [['compra_id', 'exemplar_id'], 'unique', 'targetAttribute' => ['compra_id', 'exemplar_id']],
            [['compra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Compras::class, 'targetAttribute' => ['compra_id' => 'id']],
            [['exemplar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exemplares::class, 'targetAttribute' => ['exemplar_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'compra_id' => 'Compra ID',
            'exemplar_id' => 'Exemplar ID',
            'valor_unitario' => 'Valor Unitario',
            'quantidade' => 'Quantidade',
        ];
    }

    /**
     * Gets query for [[Compra]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompra()
    {
        return $this->hasOne(Compras::class, ['id' => 'compra_id']);
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

}
