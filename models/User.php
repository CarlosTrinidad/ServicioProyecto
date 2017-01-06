<?php

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
namespace app\models;

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
{
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
            [['name', 'email', 'password'], 'string', 'max' => 40],
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
        ];
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
              return static::find()->where(['name'=>$username])->one();
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
            return $this->password === $password;
        }

}
