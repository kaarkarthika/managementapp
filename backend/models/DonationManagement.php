<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "donation_management".
 *
 * @property int $id
 * @property string $donation_type
 * @property string $donation_date
 * @property string $account_number
 * @property int $reference_number
 * @property string $others
 * @property string $donor_name
 * @property int $contact_number
 * @property string $donor_address
 * @property string $donor_description
 * @property string $created_at
 * @property string $updated_at
 */
class DonationManagement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'donation_management';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at','reference_number', 'contact_number'], 'safe'],
            [['donation_type', 'donation_date'], 'required'],
            [['others', 'donor_address', 'donor_description'], 'string'],
            [['donation_type','donationAmount', 'donor_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'donation_type' => 'Donation Mode',
            'donation_date' => 'Donation Date',
            'reference_number' => 'Reference Number',
            'others' => 'Others',
            'donor_name' => 'Name',
            'contact_number' => 'Contact Number',
            'donor_address' => 'Address',
            'donor_description' => 'Notes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
