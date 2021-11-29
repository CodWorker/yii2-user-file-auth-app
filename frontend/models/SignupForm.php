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

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'checkIsUniqUserName'],
            // [['username', 'password'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
        ];
    }

    public function checkIsUniqUserName($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user) {
                $this->addError($attribute, 'Пользователь с данным именем уже зарегестрирован.');
            }
        }
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

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = UserFile::findByUsername($this->username);
        }

        return $this->_user;
    }

}
