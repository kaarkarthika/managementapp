<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ExpensesMaster */

$this->title = 'Create Expenses Master';
$this->params['breadcrumbs'][] = ['label' => 'Expenses Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expenses-master-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
