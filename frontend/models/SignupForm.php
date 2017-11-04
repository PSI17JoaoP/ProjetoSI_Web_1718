<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $telefone;
    public $checkPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 8],

            ['checkPassword', 'required'],
            ['checkPassword', 'string'],
            ['checkPassword', 'validateCheckPassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'checkPassword' => 'Verificar Palavra-passe',
            'username' => 'Nome do utilizador',
            'password' => 'Palavra-passe',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save(false);

            $auth = Yii::$app->authManager;
            $clienteRole = $auth->getRole('cliente');
            $auth->assign($clienteRole, $user->getId());

            return $user;
        }

        return null;
    }

    /**
     * Validates the entered password.
     * This method serves as the validation for the password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     *
     */
    public function validateCheckPassword($attribute, $params, $validator)
    {
        $passwordHash = Yii::$app->security->generatePasswordHash($this->password);

        if(!Yii::$app->security->validatePassword($this->$attribute, $passwordHash))
        {
            $this->addError($attribute, 'As palavras-chaves não coincidem.');
        }
    }

}
