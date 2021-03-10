<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ExpensesManagement */

$this->title = 'Create Expenses Management';
$this->params['breadcrumbs'][] = ['label' => 'Expenses Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expenses-management-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
