<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PrayerTimings */

$this->title = 'New Prayer ';
$this->params['breadcrumbs'][] = ['label' => 'Prayer Timings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prayer-timings-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
