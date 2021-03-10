<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Colorsystem;

/**
 * ColorsystemSearch represents the model behind the search form about `backend\models\Colorsystem`.
 */
class ColorsystemSearch extends Colorsystem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['color_id'], 'integer'],
            [['color_code', 'color_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = Colorsystem::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'color_id' => $this->color_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'color_code', $this->color_code])
            ->andFilterWhere(['like', 'color_name', $this->color_name]);

        return $dataProvider;
    }
}
