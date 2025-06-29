<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Usuarios;

class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            // campos obrigatórios
            [['email','password'], 'required'],
            // email válido
            ['email', 'email'],
            // rememberMe é booleano
            ['rememberMe', 'boolean'],
            // valida password
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Valida a senha em plaintext contra o hash no banco.
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'E-mail ou senha incorretos.');
            }
        }
    }

    /**
     * Faz login usando o componente user do Yii.
     */
    public function login()
    {
        if ($this->validate()) {
            // duração: 30 dias ou sessão
            $duration = $this->rememberMe ? 3600*24*30 : 0;
            return Yii::$app->user->login($this->getUser(), $duration);
        }
        return false;
    }

    /**
     * Busca o usuário pelo e-mail.
     * @return Usuarios|null
     */
    protected function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuarios::findOne(['email' => $this->email]);
        }
        return $this->_user;
    }
}
