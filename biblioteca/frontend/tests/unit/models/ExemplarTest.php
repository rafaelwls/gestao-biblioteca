<?php
namespace frontend\tests\unit\models;

use PHPUnit\Framework\TestCase;
use yii\db\Expression;
use common\models\Exemplares;

class ExemplarTest extends TestCase
{
    public function testRemover()
    {
        $ex = new Exemplares([
            'status'        => 'disponivel',
            'estado'        => 'novo',
            'codigo_barras' => 'XYZ123',
        ]);
        $ex->remover('DANIFICADO');

        $this->assertSame('removido', $ex->status);
        $this->assertSame('DANIFICADO', $ex->motivo_remocao);
        $this->assertInstanceOf(Expression::class, $ex->data_remocao);
    }
}
