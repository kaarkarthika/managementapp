<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ExpensesManagement;

/**
 * ExpensesManagementSearch represents the model behind the search form of `backend\models\ExpensesManagement`.
 */
class ExpensesManagementSearch extends ExpensesManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'amount'], 'integer'],
            [['type', 'exe_date', 'created_at', 'updated_at','expenses_type'], 'safe'],
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
        $query = ExpensesManagement::find()->joinwith(['expensesname']);
        $startDate = $endDate = "";
        if(!empty($params)){
            if(array_key_exists('ExpensesManagementSearch', $params)){
                if(array_key_exists('created_at', $params['ExpensesManagementSearch'])){
                    $startDate = date('Y-m-d 00:00:00',strtotime($params['ExpensesManagementSearch']['created_at']));
                }if(array_key_exists('updated_at', $params['ExpensesManagementSearch'])){
                    $endDate = date('Y-m-d 23:59:59',strtotime($params['ExpensesManagementSearch']['updated_at']));
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
            $query->andWhere(['BETWEEN','exe_date',$startDate,$endDate]);
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
            'exe_date' => $this->exe_date,
            'amount' => $this->amount,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
              ->andFilterWhere(['like', 'expenses_master.expenses_name', $this->expenses_type]);

        return $dataProvider;
    }
}
