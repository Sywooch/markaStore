<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "names".
 *
 * @property integer $id
 * @property string $name
 */
class Names extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'names';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id'], 'required'],
            [['name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Относится к типу',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'name' => array(self::HAS_MANY, 'Name', 'id'),
        );
    }

    public function getType()
    {
        return$this->hasOne(Types::className(),['id'=>'type_id']);
    }

}
