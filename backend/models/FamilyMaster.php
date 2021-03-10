<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "family_master".
 *
 * @property int $familyId
 * @property string $familyHeadName
 * @property int $noOfDependents
 * @property string $dependentDetails
 * @property string $contactNumber
 * @property string $alternatePhoneNumber
 * @property string $emailId
 * @property string $landMark
 * @property string $address
 * @property string $description
 * @property string $activeStatus
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $updatedIpaddress
 */
class FamilyMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'family_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['noOfDependents'], 'integer'],
            [['emailId'], 'email'],
            [['familyHeadName','contactNumber','noOfDependents'], 'required'],
            [['dependentDetails', 'address', 'description', 'activeStatus'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['familyHeadName', 'updatedIpaddress'], 'string', 'max' => 200],
            [['contactNumber', 'alternatePhoneNumber'], 'string', 'max' => 100],
            [['landMark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'familyId' => 'Family ID',
            'familyHeadName' => 'Head of the Family',
            'noOfDependents' => 'No Of Family Members',
            'dependentDetails' => 'Members Details',
            'contactNumber' => 'Contact Number',
            'alternatePhoneNumber' => 'Alternate Phone Number',
            'emailId' => 'Email ID',
            'landMark' => 'Area',
            'address' => 'Address',
            'description' => 'Comments',
            'activeStatus' => 'Active Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'updatedIpaddress' => 'Updated Ipaddress',
        ];
    }
}
