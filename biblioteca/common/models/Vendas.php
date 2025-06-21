<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vendas".
 *
 * @property string $id
 * @property string $usuario_id
 * @property string $data_venda
 * @property float $valor_total
 *
 * @property Exemplares[] $exemplars
 * @property ItemVendas[] $itemVendas
 * @property Usuarios $usuario
 */
class Vendas extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'valor_total'], 'required'],
            [['id', 'usuario_id'], 'string'],
            [['data_venda'], 'safe'],
            [['valor_total'], 'number'],
            [['id'], 'unique'],
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
            'data_venda' => 'Data Venda',
            'valor_total' => 'Valor Total',
        ];
    }

    /**
     * Gets query for [[Exemplars]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExemplars()
    {
        return $this->hasMany(Exemplares::class, ['id' => 'exemplar_id'])->viaTable('item_vendas', ['venda_id' => 'id']);
    }

    /**
     * Gets query for [[ItemVendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemVendas()
    {
        return $this->hasMany(ItemVendas::class, ['venda_id' => 'id']);
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
