<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DonationManagement */

$this->title = 'Update ';
$this->params['breadcrumbs'][] = ['label' => 'Donation Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="donation-management-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
