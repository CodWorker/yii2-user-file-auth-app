<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Component;


class UserFile extends Component implements IdentityInterface
{
    public $username;
    public $password_hash;

    CONST CUSESSION = "currentUser";

    private static function getStorage(){
        return Yii::getAlias("@common/filestorage/storage.json");
    }
    
    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id){

    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null){

    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId(){

    }

    /**
     * @return bool
     */
    public function save(){
        $array = static::getArrayFromStorage();
        $array[$this->username] = [
            'username' => $this->username,
            'password_hash' => $this->password_hash,
        ];
        $r = static::saveArrayToStorage($array);
        if($r){
            self::saveCurrentUserSession($this->username);
        }
        return $r;
    }

    private static function getArrayFromStorage(){
        $storage = self::getStorage();
        $data = file_get_contents($storage);
        return json_decode($data, TRUE);
    }

    private static function saveArrayToStorage($array){
        $storage = self::getStorage();
        $res = json_encode($array);
        $r = file_put_contents($storage, $res);
        return $r !== false ? true : false;
    }

    public static function logout(){
        $session = Yii::$app->session;
        $session->remove(self::CUSESSION);
        
    }

    /**
     * @param array $user
     */
    public static function login($user){
        static::saveCurrentUserSession($user['username']);
    }

    private static function saveCurrentUserSession($name){
        $session = Yii::$app->session;
        $session->remove(self::CUSESSION);
        $session->set(self::CUSESSION, $name);
    }

    public static function getCurrentUserNameFromSession(){
        $session = Yii::$app->session;
        if($session->has(self::CUSESSION)){
            return $session->get(self::CUSESSION);
        }

        return false;
    }

    public static function hasCurrentUserNameInSession(){
        $r = static::getCurrentUserNameFromSession();
        return $r !== false ? true : false;
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public static function validatePassword($password, $password_hash)
    {
        return Yii::$app->security->validatePassword($password, $password_hash);
    }

    public static function findByUsername($username){
        $array = static::getArrayFromStorage();
        return isset($array[$username]) ? $array[$username] : null;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled. The returned key will be stored on the
     * client side as a cookie and will be used to authenticate user even if PHP session has been expired.
     *
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey(){

    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey){

    }
}
