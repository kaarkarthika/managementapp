<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DonationManagement;

/**
 * DonationManagementSearch represents the model behind the search form of `backend\models\DonationManagement`.
 */
class DonationManagementSearch extends DonationManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['donation_type', 'donation_date', 'others', 'donor_name', 'donor_address', 'donor_description', 'created_at', 'updated_at','donationAmount','reference_number','contact_number'], 'safe'],
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
        $startDate = $endDate = "";
        if(!empty($params)){
            if(array_key_exists('DonationManagementSearch', $params)){
                if(array_key_exists('created_at', $params['DonationManagementSearch'])){
                    $startDate = date('Y-m-d 00:00:00',strtotime($params['DonationManagementSearch']['created_at']));
                }if(array_key_exists('updated_at', $params['DonationManagementSearch'])){
                    $endDate = date('Y-m-d 23:59:59',strtotime($params['DonationManagementSearch']['updated_at']));
                }
            }
        }
        if((strpos($startDate, '1970')!== false)||(strpos($startDate, '0000')!== false)){         
            $startDate= "";
        }
        if((strpos($endDate, '1970')!== false)||(strpos($endDate, '0000')!== false)){         
            $endDate= "";
        }
        $query = DonationManagement::find();
        if($startDate!="" && $endDate!=""){
            $query->andWhere(['BETWEEN','donation_date',$startDate,$endDate]);
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
            'donation_date' => $this->donation_date,
            'reference_number' => $this->reference_number,
            'contact_number' => $this->contact_number,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'donation_type', $this->donation_type])
            ->andFilterWhere(['like', 'others', $this->others])
            ->andFilterWhere(['like', 'donationAmount', $this->donationAmount])
            ->andFilterWhere(['like', 'donor_name', $this->donor_name])
            ->andFilterWhere(['like', 'donor_address', $this->donor_address])
            ->andFilterWhere(['like', 'donor_description', $this->donor_description]);

        return $dataProvider;
    }
}
