<?php
namespace common\models;

use Yii;
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
            // agora validamos título, autor, gênero e status
            [['titulo', 'autor', 'genero', 'status'], 'required'],
            [['autor', 'genero'], 'string', 'max' => 255],
            ['status', 'in', 'range' => ['Disponivel', 'Emprestado', 'Vendido']],

            // demais campos
            [['subtitulo', 'isbn', 'idioma'], 'string', 'max' => 255],
            [['ano_publicacao', 'paginas'], 'integer'],
            [['data_criacao'], 'safe'],
            [['isbn'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'titulo'         => 'Título',
            'autor'          => 'Autor',
            'genero'         => 'Gênero',
            'status'         => 'Status',
            'subtitulo'      => 'Subtítulo',
            'isbn'           => 'ISBN',
            'ano_publicacao' => 'Ano de Publicação',
            'idioma'         => 'Idioma',
            'paginas'        => 'Páginas',
            'data_criacao'   => 'Data de Criação',
        ];
    }

    public function getExemplares()
    {
        return $this->hasMany(Exemplares::class, ['livro_id' => 'id']);
    }

    public function getFavoritos()
    {
        return $this->hasMany(Favoritos::class, ['livro_id' => 'id']);
    }
}
