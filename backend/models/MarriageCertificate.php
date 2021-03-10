<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "marriage_certificate".
 *
 * @property int $id
 * @property string $bride_name
 * @property string $bride_age
 * @property string $contact_number
 * @property string $fathers_name
 * @property string $mothers_name
 * @property string $bride_address
 * @property string $witness_name
 * @property string $groom_name
 * @property string $groom_age
 * @property string $groom_contact_number
 * @property string $groom_fathers_name
 * @property string $groom_mothers_name
 * @property string $groom_address
 * @property string $groom_witness_name
 * @property string $created_at
 * @property string $updated_at
 */
class MarriageCertificate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $hidden_Input;
    public static function tableName()
    {
        return 'marriage_certificate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bride_address', 'groom_address', 'groom_witness_name'], 'string'],
            [['created_at', 'updated_at','wedding_venue','wedding_date','imam_detail','witness_name2','groom_witness_name2'], 'safe'],
            [['bride_name', 'bride_age','contact_number','fathers_name','witness_name','mothers_name','groom_name','groom_age','groom_contact_number','groom_fathers_name','groom_mothers_name','bride_address','groom_address','groom_witness_name','wedding_date','wedding_venue','imam_detail','witness_name2','groom_witness_name2'], 'required'],
            [['bride_name', 'bride_age', 'contact_number', 'fathers_name', 'mothers_name', 'witness_name', 'groom_name', 'groom_age', 'groom_contact_number', 'groom_fathers_name', 'groom_mothers_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bride_name' => 'Name',
            'bride_age' => 'Age',
            'wedding_date' => 'Wedding Date (Nikah)',
            'wedding_venue' => 'Wedding Venue (Nikah)',
            'imam_detail' => 'Imam Detail',
            'contact_number' => "Bride Guardian's Contact",
            'fathers_name' => "Father's Name",
            'mothers_name' => "Mother's Name",
            'bride_address' => 'Address',
            'witness_name' => 'Witness Name1',
            'witness_name2' => 'Witness Name2',
            'groom_name' => 'Name',
            'groom_age' => 'Age',
            'groom_contact_number' => 'Contact Number',
            'groom_fathers_name' => "Father's Name",
            'groom_mothers_name' => "Mother's Name",
            'groom_address' => 'Address',
            'groom_witness_name' => 'Witness Name1',
            'groom_witness_name2' => 'Witness Name2',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
