<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MosqueDetails;

/**
 * MosqueDetailsSearch represents the model behind the search form of `backend\models\MosqueDetails`.
 */
class MosqueDetailsSearch extends MosqueDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['masqueId'], 'integer'],
            [['name', 'phoneNumber', 'address', 'image', 'licenceCode', 'otherInformations', 'createdAt', 'updatedAt','emailId', 'ipAddress'], 'safe'],
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
        $query = MosqueDetails::find();

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
            'masqueId' => $this->masqueId,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phoneNumber', $this->phoneNumber])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'emailId', $this->emailId])
            ->andFilterWhere(['like', 'licenceCode', $this->licenceCode])
            ->andFilterWhere(['like', 'otherInformations', $this->otherInformations])
            ->andFilterWhere(['like', 'ipAddress', $this->ipAddress]);

        return $dataProvider;
    }
}
