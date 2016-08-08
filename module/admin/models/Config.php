<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property string $parameter
 * @property string $value
 * @property string $description
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parameter'], 'required'],
            [['parameter', 'value', 'description'], 'string'],
            [['name'], 'string', 'max' => 255]
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
            'parameter' => 'Parameter',
            'value' => 'Value',
            'description' => 'Description',
        ];
    }

    static function getConfig($name = false, $parameter = false)
    {
        if (!$name) return false;
        $configModel = new Config();
        $config = $configModel->find()->where(['name' => $name]);

        if ($parameter) $config = $config->where(['parameter' => $parameter]);

        return $config->one();
    }

}
