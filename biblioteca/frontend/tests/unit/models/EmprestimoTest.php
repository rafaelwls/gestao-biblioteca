<?php
namespace frontend\tests\unit\models;

use PHPUnit\Framework\TestCase;
use frontend\models\Emprestimos;

class EmprestimoTest extends TestCase
{
    public function testCalculateMultaNoAtraso()
    {
        $e = new Emprestimos([
            'data_devolucao_prevista' => '2025-06-10',
            'data_devolucao_real'     => '2025-06-09',
        ]);
        $this->assertSame(0.0, $e->calculateMulta());
    }

    public function testCalculateMultaComAtraso()
    {
        $e = new Emprestimos([
            'data_devolucao_prevista' => '2025-06-10',
            'data_devolucao_real'     => '2025-06-12',
        ]);
        // 2 dias de atraso × taxa padrão 2.50 = 5.00
        $this->assertEqualsWithDelta(5.00, $e->calculateMulta(), 0.0001);
    }
}
