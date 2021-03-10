<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PrayerTimings;

/**
 * PrayerTimingsSearch represents the model behind the search form of `backend\models\PrayerTimings`.
 */
class PrayerTimingsSearch extends PrayerTimings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['autoid'], 'integer'],
            [['prayer_name', 'prayer_key', 'time1', 'time2', 'time3', 'time4', 'status','created_at', 'updated_at',], 'safe'],
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
        $query = PrayerTimings::find();

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
            'autoid' => $this->autoid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'prayer_name', $this->prayer_name])
            ->andFilterWhere(['like', 'prayer_key', $this->prayer_key])
            ->andFilterWhere(['like', 'time1', $this->time1])
            ->andFilterWhere(['like', 'time2', $this->time2])
            ->andFilterWhere(['like', 'time3', $this->time3])
            ->andFilterWhere(['like', 'time4', $this->time4])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
