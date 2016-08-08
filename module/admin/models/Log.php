<?php

namespace app\module\admin\models;

use Yii;
use app\module\admin\models\User;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $action
 * @property string $section
 * @property string $message
 * @property string $date
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'action'], 'required'],
            [['user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'date' => 'Date',
            'message' => 'Message',
            'section' => 'Section'
        ];
    }

    static function writeLog($message = false, $action = false, $section = false)
    {
        $model = new Log();

        $model->user_id = Yii::$app->user->id;
        $model->section = $section;
        $model->action = $action;
        $model->message = $message;

        return $model->save() ? true : false;

    }

    static function logMessageGenerator($oldData = false, $newData = [], $model = false)
    {
       // if (!$action or !$section) return false;
        $label = [];
        $text = '';
        
if($oldData) {
    foreach ($newData as $key => $value) {
        if ($value != $oldData[$key]) {
            $label[$key] = $model->attributeLabels()[$key];
            $text .= $label[$key] . " Изменилось с [" . $oldData[$key] . "] на [" . $value . "]; \n\r";
        }
    }
}else{
    foreach ($newData as $key => $value) {
            $label[$key] = $model->attributeLabels()[$key];
            $text .= $label[$key] . " [" . $value . "]; \n\r";
    }
}

        $message = $text;

        return $message;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->hasOne(User::className(),['id'=>'user_id']);
    }
}
