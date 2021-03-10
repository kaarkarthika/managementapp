<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FamilyMaster;

/**
 * FamilyMasterSearch represents the model behind the search form of `backend\models\FamilyMaster`.
 */
class FamilyMasterSearch extends FamilyMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['familyId', 'noOfDependents'], 'integer'],
            [['familyHeadName', 'dependentDetails', 'contactNumber', 'alternatePhoneNumber', 'emailId', 'landMark', 'address', 'description', 'activeStatus', 'createdAt', 'updatedAt', 'updatedIpaddress'], 'safe'],
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
        // echo "<prE>";print_r($params);die;
        $startDate = $endDate = "";
        if(!empty($params)){
            if(array_key_exists('FamilyMasterSearch', $params)){
                if(array_key_exists('createdAt', $params['FamilyMasterSearch'])){
                    $startDate = date('Y-m-d 00:00:00',strtotime($params['FamilyMasterSearch']['createdAt']));
                }if(array_key_exists('updatedAt', $params['FamilyMasterSearch'])){
                    $endDate = date('Y-m-d 23:59:59',strtotime($params['FamilyMasterSearch']['updatedAt']));
                }
            }
        }
        $query = FamilyMaster::find();
        if((strpos($startDate, '1970')!== false)||(strpos($startDate, '0000')!== false)){         
            $startDate= "";
        }
        if((strpos($endDate, '1970')!== false)||(strpos($endDate, '0000')!== false)){         
            $endDate= "";
        }
        if($startDate!="" && $endDate){
            $query->andWhere(['BETWEEN', 'createdAt', $startDate, $endDate]);
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
            'familyId' => $this->familyId,
            'noOfDependents' => $this->noOfDependents,
            // 'createdAt' => $this->createdAt,
            // 'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'familyHeadName', $this->familyHeadName])
            ->andFilterWhere(['like', 'dependentDetails', $this->dependentDetails])
            ->andFilterWhere(['like', 'contactNumber', $this->contactNumber])
            ->andFilterWhere(['like', 'alternatePhoneNumber', $this->alternatePhoneNumber])
            ->andFilterWhere(['like', 'emailId', $this->emailId])
            ->andFilterWhere(['like', 'landMark', $this->landMark])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'activeStatus', $this->activeStatus])
            // ->andFilterWhere(['like', 'createdAt', $this->createdAt])
            ->andFilterWhere(['like', 'updatedIpaddress', $this->updatedIpaddress]);

        return $dataProvider;
    }
}
