<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mosque_details".
 *
 * @property int $masqueId
 * @property string $name
 * @property string $phoneNumber
 * @property string $address
 * @property string $image
 * @property string $licenceCode
 * @property string $otherInformations
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $ipAddress
 */
class MosqueDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mosque_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','phoneNumber'], 'required'],
            [['emailId'], 'email'],
            [['address', 'image', 'otherInformations'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name', 'ipAddress'], 'string', 'max' => 200],
            // [['licenceCode'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'masqueId' => 'Masque ID',
            'name' => 'Name',
            'phoneNumber' => 'Phone Number',
            'address' => 'Address',
            'image' => 'Image',
            'emailId' => 'Email Address',
            // 'licenceCode' => 'Licence Code',
            'otherInformations' => 'Other Informations',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'ipAddress' => 'Ip Address',
        ];
    }
}
