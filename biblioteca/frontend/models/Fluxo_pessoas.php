<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fluxo_pessoas".
 *
 * @property string $id
 * @property string $usuario_id
 * @property string $tipo
 * @property string $timestamp
 *
 * @property Usuarios $usuario
 */
class Fluxo_pessoas extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const TIPO_ENTRADA = 'ENTRADA';
    const TIPO_SAIDA = 'SAIDA';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fluxo_pessoas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'tipo'], 'required'],
            [['id', 'usuario_id', 'tipo'], 'string'],
            [['timestamp'], 'safe'],
            ['tipo', 'in', 'range' => array_keys(self::optsTipo())],
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
            'tipo' => 'Tipo',
            'timestamp' => 'Timestamp',
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


    /**
     * column tipo ENUM value labels
     * @return string[]
     */
    public static function optsTipo()
    {
        return [
            self::TIPO_ENTRADA => 'ENTRADA',
            self::TIPO_SAIDA => 'SAIDA',
        ];
    }

    /**
     * @return string
     */
    public function displayTipo()
    {
        return self::optsTipo()[$this->tipo];
    }

    /**
     * @return bool
     */
    public function isTipoEntrada()
    {
        return $this->tipo === self::TIPO_ENTRADA;
    }

    public function setTipoToEntrada()
    {
        $this->tipo = self::TIPO_ENTRADA;
    }

    /**
     * @return bool
     */
    public function isTipoSaida()
    {
        return $this->tipo === self::TIPO_SAIDA;
    }

    public function setTipoToSaida()
    {
        $this->tipo = self::TIPO_SAIDA;
    }
}
