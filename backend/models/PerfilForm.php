<?php
namespace backend\models;

use yii\base\Model;
use common\models\User;

class PerfilForm extends Model
{
    public $user;
    public $username;
    public $email;
    public $password; 

    public function __construct()
    {
        $this->user = User::findOne(\Yii::$app->user->id);

        $this->username = $this->user->username;
        $this->email = $this->user->email;
    }

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

        ];
    }


    public function update()
    {
        if ($this->validate()) {
            $this->user->username = $this->username;
            $this->user->email = $this->email;
            $this->user->setPassword($this->password);
            $this->user->save(false);

            return $this->user;
        }

        return null;

    }
 
}