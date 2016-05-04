<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "sizes".
 *
 * @property integer $id
 * @property string $size
 */
class Sizes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sizes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size' , 'id'], 'required'],
            [['size'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'size' => 'Размер',
        ];
    }


}
