<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\UserFile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'safe']
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new UserFile();
        $user->username = $this->username;
        // var_dump($this->username);exit;
        $user->setPassword($this->password);
        // $user->generateAuthKey();
        return $user->save();

    }

   
}
