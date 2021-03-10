<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\IncomeManagement */

$this->title = 'Create Income Management';
$this->params['breadcrumbs'][] = ['label' => 'Income Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="income-management-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
