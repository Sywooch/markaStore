<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "types".
 *
 * @property integer $id
 * @property string $type
 */
class Types extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'genus_id'], 'required'],
            [['type'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID Типа',
            'genus_id' => 'Относится к Разделу',
            'type' => 'Название типа',
        ];
    }

    public function getGenus()
    {
        return$this->hasOne(Genus::className(),['id'=>'genus_id']);
    }
    
}
