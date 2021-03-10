<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "income_type_master".
 *
 * @property int $id
 * @property string $incomeMode
 * @property string $active_status
 * @property string $created_at
 * @property string $updated_at
 */
class IncomeTypeMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income_type_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['incomeMode', 'active_status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'incomeMode' => 'Income Mode',
            'active_status' => 'Active Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
