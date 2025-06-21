<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "favoritos".
 *
 * @property string $id
 * @property string $usuario_id
 * @property string $livro_id
 * @property string $data_favorito
 *
 * @property Livros $livro
 * @property Usuarios $usuario
 */
class Favoritos extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favoritos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'livro_id'], 'required'],
            [['id', 'usuario_id', 'livro_id'], 'string'],
            [['data_favorito'], 'safe'],
            [['usuario_id', 'livro_id'], 'unique', 'targetAttribute' => ['usuario_id', 'livro_id']],
            [['id'], 'unique'],
            [['livro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Livros::class, 'targetAttribute' => ['livro_id' => 'id']],
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
            'livro_id' => 'Livro ID',
            'data_favorito' => 'Data Favorito',
        ];
    }

    /**
     * Gets query for [[Livro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivro()
    {
        return $this->hasOne(Livros::class, ['id' => 'livro_id']);
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
