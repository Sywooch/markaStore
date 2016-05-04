<?php

namespace app\module\admin\models;

use Yii;


/**
 * This is the model class for table "sizesofproduct".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $size_id
 * @property integer $color_id
 * @property integer $availability
 */
class Sizesofproduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sizesofproduct';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'size_id', 'color_id', 'availability'], 'required'],
            [['product_id', /*'size_id', 'color_id',*/ 'availability'], 'integer'],
            [['size_id', 'color_id'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'size_id' => 'Размер',
            'color_id' => 'Цвет',
            'availability' => 'Количество единиц',
        ];
    }

   /* public function getSizes()
    {
        return$this->hasOne(Sizes::className(),['id'=>'size_id']);
    }*/

    public function getSize()
    {
        return$this->hasOne(Sizes::className(),['id'=>'size_id']);
    }

    public function getColor()
    {
        return$this->hasOne(Colors::className(),['id'=>'color_id']);
    }
}
