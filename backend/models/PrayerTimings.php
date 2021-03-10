<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "prayer_timings".
 *
 * @property int $auto_id
 * @property string $prayer_name
 * @property string $prayer_key
 * @property string $time1
 * @property string $time2
 * @property string $time3
 * @property string $time4
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class PrayerTimings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prayer_timings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['prayer_name', 'prayer_key', 'time1', 'time2', 'time3', 'time4', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'prayer_name' => 'Prayer Name',
            'prayer_key' => 'Prayer Key',
            'time1' => 'Time1',
            'time2' => 'Time2',
            'time3' => 'Time3',
            'time4' => 'Time4',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
