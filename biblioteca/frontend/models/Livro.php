<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "livros".
 *
 * @property string $id
 * @property string|null $isbn
 * @property string $titulo
 * @property string|null $subtitulo
 * @property int|null $ano_publicacao
 * @property string|null $idioma
 * @property int|null $paginas
 */
class Livro extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'livros';
    }

    /**
     * Returns full title combining title and subtitle if exists
     * @return string
     */
    public function getFullTitle(): string
    {
        return $this->subtitulo
            ? "{$this->titulo}: {$this->subtitulo}"
            : $this->titulo;
    }
}
