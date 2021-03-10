<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "commitee_management".
 *
 * @property int $id
 * @property string $name
 * @property int $age
 * @property int $select_type
 * @property string $education
 * @property string $present_address
 * @property string $permanent_address
 * @property int $salary
 * @property string $benefits1
 * @property string $benefits2
 * @property string $benefits3
 * @property string $active_status
 * @property string $created_at
 * @property string $updated_at
 */
class CommiteeManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $hidden_Input;
    public $designation;
    public static function tableName()
    {
        return 'commitee_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['age', 'salary'], 'integer'],
            [['name', 'select_type','contactNumber','employee_type','asOnDate'], 'required'],
            [['age','present_address','permanent_address','education'], 'safe'],
            [['present_address', 'permanent_address', 'benefits1', 'benefits2', 'benefits3'], 'safe'],
            [['created_at', 'updated_at','employee_type','committe_staff'], 'safe'],
            [['name', 'education', 'active_status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'age' => 'Age',
            'select_type' => 'Designation',
            'employee_type' => 'Employee Type',
            'education' => 'Education',
            'committe_staff' => 'STAFF',
            'present_address' => 'Present Address',
            'permanent_address' => 'Permanent Address',
            'salary' => 'Salary',
            'benefits1' => 'Benefits1',
            'benefits2' => 'Benefits2',
            'benefits3' => 'Benefits3',
            'active_status' => 'Active Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function afterFind() {
     if(isset($this->designationname->desigantionName) && !empty($this->designationname->desigantionName)){
       $this->designation = $this->designationname->desigantionName; 
    }
         parent::afterFind();
    }
    
     public function getDesignationname()
    {
        return $this->hasOne(DesignationMaster::className(), ['designationId' => 'select_type']);
    }
}
