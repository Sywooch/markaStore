<?php

    namespace app\module\admin\models;

    use Yii;

    /**
     * This is the model class for table "followers".
     *
     * @property integer $id
     * @property string $fio
     * @property string $email
     * @property string $date_subscription
     * @property integer $mailing
     * @property integer $genus_id
     */
    class Followers extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'followers';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                ['fio', 'required', 'message' => 'Вкажіть Ваше ім`я'],
                [['fio'], 'string', 'max' => 80, 'min' => 5, 'message' => 'Вкажіть Ваше прізвище та ім`я',
                    'tooShort' => 'Прізвище та ім`я занадто коротке',
                    'tooLong' => 'Прізвище та ім`я задовге'],
                //[['fio'], 'match', 'pattern' => '/^([a-zA-Zа-яА-Я\s])+$/', 'message' => 'Вкажіть Ваше ім`я'],
                [['email'], 'required', 'message' => 'Вкажіть Вашу E-mail адрессу'],
                [['email'], 'email', 'message' => 'Ви вказали некоректну E-mail адрессу'],
                ['genus_id', 'required', 'message' => 'Виберіть розділ'],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'fio' => 'ФИО',
                'email' => 'Email',
                'date_subscription' => 'Дата подписки',
                'mailing' => 'Разсылка',
                'genus_id' => 'Раздел',
            ];
        }

        public function getGenus()
        {
            return$this->hasOne(Genus::className(),['id'=>'genus_id']);
        }

        public function sendEmail()
        {
            $order = new Order();

            foreach (User::getAdminEmails() as $email) $order->sendEmail($email->email, 'Появился новый подписчик в LoungeStore Markaua', 'test');

                return true;

        }
    }