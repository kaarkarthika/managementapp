<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DonationManagement */

$this->title = 'Add Donation';
$this->params['breadcrumbs'][] = ['label' => 'Donation Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donation-management-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
