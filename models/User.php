<?php

    namespace app\models;

    use yii\helpers\ArrayHelper;
    use yii\base\NotSupportedException;
    use Yii;

    /**
     * This is the model class for table "user".
     *
     * @property integer $id
     * @property string $username
     * @property string $password
     * @property string $auth_key
     * @property string $token
     * @property string $email
     * @property string $role
     */
    class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
//class User extends \yii\base\Object implements \yii\web\IdentityInterface
    {
//    public $id;
//    public $username;
//    public $password;
//    public $authKey;
//    public $accessToken;



        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'username' => 'Username',
                'first_name' => 'Forst name',
                'last_name' => 'Last name',
                'password' => 'Password',
                'auth_key' => 'Auth Key',
                'token' => 'Token',
                'email' => 'Email',
                'role' => 'Role',
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
            throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        }

        /**
         * Finds user by username
         *
         * @param  string      $username
         * @return static|null
         */
        public static function findByUsername($username)
        {
            return static::findOne(['username' => $username]);
        }

        /**
         * Finds user by password reset token
         *
         * @param  string      $token password reset token
         * @return static|null
         */
        public static function findByPasswordResetToken($token)
        {
            $expire = Yii::$app->params['user.passwordResetTokenExpire'];
            $parts = explode('_', $token);
            $timestamp = (int) end($parts);
            if ($timestamp + $expire < time()) {
                // token expired
                return null;
            }

            return static::findOne([
                'password_reset_token' => $token
            ]);
        }

        /**
         * @inheritdoc
         */
        public function getId()
        {
            return $this->getPrimaryKey();
        }

        public function getRole()
        {
            return $this->role;
        }

        public function getName()
        {
            return $this->username;
        }

        /**
         * @inheritdoc
         */
        public function getAuthKey()
        {
            return $this->auth_key;
        }

        /**
         * @inheritdoc
         */
        public function validateAuthKey($authKey)
        {
            return $this->getAuthKey() === $authKey;
        }

        /**
         * Validates password
         *
         * @param  string  $password password to validate
         * @return boolean if password provided is valid for current user
         */
        public function validatePassword($password)
        {
            //return $this->password === $password;//sha1($password);
            //return Yii::$app->security->validatePassword($password, $this->password_hash);
            return $this->password === md5($password);
        }

        /**
         * Generates password hash from password and sets it to the model
         *
         * @param string $password
         */
        public function setPassword($password)
        {
            //$this->password_hash = $password;
            Yii::$app->security->generatePasswordHash($password);
        }

        /**
         * Generates "remember me" authentication
        public function generateAuthKey()
        {
        $this->auth_key = Yii::$app->security->generateRandomKey();
        }

        /**
         * Generates new password reset token
         */
        public function generatePasswordResetToken()
        {
            $this->password_reset_token = Yii::$app->security->generateRandomKey() . '_' . time();
        }

        /**
         * Removes password reset token
         */
        public function removePasswordResetToken()
        {
            $this->password_reset_token = null;
        }
    }
