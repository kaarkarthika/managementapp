<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "expenses_master".
 *
 * @property int $auto_id
 * @property string $expenses_name
 * @property string $activeStatus
 * @property string $created_at
 * @property string $updated_at
 * @property string $comments
 */
class ExpensesMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expenses_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comments','expenses_name'], 'required'],
            [['activeStatus', 'comments'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['expenses_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'expenses_name' => 'Expenses Name',
            'activeStatus' => 'Active Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'comments' => 'Comments',
        ];
    }
}
