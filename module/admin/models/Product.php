<?php

namespace app\module\admin\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $product_id
 * @property integer $name_id
 * @property integer $brand_id
 * @property integer $genus_id
 * @property integer $type_id
 * @property string $size_id
 * @property integer $quantity
 * @property integer $cost
 * @property string $description
 */
class Product extends \yii\db\ActiveRecord
{
    public $null;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_id', 'brand_id', 'genus_id', 'type_id', /*'size_id', 'quantity',*/ 'cost'], 'required'],
            [['name_id', 'brand_id', 'genus_id', 'type_id', /*'quantity',*/ 'cost'], 'integer'],
           // [['description', 'brand_art'], 'string'],
            [['description', 'brand_art', 'public'], 'safe'],
            //[['size_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'ID',
            'name_id' => 'Наименование',
            'brand_id' => 'Бренд',
            'genus_id' => 'Раздел',
            'type_id' => 'Тип товара',
            'sale' => 'Новая цена',
            'brand_art' => 'Арт.',
          // 'size_id' => 'Size ID',
           // 'sizeses' => 'Size ID',
            'quantity' => 'Quantity',
            'cost' => 'Цена',
            'description' => 'Описание',
            'public' => 'Public',
        ];
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
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
        return$this->hasOne(Sizesofproduct::className(),['id'=>'size_id']);
    }

    public function getCount($types = false, $genus = false)
    {
        return Product::find()->where(['type_id' => $types, 'genus_id' => $genus, 'public' => 1])->andWhere(['public' => 1])->count();
    }

    /*public function getQuantity()
    {
        return Sizesofproduct::find()->select('color_id')->where(['product_id' => $this->product_id])->all();
    }*/


}
