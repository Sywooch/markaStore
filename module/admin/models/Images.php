<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $color_id
 * @property string $img_file
 */
class Images extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['color_id'], 'required'],
            [['product_id', 'color_id'], 'integer'],
            ['file', 'file'],
            //[['img_file'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'color_id' => 'Color ID',
            'file' => 'Изображение товара',
        ];
    }

    public function getProduct()
    {
        return$this->hasOne(Product::className(),['product_id'=>'product_id']);
    }
    public function getColor()
    {
        return$this->hasOne(Colors::className(),['id'=>'color_id']);
    }



}
