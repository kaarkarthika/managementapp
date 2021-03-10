<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "relationship_master".
 *
 * @property int $id
 * @property string $relation_type
 * @property string $description
 * @property string $active_status
 * @property string $created_at
 * @property string $updated_at
 */
class RelationshipMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $hidden_Input;
    public static function tableName()
    {
        return 'relationship_master';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['relation_type'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['relation_type', 'active_status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'relation_type' => 'Relation Type',
            'description' => 'Description',
            'active_status' => 'Active Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
