<?php
namespace frontend\models;

use yii\db\ActiveRecord;
use yii\db\Expression;
use DateTime;

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
 * @property bool $multa_paga
 * @property string|null $data_pagamento
 * @property string $status
 *
 * @property Exemplar $exemplar
 * @property Usuario $usuario
 */
class Emprestimos extends ActiveRecord
{
    /** @var float daily fine rate */
    public $taxaDia = 2.50;

    public static function tableName()
    {
        return 'emprestimos';
    }

    public function rules()
    {
        return [
            [['exemplar_id', 'usuario_id', 'data_devolucao_prevista'], 'required'],
            [['exemplar_id', 'usuario_id'], 'string'],
            [['data_emprestimo', 'data_devolucao_prevista', 'data_devolucao_real', 'data_pagamento'], 'safe'],
            [['multa_calculada'], 'number'],
            [['multa_paga'], 'boolean'],
            [['status'], 'string'],
            ['status', 'default', 'value' => 'PENDENTE'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'exemplar_id' => 'Exemplar',
            'usuario_id' => 'Usuário',
            'data_emprestimo' => 'Data Empréstimo',
            'data_devolucao_prevista' => 'Data Devolução Prevista',
            'data_devolucao_real' => 'Data Devolução Real',
            'multa_calculada' => 'Multa Calculada',
            'multa_paga' => 'Multa Paga',
            'data_pagamento' => 'Data Pagamento',
            'status' => 'Status',
        ];
    }

    /**
     * Calculates the fine based on return dates.
     * @return float
     */
    public function calculateMulta(): float
    {
        if (empty($this->data_devolucao_real)) {
            return 0.0;
        }
        $prevista = new DateTime($this->data_devolucao_prevista);
        $real = new DateTime($this->data_devolucao_real);
        $dias = max(0, $real->diff($prevista)->days);
        return $dias * $this->taxaDia;
    }

    /**
     * Sets removal logic if needed.
     * Example: $model->remover('DANIFICADO');
     *
     * @param string $motivo not used here but example
     */
    public function remover(string $motivo)
    {
        // Delegates to Exemplar remover
        $this->exemplar->remover($motivo);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExemplar()
    {
        return $this->hasOne(Exemplar::class, ['id' => 'exemplar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }
}
