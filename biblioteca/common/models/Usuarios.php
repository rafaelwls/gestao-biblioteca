<?php

namespace common\models;

use yii\db\Expression;
use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

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
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    /** @inheritdoc */
    public static function tableName()
    {
        return 'usuarios';
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                // preenche data_cadastro ao inserir
                'createdAtAttribute' => 'data_cadastro',
                // não usamos coluna updated_at
                'updatedAtAttribute' => false,
                'value' => new Expression('CURRENT_TIMESTAMP'),
            ],
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['nome', 'sobrenome', 'email', 'senha'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['nome', 'sobrenome'], 'string', 'max' => 100],
            [['senha'], 'string', 'min' => 6],
            [['is_admin', 'is_trabalhador'], 'boolean'],
            [['data_validade'], 'default', 'value' => null],
            [['data_cadastro', 'data_validade'], 'safe'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'nome' => 'Nome',
            'sobrenome' => 'Sobrenome',
            'email' => 'E-mail',
            'senha' => 'Senha',
            'data_cadastro' => 'Data de Cadastro',
            'data_validade' => 'Data de Validade',
            'is_admin' => 'Administrador?',
            'is_trabalhador' => 'Trabalhador?',
        ];
    }

    //
    // IdentityInterface
    //

    /** {@inheritdoc} */
    public static function findIdentity($id): ?IdentityInterface
    {
        return static::findOne(['id' => $id]);
    }

    /** {@inheritdoc} */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        // se você quiser permitir busca via token JWT puro
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Retorna o nome completo do usuário (nome + sobrenome).
     *
     * @return string
     */
    public function getFullName(): string
    {
        return trim($this->nome . ' ' . $this->sobrenome);
    }

    /** {@inheritdoc} */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /** {@inheritdoc} */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /** {@inheritdoc} */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    //
    // Password handling
    //

    /**
     * gera hash e atribui em $this->senha
     */
    public function setPassword(string $password)
    {
        $this->senha = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * valida plaintext vs hash
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->senha);
    }

    /**
     * gera auth_key para “lembrar-me” e JWT
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
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

    /**
     * Conta quantos empréstimos ativos o usuário tem.
     * @return int
     */
    public function getActiveLoanCount(): int
    {
        return Emprestimos::find()
            ->where(['usuario_id' => $this->id, 'data_devolucao_real' => null])
            ->count();
    }

    /**
     * Verifica se existe algum débito pendente (empréstimo atrasado ou multa não paga).
     * @return bool
     */
    public function hasPendingDebt(): bool
    {
        return Emprestimos::find()
            ->where(['usuario_id' => $this->id])
            ->andWhere([
                'or',
                [
                    'and',
                    ['<', 'data_prevista_devolucao', new Expression('CURRENT_DATE')],
                    ['data_devolucao_real' => null]
                ],
                ['multa_paga' => false, ['>', 'multa_calculada', 0]]
            ])->exists();
    }

    /**
     * @return bool se o usuário é administrador
     */
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    /**
     * @return bool se o usuário é trabalhador
     */
    public function isTrabalhador(): bool
    {
        return (bool) $this->is_trabalhador;
    }

    /**
     * Verifica se o usuário pode pegar mais um empréstimo.
     * Exemplo de limite: 5 livros.
     */
    public function canBorrow(int $limit = 5): bool
    {
        return !$this->hasPendingDebt() && $this->getActiveLoanCount() < $limit;
    }
}
