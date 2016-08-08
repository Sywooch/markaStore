<?php

namespace app\module\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\module\admin\models\Product;

/**
 * ProductSearch represents the model behind the search form about `app\module\admin\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'name_id', 'brand_id', 'genus_id', 'type_id', /*'quantity',*/ 'cost'/*,  'brand_art', 'sale'*/], 'string'],
            [['sale'], 'integer'],
            [[/*'size_id', */'description', 'brand_art', 'public'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'product_id' => $this->product_id,
            'name_id' => $this->name_id,
            'brand_id' => $this->brand_id,
            'genus_id' => $this->genus_id,
            'type_id' => $this->type_id,
           // 'quantity' => $this->quantity,
            'sale' => $this->sale,
            'brand_art' => $this->brand_id,
            'cost' => $this->cost,
            'public' => $this->public,
        ]);

        $query->/*andFilterWhere(['like', 'size_id', $this->size_id])
            ->*/andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
