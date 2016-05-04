<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Woman;

/**
 * WomanSearch represents the model behind the search form about `app\models\Woman`.
 */
class WomanSearch extends Woman
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'name_id', 'brand_id', 'genus_id', 'type_id', 'sale', 'cost', 'public'], 'integer'],
            [['brand_art', 'description'], 'safe'],
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
        $query = Woman::find();

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
            'sale' => $this->sale,
            'cost' => $this->cost,
            'public' => $this->public,
        ]);

        $query->andFilterWhere(['like', 'brand_art', $this->brand_art])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
