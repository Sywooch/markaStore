<?php

namespace app\module\admin\models;

use Yii;
use DateTime;
use yii\base\Exception;

/**
 * This is the model class for table "notify".
 *
 * @property integer $id
 * @property string $name
 * @property string $condition
 * @property string $condition2
 * @property string $condition3
 * @property integer $number
 * @property string $date_sent
 * @property integer $message_id
 * @property integer $status
 */
class Notify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'condition', 'condition2', 'condition3', 'number', 'status', 'message_id'], 'required'],
            [['number', 'status', 'message_id'], 'integer'],
            [['name', 'condition', 'condition2'], 'string', 'max' => 255]
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
            'condition' => 'Условие',
            'condition2' => '...',
            'number' => 'Количество',
            'condition3' => 'Раздел',
            'status' => 'Status',
            'message_id' => 'Message',
            'date_sent' => 'Последнее выполнение',
        ];
    }

    public function getGenus()
    {
        return$this->hasOne(Genus::className(),['id'=>'condition3']);
    }

    public function getMessage()
    {
        return $this->hasOne(Messages::className(),['id' => 'message_id']);
    }

    public function checkNotify()
    {
        try {
            $notifications = $this->find()->where(['status' => 1]);
            if ($notifications->count() > 0) {
                foreach ($notifications->all() as $notification) {
                    $dateNow = date('Y-m-d H:i:s');
                    //$dateSent = $notification->date_sent;
                    $dateSent = $notification->date_sent;
                    if (empty($dateSent)) throw new Exception('date_sent is null');
                    if (!isset($notification->condition)) throw new Exception('condition is null');

                    $search = new Product();
                    $search = $search->find()->where(['genus_id' => $notification->condition3]);
                    if($notification->condition == 0){
                        $search = $search->andFilterWhere(['between', 'date', $dateSent, $dateNow]);
                    }elseif($notification->condition == 1){
                        $search->andFilterWhere(['>', 'sale', 0])->andFilterWhere(['between', 'date_change', $dateSent, $dateNow]);
                    }
                    $search = $search->andWhere(['public' => 1]);
                    /*switch ($notification->condition) {
                        case 0 :
                            $search = new Product();
                            $search = $search->find()->where(['public' => 1])
                                ->andFilterWhere(['between', 'date', $dateSent, $dateNow]);
                            break;
                        case 1 :
                            $search = new Product();
                            $search = $search->find()->where(['public' => 1])
                                ->andFilterWhere(['>', 'sale', 0]);
                            break;*/
                        /*
						case 2 :

						break;
						case 3 :

						break;*/
                        /*default :
                        throw new Exception('condition incorrect!');
                        break;
                    }*/

                    //$search->where(['between', 'date', $dateSent , $dateNow]);


                    $searchCount = $search->count();
                    $searchProducts = $search->all();


                    if (is_numeric($searchCount) and $searchCount >= $notification->number) {
                        $orderModel = new Order();
                        $messagesModel = Messages::findOne($notification->message_id);


                        foreach (explode(',', $messagesModel->getEmails($notification->condition3)) as $email) $orderModel->sendEmail($email, $messagesModel->subject, $messagesModel->message . Yii::$app->controller->renderPartial('preview', ['products' => $searchProducts]));

                        $notification->date_sent = $dateNow;
                        $notification->save();
                        return true;
                    }

                    /*switch ($notification->condition3){
						case 'week' :
							$dateSent->modify('+1 day');
							$search->andWhere(['like','date', $dateSent->format('Y-m-d') .'%', false]);
							$dateSent->modify('+1 day');
							$search->orWhere(['like','date', $dateSent->format('Y-m-d') .'%', false]);
							$dateSent->modify('+1 day');
							$search->orWhere(['like','date', $dateSent->format('Y-m-d') .'%', false]);
							$dateSent->modify('+1 day');
							$search->orWhere(['like','date', $dateSent->format('Y-m-d') .'%', false]);
							$dateSent->modify('+1 day');
							$search->orWhere(['like','date', $dateSent->format('Y-m-d') .'%', false]);
							$dateSent->modify('+1 day');
							$search->orWhere(['like','date', $dateSent->format('Y-m-d') .'%', false]);
							$dateSent->modify('+1 day');
							$search->orWhere(['like','date', $dateSent->format('Y-m-d') .'%', false]);
							$dateSent->modify('+1 day');
							$search->orWhere(['like','date', $dateSent->format('Y-m-d') .'%', false]);
						break;
						case 'month' :
							$dateSent->modify('+1 day');
							$search->andWhere(['like','date', $dateSent->format('Y-m-d') .'%', false]);
						break;
						case 'year' :

						break;
					}*/

                }
            } else throw new Exception('Notifications too less');
        }catch (Exception $e){
            Log::writeLog($e->getMessage(), 'Update', 'Список товаров');
        }
    }
}
