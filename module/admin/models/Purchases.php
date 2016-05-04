<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "purchases".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $size_id
 * @property integer $color_id
 * @property integer $count
 */
class Purchases extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchases';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'size_id', 'color_id', 'count'], 'required'],
            [['order_id', 'product_id', 'size_id', 'color_id', 'count'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'size_id' => 'Size ID',
            'color_id' => 'Color ID',
            'count' => 'Количество',
        ];
    }

    public function getBrand()
    {
        return$this->hasOne(Brands::className(),['id'=>'brand_id']);
    }
    public function getType()
    {
        return$this->hasOne(Types::className(),['id'=>'type_id']);
    }
    public function getName()
    {
        return$this->hasOne(Names::className(),['id'=>'name_id']);
    }


    public function getGenus()
    {
        return$this->hasOne(Genus::className(),['id'=>'genus_id']);
    }

    public function getSize()
    {
        return$this->hasOne(Sizes::className(),['id'=>'size_id']);
    }
    public function getColors()
    {
        return$this->hasOne(Colors::className(),['id'=>'color_id']);
    }

}
