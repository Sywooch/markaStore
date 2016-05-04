<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "colors".
 *
 * @property integer $id
 * @property string $color
 */
class Colors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'colors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['color', 'color_name',], 'required'],
            [['color', 'color_name',], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'color_name' => 'Название цвета'
        ];
    }

    /**
     * @inheritdoc
     * @return ColorsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ColorsQuery(get_called_class());
    }
}
