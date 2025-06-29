<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Usuarios;

class SignupForm extends Model
{
    public $nome;
    public $sobrenome;
    public $email;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['nome', 'sobrenome', 'email', 'password', 'password_repeat'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => Usuarios::class, 'targetAttribute' => 'email'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'As senhas devem ser iguais'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nome'            => 'Nome',
            'sobrenome'       => 'Sobrenome',
            'email'           => 'E-mail',
            'password'        => 'Senha',
            'password_repeat' => 'Repita a Senha',
        ];
    }

    /**
     * @return Usuarios|null
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new Usuarios();
        $user->nome      = $this->nome;
        $user->sobrenome = $this->sobrenome;
        $user->email     = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        // flags default (false, false)
        if ($user->save()) {
            return $user;
        }
        return null;
    }
}
