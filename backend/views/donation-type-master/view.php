<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
// /* @var $model backend\models\DonationTypeMaster */

// $this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Donation Type Masters', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="donation-type-master-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'donation_type',
            // 'active_status',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
