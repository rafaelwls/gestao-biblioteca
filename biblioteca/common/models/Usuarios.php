<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property string $id
 * @property string $nome
 * @property string $sobrenome
 * @property string $email
 * @property string $data_cadastro
 * @property string|null $data_validade
 * @property bool $is_admin
 * @property bool $is_trabalhador
 *
 * @property Compras[] $compras
 * @property Emprestimos[] $emprestimos
 * @property Favoritos[] $favoritos
 * @property Fluxo_pessoas[] $fluxoPessoas
 * @property Livros[] $livros
 * @property Vendas[] $vendas
 */
class Usuarios extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_validade'], 'default', 'value' => null],
            [['is_trabalhador'], 'default', 'value' => 0],
            [['id', 'nome', 'sobrenome', 'email'], 'required'],
            [['id'], 'string'],
            [['data_cadastro', 'data_validade'], 'safe'],
            [['is_admin', 'is_trabalhador'], 'boolean'],
            [['nome', 'sobrenome'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 150],
            [['email'], 'unique'],
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
            'nome' => 'Nome',
            'sobrenome' => 'Sobrenome',
            'email' => 'Email',
            'data_cadastro' => 'Data Cadastro',
            'data_validade' => 'Data Validade',
            'is_admin' => 'Is Admin',
            'is_trabalhador' => 'Is Trabalhador',
        ];
    }

    /**
     * Gets query for [[Compras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compras::class, ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Emprestimos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmprestimos()
    {
        return $this->hasMany(Emprestimos::class, ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favoritos::class, ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[FluxoPessoas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFluxoPessoas()
    {
        return $this->hasMany(Fluxo_pessoas::class, ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Livros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLivros()
    {
        return $this->hasMany(Livros::class, ['id' => 'livro_id'])->viaTable('favoritos', ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Vendas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVendas()
    {
        return $this->hasMany(Vendas::class, ['usuario_id' => 'id']);
    }

}
