<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "genus".
 *
 * @property string $genus
 */
class Genus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'genus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['genus'], 'required'],
            [['genus'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID Раздела',
            'genus' => 'Pаздел',
        ];
    }
}
