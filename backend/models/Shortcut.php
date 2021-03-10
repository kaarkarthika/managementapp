<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shortcut".
 *
 * @property string $short_id
 * @property string $name
 * @property string $link
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Shortcut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shortcut';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'link'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'short_id' => 'Short ID',
            'name' => 'Name',
            'link' => 'Link',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
