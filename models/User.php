<?php

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
namespace app\models;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{public $pass;
public $password2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            ['name', 'match', 'pattern' => "/^.{4,40}$/", 'message' => 'Mínimo 4 y máximo 40 caracteres'],
            ['email', 'email', 'message' => "Formato no valido"],
             [['name','email'],'unique'],
             [['password','password2'], 'required', 'on' => ['Create']],
            [['password2'],'compare','compareAttribute'=>'password'],
             [['password', 'password2'], 'string', 'min'=>8,'max' => 20]
        ];
    }





    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'password2' => Yii::t('app', 'Confirmar Password'),
        ];
    }
    public function beforeSave($insert)
        {
            if (parent::beforeSave($insert)) {
                if ($this->isNewRecord) {
                  $hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                  $pass[$this->id]=$this->password;
                  $this->password = $hash;

                }
                else{
                  if(!empty($this->password))
               {
                   $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
               }
                }
                return true;
            }
            return false;
        }


       public static function findIdentity($id)
       {
         return static::findOne($id);
       }


        /**
         * @inheritdoc
         */
        public static function findIdentityByAccessToken($token, $type = null)
        {
            foreach (self::$users as $user) {
                if ($user['accessToken'] === $token) {
                    return new static($user);
                }
            }

            return null;
        }

        /**
         * Finds user by username
         *
         * @param string $username
         * @return static|null
         */
        public static function findByUsername($username)
        {
               return self::findOne(['name'=>$username]);
        }
        public static function findByUserhash($password)
        {

              return static::find()->where(['password'=>$password])->one();
        }
        /**
         * @inheritdoc
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @inheritdoc
         */
        public function getAuthKey()
        {
            return $this->password;
        }

        /**
         * @inheritdoc
         */
        public function validateAuthKey($authKey)
        {
            return $this->password === $authKey;
        }

        /**
         * Validates password
         *
         * @param string $password password to validate
         * @return boolean if password provided is valid for current user
         */
        public function validatePassword($password)
        {

            return  Yii::$app->getSecurity()->validatePassword($password,$this->password );
        }

}
