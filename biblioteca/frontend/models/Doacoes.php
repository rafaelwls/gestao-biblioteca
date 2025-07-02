<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doacoes".
 *
 * @property string $id
 * @property string $usuario_id
 * @property string $titulo
 * @property string|null $autor
 * @property string|null $estado
 * @property string $status
 * @property string $data_solicitacao
 *
 * @property Usuarios $usuario
 */
class Doacoes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doacoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['autor', 'estado'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'PENDENTE'],
            [['id', 'usuario_id', 'titulo'], 'required'],
            [['id', 'usuario_id'], 'string'],
            [['data_solicitacao'], 'safe'],
            [['titulo', 'autor'], 'string', 'max' => 255],
            [['estado'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 20],
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
            'titulo' => 'Titulo',
            'autor' => 'Autor',
            'estado' => 'Estado',
            'status' => 'Status',
            'data_solicitacao' => 'Data Solicitacao',
        ];
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
