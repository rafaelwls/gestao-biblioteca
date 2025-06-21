<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "compras".
 *
 * @property string $id
 * @property string $usuario_id
 * @property string $data_compra
 * @property float $valor_total
 *
 * @property Exemplares[] $exemplars
 * @property Item_compras[] $itemCompras
 * @property Usuarios $usuario
 */
class Compras extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'valor_total'], 'required'],
            [['id', 'usuario_id'], 'string'],
            [['data_compra'], 'safe'],
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
            'data_compra' => 'Data Compra',
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
        return $this->hasMany(Exemplares::class, ['id' => 'exemplar_id'])->viaTable('item_compras', ['compra_id' => 'id']);
    }

    /**
     * Gets query for [[ItemCompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemCompras()
    {
        return $this->hasMany(Item_compras::class, ['compra_id' => 'id']);
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
