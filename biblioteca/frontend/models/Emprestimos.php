<?php
namespace frontend\models;

use yii\base\BaseObject;
use DateTime;

class Emprestimos extends BaseObject
{
    public $data_devolucao_prevista;
    public $data_devolucao_real;

    // Taxa de multa por dia de atraso
    private const TAXA_DIARIA = 2.50;

    /**
     * Calcula a multa baseada na diferença entre a data real e a data prevista.
     *
     * @return float
     */
    public function calculateMulta(): float
    {
        $prevista = new DateTime($this->data_devolucao_prevista);
        $real     = new DateTime($this->data_devolucao_real);
        $interval = $prevista->diff($real);

        // se houve atraso (real > prevista), invert === 0 e days > 0
        if ($interval->invert === 0 && $interval->days > 0) {
            return $interval->days * self::TAXA_DIARIA;
        }

        return 0.0;
    }
}
