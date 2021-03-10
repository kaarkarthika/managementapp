<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DonationTypeMaster */

$this->title = 'Donation Modes Master';
$this->params['breadcrumbs'][] = ['label' => 'Donation Modes Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donation-type-master-create">

     

    <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name,
    ]) ?>

</div>