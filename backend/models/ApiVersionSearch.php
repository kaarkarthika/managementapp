<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ApiVersion;

/**
 * ApiVersionSearch represents the model behind the search form about `backend\models\ApiVersion`.
 */
class ApiVersionSearch extends ApiVersion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auto_id'], 'integer'],
            [['apps_name', 'app_version','force_update','version_key','create_at', 'update_at'], 'safe'],
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
        $query = ApiVersion::find();

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
            'auto_id' => $this->auto_id,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'apps_name', $this->apps_name])
              ->andFilterWhere(['like', 'app_version', $this->app_version])
              ->andFilterWhere(['like', 'force_update', $this->force_update])
              ->andFilterWhere(['like', 'version_key', $this->version_key]);

        return $dataProvider;
    }
}
