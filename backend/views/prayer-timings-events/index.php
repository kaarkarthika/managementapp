<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PrayerTimingsEventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prayer Timings Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prayer-timings-events-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Prayer Timings Events', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'autoid',
            'prayerType',
            'eventName',
            'startDate',
            'endDate',
            //'createdAt',
            //'updatedAt',
            //'ipAddress',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
