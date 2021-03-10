<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "api_version".
 *
 * @property integer $auto_id
 * @property string $apps_name
 * @property string $app_version
 * @property string $create_at
 * @property string $update_at
 */
class ApiVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_version';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_at', 'update_at'], 'safe'],
            [['apps_name','force_update', 'app_version','version_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auto_id' => 'Auto ID',
            'apps_name' => 'Apps Name',
            'app_version' => 'App Version',
            'force_update' => 'Force Update',
            'version_key' => 'Version Name',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
