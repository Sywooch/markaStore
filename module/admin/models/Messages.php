<?php

    namespace app\module\admin\models;

    use Yii;

    /**
     * This is the model class for table "messages".
     *
     * @property integer $id
     * @property string $name
     * @property string $subject
     * @property string $message
     * @property string $date_sent
     * @property integer $customers
     * @property integer $followers
     * @property integer $to
     * @property integer $active
     */
    class Messages extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'messages';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['name', 'subject', 'message'], 'required'],
                [['to'], 'string'],
                [['customers'], 'integer'],
                [['followers'], 'integer'],
                [['message'], 'string'],
                [['active'], 'integer'],
                [['name', 'subject'], 'string', 'max' => 255]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'name' => 'Название',
                'to' => 'Доп. emails (Через запятую)',
                'subject' => 'Тема письма',
                'message' => 'Тело письма',
                'active' => 'Статус',
                'customers' => 'Заказчики',
                'followers' => 'Подписчики',
                'date_sent' => 'Дата последней отправки'
            ];
        }

        public function getEmails($genus_id = false)
        {
            $customersEmails = [];
            $followersEmails = [];
            $otherEmails = [];

            if ($this->customers == 1){
                $customers = Order::find()->select('email')->distinct()->all();
                foreach ($customers as $email){
                    $customersEmails[] = $email->email;
                }
            }

            if ($this->followers == 1){
                $followers = Followers::find()->select('email')
                    ->where(['mailing' => 1])
                    ->where(['genus_id' => $genus_id])
                    ->distinct()->all();

                foreach ($followers as $email){
                    $followersEmails[] = $email->email;
                }
            }

            if (!empty($this->to)){
                foreach (explode(',' ,trim($this->to)) as $email){
                    $otherEmails[] = trim($email);
                }
            }
            return (!empty($customersEmails) ? implode(',',$customersEmails) . ',' : '') . (!empty($followersEmails) ? implode(',',$followersEmails) . ',' : '') . implode(',',$otherEmails);
        }

        public function sendMessage()
        {
            $order = new Order();
            if ($this->customers == 1){
                $customers = Order::find()->select('email')->distinct()->all();
                foreach ($customers as $email){
                    $order->sendEmail($email->email, $this->subject, $this->message);
                }
            }

            if ($this->followers == 1){
                $followers = Followers::find()->select('email')->where(['mailing' => 1])->distinct()->all();
                foreach ($followers as $email){
                    $order->sendEmail($email->email, $this->subject, $this->message);
                }
            }

            if (!empty($this->to)){
                foreach (explode(',' ,trim($this->to)) as $email){
                    $order->sendEmail(trim($email), $this->subject, $this->message);
                }
            }

            $this->date_sent = date('Y-m-d H:i');
            $this->save();
            return true;
        }

    }
