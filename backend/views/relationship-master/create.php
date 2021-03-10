<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DonationTypeMaster */

$this->title = 'Relationship Master';
$this->params['breadcrumbs'][] = ['label' => 'Relationship Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relationship-master-create">

     

    <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name,
    ]) ?>


</div>
