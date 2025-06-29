<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

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
class Favoritos extends ActiveRecord
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
            [['usuario_id', 'livro_id'], 'required'],
            [['data_favorito'], 'safe'],
            [['usuario_id', 'livro_id'], 'string', 'max' => 36],
            [['livro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Livros::className(), 'targetAttribute' => ['livro_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'usuario_id'   => 'Usuário',
            'livro_id'     => 'Livro',
            'data_favorito'=> 'Data de Favorito',
        ];
    }

    /**
     * Gets related Livro
     * @return \yii\db\ActiveQuery
     */
    public function getLivro()
    {
        return $this->hasOne(Livros::className(), ['id' => 'livro_id']);
    }

    /**
     * Gets related Usuario
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Livros::className(), ['id' => 'livro_id']);
    }
}
