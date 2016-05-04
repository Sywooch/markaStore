<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $content1
 * @property string $content2
 * @property string $content3
 * @property string $content4
 * @property integer $category_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $images
 */
class Post extends \yii\db\ActiveRecord
{
    public $images;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['content1', 'content2', 'content3', 'content4'], 'string'],
            [['category_id', 'status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['created_at', 'updated_at', 'images'], 'safe'],
            [['created_at'], 'default', 'value' => empty($this->created_at) ? Yii::$app->getFormatter()->asDatetime(time(), 'Y:MM:dd H:mm:ss') : $this->created_at],
            [['updated_at'], 'default', 'value' => Yii::$app->getFormatter()->asDatetime(time(), 'Y:MM:dd H:mm:ss')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content1' => 'Content',
            'content2' => 'Content',
            'content3' => 'Content',
            'content4' => 'Content',
            'category_id' => 'Category ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
