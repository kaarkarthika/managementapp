<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PrayerTimingsEvents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prayer-timings-events-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prayerType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'eventName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'startDate')->textInput() ?>

    <?= $form->field($model, 'endDate')->textInput() ?>

    <?= $form->field($model, 'createdAt')->textInput() ?>

    <?= $form->field($model, 'updatedAt')->textInput() ?>

    <?= $form->field($model, 'ipAddress')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
