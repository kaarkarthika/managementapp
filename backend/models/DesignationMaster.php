<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "designation_master".
 *
 * @property int $designationId
 * @property string $desigantionName
 * @property string $activeStatus
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $comments
 */
class DesignationMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'designation_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activeStatus'], 'required'],
            [['activeStatus', 'comments'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['desigantionName'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'designationId' => 'Designation ID',
            'desigantionName' => 'Desigantion Name',
            'activeStatus' => 'Active Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'comments' => 'Comments',
        ];
    }
}
