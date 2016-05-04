<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "productsizes".
 *
 * @property integer $id
 * @property string $size_id
 * @property integer $product_id
 * @property integer $availability
 *
 * @property Product $product
 */
class Productsizes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productsizes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size_id', 'product_id'], 'required'],
            [['product_id', 'availability'], 'integer'],
            [['size_id'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'size_id' => 'Size ID',
            'product_id' => 'Product ID',
            'availability' => 'Availability',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['product_id' => 'product_id']);
    }
}
