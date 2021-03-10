<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "colorsystem".
 *
 * @property integer $color_id
 * @property string $color_code
 * @property string $color_name
 * @property string $created_at
 * @property string $updated_at
 */
class Colorsystem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'colorsystem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             [['color_code'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['color_code', 'color_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'color_id' => 'Color ID',
            'color_code' => 'Color Code',
            'color_name' => 'Color Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
