<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "random_generation".
 *
 * @property int $id
 * @property string $key_id
 * @property string $random_number
 * @property string $created_at
 * @property string $update_at
 */
class RandomGeneration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'random_generation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'update_at'], 'safe'],
            [['key_id', 'random_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key_id' => 'Key ID',
            'random_number' => 'Random Number',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
        ];
    }
}
