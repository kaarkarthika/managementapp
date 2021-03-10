<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MarriageCertificate;

/**
 * MarriageCertificateSearch represents the model behind the search form of `backend\models\MarriageCertificate`.
 */
class MarriageCertificateSearch extends MarriageCertificate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['bride_name', 'bride_age', 'contact_number', 'fathers_name', 'mothers_name', 'bride_address', 'witness_name', 'groom_name', 'groom_age', 'groom_contact_number', 'groom_fathers_name', 'groom_mothers_name', 'groom_address', 'groom_witness_name', 'created_at', 'updated_at','wedding_venue','wedding_date'], 'safe'],
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
        // echo "<pre>";print_r($params);die;
        $startDate = $endDate = "";
        if(!empty($params)){
            if(array_key_exists('MarriageCertificateSearch', $params)){
                if(array_key_exists('created_at', $params['MarriageCertificateSearch'])){
                    $startDate = date('Y-m-d 00:00:00',strtotime($params['MarriageCertificateSearch']['created_at']));
                }if(array_key_exists('updated_at', $params['MarriageCertificateSearch'])){
                    $endDate = date('Y-m-d 23:59:59',strtotime($params['MarriageCertificateSearch']['updated_at']));
                }
            }
        }
        $query = MarriageCertificate::find();
        if((strpos($startDate, '1970')!== false)||(strpos($startDate, '0000')!== false)){         
            $startDate= "";
        }
        if((strpos($endDate, '1970')!== false)||(strpos($endDate, '0000')!== false)){         
            $endDate= "";
        }
        if($startDate!="" && $endDate!=""){
            $query->andWhere(['BETWEEN','wedding_date',$startDate,$endDate]);
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
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'bride_name', $this->bride_name])
            ->andFilterWhere(['like', 'bride_age', $this->bride_age])
            ->andFilterWhere(['like', 'contact_number', $this->contact_number])
            ->andFilterWhere(['like', 'fathers_name', $this->fathers_name])
            ->andFilterWhere(['like', 'mothers_name', $this->mothers_name])
            ->andFilterWhere(['like', 'bride_address', $this->bride_address])
            ->andFilterWhere(['like', 'witness_name', $this->witness_name])
            ->andFilterWhere(['like', 'groom_name', $this->groom_name])
            ->andFilterWhere(['like', 'groom_age', $this->groom_age])
            ->andFilterWhere(['like', 'groom_contact_number', $this->groom_contact_number])
            ->andFilterWhere(['like', 'groom_fathers_name', $this->groom_fathers_name])
            ->andFilterWhere(['like', 'groom_mothers_name', $this->groom_mothers_name])
            ->andFilterWhere(['like', 'groom_address', $this->groom_address])
            ->andFilterWhere(['like', 'groom_witness_name', $this->groom_witness_name])
            ->andFilterWhere(['like', 'wedding_venue', $this->wedding_venue])
            ->andFilterWhere(['like', 'wedding_date', $this->wedding_date]);

        return $dataProvider;
    }
}
