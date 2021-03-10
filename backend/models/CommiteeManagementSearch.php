<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CommiteeManagement;

/**
 * CommiteeManagementSearch represents the model behind the search form of `backend\models\CommiteeManagement`.
 */
class CommiteeManagementSearch extends CommiteeManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'age', 'select_type', 'salary'], 'integer'],
            [['name', 'education', 'present_address', 'permanent_address', 'benefits1', 'benefits2', 'benefits3', 'active_status', 'created_at', 'updated_at','designation'], 'safe'],
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
        $empName = $empType = $startDate = $endDate = "";
        if(!empty($params)){
            if(array_key_exists('CommiteeManagementSearch', $params)){
                if(array_key_exists('created_at', $params['CommiteeManagementSearch'])){
                    $startDate = date('Y-m-d 00:00:00',strtotime($params['CommiteeManagementSearch']['created_at']));
                }if(array_key_exists('updated_at', $params['CommiteeManagementSearch'])){
                    $endDate = date('Y-m-d 23:59:59',strtotime($params['CommiteeManagementSearch']['updated_at']));
                }
            }
        }
        if((strpos($startDate, '1970')!== false)||(strpos($startDate, '0000')!== false)){         
            $startDate= "";
        }
        if((strpos($endDate, '1970')!== false)||(strpos($endDate, '0000')!== false)){         
            $endDate= "";
        }
        $query = CommiteeManagement::find()->joinWith(['designationname']);
        if($startDate!="" && $endDate!=""){
            $query->andWhere(['BETWEEN','asOnDate',$startDate,$endDate]);
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
            // 'age' => $this->age,
            // 'salary' => $this->salary,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'present_address', $this->present_address])
            ->andFilterWhere(['like', 'permanent_address', $this->permanent_address])
            ->andFilterWhere(['like', 'benefits1', $this->benefits1])
            ->andFilterWhere(['like', 'benefits2', $this->benefits2])
            ->andFilterWhere(['like', 'benefits3', $this->benefits3])
            ->andFilterWhere(['like', 'employee_type', $this->employee_type])
            ->andFilterWhere(['like', 'designation_master.desigantionName', $this->designation])
            ->andFilterWhere(['like', 'active_status', $this->active_status]);

        return $dataProvider;
    }
}
