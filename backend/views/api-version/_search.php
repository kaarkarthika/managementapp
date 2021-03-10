<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ApiVersionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="api-version-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'auto_id') ?>

    <?= $form->field($model, 'apps_name') ?>

    <?= $form->field($model, 'app_version') ?>
    
    <?= $form->field($model, 'force_update') ?>
    
    <?= $form->field($model, 'version_key') ?>

    <?= $form->field($model, 'create_at') ?>

    <?= $form->field($model, 'update_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
