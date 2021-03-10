<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PrayerTimings */

$this->title = 'Update Prayer Timings: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Prayer Timings', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prayer-timings-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
