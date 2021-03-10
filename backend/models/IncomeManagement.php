<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "income_management".
 *
 * @property int $id
 * @property string $income_type
 * @property string $income_date
 * @property double $incomeAmount
 * @property string $card_number
 * @property string $bankName
 * @property string $cardHolderName
 * @property int $reference_number
 * @property string $others
 * @property string $payer_name
 * @property int $contact_number
 * @property string $payer_address
 * @property string $payer_description
 * @property string $created_at
 * @property string $updated_at
 */
class IncomeManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['income_date', 'created_at', 'updated_at','reference_number'], 'safe'],
            [['incomeAmount'], 'number'],
            [['income_date', 'income_type'], 'required'],
            [['others', 'payer_address', 'payer_description'], 'string'],
            [['income_type', 'card_number', 'bankName', 'cardHolderName', 'payer_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'income_type' => 'Income Mode',
            'income_date' => 'Income Date',
            'incomeAmount' => 'Income Amount',
            'card_number' => 'Card Number',
            'bankName' => 'Bank Name',
            'cardHolderName' => 'Card Holder Name',
            'reference_number' => 'Reference Number',
            'others' => 'Others',
            'payer_name' => 'Payer Name',
            'contact_number' => 'Contact Number',
            'payer_address' => 'Payer Address',
            'payer_description' => 'Payer Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
