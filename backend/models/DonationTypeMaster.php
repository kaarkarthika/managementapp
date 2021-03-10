<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "donation_type_master".
 *
 * @property int $id
 * @property string $donation_type
 * @property string $active_status
 * @property string $created_at
 * @property string $updated_at
 */
class DonationTypeMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $hidden_Input;
    public static function tableName()
    {
        return 'donation_type_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['donation_type'], 'required'],
            [['donation_type', 'active_status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'donation_type' => 'Donation Type',
            'active_status' => 'Active Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
