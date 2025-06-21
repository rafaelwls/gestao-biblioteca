<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exemplares".
 *
 * @property string $id
 * @property string $livro_id
 * @property string $data_aquisicao
 * @property string $status
 * @property string $estado
 * @property string|null $codigo_barras
 * @property string|null $data_remocao
 * @property string|null $motivo_remocao
 *
 * @property Compras[] $compras
 * @property Emprestimos[] $emprestimos
 * @property ItemCompras[] $itemCompras
 * @property ItemVendas[] $itemVendas
 * @property Livros $livro
 * @property Vendas[] $vendas
 */
class Exemplares extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const MOTIVO_REMOCAO_DANIFICADO = 'DANIFICADO';
    const MOTIVO_REMOCAO_DESATUALIZADO = 'DESATUALIZADO';
    const MOTIVO_REMOCAO_OUTRO = 'OUTRO';
    const MOTIVO_REMOCAO_PERDIDO = 'PERDIDO';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exemplares';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo_barras', 'data_remocao', 'motivo_remocao'], 'default', 'value' => null],
            [['id', 'livro_id', 'status', 'estado'], 'required'],
            [['id', 'livro_id', 'motivo_remocao'], 'string'],
            [['data_aquisicao', 'data_remocao'], 'safe'],
            [['status'], 'string', 'max' => 20],
            [['estado', 'codigo_barras'], 'string', 'max' => 50],
            ['motivo_remocao', 'in', 'range' => array_keys(self::optsMotivoRemocao())],
            [['codigo_barras'], 'unique'],
            [['id'], 'unique'],
            [['livro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Livros::class, 'targetAttribute' => ['livro_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'livro_id' => 'Livro ID',
            'data_aquisicao' => 'Data Aquisicao',
            'status' => 'Status',
            'estado' => 'Estado',
            'codigo_barras' => 'Codigo Barras',
            'data_remocao' => 'Data Remocao',
            'motivo_remocao' => 'Motivo Remocao',
        ];
    }

    /**
     * Gets query for [[Compras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compras::class, ['id' => 'compra_id'])->viaTable('item_compras', ['exemplar_id' => 'id']);
    }

    /**
     * Gets query for [[Emprestimos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmprestimos()
    {
        return $this->hasMany(Emprestimos::class, ['exemplar_id' => 'id']);
    }

    /**
     * Gets query for [[ItemCompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemCompras()
    {
        return $this->hasMany(ItemCompras::class, ['exemplar_id' => 'id']);
    }

    /**
     * Gets query for [[ItemVendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemVendas()
    {
        return $this->hasMany(ItemVendas::class, ['exemplar_id' => 'id']);
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
     * Gets query for [[Vendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendas()
    {
        return $this->hasMany(Vendas::class, ['id' => 'venda_id'])->viaTable('item_vendas', ['exemplar_id' => 'id']);
    }


    /**
     * column motivo_remocao ENUM value labels
     * @return string[]
     */
    public static function optsMotivoRemocao()
    {
        return [
            self::MOTIVO_REMOCAO_DANIFICADO => 'DANIFICADO',
            self::MOTIVO_REMOCAO_DESATUALIZADO => 'DESATUALIZADO',
            self::MOTIVO_REMOCAO_OUTRO => 'OUTRO',
            self::MOTIVO_REMOCAO_PERDIDO => 'PERDIDO',
        ];
    }

    /**
     * @return string
     */
    public function displayMotivoRemocao()
    {
        return self::optsMotivoRemocao()[$this->motivo_remocao];
    }

    /**
     * @return bool
     */
    public function isMotivoRemocaoDanificado()
    {
        return $this->motivo_remocao === self::MOTIVO_REMOCAO_DANIFICADO;
    }

    public function setMotivoRemocaoToDanificado()
    {
        $this->motivo_remocao = self::MOTIVO_REMOCAO_DANIFICADO;
    }

    /**
     * @return bool
     */
    public function isMotivoRemocaoDesatualizado()
    {
        return $this->motivo_remocao === self::MOTIVO_REMOCAO_DESATUALIZADO;
    }

    public function setMotivoRemocaoToDesatualizado()
    {
        $this->motivo_remocao = self::MOTIVO_REMOCAO_DESATUALIZADO;
    }

    /**
     * @return bool
     */
    public function isMotivoRemocaoOutro()
    {
        return $this->motivo_remocao === self::MOTIVO_REMOCAO_OUTRO;
    }

    public function setMotivoRemocaoToOutro()
    {
        $this->motivo_remocao = self::MOTIVO_REMOCAO_OUTRO;
    }

    /**
     * @return bool
     */
    public function isMotivoRemocaoPerdido()
    {
        return $this->motivo_remocao === self::MOTIVO_REMOCAO_PERDIDO;
    }

    public function setMotivoRemocaoToPerdido()
    {
        $this->motivo_remocao = self::MOTIVO_REMOCAO_PERDIDO;
    }
}
