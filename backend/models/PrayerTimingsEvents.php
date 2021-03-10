<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "prayer_timings_events".
 *
 * @property int $autoid
 * @property string $prayerType
 * @property string $eventName
 * @property string $startDate
 * @property string $endDate
 * @property string $createdAt
 * @property string $updatedAt
 * @property string $ipAddress
 */
class PrayerTimingsEvents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prayer_timings_events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['startDate', 'endDate', 'createdAt', 'updatedAt'], 'safe'],
            [['prayerType', 'eventName', 'ipAddress'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'autoid' => 'Autoid',
            'prayerType' => 'Prayer Type',
            'eventName' => 'Event Name',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'ipAddress' => 'Ip Address',
        ];
    }
}
