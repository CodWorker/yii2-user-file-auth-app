<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\UserFile;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    // public $rememberMe = true;
    public $waitTime = (60 * 5);

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
            [['username', 'password'], 'expTime'],
            // rememberMe must be a boolean value
            // ['rememberMe', 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !UserFile::validatePassword($this->password, $user['password_hash'])) {
                $this->addError($attribute, \Yii::t('app', 'Incorrect data.'));
            }
        }
    }

    public function expTime($attribute, $params)
    {
        $user = $this->getUser();
        if (!$user || !UserFile::validatePassword($this->password, $user['password_hash'])) {
            
            //Time limit
            ////////////////////////////
            $session = Yii::$app->session;
            if (!$session->has('expTime')){
                $session->set('expTime', 0);
            }
            $achivedLimit = static::counterErrorLogin();
            
            if($achivedLimit){
                if($session->get('expTime') == 0){
                    $session->set('expTime', time() + $this->waitTime);
                }
                
                if(time() < $session->get('expTime')){
                    $sec = $session->get('expTime') - time();
                    $this->addError($attribute, \Yii::t('app', 'Попробуйте еще раз через {$sec}секунд(ы)'));
                    \Yii::$app->session->setFlash('expTimeMessage', "Попробуйте еще раз через {$sec} секунд(ы)");
                    return false;
                }else{
                    self::clearLimit();
                    $session->remove('expTime');
                }
            }
        }
    }

    private static function counterErrorLogin($moreThen = 3){
        $session = Yii::$app->session;
        $sName = 'counterErrorLogin';
        if (!$session->has($sName)){
            $session->set($sName, 1);
        }
        
        $curCount = $session->get($sName);
        if($curCount > $moreThen){
            return true;
        }else{
            $session->set($sName, $curCount + 1);
            
            return false;
        }
    }

    private static function clearLimit(){
        $session = Yii::$app->session;
        $sName = 'counterErrorLogin';
        $session->remove($sName);
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            // return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            UserFile::login($this->_user);
            return true;
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return array|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = UserFile::findByUsername($this->username);
        }

        return $this->_user;
    }
}
