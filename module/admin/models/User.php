<?php

namespace app\module\admin\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\base\Security;


/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_check
 * @property string $auth_key
 * @property string $token
 * @property string $email
 */
class User extends \yii\db\ActiveRecord
{
	public $password_check;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

	public function rules()
	{
		return [
			[['username', 'first_name', 'last_name', 'password', 'password_check', 'email', 'role'], 'required'],
			['password_check', 'compare', 'compareAttribute' => 'password'],
			[['username', 'first_name', 'last_name', 'password', 'email'], 'string', 'max' => 255],
			[['role'], 'string', 'max' => 128],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'username' => 'Логин',
			'first_name' => 'Имя',
			'last_name' => 'Фамиллия',
			'password' => 'Пароль',
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
	public static function findIdentityByAccessToken($token)
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
        return Yii::$app->security->validatePassword($password, $this->auth_key);
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

	/**
	 * @param array $emails
	 * @return array
	 */
	static function getAdminEmails($emails = [])
	{   $model = new User();
		foreach ($model->find()->where(['role' => 'admin'])->all() as $user) $emails[] = $user->email;
		return $emails;
	}

	/*public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time']
				],
				'value' => new Expression('NOW()'),
			],
		];
	}*/


}
