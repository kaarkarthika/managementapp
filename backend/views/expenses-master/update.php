<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ExpensesMaster */

$this->title = 'Update Expenses Master: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Expenses Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->auto_id, 'url' => ['view', 'id' => $model->auto_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="expenses-master-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
