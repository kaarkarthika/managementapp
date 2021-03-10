<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PrayerTimingsEvents */

$this->title = 'Create Prayer Timings Events';
$this->params['breadcrumbs'][] = ['label' => 'Prayer Timings Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prayer-timings-events-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
