<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\IncomeTypeMaster */

$this->title = 'Update Income Modes Master: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Income Modes Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="income-type-master-update">

    <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name, 
    ]) ?>

</div>
