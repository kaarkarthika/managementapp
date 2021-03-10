<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DesignationMaster;

/**
 * DesignationMasterSearch represents the model behind the search form of `backend\models\DesignationMaster`.
 */
class DesignationMasterSearch extends DesignationMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designationId'], 'integer'],
            [['desigantionName', 'activeStatus', 'createdAt', 'updatedAt', 'comments'], 'safe'],
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
        $query = DesignationMaster::find();

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
            'designationId' => $this->designationId,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'desigantionName', $this->desigantionName])
            ->andFilterWhere(['like', 'activeStatus', $this->activeStatus])
            ->andFilterWhere(['like', 'comments', $this->comments]);

        return $dataProvider;
    }
}
