<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "death_certificates".
 *
 * @property int $id
 * @property string $demised_name
 * @property string $death_date
 * @property string $contact_person
 * @property string $relation_ship
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 */
class DeathCertificates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $hidden_Input;
    public static function tableName()
    {
        return 'death_certificates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['death_date', 'created_at', 'updated_at'], 'safe'],
            [['death_date', 'address','contact_person','relation_ship'], 'safe'],
            [['demised_name','fatherName','placeOfDeath','placeOfJanazaPrayer','placeOfBurialFields'], 'required'],
            [['address'], 'string'],
            [['demised_name', 'contact_person', 'relation_ship'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'demised_name' => 'Name of Deceased',
            'fatherName' => "Father's Name of Deceased",
            'childernName' => "Childrens Name of Deceased",
            'placeOfDeath' => "Place of Death",
            'placeOfJanazaPrayer' => "Place of Janaza Prayer",
            'placeOfBurialFields' => "Place of Burial Fields",
            'death_date' => 'Date of Death',
            'contact_person' => 'Contact Person',
            'relation_ship' => 'Relationship',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
