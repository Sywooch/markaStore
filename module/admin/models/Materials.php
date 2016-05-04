<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "materials".
 *
 * @property integer $id
 * @property string $material
 */
class Materials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'materials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material'], 'required'],
            [['material'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material' => 'Название материала',
        ];
    }
}
