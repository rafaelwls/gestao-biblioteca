<?php

namespace common\models;

use Yii;

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
 * @property string $data_criacao
 *
 * @property Exemplares[] $exemplares
 * @property Favoritos[] $favoritos
 * @property Usuarios[] $usuarios
 */
class Livros extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'livros';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['isbn', 'subtitulo', 'ano_publicacao', 'idioma', 'paginas'], 'default', 'value' => null],
            [['id', 'titulo'], 'required'],
            [['id'], 'string'],
            [['ano_publicacao', 'paginas'], 'default', 'value' => null],
            [['ano_publicacao', 'paginas'], 'integer'],
            [['data_criacao'], 'safe'],
            [['isbn'], 'string', 'max' => 20],
            [['titulo', 'subtitulo'], 'string', 'max' => 255],
            [['idioma'], 'string', 'max' => 50],
            [['isbn'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'isbn' => 'Isbn',
            'titulo' => 'Titulo',
            'subtitulo' => 'Subtitulo',
            'ano_publicacao' => 'Ano Publicacao',
            'idioma' => 'Idioma',
            'paginas' => 'Paginas',
            'data_criacao' => 'Data Criacao',
        ];
    }

    /**
     * Gets query for [[Exemplares]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExemplares()
    {
        return $this->hasMany(Exemplares::class, ['livro_id' => 'id']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favoritos::class, ['livro_id' => 'id']);
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::class, ['id' => 'usuario_id'])->viaTable('favoritos', ['livro_id' => 'id']);
    }

}
