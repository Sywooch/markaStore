<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "slidebar".
 *
 * @property integer $id
 * @property string $head
 * @property string $description
 * @property string $image_url
 */
class Slidebar extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slidebar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['head', 'description'], 'required'],
            [['head'], 'string'],
            [['id', 'display'], 'integer'],
            [['description'], 'safe'],
            [['file'], 'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'head' => 'Head',
            'description' => 'Description',
            'file' => 'file',
            'display' => 'Display'
            //'image_url' => 'Image Url',
        ];
    }
}
