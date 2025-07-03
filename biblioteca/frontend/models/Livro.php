<?php
namespace frontend\models;

use yii\base\BaseObject;

class Livro extends BaseObject
{
    public $titulo;
    public $subtitulo;

    /**
     * Retorna o título completo, concatenando subtítulo se existir.
     *
     * @return string
     */
    public function getFullTitle(): string
    {
        if ($this->subtitulo === null || $this->subtitulo === '') {
            return $this->titulo;
        }
        return $this->titulo . ': ' . $this->subtitulo;
    }
}
