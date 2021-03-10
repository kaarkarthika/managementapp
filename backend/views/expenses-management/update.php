<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ExpensesManagement */

$this->title = 'Update Expenses Management: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Expenses Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="expenses-management-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
