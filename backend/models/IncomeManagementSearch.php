<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\IncomeManagement;

/**
 * IncomeManagementSearch represents the model behind the search form of `backend\models\IncomeManagement`.
 */
class IncomeManagementSearch extends IncomeManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['income_type', 'income_date', 'card_number', 'bankName', 'cardHolderName', 'others', 'payer_name', 'payer_address', 'payer_description', 'created_at', 'updated_at','reference_number', 'contact_number'], 'safe'],
            [['incomeAmount'], 'number'],
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
            if(array_key_exists('IncomeManagementSearch', $params)){
                if(array_key_exists('created_at', $params['IncomeManagementSearch'])){
                    $startDate = date('Y-m-d 00:00:00',strtotime($params['IncomeManagementSearch']['created_at']));
                }if(array_key_exists('updated_at', $params['IncomeManagementSearch'])){
                    $endDate = date('Y-m-d 23:59:59',strtotime($params['IncomeManagementSearch']['updated_at']));
                }
            }
        }
        // echo "<pre>";print_r($params);die;
        $query = IncomeManagement::find();

        // add conditions that should always apply here
        if((strpos($startDate, '1970')!== false)||(strpos($startDate, '0000')!== false)){         
            $startDate= "";
        }if((strpos($endDate, '1970')!== false)||(strpos($endDate, '0000')!== false)){         
            $endDate= "";
        }
        // echo $startDate;die;
        if($startDate!="" && $endDate){
            $query->andWhere(['BETWEEN', 'income_date', $startDate, $endDate]);
        }
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
            'income_date' => $this->income_date,
            'incomeAmount' => $this->incomeAmount,
            'reference_number' => $this->reference_number,
            'contact_number' => $this->contact_number,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'income_type', $this->income_type])
            ->andFilterWhere(['like', 'card_number', $this->card_number])
            ->andFilterWhere(['like', 'bankName', $this->bankName])
            ->andFilterWhere(['like', 'cardHolderName', $this->cardHolderName])
            ->andFilterWhere(['like', 'others', $this->others])
            ->andFilterWhere(['like', 'payer_name', $this->payer_name])
            ->andFilterWhere(['like', 'payer_address', $this->payer_address])
            ->andFilterWhere(['like', 'payer_description', $this->payer_description]);

        return $dataProvider;
    }
}
