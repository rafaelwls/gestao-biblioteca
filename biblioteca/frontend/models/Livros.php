<?php

namespace common\models;

use yii\db\ActiveRecord;

class Livro extends ActiveRecord
{
    public static function tableName()
    {
        return 'livros';
    }

    public function rules()
    {
        return [
            [['titulo', 'autor', 'genero', 'isbn', 'status'], 'required'],
            [['titulo', 'autor', 'genero'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20],
            ['status', 'in', 'range' => ['Disponível', 'Emprestado', 'Vendido']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'autor' => 'Autor',
            'genero' => 'Gênero',
            'isbn' => 'ISBN',
            'status' => 'Status',
        ];
    }
}
