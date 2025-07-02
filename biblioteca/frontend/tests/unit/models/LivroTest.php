<?php
namespace frontend\tests\unit\models;

use PHPUnit\Framework\TestCase;
use frontend\models\Livro;

class LivroTest extends TestCase
{
    public function testGetFullTitleWithoutSubtitle()
    {
        $livro = new Livro([
            'titulo' => 'Programação em PHP',
            'subtitulo' => null,
        ]);
        $this->assertSame('Programação em PHP', $livro->getFullTitle());
    }

    public function testGetFullTitleWithSubtitle()
    {
        $livro = new Livro([
            'titulo' => 'Programação em PHP',
            'subtitulo' => 'Yii2 Avançado',
        ]);
        $this->assertSame('Programação em PHP: Yii2 Avançado', $livro->getFullTitle());
    }
}
