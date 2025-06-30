<?php

namespace app\models;

use yii\db\ActiveRecord;

class Livros extends ActiveRecord
{
    public static function tableName()
    {
        return 'livros';
    }

    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['ano_publicacao', 'paginas'], 'integer'],
            [['data_criacao'], 'safe'],
            [['isbn'], 'string', 'max' => 20],
            [['titulo', 'subtitulo'], 'string', 'max' => 255],
            [['idioma'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'isbn'             => 'ISBN',
            'titulo'           => 'Título',
            'subtitulo'        => 'Subtítulo',
            'ano_publicacao'   => 'Ano de Publicação',
            'idioma'           => 'Idioma',
            'paginas'          => 'Páginas',
            'data_criacao'     => 'Data de Criação',
        ];
    }
}
