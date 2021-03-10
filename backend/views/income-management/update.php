<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\IncomeManagement */

$this->title = 'Update Income Management: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Income Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="income-management-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
