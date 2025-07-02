<?php
namespace frontend\tests\unit\models;

use PHPUnit\Framework\TestCase;
use common\models\Usuarios;

class UsuarioTest extends TestCase
{
    public function testGetFullName()
    {
        // cria um modelo sem tocar no DB
        $user = new Usuarios([
            'nome'      => 'João',
            'sobrenome' => 'Pereira',
        ]);
        $this->assertSame('João Pereira', $user->getFullName());
    }
}
