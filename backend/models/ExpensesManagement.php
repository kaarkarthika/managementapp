<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "expenses_management".
 *
 * @property int $id
 * @property string $type
 * @property string $exe_date
 * @property int $amount
 * @property string $created_at
 * @property string $updated_at
 */
class ExpensesManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $expenses_type;
    public static function tableName()
    {
        return 'expenses_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['amount'], 'integer'],
            [['type','amount','exe_date'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Expenses Type',
            'exe_date' => 'Expenses Date',
            'amount' => 'Expenses Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function afterFind() {
     if(isset($this->expensesname->expenses_name) && !empty($this->expensesname->expenses_name)){
       $this->expenses_type = $this->expensesname->expenses_name; 
    }
         parent::afterFind();
    }
    
     public function getExpensesname()
    {
        return $this->hasOne(ExpensesMaster::className(), ['auto_id' => 'type']);
    }
}
