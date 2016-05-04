<?php

	namespace app\models;

	use Yii;
	use app\module\admin\models\Names;
	use app\module\admin\models\Brands;
	use app\module\admin\models\Genus;
	use app\module\admin\models\Images;
	use app\module\admin\models\Sizesofproduct;

	/**
	 * This is the model class for table "product".
	 *
	 * @property integer $product_id
	 * @property integer $name_id
	 * @property integer $brand_id
	 * @property integer $genus_id
	 * @property integer $type_id
	 * @property string $brand_art
	 * @property integer $sale
	 * @property integer $cost
	 * @property string $description
	 * @property integer $public
	 */
	class Woman extends \yii\db\ActiveRecord
	{
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
				[['name_id', 'brand_id', 'type_id', /*'quantity',*/ 'cost', 'description'], 'required'],
				[['name_id', 'brand_id', 'type_id', /*'quantity',*/ 'cost'], 'integer'],
				[['description', 'name', 'name_id'], 'string'],
				['img_file', 'safe'],
			];
		}

		/**
		 * @inheritdoc
		 */
		public function attributeLabels()
		{
			return [
				'product_id' => 'Product ID',
				'name_id' => 'Name ID',
				'brand_id' => 'Brand ID',
				'type_id' => 'Type ID',
				//'quantity' => 'Quantity',
				'cost' => 'Cost',
				'description' => 'Description',
				'img_file' => 'image',
			];
		}

		public function getName()
		{
			return$this->hasOne(Names::className(),['id'=>'name_id']);
		}

		public function getBrand()
		{
			return$this->hasOne(Brands::className(),['id'=>'brand_id']);
		}

		public function getGenus()
		{
			return$this->hasOne(Genus::className(),['id'=>'genus_id']);
		}
		public function getImage()
		{
			return$this->hasOne(Images::className(),['product_id'=>'product_id']);
		}
		public function getSize()
		{
			return$this->hasOne(Sizesofproduct::className(),['product_id'=>'product_id']);
		}

		public function getColor()
		{
			return$this->hasOne(Sizesofproduct::className(),['product_id'=>'product_id']);
		}



		public function getCount($types = false, $genus = false)
		{
			return Product::find()->where(['type_id' => $types, 'genus_id' => $genus, 'public' => 1])->andWhere(['public' => 1])->count();
		}

	}
