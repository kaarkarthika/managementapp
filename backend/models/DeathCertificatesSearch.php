<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DeathCertificates;

/**
 * DeathCertificatesSearch represents the model behind the search form of `backend\models\DeathCertificates`.
 */
class DeathCertificatesSearch extends DeathCertificates
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['demised_name', 'death_date', 'contact_person', 'relation_ship', 'address', 'created_at', 'updated_at','fatherName'], 'safe'],
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
        $query = DeathCertificates::find();
        $startDate = $endDate = "";
        if(!empty($params)){
            if(array_key_exists('DeathCertificatesSearch', $params)){
                if(array_key_exists('created_at', $params['DeathCertificatesSearch'])){
                    $startDate = date('Y-m-d 00:00:00',strtotime($params['DeathCertificatesSearch']['created_at']));
                }if(array_key_exists('updated_at', $params['DeathCertificatesSearch'])){
                    $endDate = date('Y-m-d 23:59:59',strtotime($params['DeathCertificatesSearch']['updated_at']));
                }
            }
        }
        if((strpos($startDate, '1970')!== false)||(strpos($startDate, '0000')!== false)){         
            $startDate= "";
        }
        if((strpos($endDate, '1970')!== false)||(strpos($endDate, '0000')!== false)){         
            $endDate= "";
        }
        if($startDate!="" && $endDate!=""){
            $query->andWhere(['BETWEEN','death_date',$startDate,$endDate]);
        }
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
            'id' => $this->id,
            'death_date' => $this->death_date,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'demised_name', $this->demised_name])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'relation_ship', $this->relation_ship])
            ->andFilterWhere(['like', 'fatherName', $this->fatherName])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
