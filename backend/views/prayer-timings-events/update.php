<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PrayerTimingsEvents */

$this->title = 'Update Prayer Timings Events: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Prayer Timings Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->autoid, 'url' => ['view', 'id' => $model->autoid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prayer-timings-events-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
