<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $phone
 * @property string $email
 * @property string $date
 * @property string $fio
 * @property string $final_cost
 * @property integer $status
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {



        return [
            //[['phone', 'fio'], 'required'],
            ['fio', 'required', 'message' => 'Вкажіть Ваше ім`я'],
            ['phone', 'required', 'message' => 'Вкажіть Ваш контактний номер телефону. Наприклад +380 999999999'],
            [['user_id', 'status', 'final_cost'], 'integer'],
            [['fio'], 'string', 'max' => 80, 'min' => 5, 'message' => 'Вкажіть Ваше прізвище та ім`я',
                'tooShort' => 'Вкажіть Ваше прізвище та ім`я',
                'tooLong' => 'Вкажіть Ваше прізвище та ім`я'],
            [['phone'], 'number', 'max' => 999999999, 'min' => 100000000, 'message' => 'Вкажіть Ваш контактний номер телефону. Наприклад +380 999999999',
                'tooSmall' => 'Вкажіть Ваш контактний номер телефону. Наприклад +380 999999999',
                'tooBig' => 'Вкажіть Ваш контактний номер телефону. Наприклад +380 999999999'],
            [['email'], 'email', 'message' => 'Вкажіть Вашу E-mail адрессу'],
            [['date'], 'default', 'value' => date('Y-m-d H:i')],
            [['user_id'], 'default', 'value' => !empty(Yii::$app->user->id) ? Yii::$app->user->id : 0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер заказа',
            'date' => 'Дата заказа',
            'user_id' => 'Клиент',
            'fio' => 'ФИО',
            'phone' => 'Тел.',
            'email' => 'Email',
            'final_cost' => 'На сумму',
            'status' => 'Статус',
        ];
    }

    public function getUser()
    {
        return$this->hasOne(User::className(),['id'=>'user_id']);
    }
}
